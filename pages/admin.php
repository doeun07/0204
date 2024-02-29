<?php
if (isset($_SESSION["user_idx"])) {
    if (isset($_SESSION["is_admin"]) == false) {
        echo "<script>alert('관리자만 이용 가능한 페이지입니다.')
        location.href = './mypage'
        </script>";
    }
} else {
        echo "<script>alert('로그인 후 이용 가능합니다.')
        location.href = './login'
        </script>";
}


isset($_GET["reservation"]) ? include("./pages/adminReservation.php") : include("./pages/adminOrder.php");
?>
