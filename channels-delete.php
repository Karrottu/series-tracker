<?php

    include 'libraries/database.php';
    include 'libraries/login-check.php';

    // 1. Store the id for the channel in a variable.
    $id = $_GET['id'];

    // 2. Even in delete functions, we must check that the channel exists.
    // In this case, you might also want to see if the user has permission
    // to delete a record.
    // if after I set $channel, the value is FALSE:
    if (!$channel = get_channel($id))
    {
        exit("This channel doesn't exist.");
    }

    if (!delete_channel($id))
    {
        exit("The channel could not be deleted.");
    }

    redirect('channels-list');
?>
