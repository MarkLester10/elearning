<?php
class Classes extends Connection
{
    private $data;
    private $errors = [];
    private static $fields = ['department_id', 'subjects_schedule_id', 'google_meet_link'];
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $sql = "SELECT * FROM classes";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function create($data)
    {
        $this->data = $data;
        $this->validate();
        $this->checkIfHasError();
    }
    //Error handling
    // Validate category name
    public function validate()
    {
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)) {
                trigger_error("$field must not be empty");
                return;
            }

            // $this->validateDepartmentName();

            return $this->errors;
        }
    }

    private function validateDepartmentName()
    {
        // check if empty
        $val = $this->data['name'];
        if (empty($val)) {
            $this->addError('name', 'Department name must not be empty');
        }
    }
    //add error

    private function addError($key, $val)
    {
        $this->errors[$key] = $val;
    }

    private function getSubject($id)
    {
        $sql = "SELECT * FROM subjects_schedule WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();;
    }
    //Check if no more errors then insert data
    private function checkIfHasError()
    {
        if (!array_filter($this->errors)) {
            $department = $this->getDepartment($this->data['department_id']);
            $subject = $this->getSubject(($this->data['subject_schedule_id']));
            $scheduled_class = $department->name . '-' . $subject->subject_name . '-' . $subject->schedule;
            $department_id = $this->data['department_id'];
            $subject_schedule_id = $this->data['subject_schedule_id'];
            $google_meet_link = $this->data['google_meet_link'];
            $user_id = $_SESSION['id'];

            $sql = "INSERT INTO classes (scheduled_class, subject_schedule_id, google_meet_link, user_id )
            VALUES (:scheduled_class, :subject_schedule_id, :google_meet_link, :user_id)";
            $stmt = $this->conn->prepare($sql);
            $run = $stmt->execute([
                'scheduled_class' => $scheduled_class,
                'subject_schedule_id' => $subject_schedule_id,
                'google_meet_link' => $google_meet_link,
                'user_id' => $user_id,
            ]);
            if ($run) {
                redirect('faculty_dashboard.php');
            }
        }
    }

    // delete category
    public function delete($id)
    {
        $sql = "DELETE FROM classes WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $deleted = $stmt->execute(['id' => $id]);
        if ($deleted) {
            $_SESSION['success'] = 'A class has been deleted';
            redirect('faculty_dashboard.php');
        } else {
            $_SESSION['danger'] = 'A class cannot be deleted because of associated data';
            redirect('faculty_dashboard.php');
        }
    }
    // get single department
    public function getDepartment($id)
    {
        $sql = "SELECT * FROM departments WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $department = $stmt->fetch();
        return $department;
    }
    public function getClass($id)
    {
        $sql = "SELECT * FROM classes WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return  $stmt->fetch();
    }
    public function getUser($id)
    {
        $sql = "SELECT * FROM users WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }



    //update category
    public function update($data)
    {
        $this->data = $data;
        $this->validate();
        $this->updateDepartment();
    }
    private function updateDepartment()
    {
        $name = $this->data['name'];
        $id = $this->data['id'];
        if (!array_filter($this->errors)) {
            $sql = "UPDATE departments set name=:name WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $updated = $stmt->execute(['name' => $name, 'id' => $id]);
            if ($updated) {
                message('success', 'A department has been updated');
                redirect('departments.php');
            }
        }
    }
}
