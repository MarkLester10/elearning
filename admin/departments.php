<?php
ob_start();
require_once '../core.php';
require_once '../app/includes/admin/header.php';
require_once  '../app/middlewares/Auth.php';
require_once  '../app/middlewares/Admin.php';



$activeDepartment = new Department();
$departments = $activeDepartment->index();
?>


<div class="container">
    <div class="card shadow">
        <div class="card-header d-flex align-items-center">
            <h4>Departments</h4>
            <a href="<?php echo 'department_create.php' ?>" class="btn btn-primary ml-auto"><i class="fas fa-plus text-light"></i></a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php if ($departments) : ?>
                    <table class="table" id="resultTbl">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include '../app/includes/message.php' ?>

                            <?php foreach ($departments as $key => $department) : ?>
                                <tr>
                                    <th scope="row"><?php echo $key + 1 ?></th>
                                    <td><?php echo $department->name ?></td>

                                    <td class="d-flex">

                                        <form action="department_update.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $department->id ?>">
                                            <button type="submit" class="text-warning mr-3" style="border:none; background:none">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                        </form>
                                        <form action="department_delete.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $department->id ?>">
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
                    <h2 class="text-secondary text-center">No Department Yet</h2>
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