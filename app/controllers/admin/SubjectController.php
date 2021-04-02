<?php
class Subject extends Connection
{
    private $data;
    private $errors = [];
    private static $fields = ['schedule', 'department_id', 'subject_name'];
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $sql = "SELECT * FROM subjects_schedule";
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
    public function getDepartments()
    {
        $sql = "SELECT * FROM departments";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        return $stmt->fetchAll();
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

    //Check if no more errors then insert data
    private function checkIfHasError()
    {
        if (!array_filter($this->errors)) {
            $subject_name = $this->data['subject_name'];
            $department_id = $this->data['department_id'];
            $schedule = $this->data['schedule'];
            $sql = "INSERT INTO subjects_schedule (department_id, subject_name, schedule)
            VALUES (:department_id, :subject_name, :schedule)";
            $stmt = $this->conn->prepare($sql);
            $run = $stmt->execute([
                'department_id' => $department_id,
                'subject_name' => $subject_name,
                'schedule' => $schedule,
            ]);
            if ($run) {
                message('success', 'A new subject has been created');
                redirect('subjects.php');
            }
        }
    }

    // delete category
    public function delete($id)
    {
        $sql = "DELETE FROM subjects_schedule WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $deleted = $stmt->execute(['id' => $id]);
        if ($deleted) {
            message('success', 'A subject has been deleted');
            redirect('subjects.php');
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
    public function getSubject($id)
    {
        $sql = "SELECT * FROM subjects_schedule WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $department = $stmt->fetch();
        return $department;
    }



    //update category
    public function update($data)
    {
        $this->data = $data;
        // $this->validate();
        $this->updateSubject();
    }
    private function updateSubject()
    {
        $subject_name = $this->data['subject_name'];
        $schedule = $this->data['schedule'];
        $department_id = $this->data['department_id'];
        $id = $this->data['id'];
        if (!array_filter($this->errors)) {
            $sql = "UPDATE subjects_schedule SET department_id=:department_id, subject_name=:subject_name, schedule=:schedule  WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $updated = $stmt->execute([
                'department_id' => $department_id,
                'subject_name' => $subject_name,
                'schedule' => $schedule,
                'id' => $id
            ]);
            if ($updated) {
                message('success', 'A subject has been updated');
                redirect('subjects.php');
            }
        }
    }
}
