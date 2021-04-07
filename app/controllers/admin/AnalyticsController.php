<?php
class Analytics extends Connection
{
    private $data;
    private $errors = [];
    private static $fields = [];
    public function __construct()
    {
        parent::__construct();
    }

    public function getDepartmentsAnalytics()
    {
        $sql = "SELECT * FROM departments";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }
    public function getFacultyAnalytics()
    {
        $sql = "SELECT * FROM users WHERE position_id=2";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }
    public function getDepartmentDuration($dept_id, $fromDate = '', $toDate = '')
    {
        $sql = '';
        if (!empty($fromDate) && !empty($toDate)) {
            $sql = "SELECT duration, created_at FROM classes
                    WHERE created_at
                    BETWEEN '$fromDate' AND '$toDate'
                    AND department_id=$dept_id";
        } else {
            $sql = "SELECT duration, created_at FROM classes WHERE department_id=$dept_id";
        }
        $stmt = $this->conn->query($sql);
        $classes = $stmt->fetchAll();
        $timesArray = [];
        foreach ($classes as $item) {
            array_push($timesArray, $item->duration);
        }
        $totalDuration = getTotalDuration($timesArray);

        return $totalDuration;
    }

    //faculty duration
    public function getFacultiesDuration($faculty_id, $fromDate = '', $toDate = '')
    {
        $sql = '';
        if (!empty($fromDate) && !empty($toDate)) {
            $sql = "SELECT duration, created_at FROM classes
                    WHERE created_at
                    BETWEEN '$fromDate' AND '$toDate'
                    AND user_id=$faculty_id";
        } else {
            $sql = "SELECT duration, created_at FROM classes WHERE user_id=$faculty_id";
        }
        $stmt = $this->conn->query($sql);
        $classes = $stmt->fetchAll();
        $timesArray = [];
        foreach ($classes as $item) {
            array_push($timesArray, $item->duration);
        }
        $totalDuration = getTotalDuration($timesArray);

        return $totalDuration;
    }

    public function filterDate($data)
    {

        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $sql = "SELECT duration, created_at FROM classes WHERE created_at BETWEEN '$from_date' AND '$to_date'";
        $stmt = $this->conn->query($sql);
        $departments = $stmt->fetchAll();
        return $departments;
    }
}
