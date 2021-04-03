<?php
ob_start();
require_once '../path.php';
require_once '../core.php';
require_once '../app/includes/admin/header.php';
require_once  '../app/middlewares/Auth.php';
require_once  '../app/middlewares/Admin.php';

$adminUser = new AdminUser();
$user = '';


if (isset($_GET['id'])) {
    $user = $adminUser->getUser($_GET['id']);
} else {
    redirect('admin_users.php');
}

?>


<div class="container">
    <div class="card shadow">
        <div class="card-header d-flex align-items-center">
            <h4>Users Detail</h4>
        </div>
        <div class="card-body">
            <a href="admin_users.php"><i class="fas fa-arrow-circle-left text-success mb-2" style="font-size: 1.5rem"></i></a>
            <div class="table-responsive">
                <?php if ($user) : ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Fullname</th>
                                <th scope="col">Image</th>
                                <th scope="col">Email</th>
                                <th scope="col">Position</th>
                                <th scope="col">Department</th>
                                <th scope="col">Birth Day</th>
                                <th scope="col">Degree</th>
                                <th scope="col">Job</th>
                                <th scope="col">Mobile Number</th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php include '../app/includes/message.php' ?>


                            <tr class="align-items-center">
                                <td><a href="admin_user_detail.php?id=<?php echo $user->id ?>"><?php echo $user->firstname . ' ' . $user->lastname ?></a></td>
                                <td>
                                    <img class="rounded-circle" width="35" src="https://ui-avatars.com/api/?name=<?php echo $user->firstname . ' ' . $user->lastname ?>" alt="image">
                                </td>

                                <td><?php echo $user->email ?></td>
                                <td><?php echo $adminUser->getPosition($user->position_id)->name ?></td>
                                <td><?php echo $adminUser->getDepartment($user->department_id)->name ?? 'unset' ?></td>
                                <td><?php echo is_null($user->b_day) ? 'unset' : defaultDate($user->b_day) ?></td>
                                <td><?php echo $user->degree ?? 'unset' ?></td>
                                <td><?php echo $user->job ?? 'unset' ?></td>
                                <td><?php echo $user->mobile_no ?? 'unset' ?></td>
                            </tr>


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