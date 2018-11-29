<?php
    include 'libraries/url.php';
    include 'libraries/database.php';

    // 1. Store the id for the show in a variable.
    $id = $_GET['id'];

    // 2. Get the information from the Database.
    // If after I get $show, the value is FALSE:
    if(!$show = get_show($id))
    {
        exit("This show doens't exist.");
    }

    if(!delete_show($id))
    {
        exit("The show could not be deleted");
    }

    redirect('shows-list');

?>
