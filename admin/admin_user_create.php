<?php
ob_start();
require_once '../core.php';
require_once '../app/includes/admin/header.php';
require_once  '../app/middlewares/Auth.php';
require_once  '../app/middlewares/Admin.php';



$adminUser = new AdminUser();
$positions = $adminUser->getPositions();
$errors = [];

$email = '';
if (isset($_POST['create'])) {
    $adminUser->create($_POST);
    $errors = $adminUser->validate();

    $data = $adminUser->getData();
    $email = $data['email'];
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
}


?>

<!-- Main content -->

<!-- Main content -->

<div class="container">
    <div class="card shadow">
        <div class="card-header d-flex align-items-center">
            <h4>Create new User</h4>
        </div>
        <div class="card-body">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="form-group">
                    <label for="firstname">Firstname</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" required value="<?php echo $firstname ?? '' ?>">
                </div>
                <div class="form-group">
                    <label for="lastname">Lastname</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required value="<?php echo $lastname ?? '' ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control
                    <?php
                    if (!empty(($email))) {
                        echo $errors['email'] ? 'is-invalid' : 'is-valid';
                    } else {
                        if ($errors['email']) {
                            echo 'is-invalid';
                        }
                    }
                    ?>
                    " value="<?php echo $email ?? '' ?>">
                    <div class="text-danger">
                        <small><?php echo $errors['email'] ?? '' ?></small>
                    </div>
                </div>
                <div class="form-group">
                    <label for="position_id">Position</label>
                    <select name="position_id" id="position_id" class="form-control" required>
                        <option value="">Select Position</option>
                        <?php foreach ($positions as $position) : ?>
                            <option value="<?php echo  $position->id ?>"><?php echo $position->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <a href="admin_users.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" name="create" class="btn btn-primary">Create</button>
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