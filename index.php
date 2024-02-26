<?php
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
</head>

<body>
    <?php
    $page = "";
    switch ($resource[1]) {
        case '':
            $page = "./pages/main.php";
            break;
        case 'contents':
            $page = "./pages" . $resource[1] . ".php";
            break;
        case 'reservation':
            $page = "./pages" . $resource[1] . ".php";
            break;
        case 'mypage':
            $page = "./pages" . $resource[1] . ".php";
            break;
        default:
            $page = "./pages/main.php";
            break;
    }
    include($page);


    ?>

</body>

</html>