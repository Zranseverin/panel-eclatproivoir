<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/db_config.php';
include_once '../classes/Database.php';
include_once '../classes/Appointment.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Prepare appointment object
$appointment = new Appointment($db);

// Set ID property of appointment to be edited
$appointment->id = isset($_GET['id']) ? $_GET['id'] : die();

// Read the details of appointment to be edited
if($appointment->getAppointmentById($appointment->id)) {
    // Create array
    $appointment_arr = array(
        "id" => $appointment->id,
        "service_type" => $appointment->service_type,
        "frequency" => $appointment->frequency,
        "name" => $appointment->name,
        "email" => $appointment->email,
        "desired_date" => $appointment->desired_date,
        "phone" => $appointment->phone,
        "created_at" => $appointment->created_at,
        "updated_at" => $appointment->updated_at
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Make it json format
    echo json_encode($appointment_arr);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // Tell the user appointment does not exist
    echo json_encode(array("message" => "Appointment does not exist."));
}
?>