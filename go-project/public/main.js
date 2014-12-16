$(document).on('submit', '#movie_search_form', function(event) {
  event.preventDefault();
  window.location = "/search/" + $("#movie_query").val();
});