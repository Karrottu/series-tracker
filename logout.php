<?php
    include 'libraries/url.php';
    include 'libraries/database.php';

    # 1. Get the unique data for this session, so we can delete the login on this computer.
    $id         = array_key_exists('id', $_COOKIE) ? $_COOKIE['id'] : FALSE;
    $auth_code  = array_key_exists('auth_code', $_COOKIE) ? $_COOKIE['auth_code'] : '';
    # 2. Remove everything we have stored in the cookie.
    $keys = array_keys($_COOKIE);
    foreach ($keys as $key)
    {
        setcookie($key, '', time() - 3600);
    }
    # 3. If the ID exists, clear the login data from the table.
    if($id !== FALSE)
    {
        clear_login_data($id, $auth_code);
    }
    # 4. Redirect to the login page.
    redirect('login');
?>
