<?php
    include '../libraries/database.php';

    $shows = get_all_shows();

    http_response_code(200);
    header('Content-Type: application/json');

    echo json_encode(mysqli_fetch_all($shows, MYSQLI_ASSOC), JSON_NUMERIC_CHECK + JSON_PRETTY_PRINT);
?>
