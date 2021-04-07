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
        $id = $_SESSION['id'];
        $sql = "SELECT * FROM classes WHERE user_id=$id ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getResults()
    {
        $id = $_SESSION['id'];
        $sql = "SELECT * FROM classes WHERE end_time IS NOT NULL AND user_id = $id ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }
    public function getResultsByDate($fromDate, $toDate)
    {
        $id = $_SESSION['id'];
        $sql = "SELECT * FROM classes
                WHERE end_time IS NOT NULL
                AND created_at BETWEEN '$fromDate' AND '$toDate'
                AND user_id = $id
                ORDER BY id DESC";
        $stmt = $this->conn->query($sql);
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

    public function getSubject($id)
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

            // check if may existing scheduled class
            $sql = "SELECT * FROM classes WHERE scheduled_class=:scheduled_class LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':scheduled_class', $scheduled_class);
            $stmt->execute();
            $class = $stmt->fetch();
            if ($class) {


                redirect('faculty_dashboard.php');
                // die();
            } else {
                $sql = "INSERT INTO classes (department_id, scheduled_class, subject_schedule_id, google_meet_link, user_id )
                VALUES (:department_id, :scheduled_class, :subject_schedule_id, :google_meet_link, :user_id)";
                $stmt = $this->conn->prepare($sql);
                $run = $stmt->execute([
                    'department_id' => $department_id,
                    'scheduled_class' => $scheduled_class,
                    'subject_schedule_id' => $subject_schedule_id,
                    'google_meet_link' => $google_meet_link,
                    'user_id' => $user_id,
                ]);
                if ($run) {
                    $_SESSION['message'] = 'A class has been created';
                    $_SESSION['type'] = 'success';
                    header('location: faculty_dashboard.php');
                }
            }
        }
    }

    // delete category
    public function delete($id)
    {
        $sql = "DELETE FROM rooms WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $deleted = $stmt->execute(['id' => $id]);
        if ($deleted) {
            $_SESSION['message'] = 'A room has been deleted';
            $_SESSION['type'] = 'success';
            header('location: faculty_dashboard.php');
        } else {
            $_SESSION['danger'] = 'A class cannot be deleted because of associated data';
            $_SESSION['type'] = 'error';
            // $_SESSION['message'] = 'A room cannot be deleted because of associated data';
            header('location: faculty_dashboard.php');
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
    public function getClassesActiveRoom($room_id)
    {
        $sql = "SELECT * FROM classes WHERE room_id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $room_id]);
        return  $stmt->fetchAll();
    }
    public function getRoom($id)
    {
        $sql = "SELECT * FROM rooms WHERE id=:id";
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

    public function getActiveClassToday($room_id)
    {
        $date = date('Y-m-d h:i:a');
        $sql = "SELECT * FROM classes WHERE room_id=$room_id AND CAST(created_at AS DATE) = CAST('$date' AS DATE)";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
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


    public function createClass($data, $files)
    {
        $current_user = $_SESSION['id'];
        $current_room = $data['room_id'];
        $start_time = date('Y-m-d H:i:s');
        $department_id = $data['department_id'];
        $newImageName = '';
        $run = '';
        $lastId = '';
        if ($files) {
            $newImageName =  $files['screen_shot']['name'];
            $tmpName = $files['screen_shot']['tmp_name'];
            $targetDirectory = ROOT_PATH . "/assets/imgs/screenshots/" .  $newImageName;
            move_uploaded_file($tmpName, $targetDirectory);
            $sql = "INSERT INTO classes (room_id,department_id, user_id, is_monitored, start_time,
            screen_shot) VALUES(:room_id,:department_id, :user_id, :is_monitored, :start_time,
            :screen_shot)";

            $stmt = $this->conn->prepare($sql);
            $run = $stmt->execute([
                'room_id' => $current_room,
                'department_id' => $department_id,
                'user_id' => $current_user,
                'is_monitored' => 0,
                'start_time' => $start_time,
                'screen_shot' => $newImageName,
            ]);
            $lastId = $this->conn->lastInsertId();

            if ($run) {
                // UPDATE USERS TABLE
                $sql = "UPDATE users set is_sent_to_monitoring=:is_sent_to_monitoring WHERE id=:user_id ";
                $stmt = $this->conn->prepare($sql);
                $run = $stmt->execute([
                    'is_sent_to_monitoring' => 1,
                    'user_id' => $current_user,
                ]);
            }
        } else {
            $sql = "INSERT INTO classes (room_id,department_id, user_id, is_monitored, start_time,
            screen_shot) VALUES(:room_id,:department_id, :user_id, :is_monitored, :start_time,
            :screen_shot)";

            $stmt = $this->conn->prepare($sql);

            $run = $stmt->execute([
                'room_id' => $current_room,
                'department_id' => $department_id,
                'user_id' => $current_user,
                'is_monitored' => 0,
                'start_time' => $start_time,
                'screen_shot' => $newImageName,
            ]);
            $lastId = $this->conn->lastInsertId();
        }



        if ($run) {
            redirect('class.php?room_id=' . $current_room . '&class_id=' . $lastId);
        }
    }


    public function updateEndClass($data)
    {

        $current_class = $data['class_id'];
        $activeClass = $this->getClass($current_class);
        $current_room = $data['room_id'];
        $end_time = date('Y-m-d H:i:s');
        $duration = calculateDuration($activeClass->start_time, $end_time);
        $final_duration = $duration[0] . ':' . $duration[1] . ':' . $duration[2];

        $activeRoom = $this->getRoom($current_room);


        $sql = "UPDATE classes SET end_time=:end_time, duration=:duration  WHERE id=:id  AND room_id=:room_id";
        $stmt = $this->conn->prepare($sql);
        $run = $stmt->execute([
            'end_time' => $end_time,
            'duration' => $final_duration,
            'id' => $current_class,
            'room_id' => $current_room,
        ]);
        if ($run) {
            $sql = "UPDATE users set is_sent_to_monitoring=:is_sent_to_monitoring, is_monitored=:is_monitored WHERE id=:user_id ";
            $stmt = $this->conn->prepare($sql);
            $run = $stmt->execute([
                'is_sent_to_monitoring' => 0,
                'is_monitored' => 0,
                'user_id' => $activeClass->user_id,
            ]);

            if ($_SESSION['position_id'] == 2) {
                redirect('room.php?room_id=' . $current_room);
            } elseif ($_SESSION['position_id'] == 3) {
                redirect('monitoring_faculty_classes.php?room_id=' . $current_room . '&room_name='
                    . $activeRoom->subject_name . '&faculty_id=' . $activeClass->user_id);
                //room nanme, faculty id
            }

            //monitoring_faculty_classes.php?room_id=13
        }
    }
}
