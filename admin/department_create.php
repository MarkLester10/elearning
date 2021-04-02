<?php
ob_start();
require_once '../core.php';
require_once '../app/includes/admin/header.php';



$department = new Department();
$departments = $department->index();
$errors = [];

$name = '';
if (isset($_POST['create'])) {
    $department->create($_POST);
    $errors = $department->validate();
}


?>

<!-- Main content -->

<!-- Main content -->

<div class="container">
    <div class="card shadow">
        <div class="card-header d-flex align-items-center">
            <h4>Departments</h4>
        </div>
        <div class="card-body">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control
                    <?php
                    if (!empty(($name))) {
                        echo $errors['name'] ? 'is-invalid' : 'is-valid';
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
                    <div class="form-group d-flex justify-content-end align-items-center mt-2">
                        <a href="departments.php" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" name="create" class="btn btn-primary">Create</button>
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