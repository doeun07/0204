/**
 * 메인 페이지 슬라이드 (자동 슬라이드, 일시 정지, 재개 기능 구현)
 */
function carouselSlide() {
  //new bootstrap
  const myCarouselElement = document.querySelector(
    "#carouselExampleIndicators"
  );
  const carousel = new bootstrap.Carousel(myCarouselElement, {
    interval: 2000,
    pause: false,
  });
}

function pauseCarousel() {
  const myCarouselElement = document.querySelector(
    "#carouselExampleIndicators"
  );
  $(myCarouselElement).carousel("pause");
}

function playCarousel() {
  const myCarouselElement = document.querySelector(
    "#carouselExampleIndicators"
  );
  $(myCarouselElement).carousel("cycle");
}

// [예약 페이지 JS]
//Reservation.html
function reservation() {
  //JSON 파일에서 데이터 불러오기
  async function fetchReservation() {
    const getReservationJSON = await fetch("../api/reservation.json");
    const reservationJSON = await getReservationJSON.json();
    // console.log(reservationJSON["reservition"]);

    return reservationJSON["reservition"];
  }
  //test code
  // const reservationData = fetchReservation();
  // console.log(reservationData);

  const resDateTableElem = document.querySelector("#resDateTable");
  for (let i = 0; i < 14; i++) {
    // 날짜&요일 가져오기
    const date = new Date();
    date.setDate(date.getDate() + i);
    const year = date.getFullYear();
    const month = ("0" + (date.getMonth() + 1)).slice(-2);
    const day = ("0" + date.getDate()).slice(-2);
    const week = date.getDay();
    // const weekToString = ((week == 0) || (week == 6)) ? "주말" : "주중";
    //(조건식 ? 참일 때의 값 : 거짓일 때의 값;)
    // console.log(`${year}.${month}.${day} (${week})`);

    // 토요일, 일요일 구분 출력
    if (week == 0) {
      resDateTableElem.innerHTML += `<th id="D+${i}" class="sun">${year}.${month}.${day}</th>`;
    } else if (week == 6) {
      resDateTableElem.innerHTML += `<th id="D+${i}" class="sat">${year}.${month}.${day}</th>`;
    } else {
      resDateTableElem.innerHTML += `<th id="D+${i}">${year}.${month}.${day}</th>`;
    }

    //날짜 Table로 출력
    // resDateTableElem.innerHTML += `<th>${year}.${month}.${day}</th>`;
  }
  // 표 만들기
  for (let i = 0; i < 14; i++) {
    for (let k = 0; k < 17; k++) {
      document.querySelector(`#row${k}`).innerHTML += `<td></td>`;
    }
  }
  async function updateReservation() {
    const reservation = await fetchReservation();

    // console.log(reservation[0]["D+0"][0]["status"]);
    // 예약 현황 구분하여 아이콘으로 표에 나타내기
    for (let i = 0; i < 14; i++) {
      for (let k = 0; k < 17; k++) {
        const data = reservation[i][`D+${i}`][k]["status"];
        const tdElem = document.querySelector(
          `#row${k} > td:nth-of-type(${i + 1})`
        );

        if (data == "W") {
          tdElem.innerText = "●";
          tdElem.className = `W D+${i} ${k}`;
          tdElem.addEventListener("click", yaeyak);
        } else if (data == "R") {
          tdElem.innerText = "▲";
          tdElem.className = `R D+${i} ${k}`;
          tdElem.addEventListener("click", noyaeyak);
        } else {
          tdElem.innerText = "■";
          tdElem.className = `C D+${i} ${k}`;
          tdElem.addEventListener("click", noyaeyak);
          // document.querySelector(`#row${i}`).innerHTML += `<td>${reservation[j][`D+${j}`][i]["status"]}</td>`;
        }
      }
    }
  }
  // 5초마다 updateReservation 함수를 호출
  setInterval(() => {
    updateReservation();
  }, 5000);
  // 최초 접속 시 updateReservation을 즉시 호출하여 페이지를 렌더링
  updateReservation();
  //천단위 구분기호

}

//예약 modal 띄우기
function yaeyak() {

  const rowValue = this.classList[2];
  let position;
  if(rowValue <= 6) {
    position = "A" +  ("0" +(Number(rowValue) + 1)).slice(-2);
  } else {
    position = "T" + ("0" + (Number(rowValue) - 6)).slice(-2);
  }
  
  // console.log(position);
  document.querySelector("#position").innerText = `자리 : ${position}`;
  $("#exampleModalLive").modal("show");

  //아이디가 this.classList[1]인 Elem의 class 값을 가져와서 week 변수에 저장
  const week = document.getElementById(`${this.classList[1]}`).className;
  //주말, 평일 / A, T 영역 구분
  let price;
  if(week !=""){
    if(position.includes("A")) {
      price = 30000;
    } else{
      price = 20000;
    }
  } else {
    if(position.includes("A")) {
      price = 25000;
    } else {
      price = 15000;
    }
  }
  //toLocaleString => 금액 천 단위 구분 기호(,)
  document.querySelector("#position").innerText = `날짜 : ${position}`;
  document.querySelector("#price").innerText = `금액 : ${price.toLocaleString()}원`;

  $("#exampleModalLive").modal("show");
}

function noyaeyak() {
  alert("예약하실 수 없습니다.")
}

