<?php

session_start();

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../src/Enums/Status.php';
require_once __DIR__ . '/../src/Entities/User.php';
require_once __DIR__ . '/../src/Entities/HelpRequest.php';
require_once __DIR__ . '/../src/Repositories/UserRepository.php';
require_once __DIR__ . '/../src/Repositories/HelpRequestRepository.php';

use Src\Repositories\UserRepository;
use Src\Repositories\HelpRequestRepository;

$userRepo = new UserRepository();
$requestRepo = new HelpRequestRepository();

$requestId = $_POST['request_id'];

// tutor connecté
$tutor = $userRepo->findByEmail("tutor@enaa.com");

$request = $requestRepo->findById($requestId);

try {

    $request->assignTo($tutor);

    $requestRepo->update($request);

    header("Location: ../public/dashboard.php");
    exit;

} catch (Exception $e) {

    echo $e->getMessage();
}