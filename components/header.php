<!-- Header Start -->
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li>
            <a href="./index.html"><img class="logo" src="./logo.jpg" alt=""></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./contents">캠핑장소개</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./reservation">예약하기</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./mypage">마이페이지</a>
          </li>
        </ul>
        <span>
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 menu">
            <?php
            if(isset($_SESSION["user_idx"])) {
            echo '<li class="nav-item"><a class="nav-link" href="./logout">로그아웃</a></li>';
            } else {
              echo '<li class="nav-item"><a class="nav-link" href="./login">로그인</a></li>';
            }
            ?>
            <li class="nav-item">
              <a class="nav-link" href="./admin?reservation">운영관리</a>
              <ul class="submenu">
                <li><a href="./admin?reservation">예약관리</a></li>
                <li><a href="./admin?order">주문관리</a></li>
              </ul>
            </li>
          </ul>
        </span>
      </div>
    </nav>
    </header>
<!-- Header End -->