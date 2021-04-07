<?php
ob_start();
require_once '../core.php';
require_once '../path.php';
require_once  '../app/includes/admin/header_dashboard.php';
require_once  '../app/middlewares/Auth.php';

$class = new Classes();
$monitor = new Monitor();
if (!isset($_GET['room_id'])) {
    redirect('monitoring_dashboard.php');
    die();
}

if (isset($_POST['join'])) {
    $monitor->updateClassMonitorStatus($_POST);
}
$classes = $class->getClassesActiveRoom($_GET['room_id']);
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
                            <a href="faculty_rooms.php?faculty_id=<?php echo $_GET['faculty_id'] ?>&name=<?php echo ucfirst($monitor->getUser($_GET['faculty_id'])->firstname) . ' ' . ucfirst($monitor->getUser($_GET['faculty_id'])->lastname) ?>">
                                Rooms of <span class="text-success">
                                    <?php echo ucfirst($monitor->getUser($_GET['faculty_id'])->firstname) . ' ' . ucfirst($monitor->getUser($_GET['faculty_id'])->lastname) ?>
                                </span>
                            </a>
                        </li>
                        </li>
                        <li class="breadcrumb-item flex items-center gap-2">
                            <?php echo $class->getRoom($_GET['room_id'])->subject_name ?>
                        </li>
                    </ol>
                </nav>



                <!-- Table -->

                <div class="table-responsive">

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table bg-white" id="resultTbl">
                            <thead class="thead-dark">
                                <tr class="text-center align-items-center">
                                    <th scope="col">ROOM ID</th>
                                    <th scope="col">ROOM/DEPARTMENT/SUBJECT/TIME</th>
                                    <th scope="col">MONITORING STAFF</th>
                                    <th scope="col">MONITORING STATUS</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($classes as $key => $singleClass) : ?>
                                    <tr class="text-center">
                                        <td scope="row" class="text-sm">TCU-MSU - <?php echo $singleClass->id ?></th>
                                        <td>
                                            <?php echo $monitor->getRoom($singleClass->room_id)->subject_name; ?>
                                        </td>
                                        <?php $staff = $class->getUser($singleClass->monitoring_id) ?>
                                        <td><?php echo (!empty($staff)) ? ucfirst($staff->firstname) . ' ' . ucfirst($staff->lastname) : '<span class="text-danger">pending</span>' ?></td>

                                        <td class="d-flex justify-content-center">
                                            <?php if (!is_null($singleClass->start_time) && is_null($singleClass->end_time) && !$singleClass->is_monitored) : ?>
                                                <div class="flex items-center gap-4">
                                                    <div class="w-4 h-4 rounded-full bg-red-400 relative">
                                                        <div class="absolute inset-0 w-full h-full animate-ping bg-red-500 rounded-full">
                                                        </div>
                                                    </div>
                                                    <span class="text-danger">On Going Class </span>
                                                </div>
                                            <?php elseif (!is_null($singleClass->duration)) : ?>
                                                <span class="text-green-500">Recorded</span>
                                            <?php elseif (!is_null($singleClass->monitoring_id) && $singleClass->is_monitored) : ?>
                                                <div class="flex items-center gap-4">
                                                    <div class="w-4 h-4 rounded-full bg-green-400 relative">
                                                        <div class="absolute inset-0 w-full h-full animate-ping bg-green-500 rounded-full">
                                                        </div>
                                                    </div>
                                                    <span class="text-success">On Going Class </span>
                                                </div>
                                            <?php else : ?>
                                                <span class="text-muted">idle</span>
                                            <?php endif; ?>

                                        </td>

                                        <td>

                                            <?php if (!is_null($singleClass->start_time) && is_null($singleClass->end_time) && !$singleClass->is_monitored) : ?>
                                                <form action="<?php echo $_SERVER['PHP_SELF'] . '?room_id=' . $_GET['room_id'] ?>" method="POST">
                                                    <input type="hidden" name="class_id" value="<?php echo $singleClass->id ?>">
                                                    <input type="hidden" name="faculty_id" value="<?php echo $singleClass->user_id ?>">
                                                    <input type="hidden" name="room_id" value="<?php echo $singleClass->room_id ?>">
                                                    <button type="submit" class="btn btn-success btn-sm" name="join">Join</button>
                                                </form>
                                            <?php elseif (!is_null($singleClass->duration)) : ?>


                                                <a class="btn btn-warning btn-sm" href="monitoring_class_detail.php?class_id=<?php echo $singleClass->id ?>&user_id=<?php echo $singleClass->user_id ?>&room_id=<?php echo $singleClass->room_id ?>">
                                                    <i class="fa fa-eye"></i>&ThickSpace;View
                                                </a>

                                            <?php elseif (!is_null($singleClass->monitoring_id) && $singleClass->is_monitored) : ?>

                                                <a class="btn btn-warning btn-sm" href="monitoring_class_detail.php?class_id=<?php echo $singleClass->id ?>&user_id=<?php echo $singleClass->user_id ?>&room_id=<?php echo $singleClass->room_id ?>">
                                                    <i class="fa fa-eye"></i>&ThickSpace;View
                                                </a>

                                            <?php else : ?>
                                                Unavailable
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../app/includes/admin/footer.php' ?>
<?php ob_flush(); ?>