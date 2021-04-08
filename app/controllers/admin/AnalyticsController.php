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
                    AND department_id=$dept_id AND duration IS NOT NULL";
        } else {
            $sql = "SELECT duration, created_at FROM classes WHERE department_id=$dept_id AND duration IS NOT NULL";
        }
        $stmt = $this->conn->query($sql);
        $classes = $stmt->fetchAll();
        $timesArray = array();
        foreach ($classes as $item) {
            array_push($timesArray, $item->duration);
        }
        $totalDuration = $this->getTotalDuration($timesArray);

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
                    AND user_id=$faculty_id AND duration IS NOT NULL";
        } else {
            $sql = "SELECT duration, created_at FROM classes WHERE user_id=$faculty_id AND duration IS NOT NULL";
        }
        $stmt = $this->conn->query($sql);
        $classes = $stmt->fetchAll();
        $timesArray = array();
        foreach ($classes as $item) {
            array_push($timesArray, $item->duration);
        }
        $totalDuration = $this->getTotalDuration($timesArray);

        return $totalDuration;
    }

    public function filterDate($data)
    {

        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $sql = "SELECT duration, created_at FROM classes WHERE created_at BETWEEN '$from_date' AND '$to_date'";
        $stmt = $this->conn->query($sql);
        $classes = $stmt->fetchAll();
        return $classes;
    }

    public function getTotalDuration($timesArray)
    {
        $all_seconds = 0;
        // loop throught all the times
        foreach ($timesArray as $time) {
            list($hour, $minute, $second) = explode(':', $time);
            $all_seconds += $hour * 3600;
            $all_seconds += $minute * 60;
            $all_seconds += $second;
        }


        $total_minutes = floor($all_seconds / 60);
        $seconds = $all_seconds % 60;
        $hours = floor($total_minutes / 60);
        $minutes = $total_minutes % 60;

        // returns the time already formatted
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
