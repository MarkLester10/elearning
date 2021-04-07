<?php
ob_start();
require_once '../core.php';
require_once '../path.php';
require_once  '../app/includes/admin/header_dashboard.php';
require_once  '../app/middlewares/Auth.php';

$class = new Classes();
$monitor = new Monitor();
$departments = $monitor->getDepartments();

if (!isset($_GET['dept_id'])) {
    redirect('monitoring_dashboard.php');
}
$faculties = $monitor->index($_GET['dept_id']);

$activeUser = $class->getUser($_SESSION['id']);
?>

<!-- Main content -->

<section class="content">
    <div class="relative md:-top-24">
        <div class="container mx-auto bg-white shadow-lg border-2 border-gray-400 mt-12 rounded-md">
            <!-- profile -->
            <div class="container mx-auto relative -top-16">

                <div class="flex items-center justify-center flex-col">
                    <div class="bg-white h-32 p-2 w-32 rounded-full">
                        <?php if ($activeUser->image) : ?>
                            <img src="../assets/imgs/profiles/<?php echo $activeUser->image ?>" class="h-full w-full object-cover rounded-full ring" alt="">
                        <?php else : ?>
                            <img src="https://ui-avatars.com/api/?name=<?php echo ucfirst($activeUser->firstname) . ' ' . ucfirst($activeUser->lastname) ?>" class="h-full w-full object-cover rounded-full ring" alt="profile">
                        <?php endif ?>

                    </div>
                    <div class="mt-4 text-center">
                        <h1 class="text-lg font-bold"><?php echo ucfirst($activeUser->firstname) . ' ' . ucfirst($activeUser->lastname) ?></h1>
                        <hr class="block my-2">
                        <h2 class="uppercase">Monitoring</h2>
                    </div>
                </div>

                <!--message-->
                <?php include '../app/includes/message.php' ?>

                <!-- breadcrumbs -->
                <nav aria-label="breadcrumb" class="mt-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item flex items-center gap-2">
                            <i class="fa fa-check-circle text-green-500"></i>
                            <a href="monitoring_dashboard.php">Department List</a>
                        </li>
                        <li class="breadcrumb-item flex items-center gap-2">
                            Faculty List
                        </li>
                    </ol>
                </nav>



                <!-- Table -->

                <div class="table-responsive">

                    <table class="table bg-white" id="resultTbl">
                        <thead class="thead-dark">
                            <tr class="text-center align-items-center">
                                <th scope="col">ROOM ID</th>
                                <th scope="col">FACULTY NAME</th>
                                <th scope="col">MONITORING STATUS</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php foreach ($faculties as $faculty) : ?>
                                <tr>
                                    <td>TCU-MSU -<?php echo $faculty->id ?></td>
                                    <td>
                                        <?php echo ucfirst($monitor->getUser($faculty->id)->firstname) . ' ' . ucfirst($monitor->getUser($faculty->id)->lastname) ?>
                                    </td>
                                    <td class="text-muted">
                                        <?php if (!$faculty->is_monitored && !$faculty->is_sent_to_monitoring) : ?>
                                            <span class="text-muted">Idle</span>
                                        <?php elseif (!$faculty->is_monitored && $faculty->is_sent_to_monitoring) : ?>
                                            <span class="text-danger">On Going Class - Not Monitored</span>
                                        <?php elseif ($faculty->is_monitored && $faculty->is_sent_to_monitoring) : ?>
                                            <span class="text-success">On Going Class - Monitored</span>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <a href="faculty_rooms.php?faculty_id=<?php echo $faculty->id ?>&name=<?php echo ucfirst($monitor->getUser($faculty->id)->firstname) . ' ' . ucfirst($monitor->getUser($faculty->id)->lastname) ?>" class="btn btn-warning btn-sm space-x-2 p-2">
                                            <i class="fa fa-eye"></i> View Rooms
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../app/includes/admin/footer.php' ?>
<?php ob_flush(); ?>