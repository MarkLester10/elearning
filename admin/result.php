<?php
ob_start();
require_once '../core.php';
require_once '../path.php';
require_once  '../app/includes/admin/header.php';
require_once  '../app/middlewares/Auth.php';




$averageTime = '00:00:00';
$totalDuration = '00:00:00';
$class = new Classes();
$classes = $class->getResults();;

// dump($classes);

if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
  $classes = $class->getResultsByDate($_GET['from_date'], $_GET['to_date']);
}


if (!empty($classes)) {
  $timesArray = [];
  foreach ($classes as $item) {
    array_push($timesArray, $item->duration);
  }
  $averageTime =  date('H:i:s', array_sum(array_map('strtotime', $timesArray)) / count($timesArray));
  // $totalDuration =  date('H:i:s', array_sum(array_map('strtotime', $timesArray)) / 1);
  $totalDuration = getTotalDuration($timesArray);
}









// die();

// $averageTime = getAverageDuration($timesArray);




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
              <i class="fa fa-chart-bar text-green-500"></i>
              Monitoring Result
            </li>
          </ol>
        </nav>



        <!-- Table -->
        <div class="table-responsive">
          <div class="my-6 bg-gray-100 p-4">
            <form class="flex flex-col space-y-4 md:space-y-0 md:flex-row items-center space-x-4" action="#" method="GET" id='filterform'>
              <div class="from p-2 bg-white w-full">
                <h4 class="font-bold inline text-gray-900 mr-2">From:</h4>
                <input type="date" name="from_date" id="from_date" class="form-control">
              </div>
              <div class="to p-2 bg-white w-full">
                <h4 class="font-bold inline text-gray-900 mr-2">To:</h4>
                <input type="date" name="to_date" id="to_date" class="form-control">
              </div>
              <div class="w-full">
                <button type="submit" class="btn btn-success btn-sm block md:inline" name="filter_date" id="filter">
                  Filter
                </button>
                <a href="results.php" class="btn btn-warning btn-sm">Reset</a>
              </div>
            </form>

          </div>
          <table class="table bg-white" id="resultTbl">
            <div class="flex gap-4 w-1/3 my-2">
              <span class="block p-2 bg-green-600 text-white text-lg">
                Total Duration: <b><?php echo $totalDuration ?></b>
              </span>
              <span class="block p-2 bg-red-400 text-white text-lg">
                Average Duration: <b><?php echo $averageTime ?></b>
              </span>
            </div>

            <div class="p-2 bg-gray-800 text-white text-center inline-block my-4">
              <?php echo formatDate(strtotime(date('Y-m-d h:i:A'))) ?>
            </div>


            <thead class="thead-dark">
              <tr class="text-center">
                <th scope="col">DEPARTMENT/SUBJECT/SCHEDULE</th>
                <th scope="col">MONITORING STAFF</th>
                <th scope="col">FACULTY NAME</th>
                <th scope="col">DATE</th>
                <th scope="col">START TIME</th>
                <th scope="col">END TIME</th>
                <th scope="col">DURATION <br> (HRS:MINS:SECS) </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($classes as $key => $singleClass) : ?>
                <tr class="text-center">
                  <td><?php echo $class->getRoom($singleClass->room_id)->subject_name ?></td>
                  <?php $staff = $class->getUser($singleClass->monitoring_id) ?>
                  <td><?php echo (!empty($staff)) ? ucfirst($staff->firstname) . ' ' . ucfirst($staff->lastname) : '<span class="text-danger">pending</span>' ?></td>
                  <td><?php echo ucfirst($activeUser->firstname) . ' ' . ucfirst($activeUser->lastname) ?></td>
                  <td><?php echo shortDate($singleClass->created_at) ?></td>
                  <td><?php echo formatDate2($singleClass->start_time, true); ?></td>
                  <td><?php echo formatDate2($singleClass->end_time, true); ?></td>
                  <?php if ($key == 0) :  ?>
                    <td class="bg-red-400 text-white">
                      <?php echo $singleClass->duration ?>
                      <br>
                    </td>
                  <?php else : ?>
                    <td>
                      <?php echo $singleClass->duration ?>
                      <br>
                    </td>
                  <?php endif; ?>
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
<?php ob_flush(); ?>