// 휴대폰번호 정규표현식으로 3-4-4 만들기
const regexPhonNumber = (target) => {
  target.value = target.value.replace(/[^0-9]/g, "").replace(/^(\d{3})(\d{4})(\d{4})/, `$1-$2-$3`);
}
// 인증번호 정규표현식
const regexVerifyNumber = (target) => {
  target.value = target.value.replace(/[^0-9]/g, "");
}

//인증번호 칸 활성화 조건
function sendVerifyNumber() {
  if(document.querySelector("#phoneNumber").value.length == 13) {
    document.querySelector("#phoneVerify").disabled = false;
  } else {
    alert("휴대폰 번호를 확인해 주세요");
  }
}

//예약 조건
function reservationSubmit() {
  const name = document.querySelector("#name").value;
  const phoneNumber = document.querySelector("#phoneNumber").value;
  const phoneVerify = document.querySelector("#phoneVerify").value;

  if(!name) {
    return alert("이름을 확인하여 주시기 바랍니다.")
  }
  if(phoneNumber.length != 13) {
    return alert("전화번호를 확인하여 주시기 바랍니다.")
  }
  if(phoneVerify != "1234") {
    return alert("인증번호를 확인하여 주시기 바랍니다.")
  }

  $("#exampleModalLive").modal("hide");
  // alert("예약완료")
  showToast();
}

//Toast 띄우기
function showToast() {
  const toastLiveExample = document.getElementById('liveToast')
  const toast = new bootstrap.Toast(toastLiveExample)
  toast.show();
}

// [마이페이지 JS]
const babiqGrillPrice = 10000;
const pigBabiqPrice = 12000;
const haesanBabiqPrice = 15000;
const juicePrice = 3000;
const sojuPrice = 5000;
const gajaSetPrice = 4000;

const orderArr = [0, 0, 0, 0, 0, 0];
let totalPrice = 0;
let orderCount = 0;

//가격 받아오기
function setPrice(product) {
  switch (product.id) {
    case 'babiqGrill':
      orderArr[0] = product.value;
      break;
    case 'pigBabiq':
      orderArr[1] = product.value;
      break;
    case 'haesanBabiq':
      orderArr[2] = product.value;
      break;
    case 'juice':
      orderArr[3] = product.value;
      break;
    case 'soju':
      orderArr[4] = product.value;
      break;
    case 'gajaSet':
      orderArr[5] = product.value;
      break;
  } 

  const babiqGrillTotal = babiqGrillPrice * orderArr[0];
  const pigBabiqTotal = pigBabiqPrice * orderArr[1];
  const haesanBabiqTotal = haesanBabiqPrice * orderArr[2];
  const juiceTotal = juicePrice * orderArr[3];
  const sojuTotal = sojuPrice * orderArr[4];
  const gajaSetTotal = gajaSetPrice * orderArr[5];
  totalPrice = babiqGrillTotal + pigBabiqTotal + haesanBabiqTotal + juiceTotal + sojuTotal + gajaSetTotal;
  document.querySelector("#totalPrice").innerText = `총 주문 금액 : ${totalPrice.toLocaleString()}원`;
  //소계금액
  document.querySelector("#babiqGrillTotal").innerText = `${babiqGrillTotal.toLocaleString()}원`;
  document.querySelector("#pigBabiqTotal").innerText = `${pigBabiqTotal.toLocaleString()}원`;
  document.querySelector("#haesanBabiqTotal").innerText = `${haesanBabiqTotal.toLocaleString()}원`;
  document.querySelector("#juiceTotal").innerText = `${juiceTotal.toLocaleString()}원`;
  document.querySelector("#sojuTotal").innerText = `${sojuTotal.toLocaleString()}원`;
  document.querySelector("#gajaSetTotal").innerText = `${gajaSetTotal.toLocaleString()}원`;
}

//주문 modal 띄우기
function babiqOrderModal() {
  $("#BabiqOrderModal").modal("show");
}
//modal 닫고 주문 건수 올리기
function babiqSubmit() {
  $("#BabiqOrderModal").modal("hide");
  alert("주문이 완료되었습니다.");
  orderCount++;
  document.querySelector("#totalOrder").innerHTML = orderCount;
}

//주문내역보기 Modal
function babiqOrderCheck() {
  $("#babiqOrderCheck").modal("show");

  //주문내역보기 갯수 및 가격 띄우기
  document.querySelector("#babiqCheck").innerText = `바비큐 그릴 대여(도구 및 숯 등 포함) : ${orderArr[0]}개`;
  document.querySelector("#pigBabiqCheck").innerText = `돼지고기 바비큐 세트 : ${orderArr[1]}세트`;
  document.querySelector("#haesanBabiqCheck").innerText = `해산물 바비큐 세트 : ${orderArr[2]}세트`;
  document.querySelector("#juiceCheck").innerText = `음료 : ${orderArr[3]}병`;
  document.querySelector("#sojuCheck").innerText = `주류 : ${orderArr[4]}병`;
  document.querySelector("#gajaSetCheck").innerText = `과자세트 : ${orderArr[5]}세트`;
  document.querySelector("#totalPriceCheck").innerText = `총 주문 금액 : ${totalPrice.toLocaleString()}원`;
}

//예약취소
function reservationCancell(jari) {
  const trElem = jari.parentElement.parentElement;
  const position = trElem.getElementsByTagName('td')[1].innerText;
  const cancell = prompt(`${position} 자리의 예약을 취소하시려면 '예'를 입력해주세요.`);
  if(cancell == "예") {
    trElem.innerHTML = ""
    alert("예약이 취소되었습니다.");
  } else {
    alert("예약 취소 실패");
  }
}