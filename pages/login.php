<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $phone_num = $_POST["phone_num"];

    $sql = "SELECT * FROM users WHERE username = :username and phone_num = :phone_num";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":phone_num", $phone_num);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user) {
        $_SESSION["user_idx"] = $user["user_idx"];
        $_SESSION["is_admin"] = (($user["username"] == "관리자") && ($user["phone_num"] == "000-0000-0000")) ? true : false;
        if ($_SESSION["is_admin"]) {
            header("Location: /admin");
        } else {
            header("Location: /mypage");
        }
    } else {
        echo "<script>alert('예약정보가 없습니다.')</script>";
    }
} 
?>
<form class="row g-3 col-3" style="margin:0 auto" method="POST">
  <div class="input-group col-2">
    <input class="form-control" id="username" name="username" placeholder="이름" required>
  </div>
  <div class="input-group col-2">
    <input class="form-control" type="text" id="phone_num" name="phone_num" placeholder="전화번호" required maxlength="13" oninput="regexPhonNumber(this)">
  </div>
  <div class="input-group col-2">
    <button type="submit" class="btn btn-primary mb-3">로그인</button>
  </div>
</form>