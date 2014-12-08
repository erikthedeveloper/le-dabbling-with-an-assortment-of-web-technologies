package main

import (
	"encoding/json"
	"fmt"
	"github.com/go-martini/martini"
	"github.com/martini-contrib/render"
	"io/ioutil"
	"net/http"
	"net/url"
)

const (
	API_KEY            = "a22bd87e65d902c94961fd393d621833"
	API_KEY_PARAM      = "api_key=" + API_KEY
	API_BASE_URL       = "http://api.themoviedb.org/3/"
	API_BASE_URL_IMAGE = "http://image.tmdb.org/t/p/w500"
)

func EndpointUrl(endpoint string) string {
	return API_BASE_URL + endpoint
}

func ImageUrl(path string) string {
	return API_BASE_URL_IMAGE + path
}

type MovieSearchResult struct {
	Adult         bool    `json:"adult"`
	BackdropPath  string  `json:"backdrop_path"`
	Id            int     `json:"id"`
	OriginalTitle string  `json:"original_title"`
	ReleaseDate   string  `json:"release_date"`
	PosterPath    string  `json:"poster_path"`
	Popularity    float64 `json:"popularity"`
	Title         string  `json:"title"`
	VoteAverage   float64 `json:"vote_average"`
	VoteCount     int     `json:"vote_count"`
}

func (m MovieSearchResult) PosterSrc() string {
	return ImageUrl(m.PosterPath)
}

func (m MovieSearchResult) BackdropSrc() string {
	return ImageUrl(m.BackdropPath)
}

type SearchResults struct {
	Query        string              `json:"query"`
	Results      []MovieSearchResult `json:"results"`
	TotalResults int                 `json:"total_results"`
	Page         int                 `json:"page"`
	TotalPages   int                 `json:"total_pages"`
}

func PanicIfError(err error) {
	if err != nil {
		panic(err)
	}
}

func SearchMovies(query string) *SearchResults {
	results := new(SearchResults)
	results.Query = query
	query = url.QueryEscape(query)

	client := &http.Client{}
	req, _ := http.NewRequest("GET", EndpointUrl("search/movie"), nil)
	values := req.URL.Query()
	values.Add("api_key", API_KEY)
	values.Add("query", query)
	req.URL.RawQuery = values.Encode()

	res, _ := client.Do(req)
	defer res.Body.Close()
	body, _ := ioutil.ReadAll(res.Body)

	// Parse JSON and Save to SearchResults
	_ = json.Unmarshal(body, results)

	fmt.Println(results)
	return results
}

func main() {
	// Setup
	m := martini.Classic()
	m.Use(render.Renderer(render.Options{
		Layout: "layout",
	}))

	m.Get("/", func(r render.Render) {
		r.HTML(200, "index", nil)
	})

	m.Get("/dogs", func(r render.Render) {
		dogs := []string{"Fido", "Harold", "Fluffy", "FooFoo"}
		r.HTML(200, "dogs/index", dogs)
	})

	m.Get("/search/:query", func(r render.Render, params martini.Params) {
		results := SearchMovies(params["query"])
		r.HTML(200, "movies/search_results", results)
	})

	m.Run()
}
