<?php

define("APP_DIR", __DIR__);

// Functions
function app_path($fname) {
  return sprintf("%s/%s", APP_DIR, $fname);
}

function partial($name, $data = []) {
  extract($data);
  ob_start();
  require app_path("partials/{$name}.php");
  $output = ob_get_contents();
  ob_clean();
  return $output;
}

// Classes

// Session

// Database