<?php
ob_start();
require_once '../core.php';
require_once '../path.php';
require_once  '../app/includes/admin/header.php';
?>

<!-- Main content -->

<section class="content">

  <div class="relative md:-top-64">
    <div class="container mx-auto bg-white shadow-lg border-2 border-gray-400 mt-12 rounded-md">
      <!-- profile -->
      <div class="container mx-auto relative -top-16">
        <div class="flex items-center justify-center flex-col">
          <div class="bg-white h-32 p-2 w-32 rounded-full">
            <img src="../assets/imgs/faculty/placeholder.png" class="h-full w-full object-cover rounded-full ring"
              alt="">
          </div>
          <div class="mt-4 text-center">
            <h1 class="text-lg font-bold">John Doe</h1>
            <hr class="block my-2">
            <h2 class="uppercase">Faculty</h2>
          </div>
        </div>

        <!-- breadcrumbs -->
        <nav aria-label="breadcrumb" class="mt-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item flex items-center gap-2">
              <i class="fa fa-check-circle text-green-500"></i>
              <a href="#">Room List</a>
            </li>
            <li class="breadcrumb-item">
              COLLEGE OF SOMETHING Monday 2:30PM - 4:30PM ELECT-415
          </ol>
        </nav>


        <!-- Recordings -->
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

        <div class="row  p-2 md:p-4">
          <div class="col-lg-8 p-4">
            <h1 class="font-bold uppercase text-2xl text-center">COLLEGE OF SOMETHING Monday 2:30PM - 4:30PM ELECT-415
            </h1>

            <form action="#" class="mt-12">
              <div class="form-group">
                <div class="flex items-center justify-center border border-red-300 p-6">
                  <img src="../assets/imgs/logo.png" alt="#" class="w-32" id="screenshotPreview">
                </div>
              </div>

              <div class="form-group">
                <label for="#">Class Screen Shot</label>
                <input class="form-control" type="file" name="screen_shot"
                  onchange="displayImage(this, '#screenshotPreview')">
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-danger btn-md">Send to Monitoring</button>
                <small id="passwordHelpBlock" class="form-text text-muted">
                  Please Make sure to send your class to monitoring before lecturing, so our monitoring staff will save
                  your records.
                </small>
                <br>
                <a href="#" class="btn btn-success btn-md mt-4" target="_blank" id="start_class">Go to Class</a>
                <div class="hidden" id="end_class">
                  <form action="#">
                    <input type="hidden" name="is_class_started">
                    <button type="submit" class="btn btn-danger btn-md mt-4">End Class</button>
                  </form>
                </div>
              </div>
            </form>
          </div>

          <div class="col-lg-4 p-4 bg-gray-100 space-y-6">

            <div class="flex items-center justify-between">
              <div>
                <i class="fa fa-clock"></i>
                Class Session started at
              </div>
              <span>
                2:51 PM
              </span>
            </div>

            <div class="flex items-center justify-between">
              <div class="space-x-4">
                <i class="fa fa-user"></i>
                Faculty
              </div>
              <h1 class="font-bold text-green-400">John Doe</h1>
            </div>

            <div class="flex items-center justify-between">
              <div class="space-x-4">
                <i class="fa fa-user-tie"></i>
                Monitoring Staff
              </div>
              <h1 class="font-bold text-red-400">John Doe</h1>
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

document.querySelector('#start_class').addEventListener('click', function() {
  this.style.display = 'none';
  document.querySelector('#end_class').classList.remove('hidden');
})
</script>

<?php ob_flush(); ?>