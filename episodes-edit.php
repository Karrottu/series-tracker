<?php
    include 'libraries/form.php';
    include 'libraries/database.php';
    include 'libraries/login-check.php';

    // 1. Store the id for the show in a variable.
    $id = $_GET['id'];

    // 2. Get the information from the database.
    // if after I set $episode, the value is FALSE:
    if (!$episode = get_episode($id))
    {
        exit("This episode doesn't exist.");
    }

    include 'template/header.php';

    $shows = get_all_shows_dropdown();
    $show_id = (array_key_exists('show', $_GET)) ? $_GET['show'] : NULL;

    $episode['episode-airdate'] = date('m/d/Y', $episode['episode-airdate']);

    // 4. only convert this data if there is nothing else on the server.
    if (!$formdata = get_formdata())
    {
        $formdata = to_formdata($episode);
    }
?>

<header class="page-header row no-gutters py-4 border-bottom">
    <div class="col-12">
        <h6 class="text-center text-md-left">Episodes</h6>
        <h3 class="text-center text-md-left">Edit Episode</h3>
    </div>
</header>

<form class="row content" action="episodes-edit-process.php" method="post">
    <div class="col-12 col-lg-9">
        <div class="card">
            <div class="card-body">
<?php if (has_error($formdata, 'episode-name')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'episode-name'); ?>
                </div>
<?php endif; ?>
                <input type="text" name="episode-name" class="form-control mb-3" placeholder="New Episode"
                    value="<?php echo get_value($formdata, 'episode-name'); ?>">

<?php if (has_error($formdata, 'episode-desc')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'episode-desc'); ?>
                </div>
<?php endif; ?>
                <textarea name="episode-desc" rows="8" cols="80" placeholder="What is this episode about?" class="form-control mb-3"><?php echo get_value($formdata, 'episode-desc'); ?></textarea>

<?php if (has_error($formdata, 'episode-show')): ?>
            <div class="alert-danger mb-3 p-3">
                <?php echo get_error($formdata, 'episode-show'); ?>
            </div>
<?php endif; ?>
            <div class="form-group row">
                <label for="input-episode-show" class="col-sm-3 col-form-label">Show:</label>
                <div class="col-sm-9">
                    <select class="custom-select mb-3" name="episode-show" id="input-episode-show">
                        <option disabled selected>Choose a Show</option>
<?php while ($show = mysqli_fetch_assoc($shows)): ?>
                        <option value="<?php echo $show['id']; ?>" <?php echo ($show['id'] == $show_id) ? 'selected' : '' ?>><?php echo $show['name']; ?></option>

<?php endwhile; ?>
                    </select>
                </div>
            </div>

<?php if (has_error($formdata, 'episode-airdate')): ?>
            <div class="alert-danger mb-3 p-3">
                <?php echo get_error($formdata, 'episode-airdate'); ?>
            </div>
<?php endif; ?>
                <div class="form-group row">
                    <label for="input-episode-airdate" class="col-sm-3 col-form-label">Air Date:</label>
                    <div class="col-sm-9">
                        <input type="text" name="episode-airdate" class="form-control mb-3" placeholder="01/01/2018"
                            id="input-episode-airdate" value="<?php echo get_value($formdata, 'episode-airdate'); ?>">
                    </div>
                </div>

<?php if (has_error($formdata, 'episode-season')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'episode-season'); ?>
                </div>
<?php endif; ?>
                <div class="form-group row">
                    <label for="input-episode-season" class="col-sm-3 col-form-label">Season:</label>
                    <div class="col-sm-9">
                        <input type="number" name="episode-season" class="form-control mb-3" placeholder="0"
                            id="input-episode-season" value="<?php echo get_value($formdata, 'episode-season'); ?>">
                    </div>
                </div>

<?php if (has_error($formdata, 'episode-episode')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'episode-episode'); ?>
                </div>
<?php endif; ?>
                <div class="form-group row">
                    <label for="input-episode-episode" class="col-sm-3 col-form-label">Episode:</label>
                    <div class="col-sm-9">
                        <input type="number" name="episode-episode" class="form-control mb-3" placeholder="0"
                            id="input-episode-episode" value="<?php echo get_value($formdata, 'episode-episode'); ?>">
                    </div>
                </div>

<?php if (has_error($formdata, 'episode-rating')): ?>
                <div class="alert-danger mb-3 p-3">
                    <?php echo get_error($formdata, 'episode-rating'); ?>
                </div>
<?php endif; ?>
                <div class="form-group row">
                    <label for="input-episode-rating" class="col-sm-3 col-form-label">Rating:</label>
                    <div class="col-sm-9">
                        <input type="number" name="episode-rating" class="form-control mb-3" placeholder="0"
                            step="0.1" id="input-episode-rating" value="<?php echo get_value($formdata, 'episode-rating'); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-3 mt-3 mt-lg-0">
        <div class="card">
            <div class="card-body">
                <input type="hidden" name="episode-id" value="<?php echo $id; ?>">

                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>

<?php include 'template/footer.php'; ?>
