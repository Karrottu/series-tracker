<?php
    include 'libraries/form.php';
    include 'libraries/database.php';

    // 1. Store the id for the channel in a variable.
    $id = $_GET['id'];

    // 2. Get the information from the database.
    // if after I set $channel, the value is FALSE:
    if (!$channel = get_channel($id))
    {
        exit("This channel doesn't exist.");
    }

    // 3. only convert this data if there is nothing else on the server.
    if (!$formdata = get_formdata())
    {
        $formdata = to_formdata($channel);
    }

    include 'template/header.php';
?>
<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">Channels</h6>
        <h3 class="text-center text-md-left">Edit Channel</h3>
    </div>
</header>

<form class="row content" action="channels-edit-process.php" method="post">
    <div class="col-12 col-lg-9">
        <div class="card">
            <div class="card-body">
<?php if (has_error($formdata, 'channel-name')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'channel-name'); ?>
                </div>
<?php endif; ?>
                <input type="text" name="channel-name" class="form-control mb-3" placeholder="New channel"
                    value="<?php echo get_value($formdata, 'channel-name'); ?>">
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-3 mt-3 mt-lg-0">
        <div class="card">
            <div class="card-body">
                <input type="hidden" name="channel-id" value="<?php echo $id; ?>">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>

<?php include 'template/footer.php'; ?>
