<?php
    // load the file the parent directory
    include '../libraries/database.php';

    // retrieve the shows into a variable.
    $shows = get_all_shows();

    // a response code will tell the app whether the process is sucessful or not
    //200 for OK. 400 for a client error.

    http_response_code(200);

    // the app needs to know that it is reading a language it can understand.
    header('Content-Type: application/json');

    //print the data in json format
    $shows = mysqli_fetch_all($shows, MYSQLI_ASSOC);

    echo json_encode($shows, JSON_PRETTY_PRINT);
?>
