<?php
include 'path.php';
require_once  'core.php';

// if (!isset($_GET['token'])) {
//     redirect('login.php');
if (isset($_POST['change_pass'])) {
    // instantiate user validator
    $user = new UserController($_POST);
    $errors = $user->validateForgotPass();
    //get the data
    $data = $user->getData();
    // $password1 = sanitize($data['password1']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo TITLE ?></title>
    <!--fontawesome5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <!--bootstrap-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <!--custom css -->
    <!--flatpckr -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->
    <!--custom css -->
    <!-- <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/sub-main.css"> -->
</head>

<body style="background-image: url('assets/imgs/bg-image.jpg'); background-size: cover; background-position: top center;">


    <div class="h-screen flex items-center">
        <div class="container m-16">
            <div class="row">
                <div class="col-md-5 mx-auto shadow p-3 bg-white register">
                    <?php include 'app/includes/message.php' ?>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . '?token=' . $_GET['token'] ?>" method="POST">
                        <input type="hidden" name="token" value="<?php echo $_GET['token'] ?? '' ?>">
                        <div class="mx-auto shadow-md p-4">
                            <img src="./assets/imgs/logo.png" class="w-8/12 mx-auto" alt="">
                        </div>


                        <!--password1-->
                        <div class="form-group mt-2">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-lock text-xl"></i>
                                <input type="password" name="password1" id="password1" class="form-control
                    <?php
                    if (!empty($password1)) {
                        echo $errors['password1'] ? 'is-invalid' : '';
                    } else {
                        if ($errors['password1']) {
                            echo 'is-invalid';
                        }
                    }
                    ?>
                    " placeholder="Enter your password" required>
                            </div>
                            <div class="text-danger">
                                <small><?php echo $errors['password1'] ?? '' ?></small>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-lock text-xl"></i>
                                <input type="password" name="password2" id="password2" class="form-control
                    <?php
                    if (!empty($password2)) {
                        echo $errors['password2'] ? 'is-invalid' : '';
                    } else {
                        if ($errors['password2']) {
                            echo 'is-invalid';
                        }
                    }
                    ?>
                    " placeholder="Confirm password" required>
                            </div>
                            <div class="text-danger">
                                <small><?php echo $errors['password2'] ?? '' ?></small>
                            </div>
                        </div>
                        <div class="d-grid mt-2">
                            <button class="btn btn-primary btn-block" name="change_pass">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>