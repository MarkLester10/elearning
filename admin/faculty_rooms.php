<?php
ob_start();
require_once '../core.php';
require_once '../path.php';
require_once  '../app/includes/admin/header_dashboard.php';
require_once  '../app/middlewares/Auth.php';

$class = new Classes();
$monitor = new Monitor();
$departments = $monitor->getDepartments();

if (!isset($_GET['faculty_id'])) {
    redirect('monitoring_dashboard.php');
}
$rooms = $monitor->getRooms($_GET['faculty_id']);

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
                            Faculty Rooms
                        </li>
                    </ol>
                </nav>

                <div class="p-2 bg-gray-800 text-white my-2 shadow-md text-lg text-center rounded-md">
                    Available Rooms of <br>
                    <h1 class="text-green-400"><?php echo ucfirst($monitor->getUser($_GET['faculty_id'])->firstname) . ' ' . ucfirst($monitor->getUser($_GET['faculty_id'])->lastname) ?>
                    </h1>
                </div>



                <!-- Table -->

                <div class="table-responsive">

                    <table class="table bg-white" id="resultTbl">
                        <thead class="thead-dark">
                            <tr class="text-center align-items-center">
                                <th scope="col">ID</th>
                                <th scope="col">Department/Subject/Schedule</th>
                                <th scope="col">Class Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php foreach ($rooms as $room) : ?>
                                <tr>
                                    <td>TCU-MSU -<?php echo $room->id ?></td>
                                    <td><a href="monitoring_faculty_classes.php?room_id=<?php echo $room->id ?>" class="text-info underline">
                                            TCU-MSU -<?php echo $room->subject_name ?>
                                        </a></td>
                                    <td class="text-muted">
                                        <?php $class = $monitor->getClassesByRoomId($room->id); ?>
                                        <?php if (!empty($class)) : ?>
                                            <span class="text-success">On Going Class</span>
                                        <?php else : ?>
                                            <span class="text-muted">Idle</span>
                                        <?php endif; ?>
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