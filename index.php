<?php
header("Content-Type: application/json");

//Start time
$startTime = microtime(true);

$requestMethod = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Common response function
function sendResponse($data, $startTime) {
    $endTime = microtime(true);
    $data["response_time_ms"] = round(($endTime - $startTime) * 1000, 2) . " ms";
    echo json_encode($data);
    exit;
}

//GET API
if ($requestMethod === "GET" && $uri === "/status") {
    sendResponse([
        "status" => "ok",
        "time" => date("Y-m-d H:i:s"),
        "server" => gethostname() 
    ], $startTime);
}

//POST API
if ($requestMethod === "POST" && $uri === "/data") {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!$input) {
        http_response_code(400);
        sendResponse(["error" => "Invalid JSON"], $startTime);
    }

    sendResponse([
        "message" => "Data received",
        "data" => $input,
        "server" => gethostname()
    ], $startTime);
}

//404
http_response_code(404);
sendResponse(["error" => "Not Found"], $startTime);
