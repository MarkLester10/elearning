<?php
ob_start();
require_once '../core.php';
require_once '../app/includes/admin/header.php';


$subject = new Subject();


if (isset($_POST['id'])) {
    $id = sanitize($_POST['id']);
    $activeSubject = $subject->getSubject($id);
} else {
    redirect('subjects.php');
}
if (isset($_POST['delete'])) {
    $subject->delete($_POST['id']);
}




?>

<!-- Main content -->

<!-- Main content -->

<div class="container">
    <div class="card shadow">
        <div class="card-body">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="form-group">
                    <h1 class="text-2xl font-weight-bold">Are you sure you want to delete <?php echo $activeSubject->subject_name ?>?</h1>
                    <div class="form-group d-flex justify-content-end align-items-center mt-2">
                        <input type="hidden" name="id" value="<?php echo $activeSubject->id ?>">
                        <a href="subjects.php" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
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

<?php require_once  '../app/includes/admin/footer.php' ?>
<?php ob_flush(); ?>