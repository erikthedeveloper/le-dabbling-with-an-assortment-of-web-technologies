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

/**
 * Types, Structs, and ...
 */

type Movie struct {
	Id            int    `json:"id"`
	ImdbId        int    `json:"imdb_id"`
	Title         string `json:"title"`
	OriginalTitle string `json:"original_title"`
	Overview      string `json:"overview"`
	BackdropPath  string `json:"backdrop_path"`
	PosterPath    string `json:"poster_path"`
	// Genres        string  `json:"genres"` // [{"id": 28, "name": "Action"}, ...]
	Homepage    string  `json:"homepage"`
	ReleaseDate string  `json:"release_date"`
	Revenue     int     `json:"revenue"`
	Runtime     int     `json:"runtime"`
	Tagline     string  `json:"tagline"`
	VoteAverage float64 `json:"vote_average"`
	VoteCount   int     `json:"vote_count"`
}

func (m Movie) PosterSrc() string {
	return ImageUrl(m.PosterPath)
}

func (m Movie) BackdropSrc() string {
	return ImageUrl(m.BackdropPath)
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

/**
 * Howabout Some Funcs?!
 */

func EndpointUrl(endpoint string) string {
	return API_BASE_URL + endpoint
}

func ImageUrl(path string) string {
	return API_BASE_URL_IMAGE + path
}

func PanicIf(err error) {
	if err != nil {
		panic(err)
	}
}

/**
 * And some API HTTP funcs!
 */

func GetMovie(movie_id string) Movie {
	movie := Movie{}

	client := &http.Client{}
	req, _ := http.NewRequest("GET", EndpointUrl(fmt.Sprintf("movie/%s", movie_id)), nil)
	values := req.URL.Query()
	values.Add("api_key", API_KEY)
	req.URL.RawQuery = values.Encode()

	res, _ := client.Do(req)
	defer res.Body.Close()
	body, _ := ioutil.ReadAll(res.Body)
	_ = json.Unmarshal(body, &movie)

	fmt.Println(fmt.Sprintf("Movie (%s): \n\n%s \n\n%s", movie_id, body, movie))

	return movie
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

/**
 * Do the magic!
 */
func main() {
	m := martini.Classic()
	m.Use(render.Renderer(render.Options{
		Layout: "layout",
	}))

	m.Get("/", func(r render.Render) {
		r.HTML(200, "index", nil)
	})

	m.Get("/search/(?P<query>[a-zA-Z]+)?", func(r render.Render, params martini.Params) {
		results := SearchMovies(params["query"])
		r.HTML(200, "movies/search_results", results)
	})

	m.Get("/movies/:movie_id", func(r render.Render, params martini.Params) {
		movie := GetMovie(params["movie_id"])
		r.HTML(200, "movies/show", movie)
	})

	m.Run()
}
