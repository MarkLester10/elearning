<?php
ob_start();
require_once '../core.php';
require_once '../app/includes/admin/header.php';
require_once  '../app/middlewares/Auth.php';
require_once  '../app/middlewares/Admin.php';


$department = new Department();
$errors = [];

$name = '';
$id = '';
if (isset($_POST['id'])) {
    $id = sanitize($_POST['id']);
    $activeDepartment = $department->getDepartment($id);
    $name = $activeDepartment->name;
    $id = $activeDepartment->id;
}
if (isset($_POST['update'])) {
    $department->update($_POST);
    $errors = $department->validate();
}

?>

<!-- Main content -->

<!-- Main content -->

<div class="container">
    <div class="card shadow">
        <div class="card-header d-flex align-items-center">
            <h4>Update Department</h4>
        </div>
        <div class="card-body">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo $name ?>" class="form-control
                    <?php
                    if (!empty(($name))) {
                        echo $errors['name'] ? 'is-invalid' : '';
                    } else {
                        if ($errors['name']) {
                            echo 'is-invalid';
                        }
                    }
                    ?>
                    " value="<?php echo $name ?>">
                    <div class="text-danger">
                        <small><?php echo $errors['name'] ?? '' ?></small>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <div class="form-group d-flex justify-content-end align-items-center mt-2">
                        <a href="departments.php" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </div>

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