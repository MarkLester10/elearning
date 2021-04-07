<?php

function sendMail($user, $token)
{
  return '
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta http-equiv="Content Type" content="text/html; charset=utf-8" />
      <meta http-euiv="X-UA-Compatible" content="IE-Edge" />
      <meta name="viewport" content="width=device-width, intitial-scale=1.0" />
      <title>Reset Password</title>
      <link rel="preconnect" href="https://fonts.gstatic.com" />
      <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap"
        rel="stylesheet"
      />
      <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
      />
      <style>
      body {
        margin: 0;
        padding: 0;
        background-color: #ebebeb;
        font-family: "Poppins", sans-serif;
        display: flex;
        flex-direction: column;
        text-align: center;
      }
      a {
        text-decoration: none;
        color: #fff;
        text-align: center;
      }
      .logo img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        height: 100px;
        padding: 25px;
      }
      .wrapper {
        background-color: white;
        margin: 0 auto;
        width: 50%;
        padding: 20px;
      }
      @media screen and (max-width: 640px) {
        .wrapper {
          width: 90%;
          margin: 0 auto;
        }
      }
      a.btn {
        display: inline-block;
        margin-top: 5px;
        padding: 15px 32px;
        font-family: "Poppins", sans-serif;
        font-weight: bold;
        border: none;
        background-color: black;
        cursor: pointer;
        text-align: center;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 1px;
      }
      a.btn:hover {
        background-color: #f87171;
      }
      .socials {
        text-align: center;
        letter-spacing: 10px;
      }
      .socials a {
        font-size: 25px;
        color: #f87171;
      }
      @media only screen and (max-width: 600px) {
        h2 {
          font-size: 14px;
        }
        h4 {
          font-size: 10px;
        }
        h5 {
          font-size: 8px;
        }
        a.btn {
          font-size: 10px;
          padding: 5px 12px;
        }
        .logo img {
          height: 80px;
        }
        .socials a {
          font-size: 15px;
        }
      }
    </style>
    </head>

    <body style="background-color:#faf9fc;">
      <div class="logo">
        <img src="https://i.imgur.com/f2Fvyux.png" alt="logo1" />
      </div>

      <div class="wrapper" style="text-align:center;background-color:#fff;">
        <h2 style="text-align: center">
          Thank you for signing in, ' . ucfirst($user->firstname) . ucfirst($user->lastname) . '
        </h2>

        <h4 style="text-align: center">
          Click the button below to setup your account.
        </h4>

        <a style="text-decoration: none;color: #fff;text-align: center;" href="http://localhost/lms/change_password.php?token=' . $token . '" class="btn">Setup Account</a>
        <br><small style="text-align:center"> OR </small><br><hr>
        <a style="text-decoration: none;color: blue;text-align: center;" href="http://localhost/lms/change_password.php?token=' . $token . '">
        http://localhost/lms/change_password.php?token=' . $token . '
        </a>

      </div>

      <footer>
        <div class="content">
          <div class="logo">
            <img src="https://i.imgur.com/f2Fvyux.png" alt="logo3" />
          </div>

          <h5 style="text-align: center; margin: 0">
            We love hearing from you! <br />
            Have any question? Check out more about us!
          </h5>
        </div>
      </footer>
    </body>
  </html>
  ';
}
