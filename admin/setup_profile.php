<?php
ob_start();
include '../core.php';
include '../path.php';
include '../app/includes/admin/header.php';
include  '../app/middlewares/Auth.php';




$adminUser = new AdminUser();
$activeUser = $adminUser->getUser($_SESSION['id']);
$positions = $adminUser->getPositions();
$errors = [];

$image = '';

if (!empty($activeUser->image)) {
    $image = '../assets/imgs/profiles/' . $activeUser->image;
} else {
    $image = '../assets/imgs/logo.png';
}
$activeDepartment = new Department();
$departments = $activeDepartment->index();


$email = '';
if (isset($_POST['create'])) {
    // dump($_POST);
    $adminUser->setUpProfile($_POST, $_FILES);
}


?>

<!-- Main content -->

<!-- Main content -->

<div class="container">
    <div class="card shadow">
        <?php include '../app/includes/message.php' ?>
        <div class="card-header d-flex align-items-center">
            <h4>Fill up account information </h4>
        </div>
        <div class="card-body">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo $activeUser->firstname ?? '' ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="lastname">Lastname</label>
                                <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo $activeUser->lastname ?? '' ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="email"> Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo $activeUser->email ?? '' ?>">
                            </div>
                        </div>
                        <div class="col">
                            <h2>Preview Image</h2>

                            <img src="<?php echo $image ?>" alt="profile" id="screenshotPreview" width="100" height="100" class="border my-2 p-2">

                        </div>


                    </div>
                    <div class="row">

                        <div class="col <?php echo ($activeUser->position_id == 3) ? 'd-none' : '' ?>">
                            <label for="department_id">Select Department</label>
                            <select name="department_id" id="department_id" required class="form-control" <?php echo ($activeUser->position_id == 3) ? 'disabled' : '' ?>>
                                <option value=""> Choose Department</option>
                                <?php foreach ($departments as $department) : ?>
                                    <option value="<?php echo $department->id ?>" <?php echo ($department->id == $activeUser->department_id) ? 'selected' : '' ?>>
                                        <?php echo $department->name ?>

                                    </option>

                                <?php endforeach; ?>
                            </select>

                        </div>


                        <div class="col">
                            <label for="image">Profile Image</label>
                            <input type="file" onchange="displayImage(this, '#screenshotPreview')" name="image" id="image" class="form-control" required>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="mobile_no">Mobile Number</label>
                            <input type="number" name="mobile_no" required id="mobile_no" class="form-control" value="<?php echo $activeUser->mobile_no  ?>">
                        </div>
                        <div class="col">
                            <label for="b_day">Birth Date</label>
                            <small class="text-info">(<?php echo shortDate($activeUser->b_day, false) ?>)</small>
                            <input type="date" name="b_day" id="b_day" required class="form-control" value="<?php echo $activeUser->b_day ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col <?php echo ($activeUser->position_id == 3) ? 'd-none' : '' ?>">
                            <label for="job">Job</label>
                            <select name="job" id="job" class="form-control" required <?php echo ($activeUser->position_id == 3) ? 'disabled' : '' ?>>
                                <option value="">Choose Job</option>
                                <option value="full-time" <?php echo ($activeUser->job == 'full-time') ? 'selected' : '' ?>>Full Time</option>
                                <option value="part-time" <?php echo ($activeUser->job == 'part-time') ? 'selected' : '' ?>>Part Time</option>
                            </select>
                            <!-- <input type="text" name="job" id="job" class="form-control" value="<?php echo $activeUser->job ?>"> -->
                        </div>
                        <div class="col <?php echo ($activeUser->position_id == 3) ? 'd-none' : '' ?>">
                            <label for="degree">Degree</label>
                            <select name="degree" id="degree" class="form-control" required <?php echo ($activeUser->position_id == 3) ? 'disabled' : '' ?>>
                                <option value="">Choose Degree</option>
                                <option value="graduate" <?php echo ($activeUser->degree == 'graduate') ? 'selected' : '' ?>>Graduate</option>
                                <option value="under-graduate" <?php echo ($activeUser->degree == 'under-graduate') ? 'selected' : '' ?>>Under Graduate</option>
                            </select>


                            <!-- <input type="text" name="degree" id="degree" required class="form-control" value="<?php echo $activeUser->degree ?>"> -->
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <a href="faculty_dashboard.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" name="create" class="btn btn-primary">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.content -->

<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function displayImage(e, display) {
        if (e.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                document.querySelector(display).setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    }
</script>
<?php require_once '../app/includes/admin/footer.php';
ob_flush();
?>