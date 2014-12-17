<?php

function app_path($fname)
{
    return sprintf("%s/%s", APP_DIR, $fname);
}

function partial($name, $data = [])
{
    extract($data);
    ob_start();
    require app_path("partials/{$name}.php");
    $output = ob_get_contents();
    ob_clean();
    return $output;
}

function array_get(&$the_array, $key, $default = null)
{
    return (isset($the_array[$key])) ? $the_array[$key] : $default;
}

function redirect_user($destination)
{
    header("Location: {$destination}");
    exit;
}

