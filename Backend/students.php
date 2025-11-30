<?php
require_once 'config.php';

class StudentManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getStudentProfile($user_id) {
        $query = "SELECT s.*, u.email, u.full_name 
                  FROM students s 
                  JOIN users u ON s.user_id = u.id 
                  WHERE s.user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getStudentAttendance($student_id, $month = null, $year = null) {
        if (!$month) $month = date('m');
        if (!$year) $year = date('Y');
        
        $query = "SELECT * FROM attendance 
                  WHERE student_id = :student_id 
                  AND MONTH(attendance_date) = :month 
                  AND YEAR(attendance_date) = :year 
                  ORDER BY attendance_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':month', $month);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        
        $attendance = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $attendance[] = $row;
        }
        
        return $attendance;
    }

    public function getAttendanceStats($student_id) {
        $query = "SELECT 
                    COUNT(*) as total_days,
                    SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_days,
                    SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent_days,
                    SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late_days
                  FROM attendance 
                  WHERE student_id = :student_id 
                  AND MONTH(attendance_date) = MONTH(CURRENT_DATE()) 
                  AND YEAR(attendance_date) = YEAR(CURRENT_DATE())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Handle student data requests
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
    $database = new Database();
    $db = $database->getConnection();
    $studentManager = new StudentManager($db);
    
    if ($_GET['action'] == 'get_profile' && isset($_SESSION['user_id'])) {
        $profile = $studentManager->getStudentProfile($_SESSION['user_id']);
        echo json_encode(array("status" => "success", "data" => $profile));
        exit;
    }
}
?>