<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/Database.php';
include_once '../class/Cities.php';
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get database connection
    $database = new Database();
    $db = $database->getConnection();

    // Create a new Cities object
    $cities = new Cities($db);

    // Get the input data
    $data = json_decode(file_get_contents("php://input"));

    // Set the Cities object properties
    $cities->name = $data->name;
    $cities->country_code = $data->country_code;
    $cities->district = $data->district;
    $cities->population = $data->population;

    // Create the record
    if ($cities->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Record created successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create record."));
    }
}
