<?php
class Department extends Connection
{
    private $data;
    private $errors = [];
    private static $fields = ['name'];
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $sql = "SELECT * FROM departments";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        return $departments = $stmt->fetchAll();
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

            $this->validateDepartmentName();

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
            $name = $this->data['name'];
            $sql = "INSERT INTO departments (name) VALUES (:name)";
            $stmt = $this->conn->prepare($sql);
            $run = $stmt->execute(['name' => $name]);
            if ($run) {
                message('success', 'A new department has been created');
                redirect('departments.php');
            }
        }
    }

    // delete category
    public function delete($id)
    {
        $sql = "DELETE FROM departments WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $deleted = $stmt->execute(['id' => $id]);
        if ($deleted) {
            message('success', 'A department has been deleted');
            redirect('departments.php');
        } else {
            message('danger', 'A department cannot be deleted because of associated loans');
            redirect('departments.php');
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
