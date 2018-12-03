<?php
    // Connects to the MySQL database.
    function connect()
    {
        // 1. Assign a new connection to a new variable.
        $link = mysqli_connect('localhost', 'root', '', 'db_series_tracker')
            or die('Could not connect to the database.');

        // 2. Give back the variable so we can always use it.
        return $link;
    }

    // Disconnects the website from the database.
    function disconnect(&$link)
    {
        mysqli_close($link);
    }

    // Add a new channel to the table.
    function add_channel($name)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            INSERT INTO tbl_channels
                (name)
            VALUES
                (?)
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: string string double integer double
        mysqli_stmt_bind_param($stmt, 's', $name);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_insert_id($stmt);
    }

    // Add a new show to the table.
    function add_episode($name, $desc, $airdate, $season, $episode, $rating, $show)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            INSERT INTO tbl_episodes
                (name, description, season, episode, airdate, rating, show_id)
            VALUES
                (?, ?, ?, ?, ?, ?, ?)
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: string string double integer double
        mysqli_stmt_bind_param($stmt, 'ssiiidi', $name, $desc, $season, $episode, $airdate, $rating, $show);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_insert_id($stmt);
    }

    // Add a new show to the table.
    function add_show($name, $desc, $airtime, $duration, $rating, $channel)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            INSERT INTO tbl_shows
                (name, description, airtime, duration, rating, channel_id)
            VALUES
                (?, ?, ?, ?, ?, ?)
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: string string double integer double
        mysqli_stmt_bind_param($stmt, 'ssdidi', $name, $desc, $airtime, $duration, $rating, $channel);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_insert_id($stmt);
    }

    // Checks that the information in a channel has changed.
    function check_channel($id, $name)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $id = mysqli_real_escape_string($link, $id);
        $name = mysqli_real_escape_string($link, $name);

        // 3. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT id
            FROM tbl_channels
            WHERE
                id = {$id} AND
                name = '{$name}'
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. There should only be one row, or FALSE if nothing.
        return mysqli_num_rows($result) == 1;
    }

    // Checks that the information in a show has changed.
    function check_show($id, $name, $desc, $airtime, $duration, $rating, $channel)
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
        $channel = mysqli_real_escape_string($link, $channel);

        // 3. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT id
            FROM tbl_shows
            WHERE
                id = {$id} AND
                name = '{$name}' AND
                description = '{$desc}' AND
                airtime = {$airtime} AND
                duration = {$duration} AND
                rating = {$rating}
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. There should only be one row, or FALSE if nothing.
        return mysqli_num_rows($result) == 1;
    }

    // Deletes a channel from the table.
    function delete_channel($id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            DELETE FROM tbl_channels
            WHERE id = ?
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: integer
        mysqli_stmt_bind_param($stmt, 'i', $id);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have changed one row.
        return mysqli_stmt_affected_rows($stmt) == 1;
    }

    // Deletes a show from the table.
    function delete_show($id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            DELETE FROM tbl_shows
            WHERE id = ?
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: integer
        mysqli_stmt_bind_param($stmt, 'i', $id);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have changed one row.
        return mysqli_stmt_affected_rows($stmt) == 1;
    }

    // Edit a channel in the table.
    function edit_channel($id, $name)
    {
        if (check_show($id, $name))
        {
            return TRUE;
        }

        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare the statement using mysqli
        // to take care of any potential SQL injections.
        $stmt = mysqli_prepare($link, "
            UPDATE tbl_channels
            SET
                name = ?
            WHERE
                id = ?
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: string string double integer double integer
        mysqli_stmt_bind_param($stmt, 'si', $name, $id);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have changed one row.
        return mysqli_stmt_affected_rows($stmt) == 1;
    }

    // Edit a show in the table.
    function edit_show($id, $name, $desc, $airtime, $duration, $rating, $channel)
    {
        if (check_show($id, $name, $desc, $airtime, $duration, $rating, $channel))
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
                description = ?,
                airtime = ?,
                duration = ?,
                rating = ?,
                channel_id = ?
            WHERE
                id = ?
        ");

        // 3. Bind the parameters so we don't have to do the work ourselves.
        // the sequence means: string string double integer double integer
        mysqli_stmt_bind_param($stmt, 'ssdidii', $name, $desc, $airtime, $duration, $rating, $channel, $id);

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have changed one row.
        return mysqli_stmt_affected_rows($stmt) == 1;
    }

    // Retrieves all the channels available in the database.
    function get_all_channels()
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Retrieve all the rows from the table.
        $result = mysqli_query($link, "
            SELECT *
            FROM tbl_channels
            ORDER BY name ASC
        ");

        echo mysqli_error($link);

        // 3. Disconnect from the database.
        disconnect($link);

        // 4. Return the result set.
        return $result;
    }

    // Retrieves all the episodes for the selected show.
    function get_all_episodes($show_id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect the variables.
        $show_id = mysqli_real_escape_string($link, $show_id);

        // 3. Retrieve all the rows from the table.
        $result = mysqli_query($link, "
            SELECT *
            FROM tbl_episodes
            WHERE show_id = {$show_id}
            ORDER BY season ASC, episode ASC
        ");

        echo mysqli_error($link);

        // 3. Disconnect from the database.
        disconnect($link);

        // 4. Return the result set.
        return $result;
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

    // Retrieves all the shows available in the database for a dropdown list.
    function get_all_shows_dropdown()
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Retrieve all the rows from the table.
        $result = mysqli_query($link, "
            SELECT id, name
            FROM tbl_shows
            ORDER BY name ASC
        ");

        // 3. Disconnect from the database.
        disconnect($link);

        // 4. Return the result set.
        return $result;
    }

    // Retrieves a single channel from the database.
    function get_channel($id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $id = mysqli_real_escape_string($link, $id);

        // 3. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT
                name AS 'channel-name'
            FROM tbl_channels
            WHERE id = {$id}
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. There should only be one row, or FALSE if nothing.
        return mysqli_fetch_assoc($result) ?: FALSE;
    }

    // Retrieves a single show from the database.
    function get_show($id)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect variables to avoid any SQL injection
        $id = mysqli_real_escape_string($link, $id);

        // 3. Generate a query and return the result.
        $result = mysqli_query($link, "
            SELECT
                name AS 'show-name',
                description AS 'show-desc',
                airtime AS 'show-airtime',
                duration AS 'show-duration',
                rating AS 'show-rating',
                channel_id AS 'show-channel'
            FROM tbl_shows
            WHERE id = {$id}
        ");

        // 4. Disconnect from the database.
        disconnect($link);

        // 5. There should only be one row, or FALSE if nothing.
        return mysqli_fetch_assoc($result) ?: FALSE;
    }
?>
