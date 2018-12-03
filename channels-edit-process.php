<?php
    // This file will be used to process the add channels form.
    include 'libraries/form.php';
    include 'libraries/url.php';
    include 'libraries/database.php';

    // 1. check that the form has been sent.
    if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        exit('You have no access to this page.');
    }

    // 2. store the form data in case of any errors.
	set_formdata($_POST);

    // 3. retrieve the variables from $_POST.
    $name       = $_POST['channel-name'];
    $id         = $_POST['channel-id'];

    // we'll use a boolean to determine if we have errors on the page.
    $has_errors = FALSE;

    // 4. check the inputs that are required.
    if (empty($name))
    {
    	$has_errors = set_error('channel-name', 'The name field is required.');
    }

	// 5. if there are errors, we should go back and channel them.
    if ($has_errors)
    {
        redirect('channels-edit', ['id' => $id]);
    }

    // 6. Check that the record exists, and try to edit it.
    $check = edit_channel($id, $name);
    if (!$check)
    {
        exit('The record could not be updated!');
    }

    // 7. Everything worked, go back to the list.
    clear_formdata();
    redirect('channels-list');
?>
