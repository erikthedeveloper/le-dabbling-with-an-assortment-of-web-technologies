package main

import (
	"github.com/go-martini/martini"
	"github.com/martini-contrib/render"
)

func main() {
	// Setup
	m := martini.Classic()
	m.Use(render.Renderer())

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
	m.Get("/people/:username", func(params martini.Params) string {
		return "people.show " + params["username"]
	})

	m.Get("/dogs", func(r render.Render) {
		dogs := []string{"Fido", "Harold", "Fluffy", "FooFoo"}
		r.HTML(200, "dogs/index", dogs)
	})

	m.Run()
}
