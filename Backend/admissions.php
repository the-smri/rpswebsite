<?php
require_once 'config.php';

class Admissions {
    private $conn;
    private $table_name = "admissions";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function submitApplication($data) {
        $application_id = "APP" . date('YmdHis') . rand(100, 999);
        
        $query = "INSERT INTO " . $this->table_name . " 
                  (application_id, student_name, date_of_birth, class_applying, father_name, mother_name, contact_number, email) 
                  VALUES (:application_id, :student_name, :date_of_birth, :class_applying, :father_name, :mother_name, :contact_number, :email)";
        
        $stmt = $this->conn->prepare($query);
        $data['application_id'] = $application_id;
        
        if ($stmt->execute($data)) {
            return array(
                "status" => "success",
                "message" => "Application submitted successfully! Your Application ID: " . $application_id,
                "application_id" => $application_id
            );
        }
        
        return array("status" => "error", "message" => "Failed to submit application");
    }

    public function getPendingApplications() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE status = 'pending' ORDER BY applied_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $applications = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $applications[] = $row;
        }
        
        return $applications;
    }

    public function updateApplicationStatus($application_id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE application_id = :application_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':application_id', $application_id);
        
        return $stmt->execute();
    }
}

// Handle admission submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'submit_admission') {
    $database = new Database();
    $db = $database->getConnection();
    $admissions = new Admissions($db);
    
    $data = array(
        ':student_name' => $_POST['student_name'] ?? '',
        ':date_of_birth' => $_POST['date_of_birth'] ?? '',
        ':class_applying' => $_POST['class_applying'] ?? '',
        ':father_name' => $_POST['father_name'] ?? '',
        ':mother_name' => $_POST['mother_name'] ?? '',
        ':contact_number' => $_POST['contact_number'] ?? '',
        ':email' => $_POST['email'] ?? ''
    );
    
    $result = $admissions->submitApplication($data);
    echo json_encode($result);
    exit;
}
?>