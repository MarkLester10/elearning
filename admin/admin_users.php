<?php
ob_start();
require_once '../path.php';
require_once '../core.php';
require_once '../app/includes/admin/header.php';
require_once  '../app/middlewares/Auth.php';
require_once  '../app/middlewares/Admin.php';


$adminUser = new AdminUser();



$users = $adminUser->index();
?>


<div class="container">
    <div class="card shadow">
        <div class="card-header d-flex align-items-center">
            <h4>Users</h4>
            <a href="admin_user_create.php" class="btn btn-primary ml-auto"><i class="fas fa-plus text-light"></i></a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php if ($users) : ?>
                    <table class="table" id="resultTbl">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fullname</th>
                                <th scope="col">Image</th>
                                <th scope="col">Email</th>
                                <th scope="col">Position</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php include '../app/includes/message.php' ?>

                            <?php foreach ($users as $key => $singleUser) : ?>
                                <tr class="align-items-center">
                                    <th scope="row"><?php echo $key + 1 ?></th>
                                    <td><a href="admin_user_detail.php?id=<?php echo $singleUser->id ?>"><?php echo $singleUser->firstname . ' ' . $singleUser->lastname ?></a></td>
                                    <td>
                                        <img class="rounded-circle" width="35" src="https://ui-avatars.com/api/?name=<?php echo $singleUser->firstname . ' ' . $singleUser->lastname ?>" alt="image">
                                    </td>

                                    <td><?php echo $singleUser->email ?></td>
                                    <td><?php echo $adminUser->getPosition($singleUser->position_id)->name ?></td>



                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php else : ?>
                    <h2 class="text-secondary text-center">No User Yet</h2>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->

<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php require_once BASE . '/app/includes/admin/footer.php' ?>
<?php ob_flush() ?>