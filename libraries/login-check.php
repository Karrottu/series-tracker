<?php
    include 'url.php';

    if (!is_logged())
    {
        redirect('login');
    }
?>
