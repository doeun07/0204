<?php
if (isset($_SESSION["user_idx"])) {
    session_destroy();
    header("Location: /");
} else {
    echo "로그인하셨나요?";
}
?>