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
          </ol>
        </nav>

        <!-- Select Room Form -->
        <form action="#">
          <div class="flex items-center justify-center gap-4">
            <div class="form-group w-full">
              <select class="form-control">
                <option>Select Department</option>
              </select>
            </div>
            <div class="form-group w-full">
              <select class="form-control">
                <option>Select Subject/Schedule</option>
              </select>
            </div>
            <div class="form-group w-full">
              <button class="btn btn-danger"><i class="fa fa-plus"></i></button>
            </div>
          </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
          <table class="table  bg-white">
            <thead class="thead-dark">
              <tr>
                <th scope="col">ROOM ID</th>
                <th scope="col">ROOM/DEPARTMENT/SUBJECT/TIME</th>
                <th scope="col">MONITORING STAFF</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">#12343</th>
                <td>
                  <a href="#" class="hover:underline text-red-400">Lorem ipsum dolor sit amet.</a>
                </td>
                <td>Mark</td>
                <td>
                  <form action="#">
                    <button class="btn" type="submit">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>


<?php ob_flush(); ?>