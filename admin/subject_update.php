<?php
ob_start();
require_once '../core.php';
require_once '../app/includes/admin/header.php';


$subject = new Subject();
$errors = [];
$departments = $subject->getDepartments();

$subject_name = '';
$schedule = '';
$department_id = '';
$id = '';
if (isset($_POST['id'])) {
    $id = sanitize($_POST['id']);
    $activeSubject = $subject->getSubject($id);
    $subject_name = $activeSubject->subject_name;
    $schedule = $activeSubject->schedule;
    $department_id = $activeSubject->department_id;
    $id = $activeSubject->id;
} else {
    redirect('subjects.php');
}
if (isset($_POST['update'])) {
    $subject->update($_POST);
    $errors = $subject->validate();
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
                    <label for="department_id">Department</label>
                    <select name="department_id" id="department_id" class="form-control">
                        <!-- <option value="">Select Department</option> -->
                        <?php foreach ($departments as $department) : ?>
                            <option value="<?php echo $department->id ?>" <?php echo ($department->id == $department_id) ? "selected" : '' ?>>
                                <?php echo $department->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="subject_name">Subject Name</label>
                    <input type="text" name="subject_name" id="subject_name" class="form-control" value="<?php echo $subject_name ?>">

                </div>
                <div class="form-group">
                    <label for="schedule">Schedule</label>
                    <input type="text" name="schedule" id="schedule" placeholder="Day - time" class="form-control" value="<?php echo $schedule ?>" required>
                    <small class="text-info">Eg: Monday- 6:30-8:30 PM</small>
                </div>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <div class="form-group d-flex justify-content-end align-items-center mt-2">
                    <a href="subjects.php" class="btn btn-secondary mr-2">Cancel</a>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
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