<?php
    include '../libraries/http.php';
    include '../libraries/database.php';

    // 1. Check if we are using a POST request.
    ($_SERVER['REQUEST_METHOD'] === 'POST' or error());

    // 2. WE canuse a custom function to read the information from the app.
    get_input_stream($data);

    $email      = isset($data['email']) ? $data['email'] : '';
    $password   = isset($data['password']) ? $data['password'] : '';

    // 3. check the inputs that are required.
    if (empty($email) || empty($password))
    {
    	error('Please fill in both the email and password');
    }

    // 4. check if the email exists and retrieve the password.
    $check = check_password($email, $password);
    if($check === FALSE)
    {
        error('Your email or password are incorrect');
    }

    // 5. The user managed to log in. Keep a record in the database.
    $code = random_code(32);
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $expiration = time() + 60 * 60 * 24 * 30;

    set_login_data($check, $code, $ip_address, $expiration);

    // 6. Get the login data to set in a cookie.
    $userinfo = get_login_data($check, $ip_address);
    if($userinfo === FALSE)
    {
        error("You could not be logged in.");
    }

    // 7. The server will take care of the expiration key so we can remove it
    unset($userinfo['expiration']);

    // 8. Write back the user information so the app can read and store it.
    success('userdata', $userinfo);
?>
