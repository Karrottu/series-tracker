<?php
    include 'libraries/database.php';

    include 'template/header.php';

    $channels = get_all_channels();
?>

<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">Channels</h6>
        <h3 class="text-center text-md-left">All Channels</h3>
    </div>
</header>

<div class="row content">
    <div class="col">

        <div class="card">
            <div class="card-header border-bottom-0">
                <h6 class="m-0">Table</h6>
            </div>

            <div class="card-body p-0 text-center">
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
<?php while($row = mysqli_fetch_assoc($channels)): ?>
                        <tr>
                            <td><span class="counter"></span></td>
                            <td><?php echo $row['name']; ?></td>
                            <td>
                                <a href="channels-edit.php?id=<?php echo $row['id']; ?>">
                                    <i class="icon fas fa-pencil-alt"></i>
                                </a>
                                <a href="channels-delete.php?id=<?php echo $row['id']; ?>">
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
