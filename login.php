<?php
    include 'libraries/form.php';
    include 'libraries/url.php';
    include 'libraries/database.php';

    if (is_logged())
    {
        redirect();
    }

    $formdata = get_formdata();
?><!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Series Tracker</title>

        <!-- The Bootstrap CSS file -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.min.css">

        <!-- FontAwesome Icons -->
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>
    </head>
    <body>
        <form class="container-fluid px-4" action="login-process.php" method="post">
            <div class="col-12 col-md-6 mx-auto py-3">
                <div class="card">
                    <div class="card-body">
<?php if (has_error($formdata, 'user-email')): ?>
                        <div class="alert-danger mb-3 p-3">
                            <?php echo get_error($formdata, 'user-email'); ?>
                        </div>
<?php endif; ?>
                        <input type="email" name="user-email" class="form-control mb-3" placeholder="me@example.com"
                            value="<?php echo get_value($formdata, 'user-email'); ?>">

<?php if (has_error($formdata, 'user-password')): ?>
                        <div class="alert-danger mb-3 p-3">
                            <?php echo get_error($formdata, 'user-password'); ?>
                        </div>
<?php endif; ?>
                        <input type="password" name="user-password" class="form-control mb-3" placeholder="password">
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <small class="d-block pt-1">
                            or <a href="register.php">register</a>
                        </small>
                    </div>
                </div>
            </div>
        </form>

        <!-- The Bootstrap Javascript files -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>
