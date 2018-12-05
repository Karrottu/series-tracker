<?php
    // This file will be used to process the add shows form.
    include 'libraries/form.php';
    include 'libraries/database.php';
    include 'libraries/login-check.php';

    // 1. check that the form has been sent.
    if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        exit('You have no access to this page.');
    }

    // 2. store the form data in case of any errors.
	set_formdata($_POST);

    // 3. retrieve the variables from $_POST.
    $name       = $_POST['episode-name'];
    $desc       = $_POST['episode-desc'];
    $show       = $_POST['episode-show'] ?: NULL;
    $airdate    = $_POST['episode-airdate'];
    $season     = $_POST['episode-season'];
    $episode    = $_POST['episode-episode'];
    $rating     = $_POST['episode-rating'];
    $id         = $_POST['episode-id'];

    // we'll use a boolean to determine if we have errors on the page.
    $has_errors = FALSE;

    // 4. check the inputs that are required.
    if (empty($name))
    {
    	$has_errors = set_error('episode-name', 'The name field is required.');
    }

    if (empty($show))
    {
        $has_errors = set_error('episode-show', 'Please choose a show.');
    }

    if (empty($airdate))
    {
    	$has_errors = set_error('episode-airdate', 'The airdate field is required.');
    }

    // to confirm a time, we can use STRTOTIME.
    $airdate = strtotime($airdate);

    // If the air time was not converted properly.
    if (!$airdate)
    {
    	$has_errors = set_error('episode-airdate', 'The air date is in a wrong format. Please use DD/MM/YYYY.');
    }

    if (empty($season))
    {
    	$has_errors = set_error('episode-season', 'The season field is required.');
    }

    if (empty($episode))
    {
        $has_errors = set_error('episode-episode', 'The episode field is required.');
    }

    if (!empty($rating) && ($rating < 0 || $rating > 10))
    {
    	$has_errors = set_error('episode-rating', 'Ratings must be between 0 and 10.');
    }

	// 5. if there are errors, we should go back and show them.
    if ($has_errors)
    {
        redirect('episodes-add', ['show' => $show]);
    }


    // 6. Insert the data in the table.
    // since the function will return a number, we can check it
    // to see if the query worked.
    $check = edit_episode($id, $name, $desc, $airdate, $season, $episode, $rating, $show);
    if (!$check)
    {
        exit("The record could not be updated!");
    }

    // 7. Everything worked, go back to the list.
    clear_formdata();
    redirect('episodes-list', ['id' => $show]);

?>
