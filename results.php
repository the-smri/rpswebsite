<?php
require_once 'config.php';

class Results {
    private $conn;
    private $table_name = "results";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getResult($student_id, $year, $exam_type) {
        $query = "SELECT r.*, s.name as subject_name, st.student_id as student_code, st.class, st.section 
                  FROM " . $this->table_name . " r
                  JOIN students st ON r.student_id = st.id
                  JOIN subjects s ON r.subject_id = s.id
                  WHERE st.student_id = :student_id AND r.exam_year = :year AND r.exam_type = :exam_type";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':exam_type', $exam_type);
        $stmt->execute();

        $results = array();
        $student_info = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (empty($student_info)) {
                $student_info = array(
                    'student_id' => $row['student_code'],
                    'name' => 'Ahmed Hassan', // You would join with users table in production
                    'class' => $row['class'],
                    'section' => $row['section'],
                    'exam' => $row['exam_type'] . ' ' . $row['exam_year']
                );
            }
            
            $results[] = array(
                'name' => $row['subject_name'],
                'theory' => $row['theory_marks'],
                'practical' => $row['practical_marks'],
                'max' => 100, // Assuming max marks is 100
                'total' => $row['total_marks'],
                'grade' => $row['grade']
            );
        }

        if (empty($results)) {
            return array("status" => "error", "message" => "Result not found");
        }

        return array(
            "status" => "success",
            "student_info" => $student_info,
            "subjects" => $results
        );
    }

    public function addResult($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (student_id, exam_type, exam_year, subject_id, theory_marks, practical_marks, total_marks, grade, gpa) 
                  VALUES (:student_id, :exam_type, :exam_year, :subject_id, :theory_marks, :practical_marks, :total_marks, :grade, :gpa)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute($data);
    }
}

// Handle result search request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'search_result') {
    $database = new Database();
    $db = $database->getConnection();
    $results = new Results($db);
    
    $student_id = $_POST['student_id'] ?? '';
    $year = $_POST['year'] ?? date('Y');
    $exam_type = $_POST['exam_type'] ?? '';
    
    $result = $results->getResult($student_id, $year, $exam_type);
    echo json_encode($result);
    exit;
}
?>