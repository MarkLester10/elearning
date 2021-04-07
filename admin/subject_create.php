<?php
ob_start();
require_once '../core.php';
require_once '../app/includes/admin/header.php';



$subject = new Subject();
$subjects = $subject->index();
$departments = $subject->getDepartments();
$errors = [];

$subject_name = '';
$schedule = '';
$department_id = '';
$subject_code = '';
if (isset($_POST['create'])) {
    $subject->create($_POST);
    $errors = $subject->validate();
    $data = $subject->getData();
}


?>

<!-- Main content -->

<!-- Main content -->

<div class="container">
    <div class="card shadow">
        <div class="card-header d-flex align-items-center">
            <h4>Create Subject</h4>
        </div>
        <div class="card-body">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="form-group">
                    <label for="department_id">Department</label>
                    <select name="department_id" id="department_id" class="form-control">
                        <option value="">Select Department</option>
                        <?php foreach ($departments as $department) : ?>
                            <option value="<?php echo $department->id ?>" <?php echo ($department_id === $department->id) ? 'selected' : '' ?>>
                                <?php echo $department->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="subject_code">Subject Code</label>
                    <input type="text" name="subject_code" id="subject_code" class="form-control" value="<?php echo $subject_code ?>">
                </div>
                <div class="form-group">
                    <label for="subject_name">Subject Name</label>
                    <input type="text" name="subject_name" id="subject_name" class="form-control" value="<?php echo $subject_name ?>">

                </div>
                <div class="form-group">
                    <label for="schedule">Schedule</label>
                    <input type="text" name="schedule" id="schedule" placeholder="Day - time" value="<?php echo $schedule ?>" class="form-control" required>
                    <small class="text-info">Eg: Monday-Thurdsday-Friday 6:30-8:30 PM</small>
                </div>
                <div class="form-group d-flex justify-content-end align-items-center mt-2">
                    <a href="subjects.php" class="btn btn-secondary mr-2">Cancel</a>
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