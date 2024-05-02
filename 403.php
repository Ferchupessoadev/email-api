<?php

header("Content-type: application/json");

$response = [
    "message" => "403 - Forbidden",
    "status_code" => 403
];

echo json_encode($response);
