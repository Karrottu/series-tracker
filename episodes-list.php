<?php
    include 'libraries/database.php';
    include 'libraries/login-check.php';

    include 'template/header.php';

    // 1. Store the id for the show in a variable.
    $id = $_GET['id'];

    // 2. Get the information from the database.
    // if after I set $show, the value is FALSE:
    if (!$show = get_show($id))
    {
        exit("This show doesn't exist.");
    }

    // 3. Get the episodes for this show.
    $episodes = get_all_episodes($_GET['id']);
?>

<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">Episodes</h6>
        <h3 class="text-center text-md-left"><?php echo $show['show-name']; ?></h3>
    </div>
</header>

<div class="row content">
    <div class="col">

        <div class="card">
            <div class="card-header border-bottom-0">
                <div class="float-right">
                    <a href="episodes-add.php?show=<?php echo $id; ?>">New Episode</a>
                </div>
                <h6 class="m-0"><?php echo $show['show-name']; ?> episodes</h6>
            </div>

            <div class="card-body p-0 text-center">
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Rating</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
<?php while($row = mysqli_fetch_assoc($episodes)): ?>
                        <tr>
                            <td><span class="counter"></span></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['rating']; ?></td>
                            <td>
                                <a href="episodes-edit.php?id=<?php echo $row['id']; ?>&amp;show=<?php echo $id; ?>">
                                    <i class="icon fas fa-pencil-alt"></i>
                                </a>
                                <a href="episodes-delete.php?id=<?php echo $row['id']; ?>&amp;show=<?php echo $id; ?>">
                                    <i class="icon fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>

<?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


<?php include 'template/footer.php'; ?>
