<?php
    // definitions are constant variables.
    define('BASE_URL', 'http://localhost/php/series-tracker/');

    // Redirects the website to a specific file.
    function redirect($url = '', $param = [])
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

        // only add parameters if we have any.
        if ($param)
        {
            // add the parameters to the end of the url.
            $param = array_map(function($k, $v) {
                return "{$k}={$v}";
            }, array_keys($param), array_values($param));

            $url .= '?' . implode('&', $param);
        }

        // redirect and stop the code.
        header("Location:{$url}");

        exit;
    }
?>
