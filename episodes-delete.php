<?php

    include 'libraries/database.php';
    include 'libraries/login-check.php';

    // 1. Store the id for the show in a variable.
    $id = $_GET['id'];

    // 2. Even in delete functions, we must check that the show exists.
    // In this case, you might also want to see if the user has permission
    // to delete a record.
    // if after I set $episode, the value is FALSE:
    if (!$episode = get_episode($id))
    {
        exit("This episode doesn't exist.");
    }

    if (!delete_episode($id))
    {
        exit("The episode could not be deleted.");
    }

    redirect('episodes-list', ['id' => $_GET['show']]);
?>
