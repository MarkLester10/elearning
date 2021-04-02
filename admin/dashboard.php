<?php
ob_start();
require_once '../core.php';
require_once '../path.php';
require_once  '../app/includes/admin/header.php';


?>

<!-- Main content -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <?php include '../app/includes/message.php' ?>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>4</h3>

                        <p>Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="admin_users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>5</h3>
                        <p>Types</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list-alt"></i>
                    </div>
                    <a href="types.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>6</h3>
                        <p>Loans</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-check"></i>
                    </div>
                    <a href="loans.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>8</h3>

                        <p>Payments</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-credit-card"></i>
                    </div>
                    <a href="payments.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-md-6 mx-auto mt-5">
                <h5 class="text-center">Loan Summary</h5>
                <canvas id="myChart" width="400" height="200"></canvas>
                <!-- </div>
            <div class="col-md-6 mt-5">
                <h5 class="text-center">Loan Summary (<?php echo date("Y") ?>)</h5>
                <canvas id="lineChart" width="400" height="200"></canvas>
            </div> -->
            </div>

        </div><!-- /.container-fluid -->
</section>

<!-- /.content -->
<!-- /.content-wrapper -->
<?php include '../app/includes/admin/footer.php' ?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script> -->
<script src="../assets/js/Chart.min.js"></script>
<script>
    // BAR GRAPH
    var ctx = document.getElementById('myChart').getContext('2d');
    var usersCount = "<?php echo $usersCount ?>";
    var typesCount = "<?php echo $loanTypesCount ?>";
    var loansCount = "<?php echo $loansCount ?>";
    var paymentsCount = "<?php echo $paymentsCount ?>";
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Types', 'Loans', 'Users', 'Payments'],
            datasets: [{
                label: 'Total Result',
                data: [typesCount, loansCount, usersCount, paymentsCount],
                backgroundColor: [
                    '#17a2b8',
                    '#28a745',
                    '#ffc107',
                    '#6c757d',
                ],
                borderColor: [
                    '#333',
                    '#333',
                    '#333',
                    '#333',
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
</script>

<script>
    // LINE GRAPH
    var ctx = document.getElementById('lineChart').getContext('2d');
    var jan = "<?php echo $data['jan'] ?>";
    var feb = "<?php echo $data['feb'] ?>";
    var mar = "<?php echo $data['mar'] ?>";
    var april = "<?php echo $data['april'] ?>";
    var may = "<?php echo $data['may'] ?>";
    var june = "<?php echo $data['june'] ?>";
    var july = "<?php echo $data['july'] ?>";
    var aug = "<?php echo $data['aug'] ?>";
    var sept = "<?php echo $data['sept'] ?>";
    var oct = "<?php echo $data['oct'] ?>";
    var nov = "<?php echo $data['nov'] ?>";
    var dec = "<?php echo $data['dec'] ?>";

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Total Result',
                data: [jan, feb, mar, april, may, june, july, aug, sept, oct, nov, dec],
                backgroundColor: [
                    '#17a2b8',
                    '#17a2b8',
                    '#17a2b8',
                    '#17a2b8',
                ],
                borderColor: [
                    '#333',
                    '#333',
                    '#333',
                    '#333',
                ],
                borderWidth: 1,
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
</script>
<?php ob_flush(); ?>