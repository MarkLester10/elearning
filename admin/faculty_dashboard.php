<?php
ob_start();
require_once '../core.php';
require_once '../path.php';
require_once  '../app/includes/admin/header_dashboard.php';
require_once  '../app/middlewares/Auth.php';
require_once  '../app/middlewares/Faculty.php';


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

        <!-- breadcrumbs -->
        <nav aria-label="breadcrumb" class="mt-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item flex items-center gap-2">
              <i class="fa fa-check-circle text-green-500"></i>
              <a href="#">Room List</a>
            </li>
          </ol>
        </nav>

        <!-- Select Room Form -->
        <div id="app">
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="flex items-center justify-center gap-4">
              <input type="hidden" v-model="url" value="<?php echo BASE ?>">
              <div class="form-group w-full">
                <select class="form-control" @change="getSubjects" v-model="department_id" name="department_id" required>
                  <option value="">Select Department</option>
                  <?php foreach ($departments as $department) : ?>
                    <option value="<?php echo $department->id ?>"><?php echo $department->name ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group w-full">
                <select class="form-control" name="subject_schedule_id" required>
                  <option value="">Select Subject/Schedule</option>
                  <option v-for="subject in subjects.subjects" :key="subject.id" :value="subject.id">
                    {{subject.subject_name}}
                  </option>
                </select>
              </div>
              <div class="form-group w-full">
                <input type="text" name="google_meet_link" class="form-control" placeholder="Enter Google Meet Link" required>
              </div>
              <div class="form-group w-full">
                <button class="btn btn-danger" type="submit" name="add_class"><i class="fa fa-plus"></i></button>
              </div>
            </div>
          </form>
        </div>

        <!-- Table -->
        <div class="table-responsive">
          <table class="table bg-white" id="resultTbl">
            <thead class="thead-dark">
              <tr>
                <th scope="col">ROOM ID</th>
                <th scope="col">ROOM/DEPARTMENT/SUBJECT/TIME</th>
                <th scope="col">MONITORING STAFF</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($classes as $key => $singleClass) : ?>
                <tr>
                  <th scope="row">TCU-MSU - <?php echo $key + 1 ?></th>
                  <td>
                    <a href="class.php?id=<?php echo $singleClass->id ?>" class="hover:underline text-blue-400">
                      <?php echo $singleClass->scheduled_class ?>
                    </a>
                  </td>
                  <?php $staff = $class->getUser($singleClass->monitoring_id) ?>
                  <td><?php echo (!empty($staff)) ? ucfirst($staff->firstname) . ' ' . ucfirst($staff->lastname) : '<span class="text-danger">not monitored</span>' ?></td>
                  <td>

                    <a href="<?php echo $_SERVER['PHP_SELF'] ?>?delete_id=<?php echo $singleClass->id ?>" class="text-danger" onclick="return confirm('Are you sure you want to delete this class?');">
                      delete
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../app/includes/admin/footer.php' ?>
<?php ob_flush(); ?>