<?php
ob_start();
require_once '../core.php';
require_once '../app/includes/admin/header.php';
require_once  '../app/middlewares/Auth.php';




$adminUser = new AdminUser();
$positions = $adminUser->getPositions();
$errors = [];


$activeDepartment = new Department();
$departments = $activeDepartment->index();

$email = '';
if (isset($_POST['create'])) {
    print_r($_POST);
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
                            <label for="department_id">Select Department</label>
                            <select name="department_id" id="department_id" class="form-control">
                                <option value="" required> Choose Department</option>
                                <?php foreach ($departments as $department) : ?>
                                    <option value="<?php echo $department->id ?>" required><?php echo $department->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="image">Profile Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="mobile_no">Mobile Number</label>
                            <input type="number" name="mobile_number" required id="mobile_no" class="form-control">
                        </div>
                        <div class="col">
                            <label for="b_day">Birth Date</label>
                            <input type="date" name="b_day" id="b_day" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="job">Job</label>
                            <input type="text" name="job" id="job" class="form-control">
                        </div>
                        <div class="col">
                            <label for="degree">Degree</label>
                            <input type="text" name="degree" id="b_day" required class="form-control">
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

<?php require_once '../app/includes/admin/footer.php';
ob_flush();
?>