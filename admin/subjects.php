<?php
ob_start();
require_once '../core.php';
require_once '../app/includes/admin/header.php';



$activeSubject = new Subject();
$subjects = $activeSubject->index();
?>


<div class="container">
    <div class="card shadow">
        <div class="card-header d-flex align-items-center">
            <h4>Subjects</h4>
            <a href="<?php echo 'subject_create.php' ?>" class="btn btn-primary ml-auto"><i class="fas fa-plus text-light"></i></a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php if ($subjects) : ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Department</th>
                                <th scope="col">Subject Name</th>
                                <th scope="col">Schedule</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include '../app/includes/message.php' ?>

                            <?php foreach ($subjects as $key => $subject) : ?>
                                <tr>
                                    <th scope="row"><?php echo $key + 1 ?></th>
                                    <td><?php echo $activeSubject->getDepartment($subject->department_id)->name ?></td>
                                    <td><?php echo $subject->subject_name ?></td>
                                    <td><?php echo $subject->schedule ?></td>

                                    <td class="d-flex">

                                        <form action="subject_update.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $subject->id ?>">
                                            <button type="submit" class="text-warning mr-3" style="border:none; background:none">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                        </form>
                                        <form action="subject_delete.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $subject->id ?>">
                                            <button type="submit" style="border:none; background:none">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php else : ?>
                    <h2 class="text-secondary text-center">No subject Yet</h2>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->

<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php require_once  '../app/includes/admin/footer.php' ?>
<?php echo ob_flush() ?>