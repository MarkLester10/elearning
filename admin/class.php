<?php
ob_start();
require_once '../core.php';
require_once '../path.php';
require_once  '../app/includes/admin/header_dashboard.php';

$class = new Classes();
$activeUser = $class->getUser($_SESSION['id']);
if (!isset($_GET['id'])) {
  redirect('faculty_dashboard.php');
}

if (isset($_POST['send_to_monitoring'])) {
  $class->updateClass($_POST, $_FILES);
}

if (isset($_POST['end_class'])) {
  $class->updateEndClass($_POST);
}
$activeClass = $class->getClass($_GET['id']);

$screenshot = '../assets/imgs/logo.png';

is_null($activeClass->screen_shot) ? '../assets/imgs/logo.png'
  : '../assets/imgs/screenshots/' . $activeClass->screen_shot;

if (!is_null($activeClass->screen_shot)) {
  $screenshot = '../assets/imgs/screenshots/' . $activeClass->screen_shot;
}

?>

<!-- Main content -->

<section class="content">

  <div class="relative md:-top-64">
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
            <li class="breadcrumb-item">
              <?php echo $activeClass->scheduled_class ?>
          </ol>
        </nav>


        <!-- Recordings -->
        <?php if (!is_null($activeClass->start_time) && is_null($activeClass->end_time)) : ?>
          <div class="bg-gray-800 text-white p-4 rounded-md flex flex-col md:flex-row items-center justify-between">
            <h1>Your class session has been started</h1>
            <div class="flex items-center justify-center space-x-4">
              <small>Time is running</small>
              <div class="w-6 h-6 rounded-full bg-red-400 relative">
                <div class="absolute inset-0 w-full h-full animate-ping bg-red-500 rounded-full">
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="row  p-2 md:p-4">
          <div class="col-lg-8 p-4">
            <h1 class="font-bold uppercase text-2xl text-center"><?php echo $activeClass->scheduled_class ?>
            </h1>

            <!-- Form -->
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_GET['id'] ?>" class="mt-12" enctype="multipart/form-data" method="POST">
              <div class="form-group">
                <div class="flex items-center justify-center border border-red-300 p-6">
                  <img src="<?php echo $screenshot ?>" alt="#" class="w-32" id="screenshotPreview">
                </div>
              </div>
              <?php if (is_null($activeClass->screen_shot)) : ?>
                <div class="form-group">
                  <label for="#">Class Screen Shot</label>
                  <input class="form-control" type="file" name="screen_shot" onchange="displayImage(this, '#screenshotPreview')">
                </div>
              <?php endif; ?>

              <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <?php if (!$activeClass->is_sent_to_monitoring) : ?>
                  <button type="submit" class="btn btn-danger btn-md" name="send_to_monitoring">Send to Monitoring</button>

                  <small id="passwordHelpBlock" class="form-text text-muted">
                    Please Make sure to send your class to monitoring before lecturing, so our monitoring staff will save
                    your records.
                  </small>
                <?php endif ?>
                <br>

                <a href="<?php echo $activeClass->google_meet_link ?>" class="btn btn-success btn-md mt-4" target="_blank" id="start_class">Go to Class</a>

              </div>
            </form>

            <?php if (is_null($activeClass->end_time)) : ?>
              <div class="" id="end_class">
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_GET['id'] ?>" method="POST">
                  <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                  <button type="submit" name="end_class" class="btn btn-danger btn-md mt-4">End Class</button>
                </form>
              </div>
            <?php endif ?>


          </div>

          <div class="col-lg-4 p-4 bg-gray-100 space-y-6">

            <?php if (!is_null($activeClass->start_time)) : ?>
              <div class="flex items-center justify-between">
                <div>
                  <i class="fa fa-clock"></i>
                  Class Session started at
                </div>
                <span>
                  <?php echo shortDate($activeClass->start_time) ?>
                </span>
              </div>

            <?php endif; ?>

            <?php if (!is_null($activeClass->end_time)) : ?>
              <div class="flex items-center justify-between">
                <div>
                  <i class="fa fa-clock"></i>
                  Class Session ended at
                </div>
                <span>
                  <?php echo shortDate($activeClass->end_time) ?>
                </span>
              </div>
            <?php endif; ?>

            <div class="flex items-center justify-between">
              <div class="space-x-4">
                <i class="fa fa-user"></i>
                Faculty
              </div>
              <h1 class="font-bold text-green-400"><?php echo ucfirst($activeUser->firstname) . ' ' . ucfirst($activeUser->lastname) ?></h1>
            </div>

            <div class="flex items-center justify-between">
              <div class="space-x-4">
                <i class="fa fa-user-tie"></i>
                Monitoring Staff
              </div>
              <h1 class="font-bold text-red-400">
                <?php $staff = $class->getUser($activeClass->monitoring_id) ?>
                <?php echo (!empty($staff)) ? ucfirst($staff->firstname) . ' ' . ucfirst($staff->lastname) : '<span class="text-danger">pending</span>' ?>
              </h1>
            </div>

            <hr>

            <!-- Chatting Room Here -->
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

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

  // document.querySelector('#start_class').addEventListener('click', function() {
  //   this.style.display = 'none';
  //   document.querySelector('#end_class').classList.remove('hidden');
  // })
</script>

<?php ob_flush(); ?>