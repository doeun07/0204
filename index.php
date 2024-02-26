<?php
include("./config/DBconnect.php");
session_start();
$request = $_SERVER["REQUEST_URI"];
$path = explode('?', $request);
$path[1] = isset($path[1]) ? $path[1] : null;
$resource = explode("/", $path[0]);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills Camping</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./bootstrap/dist/css/bootstrap.css">
    <script src="./js/script.js"></script>
</head>

<body>
    <?php
    $includeheaderAndFooter = false;
    $page = "";
    switch ($resource[1]) {
        case '':
            $page = "./pages/main.php";
            $includeheaderAndFooter = true;
            break;
        case 'contents':
            $page = "./pages/" . $resource[1] . ".php";
            $includeheaderAndFooter = true;
            break;
        case 'reservation':
            $page = "./pages/" . $resource[1] . ".php";
            $includeheaderAndFooter = true;
            break;
        case 'mypage':
            $page = "./pages/" . $resource[1] . ".php";
            $includeheaderAndFooter = true;
            break;
        case 'login':
            $page = './pages/' . $resource[1] . '.php';
            $includeheaderAndFooter = true;
            break;
        case 'logout':
            $page = './pages/' . $resource[1] . '.php';
        case 'admin':
            $page = './pages/' . $resource[1] . '.php';
            $includeheaderAndFooter = true;
            break;
        case 'mypage':
            $page = './pages/' . $resource[1] . '.php';
            $includeheaderAndFooter = true;
            break;
        default:
            $page = "./pages/main.php";
            $includeheaderAndFooter = true;
            break;
    }
    $includeheaderAndFooter ? include("./components/header.php") : null;
    include($page);
    $includeheaderAndFooter ? include("./components/footer.php") : null;
    ?>

</body>
<script src="./jquery/jquery-3.6.0.js"></script>
<script src="./bootstrap/dist/js/bootstrap.js"></script>

</html>