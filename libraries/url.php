<?php
    // definitions are constant variables.
    define('BASE_URL', 'http://localhost/php/series-tracker/');

    // Redirects the website to a specific file.
    function redirect($url = '', $params = [])
    {
        // if the first character is a slash, remove it.
        if (substr($url, 0, 1) === '/')
        {
            $url = substr($url, 1);
        }

        // if the url is not a blank screen, add .php to the end.
        if (!empty($url))
        {
            $url .= '.php';
        }

        // start the link using the website address.
        $url = BASE_URL . $url;

        // if there are parameters, add them to the url
        if ($params)
        {
            // array_map will apply a function to an entire array
            $params = array_map(function ($key, $value){
                return "{$key}={$value}";
            }, array_keys($params), array_values($params));

            $url .= '?' . implode('&', $params);
        }

        // redirect and stop the code.
        header("Location:{$url}");

        exit;
    }
?>
