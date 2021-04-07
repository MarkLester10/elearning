<?php
ob_start();
require_once '../core.php';
require_once '../path.php';
require_once  '../app/includes/admin/header_dashboard.php';
require_once  '../app/middlewares/Auth.php';



$class = new Classes();
$classes = $class->getResults();
if (!isset($_GET['room_id'])) {
    redirect('faculty_dashboard.php');
}
$activeClasses = $class->getClassesActiveRoom($_GET['room_id']);
$activeUser = $class->getUser($_SESSION['id']);
$activeRoom = $class->getRoom($_GET['room_id']);

$activeClassToday = $class->getActiveClassToday($_GET['room_id']);

if (isset($_POST['send_to_monitoring'])) {
    $class->createClass($_POST, $_FILES);
}
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
                        <h2 class="uppercase">Faculty</h2>
                    </div>
                </div>

                <!-- breadcrumbs -->
                <nav aria-label="breadcrumb" class="mt-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item flex items-center gap-2">
                            <i class="fa fa-check-circle text-green-500"></i>
                            <a href="faculty_dashboard.php">Room List</a>
                        </li>
                        <li class="breadcrumb-item flex items-center gap-2">

                            <?php echo $activeRoom->subject_name ?>
                        </li>
                    </ol>
                </nav>

                <!-- Form -->
                <?php if (empty($activeClassToday)) : ?>
                    <div class="w-8/12 mx-auto px-2">
                        <form action="<?php echo $_SERVER['PHP_SELF'] . '?room_id=' . $_GET['room_id'] ?>" class="mt-12" enctype="multipart/form-data" method="POST">
                            <div class="form-group">
                                <div class="flex items-center justify-center border border-red-300 p-6">
                                    <img src="../assets/imgs/logo.png" alt="#" class="w-32" id="screenshotPreview">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="#">Class Screen Shot</label>
                                <input class="form-control" type="file" name="screen_shot" onchange="displayImage(this, '#screenshotPreview')">
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="department_id" value="<?php echo $activeRoom->department_id ?>">
                                <input type="hidden" name="room_id" value="<?php echo $_GET['room_id'] ?>">
                                <button type="submit" class="btn btn-danger btn-md" name="send_to_monitoring">Send to Monitoring</button>
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Please Make sure to send your class to monitoring before lecturing, so our monitoring staff will save
                                    your records.
                                </small>
                                <br>

                                <!-- <a href="#" class="btn btn-success btn-md mt-4" target="_blank" id="start_class">Go to Class</a> -->

                            </div>
                        </form>
                    </div>
                <?php endif; ?>


                <!-- Table -->
                <div class="table-responsive">
                    <table class="table bg-white" id="resultTbl">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th scope="col">DEPARTMENT</th>
                                <th scope="col">MONITORING STAFF</th>
                                <th scope="col">FACULTY NAME</th>
                                <th scope="col">SUBJECT</th>
                                <th scope="col">DATE</th>
                                <th scope="col">MONITORING STATUS</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activeClasses as $key => $singleClass) : ?>
                                <tr class="text-center">
                                    <td>
                                        <?php echo $class->getDepartment($singleClass->department_id)->name ?>
                                    </td>

                                    <td>
                                        <?php $staff = $class->getUser($singleClass->monitoring_id) ?>
                                        <?php echo (!empty($staff)) ? ucfirst($staff->firstname) . ' ' . ucfirst($staff->lastname) : '<span class="text-danger">pending</span>' ?>
                                    </td>

                                    <td>
                                        <?php echo ucfirst($activeUser->firstname) . ' ' . ucfirst($activeUser->lastname) ?>
                                    </td>
                                    <td>
                                        <a href="class.php?room_id=<?php echo $activeRoom->id ?>&class_id=<?php echo $singleClass->id ?>" class="text-info underline">
                                            <?php echo $class->getSubject($activeRoom->subject_schedule_id)->subject_code . '-'
                                                . $class->getSubject($activeRoom->subject_schedule_id)->subject_name ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo shortDate($singleClass->created_at) ?>
                                    </td>
                                    <td class="flex items-center justify-center ">
                                        <?php if (!is_null($singleClass->start_time) && is_null($singleClass->end_time)) : ?>
                                            <div class="w-4 h-4 rounded-full bg-red-400 relative">
                                                <div class="absolute inset-0 w-full h-full animate-ping bg-red-500 rounded-full">
                                                </div>
                                            </div>
                                        <?php elseif (!is_null($singleClass->start_time) && !is_null($singleClass->end_time)) : ?>
                                            <span class="text-green-500">Recorded</span>
                                        <?php else : ?>
                                            <span class="text-muted">not monitored</span>
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


<?php require_once '../app/includes/admin/footer.php' ?>

<script>
    function displayImage(e, display) {
        if (e.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                document.querySelector(display).setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    }
</script>
<?php ob_flush(); ?>