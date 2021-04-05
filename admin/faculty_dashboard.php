<?php
ob_start();
require_once '../core.php';
require_once '../path.php';
require_once  '../app/includes/admin/header_dashboard.php';

require_once  '../app/middlewares/Auth.php';
require_once  '../app/middlewares/Faculty.php';
// // Turn off all error reporting
// error_reporting(0);



$activeDepartment = new Department();
$departments = $activeDepartment->index();

$activeSubject = new Subject();
$subjects = $activeSubject->index();

$class = new Classes();
$classes = $class->index();

if (isset($_POST['add_class'])) {
  $class->create($_POST);
}
if (isset($_GET['delete_id'])) {
  $class->delete($_GET['delete_id']);
}

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
            <h2 class="uppercase">Faculty</h2>
          </div>
        </div>
        <div id="app">
          <!--message-->
          <!-- <?php include '../app/includes/message.php' ?> -->

          <div class="mt-4">
            <p v-if="is_created" class="rounded-md shadow-md py-2 px-2 tracking-wider text-sm text-center text-white bg-red-500">
              You Already have this class.
            </p>
            <p v-if="message" class="rounded-md shadow-md py-2 px-2 tracking-wider text-sm text-center text-white bg-green-500">
              {{message}}
            </p>
          </div>

          <!-- breadcrumbs -->
          <nav aria-label="breadcrumb" class="mt-6">
            <ol class="breadcrumb">
              <li class="breadcrumb-item flex items-center gap-2">
                <i class="fa fa-check-circle text-green-500"></i>
                <a href="faculty_dashboard.php">Room List</a>
              </li>
            </ol>
          </nav>

          <!-- Select Room Form -->

          <input id="faculty_id" type="hidden" value="<?php echo $activeUser->id ?>">
          <form @submit.prevent="addClass">
            <div class="flex items-center justify-center gap-4">
              <input type="hidden" v-model="url" value="<?php echo BASE ?>">
              <div class="form-group w-full">

                <select id="department_id" class="form-control" @change="getSubjects" v-model="department_id" name="department_id" required>
                  <option value="">Select Department</option>
                  <?php foreach ($departments as $department) : ?>
                    <option value="<?php echo $department->id ?>"><?php echo $department->name ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group w-full">
                <select class="form-control" v-model="newClass.subject_schedule_id" name="subject_schedule_id" required>
                  <option value="">Select Subject/Schedule</option>
                  <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                    {{subject.subject_name}} - {{subject.schedule}}
                  </option>
                </select>
              </div>
              <div class="form-group w-full">
                <input type="text" v-model="newClass.google_meet_link" name="google_meet_link" class="form-control" placeholder="Enter Google Meet Link" required>
              </div>
              <div class="form-group w-full">
                <button class="btn btn-danger" type="submit" name="add_class"><i class="fa fa-plus"></i></button>
              </div>
            </div>
          </form>

          <!-- Table -->
          <div class="table-responsive">
            <table class="table bg-white" id="resultTbl">
              <thead class="thead-dark">
                <tr class="text-center align-items-center">
                  <th scope="col">ROOM ID</th>
                  <th scope="col">ROOM/DEPARTMENT/SUBJECT/TIME</th>
                  <th scope="col">MONITORING STATUS</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>

                <tr class="text-center" v-for="classItem in classes" :key="classItem.id">
                  <th scope="row" class="text-sm">TCU-MSU - {{classItem.id}}</th>
                  <td>
                    <!-- :href="'/user/profile.php?username='+comment.username+'&id='+comment.user_id" -->
                    <a :href="'class.php?id='+classItem.id" class="hover:underline text-blue-400">
                      {{classItem.scheduled_class}}
                    </a>
                  </td>
                  <td class="d-flex justify-content-center">
                    <div v-if="classItem.start_time != null && classItem.end_time ==null" class="w-4 h-4 rounded-full bg-red-400 relative">
                      <div class="absolute inset-0 w-full h-full animate-ping bg-red-500 rounded-full">
                      </div>
                    </div>
                    <span v-else-if="classItem.start_time != null && classItem.end_time !=null" class="text-green-500">Recorded</span>
                    <span v-else class="text-muted">not monitored</span>

                  </td>

                  <td>

                    <a :href="'faculty_dashboard.php?delete_id='+classItem.id" class="text-danger" onclick="return confirm('Are you sure you want to delete this class?');">
                      delete
                    </a>
                  </td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php ob_flush(); ?>
<?php include '../app/includes/admin/footer.php' ?>