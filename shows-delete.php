<?php
    include 'libraries/url.php';
    include 'libraries/database.php';

    // 1. Store the id for the show in a variable.
    $id = $_GET['id'];

    // 2. Even in delete functions, we must check that the show exists.
    // In this case, you might also want to see if the user has permission
    // to delete a record.
    // if after I set $show, the value is FALSE:
    if (!$show = get_show($id))
    {
        exit("This show doesn't exist.");
    }

    if (!delete_show($id))
    {
        exit("The show could not be deleted.");
    }

    redirect('shows-list');
?>
