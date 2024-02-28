<?php
include("./config/DBconnect.php");
session_start();
$request = $_SERVER["REQUEST_URI"];
$path = explode('?', $request);
$path[1] = isset($path[1]) ? $path[1] : null;
$resource = explode("/", $path[0]);

$includeHeaderAndFooter = false;
$page = "";
switch ($resource[1]) {
    case '':
        $page = "./pages/main.php";
        $includeHeaderAndFooter = true;
        break;
    case 'contents':
    case 'admin':
    case 'mypage':
    case 'reservation':
    case 'mypage':
    case 'login':
        $page = "./pages/" . $resource[1] . ".php";
        $includeHeaderAndFooter = true;
        break;
    case 'logout':
        $page = './pages/' . $resource[1] . '.php';
        $includeHeaderAndFooter = false;
        break;
    default:
        $page = "./pages/main.php";
        $includeHeaderAndFooter = true;
        break;
}

if ($resource[1] == "api") {
    switch ($resource[2]) {
        case 'reservation':
        case 'createReservation':
        case 'babiq':
            $page = './api/' . $resource[2] . '.php';
            $includeHeaderAndFooter = false;
            break;
        default:
            echo "잘못된 접근입니다.";
            break;
    }
    include($page);
} else {
    include("./components/render.php");
}
?>