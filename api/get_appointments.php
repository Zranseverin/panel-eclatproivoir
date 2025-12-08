<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db_config.php';
include_once '../classes/Database.php';
include_once '../classes/Appointment.php';

$database = new Database();
$db = $database->getConnection();

$appointment = new Appointment($db);

$stmt = $appointment->getAllAppointments();
$num = $stmt->rowCount();

if($num > 0) {
    $appointments_arr = array();
    $appointments_arr["records"] = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        $appointment_item = array(
            "id" => $id,
            "service_type" => $service_type,
            "frequency" => $frequency,
            "name" => $name,
            "email" => $email,
            "desired_date" => $desired_date,
            "phone" => $phone,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );
        
        array_push($appointments_arr["records"], $appointment_item);
    }
    
    http_response_code(200);
    echo json_encode($appointments_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No appointments found."));
}
?>