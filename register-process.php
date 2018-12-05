<?php
    include 'libraries/form.php';
    include 'libraries/url.php';
    include 'libraries/database.php';

    # 1. check that the form has been sent.
    if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    {
        exit('You have no access to this page.');
    }

    # 2. store the form data in case of any errors.
	set_formdata($_POST);

    # 3. retrieve the variables from $_POST
    $email      = $_POST['user-email'];
    $password   = $_POST['user-password'];
    $name       = $_POST['user-name'];
    $surname    = $_POST['user-surname'];

    # we'll use a boolean to determine if we have errors on the page.
    $has_errors = FALSE;

    # 4. check the inputs that are required.
    if (empty($email))
    {
    	$has_errors = set_error('user-email', 'The email field is required.');
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $has_errors = set_error('user-email', 'Please enter a valid email address.');
    }
    else if (email_exists($email))
    {
        $has_errors = set_error('user-email', 'This email address is already registered.');
    }

    if (strlen($password) < 8)
    {
        $has_errors = set_error('user-password', 'Please enter a password that is at least 8 characters long.');
    }

    if (empty($name))
    {
    	$has_errors = set_error('user-name', 'The name field is required.');
    }

    if (empty($surname))
    {
    	$has_errors = set_error('user-surname', 'The surname field is required.');
    }

    # 5. if there are errors, we should go back and show them.
    if ($has_errors)
    {
        redirect('register');
    }

    # 6. When keeping user data, information should be split to make reading faster.
    # 6a. Generate a salt variable to further protect the password.
    $salt = random_code();

    # 6b. The function will hash the password and write it to the database.
    # If the query fails, we stop here.
    $id = register_login_data($email, $password, $salt);
    if(!$id)
    {
        exit('The query was unsuccrssful.');
    }
    # 6c. Register the user details and check for errors.
    $check = register_user_details($id, $name, $surname);
    if(!$check)
    {
        exit('User not fully registered');
    }

    # 7. Everything worked, go to the login page.
    clear_formdata();
    redirect('login');
?>
