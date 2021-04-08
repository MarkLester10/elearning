<?php
ob_start();
require_once '../path.php';
require_once '../core.php';
require_once '../app/includes/admin/header.php';
require_once  '../app/middlewares/Auth.php';
require_once  '../app/middlewares/Admin.php';

$analytic = new Analytics();
$departments = $analytic->getDepartmentsAnalytics();;
$departments_name = [];
$departments_duration = [];


foreach ($departments as $department) {
    array_push($departments_name, $department->name);
    array_push($departments_duration, $analytic->getDepartmentDuration($department->id));
}
array_push($departments_duration, '02:00:00');
array_push($departments_name, 'BSIT');
// dump($departments_name);

?>


<div class="container">
    <div class="card shadow">
        <div class="card-header d-flex align-items-center">
            <h4>Departments Analytics</h4>

        </div>

        <div class="my-6 bg-gray-100 p-4">
            <form class="flex flex-col space-y-4 md:space-y-0 md:flex-row items-center space-x-4" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET" id='filterform'>
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
                    <a href="admin_department_analytics.php" class="btn btn-warning btn-sm">Reset</a>
                </div>
            </form>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="resultTbl">
                    <thead>
                        <tr>
                            <th># </th>
                            <th>Department</th>
                            <?php if (isset($_GET['from_date']) && isset($_GET['to_date'])) : ?>
                                <th>Date</th>
                            <?php endif; ?>
                            <th>Total Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($departments as  $department) : ?>
                            <tr>
                                <td>TCU-MCU - <?php echo $department->id ?></td>
                                <td><?php echo $department->name ?></td>
                                <?php if (isset($_GET['from_date']) && isset($_GET['to_date'])) : ?>
                                    <td class="font-weight-bold"><?php echo shortDate($_GET['from_date']) . ' - ' . shortDate($_GET['to_date']) ?></td>
                                <?php endif; ?>
                                <td>
                                    <?php if (isset($_GET['from_date']) && isset($_GET['to_date'])) : ?>
                                        <?php echo $analytic->getDepartmentDuration($department->id, $_GET['from_date'], $_GET['to_date']) ?>
                                    <?php else : ?>
                                        <?php echo $analytic->getDepartmentDuration($department->id) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

            </div>

        </div>
        <!-- <h1>Total Duration Summary Per Department</h1>
        <canvas id="myChart" width="400" height="200"></canvas> -->
    </div>
</div>

<!-- /.content -->

<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php require_once BASE . '/app/includes/admin/footer.php' ?>
<script src="../assets/js/Chart.min.js"></script>
<script>
    // BAR GRAPH
    var ctx = document.getElementById('myChart').getContext('2d');

    var departments = <?php echo json_encode($departments_name); ?>;
    var durations = <?php echo json_encode($departments_duration); ?>;
    var d = new Date(durations[2]);
    var n = d.getUTCHours();
    console.log(n);
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: departments,
            datasets: [{
                label: "Time",
                data: durations,
                backgroundColor: [
                    '#17a2b8',
                    '#28a745',
                    // '#ffc107',

                ],
                borderColor: [
                    '#333',
                    '#333',
                    // '#333',

                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    jQuery(document).ready(function() {


                $('#filter').click(function() {
                    if ($('#from_date').val() == '' && $('#to_date').val() == '') {
                        alert('Please select a date');
                    }
                });
</script>
<?php ob_flush() ?>