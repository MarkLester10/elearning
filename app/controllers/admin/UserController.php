<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



class AdminUser extends Connection
{
    private $data;
    private $errors = [];
    private static $fields = ['firstname', 'lastname', 'email', 'position_id'];
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getPositions()
    {
        $sql = "SELECT * FROM positions";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getData()
    {
        return $this->data;
    }
    public function create($data)
    {
        $this->data = $data;
        $this->validate();
        $this->checkIfHasError();
    }

    public function getPosition($id)
    {
        $sql = "SELECT * FROM positions WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    public function getDepartment($id)
    {
        $sql = "SELECT * FROM departments WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    //Error handling
    // Validate category name
    public function validate()
    {
        $this->validateEmail();
        return $this->errors;
    }

    // validate firstname
    private function validateFirstname()
    {
        //trim whitespace
        $val = trim($this->data['firstname']);
        // check if empty
        if (empty($val)) {
            $this->addError('firstname', 'Firstname must not be empty');
        } else {
            // match any lowercase/uppercase letter, any digits from 0-9, atleast 3-20 characters
            if (!preg_match('/^[a-zA-Z0-9]{3,20}$/', $val)) {
                $this->addError('firstname', 'Firstname must be 3-20 characters and alphanumeric');
            }
        }
    }
    //validate lastname
    private function validateLastname()
    {
        //trim whitespace
        $val = trim($this->data['lastname']);
        // check if empty
        if (empty($val)) {
            $this->addError('lastname', 'Lastname must not be empty');
        } else {
            // match any lowercase/uppercase letter, any digits from 0-9, atleast 3-20 characters
            if (!preg_match('/^[a-zA-Z0-9]{3,20}$/', $val)) {
                $this->addError('lastname', 'Lastname must be 3-20 characters and alphanumeric');
            }
        }
    }
    //validate email
    private function validateEmail()
    {
        //trim white space
        $val = trim($this->data['email']);
        if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
            $this->addError('email', 'Email must be a valid email');
        }
    }

    //add error

    private function addError($key, $val)
    {
        $this->errors[$key] = $val;
    }

    //Check if no more errors then insert data
    private function checkIfHasError()
    {
        if (empty($this->errors)) {


            // check if email already exists
            $sql = "SELECT * FROM users WHERE email=:email LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email' => $this->data['email']]);
            $user = $stmt->fetch();
            // if email already registered
            if ($stmt->rowCount()) {
                $this->errors['email'] = 'Email already exists. Please try a new one';
            }
            if (empty($this->errors)) {
                $firstname = $this->data['firstname'];
                $lastname = $this->data['lastname'];
                $email = $this->data['email'];
                $position_id = intval($this->data['position_id']);
                $password = 'secret123';
                $token = bin2hex(random_bytes(7));


                // register user using named params
                $sql = "INSERT INTO users (firstname, lastname, email, password, position_id, token)
                VALUES (:firstname, :lastname, :email, :password, :position_id, :token)";

                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(':firstname', $firstname);
                $stmt->bindValue(':lastname', $lastname);
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':password', $password);
                $stmt->bindValue(':position_id', $position_id);
                $stmt->bindValue(':token', $token);
                $run = $stmt->execute();


                $lastId = $this->conn->lastInsertId();
                if ($run) {
                    $user = $this->getUser($lastId);
                    // send mail
                    $this->send_mail($user, $user->token);
                    message('success', 'A new user has been created');
                    redirect('admin_users.php');
                } else {
                    echo 'error occured';
                }
            }
        }
    }

    private function send_mail($user, $token)
    {
        // Instantiation and passing `true` enables exceptions
        require '../mail/Exception.php';
        require '../mail/PHPMailer.php';
        require '../mail/SMTP.php';

        try {
            $mail = new PHPMailer();
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = EMAIL;                     // SMTP username
            $mail->Password   = PASS;                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('elearning@gmail.com', 'TCU - Monitoring System');
            $mail->addAddress($user->email);     // Add a recipient


            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Account Creation';
            $mail->Body    = sendMail($user, $token);
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $sent = $mail->send();
            if ($sent) {
                message('success', 'A user has been created');
                redirect('admin_users.php');
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


    // delete category
    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $deleted = $stmt->execute(['id' => $id]);
        if ($deleted) {
            message('success', 'A user has been deleted');
            redirect('admin_users.php');
        } else {
            message('danger', 'A user cannot be deleted because of associated reservation');
            redirect('admin_users.php');
        }
    }
    // get single category
    public function getUser($id)
    {
        $sql = "SELECT * FROM users WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user;
    }

    //update category
    public function update($data)
    {
        $this->data = $data;
        $this->validate();
        $this->updateUser();
    }
    private function updateUser()
    {
        $password = md5($this->data['password1']);
        $id = $this->data['id'];
        if (!array_filter($this->errors)) {
            $sql = "UPDATE users set is_admin=:is_admin, is_product_manager=:is_product_manager WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $updated = $stmt->execute($this->updateRole());
            if ($updated) {
                message('success', 'A user has been updated');
                redirect('admin_users.php');
            }
        }
    }
    public function updateRole()
    {
        $id = $this->data['id'];
        if ($this->data['role'] === 'is_admin') {
            return ['is_admin' => 1, 'is_product_manager' => 0, 'id' => $id,];
        } else if ($this->data['role'] === 'is_product_manager') {
            return ['is_admin' => 0, 'is_product_manager' => 1, 'id' => $id,];
        } else {
            return ['is_admin' => 0, 'is_product_manager' => 0, 'id' => $id,];
        }
    }
}
