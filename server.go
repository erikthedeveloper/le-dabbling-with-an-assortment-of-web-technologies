package main

import (
	"github.com/go-martini/martini"
	"github.com/martini-contrib/render"
)

const (
	API_KEY = "a22bd87e65d902c94961fd393d621833"
)

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
		r.HTML(200, "dogs/index", dogs)
	})

	m.Run()
}
