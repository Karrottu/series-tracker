<?php
    // Connects to the MySQL database.
    function connect()
    {
        // 1. Assign a new connection to a new variable.
        $link = mysqli_connect('localhost', 'root', '', 'db_seriestracker')
            or die('Could not connect to the database.');

        // 2. Give back the variable so we can always use it.
        return $link;
    }

    // Disconnects the website from the database.
    function disconnect(&$link)
    {
        mysqli_close($link);
    }

    // Add a new show to the table.
    function add_show($name, $desc, $airtime, $duration, $rating)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            INSERT INTO tbl_shows
                (name, descrpt, airtime, duration, rating)
            VALUES
                (?, ?, ?, ?, ?)
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: string string double integer double
        mysqli_stmt_bind_param($stmt, 'ssdid', $name, $desc, $airtime, $duration, $rating);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_insert_id($stmt);
    }

    // Retrieves all the shows available in the database.
    function get_all_shows()
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Retrieve all the rows from the table.
        $result = mysqli_query($link, "
            SELECT *
            FROM tbl_shows
            ORDER BY name ASC
        ");

        // 3. Disconnect from the database.
        disconnect($link);

        // 4. Return the result set.
        return $result;
    }

    // Retrieves a single show from the database.
    function get_show($id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $id = mysqli_real_escape_string($link, $id);

        // 3. Generate a query and return the result
        $result = mysqli_query($link, "
            SELECT
                name AS 'show-name',
                descrpt AS 'show-description',
                airtime AS 'show-airtime',
                duration AS 'show-duration',
                rating AS 'show-rating'
            FROM tbl_shows
            WHERE id = {$id}
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new primary key ID.
        return mysqli_fetch_assoc($result) ?: FALSE;
    }

    // Add a new show to the table.
    function edit_show($id, $name, $desc, $airtime, $duration, $rating)
    {
        if (check_show($id, $name, $desc, $airtime, $duration, $rating))
        {
            return TRUE;
        }
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            UPDATE tbl_shows
                SET
                    name = ?,
                    descrpt = ?,
                    airtime = ?,
                    duration = ?,
                    rating = ?
                WHERE
                    id = ?
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: string string double integer double
        mysqli_stmt_bind_param($stmt, 'ssdidi', $name, $desc, $airtime, $duration, $rating, $id);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have changed one row.
        return mysqli_stmt_affected_rows($stmt) == 1;
    }

    //Checks that the information in a show has changed.
    function check_show($id, $name, $desc, $airtime, $duration, $rating)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $id = mysqli_real_escape_string($link, $id);
        $name = mysqli_real_escape_string($link, $name);
        $desc = mysqli_real_escape_string($link, $desc);
        $airtime = mysqli_real_escape_string($link, $airtime);
        $duration = mysqli_real_escape_string($link, $duration);
        $rating = mysqli_real_escape_string($link, $rating);

        // 3. Generate a query and return the result
        $result = mysqli_query($link, "
            SELECT id
            FROM tbl_shows
            WHERE
                id = {$id} AND
                name = '{$name}' AND
                desc = '{$desc}' AND
                airtime = {$airtime} AND
                duration = {$duration} AND
                rating = {$rating}
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. If the query worked, we should have a new primary key ID.
        return mysqli_num_rows($result) == 1;
    }
?>
