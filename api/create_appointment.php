<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/db_config.php';
include_once '../classes/Database.php';
include_once '../classes/Appointment.php';

$database = new Database();
$db = $database->getConnection();

$appointment = new Appointment($db);

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->service_type) &&
    !empty($data->frequency) &&
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->desired_date) &&
    !empty($data->phone)
) {
    $appointment->service_type = $data->service_type;
    $appointment->frequency = $data->frequency;
    $appointment->name = $data->name;
    $appointment->email = $data->email;
    $appointment->desired_date = $data->desired_date;
    $appointment->phone = $data->phone;

    if($appointment->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Appointment was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create appointment."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create appointment. Data is incomplete."));
}
?>