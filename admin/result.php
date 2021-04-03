<?php
ob_start();
require_once '../core.php';
require_once '../path.php';
require_once  '../app/includes/admin/header.php';
?>

<!-- Main content -->

<section class="content">

  <div class="relative md:-top-24">
    <div class="container mx-auto bg-white shadow-lg border-2 border-gray-400 mt-12 rounded-md">
      <!-- profile -->
      <div class="container mx-auto relative -top-16">
        <div class="flex items-center justify-center flex-col">
          <div class="bg-white h-32 p-2 w-32 rounded-full">
            <img src="../assets/imgs/faculty/placeholder.png" class="h-full w-full object-cover rounded-full ring" alt="">
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
              <i class="fa fa-chart-bar text-green-500"></i>
              Monitoring Result
            </li>
          </ol>
        </nav>



        <!-- Table -->
        <div class="table-responsive">
          <table class="table bg-white" id="resultTbl">
            <thead class="thead-dark">
              <tr>
                <th scope="col">DEPARTMENT</th>
                <th scope="col">MONITORING STAFF</th>
                <th scope="col">FACULTY NAME</th>
                <th scope="col">SUBJECT</th>
                <th scope="col">DATE</th>
                <th scope="col">START TIME</th>
                <th scope="col">END TIME</th>
                <th scope="col">RESULT</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>Lorem ipsum dolor sit amet.</th>
                <td>
                  Lorem ipsum dolor sit.
                </td>
                <td>Mark</td>
                <td>Lorem, ipsum.</td>
                <td>July 10, 1776</td>
                <td>Monday 4:30PM</td>
                <td>Monday 5:00PM</td>
                <td>30:00 Minutes</td>
              </tr>
              <tr>
                <th>Lorem ipsum dolor sit amet.</th>
                <td>
                  Lorem ipsum dolor sit.
                </td>
                <td>Mark</td>
                <td>Lorem, ipsum.</td>
                <td>July 10, 1776</td>
                <td>Monday 4:30PM</td>
                <td>Monday 5:00PM</td>
                <td>30:00 Minutes</td>
              </tr>
              <tr>
                <th>Lorem ipsum dolor sit amet.</th>
                <td>
                  Lorem ipsum dolor sit.
                </td>
                <td>Mark</td>
                <td>Lorem, ipsum.</td>
                <td>July 10, 1776</td>
                <td>Monday 4:30PM</td>
                <td>Monday 5:00PM</td>
                <td>30:00 Minutes</td>
              </tr>
              <tr>
                <th>Lorem ipsum dolor sit amet.</th>
                <td>
                  Lorem ipsum dolor sit.
                </td>
                <td>test me</td>
                <td>Lorem, ipsum.</td>
                <td>July 10, 1776</td>
                <td>Monday 4:30PM</td>
                <td>Monday 5:00PM</td>
                <td>30:00 Minutes</td>
              </tr>
              <tr>
                <th>Lorem ipsum dolor sit amet.</th>
                <td>
                  Lorem ipsum dolor sit.
                </td>
                <td>Mark</td>
                <td>Lorem, ipsum.</td>
                <td>July 10, 1776</td>
                <td>Monday 4:30PM</td>
                <td>Monday 5:00PM</td>
                <td>30:00 Minutes</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require_once '../app/includes/admin/footer.php' ?>
<?php ob_flush(); ?>