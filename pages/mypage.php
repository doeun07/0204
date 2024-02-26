<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>기능경기대회 마이페이지</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./bootstrap/dist/css/bootstrap.css">
</head>
<body>
    <!-- Header Start -->
  <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li>
            <a href="./index.html"><img class="logo" src="./logo.jpg" alt=""></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./contents.html">캠핑장소개</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./reservation.html">예약하기</a>
          </li>
          <li class="nav-item">
            <a class="nav-link now" href="./mypage.html">마이페이지</a>
          </li>
        </ul>
        <span>
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="#">로그인</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">운영관리</a>
            </li>
          </ul>
        </span>
      </div>
    </nav>
    </header>
<!-- Header End -->

<table>
    <tr>
        <th>예약 날짜</th>
        <th>예약 자리</th>
        <th>예약 상태</th>
        <th>예약 취소</th>
        <th>바비큐 주문하기</th>
        <th>주문 건수</th>
        <th>주문 내역 보기</th>
    </tr>
    <tr>
        <td>2024. 02. 15.</td>
        <td>A01</td>
        <td>예약 완료</td>
        <td><button onclick="reservationCancell(this)" type="button" class="btn btn-primary mypage_btn">예약 취소</button></td>
        <td><button onclick="babiqOrderModal()" type="button" class="btn btn-primary mypage_btn">바비큐 주문하기</button></td>
        <td id="totalOrder">0</td>
        <td><button onclick="babiqOrderCheck()" type="button" class="btn btn-primary mypage_btn">주문 내역 보기</button></td>
    </tr>
</table>

<!-- Footer Start-->
<footer>
  <div class="footer">
    <p class="h6">
      <a class="footer_a" href="#">개인정보처리방침</a> | 
      <a class="footer_a" href="#">홈페이지 이용약관</a></p>
    <p class="h6">Copyright : Copyright(C) Skills Camping All Rights Reserved.<br>
      주소 : 충청남도 청양군 대치면 까치내로 123<br>
      고객센터 전화번호 : 041-987-1234<br>
      고객센터 운영시간 : 평일 09:00 ~ 18:00, 주말 10:00 ~ 15:00, 점심시간 12:30~13:30</p>
  </div>
</footer>
<!-- Footer End-->

  <!-- Babiq Order Modal Start -->
<div class="modal fade modal-lg" id="BabiqOrderModal" tabindex="-1" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLiveLabel">바베큐 주문하기</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h5>자리 : A01</h5>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">바비큐 그릴 대여(도구 및 숯 등 포함) (10,000원/개)</span>
            <input id="babiqGrill" type="number" class="form-control" placeholder="개수" aria-label="개수" value="0" max="1" min="0" aria-describedby="basic-addon1" oninput="setPrice(this)">
            <span class="input-group-text" id="babiqGrillTotal">0원</span>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">돼지고기 바비큐 세트 (12,000원/인)</span>
            <input id="pigBabiq" type="number" class="form-control" placeholder="개수" aria-label="개수" value="0" min="0" aria-describedby="basic-addon1" oninput="setPrice(this)">
            <span class="input-group-text" id="pigBabiqTotal">0원</span>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">해산물 바비큐 세트 (15,000원/인)</span>
            <input id="haesanBabiq" type="number" class="form-control" placeholder="개수" aria-label="개수" value="0" min="0" aria-describedby="basic-addon1" oninput="setPrice(this)">
            <span class="input-group-text" id="haesanBabiqTotal">0원</span>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">음료 (3,000원/병)</span>
            <input id="juice" type="number" class="form-control" placeholder="개수" aria-label="개수" value="0" min="0" aria-describedby="basic-addon1" oninput="setPrice(this)">
            <span class="input-group-text" id="juiceTotal">0원</span>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">주류 (5,000원/병)</span>
            <input id="soju" type="number" class="form-control" placeholder="개수" aria-label="개수" value="0" min="0" aria-describedby="basic-addon1" oninput="setPrice(this)">
            <span class="input-group-text" id="sojuTotal">0원</span>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">과자 세트(3종) (4,000원/세트)</span>
            <input id="gajaSet" type="number" class="form-control" placeholder="개수" aria-label="개수" value="0" min="0" aria-describedby="basic-addon1" oninput="setPrice(this)">
            <span class="input-group-text" id="gajaSetTotal">0원</span>
            </div>
        </div>
        <div class="modal-footer">
            <h5 id="totalPrice">총 주문 금액 : 0원</h5>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
            <button type="button" class="btn btn-primary" onclick="babiqSubmit()">주문하기</button>
        </div>
      </div>
    </div>
  </div>
<!-- Babiq Order Modal End -->

<!-- 주문내역확인 Modal Start -->
<div class="modal fade" id="babiqOrderCheck" tabindex="-1" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLiveLabel">주문 내역 확인</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h6 id="babiqCheck">바비큐 그릴 대여(도구 및 숯 등 포함) : 0개</h6>
            <h6 id="pigBabiqCheck">돼지고기 바비큐 세트 : 0세트</h6>
            <h6 id="haesanBabiqCheck">해산물 바비큐 세트 : 0세트</h6>
            <h6 id="juiceCheck">음료 : 0병</h6>
            <h6 id="sojuCheck">주류 : 0병</h6>
            <h6 id="gajaSetCheck">과자세트 : 0세트</h6>
            <h5 id="totalPriceCheck">총 주문 금액 : 0원</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
        </div>
      </div>
    </div>
  </div>
<!-- 주문내역확인 Modal End -->

    <script src="./jquery/jquery-3.6.0.js"></script>
    <script src="./bootstrap/dist/js/bootstrap.js"></script>
    <script src="./js/script.js"></script>
</body>
</html>