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
	API_KEY       = "a22bd87e65d902c94961fd393d621833"
	API_KEY_PARAM = "api_key=" + API_KEY
	API_BASE_URL  = "http://api.themoviedb.org/3/"
)

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

func SearchMovies(title string) *SearchResults {
	query := url.QueryEscape(title)
	url := API_BASE_URL + "search/movie?" + API_KEY_PARAM + "&query=" + query
	res, err := http.Get(url)
	PanicIfError(err)
	// Get Results From Response
	defer res.Body.Close()
	body, err := ioutil.ReadAll(res.Body)
	PanicIfError(err)

	// Parse JSON and Save to SearchResults
	// Return Render SearchResults View
	results := new(SearchResults)
	err = json.Unmarshal(body, results)
	PanicIfError(err)

	return results

	//  MovieSearchResults := []MovieSearchResult{
	//    ,MovieSearchResult{Id: 23 }
	//    ,MovieSearchResult{Id: 25 }
	//    ,MovieSearchResult{Id: 29 }
	//  }

	// return SearchResults{
	//    Query: query
	//    Results: MovieSearchResults
	//    TotalResults: "sdf"
	//    Page: "sdf"
	//    TotalPages: "sdf"
	//  }
}

func main() {
	// Setup
	m := martini.Classic()
	m.Use(render.Renderer(render.Options{
		Layout: "layout",
	}))

	/**
	 * Routes
	 */

	m.Get("/", func() string {
		return "Hello world!"
	})

	// people.index
	m.Get("/people", func() string {
		return "people.index"
	})

	// people.show
	// m.Get("/people/:username", func(params martini.Params, r render.Render) string {
	// 	r.HTML(200, "people/show", params["username"])
	// })

	m.Get("/dogs", func(r render.Render) {
		dogs := []string{"Fido", "Harold", "Fluffy", "FooFoo"}
		results := SearchMovies("matrix")
		fmt.Println(results)
		r.HTML(200, "dogs/index", dogs)
	})

	// m.Get("/movies", func(r render.Render) {
	// 	url := API_BASE_URL + "search/movie?" + API_KEY_PARAM + "&query=matrix"
	// 	resp, err := http.Get(url)
	// })

	m.Run()
}
