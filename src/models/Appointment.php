<?php
class Appointment {
    private $conn;
    private $table_name = "appointments";

    public $id;
    public $doctor_id;
    public $patient_id;
    public $date;
    public $time;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get appointments by doctor ID
    public function getAppointmentsByDoctor($doctor_id) {
        $query = "SELECT a.id, p.name as patient_name, a.date, a.time, a.status, p.id as patient_id
                  FROM " . $this->table_name . " a
                  JOIN patients p ON a.patient_id = p.id
                  WHERE a.doctor_id = :doctor_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get appointment details by appointment ID
    public function getAppointmentById($id) {
        $query = "SELECT a.id, p.name as patient_name, a.date, a.time, a.status, p.id as patient_id
                  FROM " . $this->table_name . " a
                  JOIN patients p ON a.patient_id = p.id
                  WHERE a.id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update appointment details
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET date = :date, time = :time, status = :status
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->time = htmlspecialchars(strip_tags($this->time));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind parameters
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':time', $this->time);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Cancel an appointment
    public function cancel($id) {
        $query = "UPDATE " . $this->table_name . " SET status = 'cancelled' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }




    // Update appointment details
public function updateAppointment($id, $patient_id, $doctor_id, $date, $time, $status) {
    $query = "UPDATE " . $this->table_name . " 
              SET patient_id = :patient_id, doctor_id = :doctor_id, date = :date, time = :time, status = :status
              WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    // Sanitize input
    $id = htmlspecialchars(strip_tags($id));
    $patient_id = htmlspecialchars(strip_tags($patient_id));
    $doctor_id = htmlspecialchars(strip_tags($doctor_id));
    $date = htmlspecialchars(strip_tags($date));
    $time = htmlspecialchars(strip_tags($time));
    $status = htmlspecialchars(strip_tags($status));

    // Bind parameters
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':status', $status);

    // Execute query
    if ($stmt->execute()) {
        return true;
    }
    return false;
}



    // get all appointments
    public function getAllAppointments() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
