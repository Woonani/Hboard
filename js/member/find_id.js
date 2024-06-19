document.addEventListener("DOMContentLoaded", () => {
    const findForm = document.querySelector("#findForm")
    const getNumByPhone = document.querySelector("#getNumByPhone")
    const getNumByEmail = document.querySelector("#getNumByEmail")
    const authNumBtn = document.querySelector("#authNumBtn")
    

    // 휴대전화로 인증번호 받기
    getNumByPhone.addEventListener("click", ()=>{
        // 입력값 체크
        let phoneNum = findForm.num1.value.trim() + "-" + findForm.num2.value.trim() + "-" + findForm.num3.value.trim();
        let regPhone = /^01([0|1|6|7|8|9])-([0-9]{3,4})-([0-9]{4})$/;
        if (!regPhone.test(phoneNum)) {
            alert("형식에 맞지 않는 전화번호 입니다.");
            return false;
        }
        if (findForm.username.value.trim() =="") {
            alert("이름을 입력해주세요.");
            return false;
        }
        // param set
        let params = new URLSearchParams({
            mode: "find_user_id",
            username: findForm.username.value,
            mobil_phone: phoneNum,
            email: '',
        });

        sendAuthNum (params);
    })

    // 이메일로 인증번호 받기
    getNumByEmail.addEventListener("click", ()=>{
        // 입력값 체크
        let emailAddr = findForm.email1.value.trim() + "@" + findForm.email2.value.trim();
        const regEmail = /^[a-zA-Z0-9]+@[a-zA-Z]+\.(com|net|org|ac\.kr)$/;

        if (!regEmail.test(emailAddr)) {
            alert("형식에 맞지 않는 이메일 입니다.");
            return false;
        }
        if (findForm.username.value.trim() =="") {
            alert("이름을 입력해주세요.");
            return false;
        }
        // param set
        let params = new URLSearchParams({
            mode: "find_user_id",
            username: findForm.username.value,
            mobil_phone: '',
            email: emailAddr,
        });

        sendAuthNum (params);
    })

    // 인증번호 확인 > 아이디 찾기
    authNumBtn.addEventListener('click', ()=>{

        let params;

        // param set
        if(byPhone.checked){
            let phoneNum = findForm.num1.value.trim() + "-" + findForm.num2.value.trim() + "-" + findForm.num3.value.trim();

            params = new URLSearchParams({
                mode: "auth_num_chk_id",
                username: findForm.username.value,
                mobil_phone: phoneNum,
                email: '',
                authNum: findForm.authNumInput.value,
            });
    
        }else if (byEmail.checked){
            let emailAddr = findForm.email1.value.trim() + "@" + findForm.email2.value.trim();

            params = new URLSearchParams({
                mode: "auth_num_chk_id",
                username: findForm.username.value,
                mobil_phone: '',
                email: emailAddr,
                authNum: findForm.authNumInput.value,
            });
        }

        // 인증 진행
        fetch("../../controller/member/find.php", {
            method: "POST",
            cache: "no-cache",
            headers: {
              "content-Type": "application/x-www-form-urlencoded; charset=utf-8",
            },
            body: params,
        }).then((res)=>{
            return res.json();
        }).then((res) => {
            if (res.status) {
                console.log("res : ", res)
                alert(res.message + "회원님의 아이디는 " + res.data + "입니다.");
                alert("로그인페이지로 이동합니다.");
                location.href = "../../member/index.php";
            } else {
                alert("인증번호가 일치하지 않습니다. 다시 진행해 주세요.");
            return false;
            }
        })
        .catch((error) => console.error("Error:", error));

    })

    findForm.emailSelect.addEventListener('change', ()=>{
        if(findForm.emailSelect.value==""){
            findForm.email2.readOnly=false;
            findForm.email2.value="";
        }else{
            findForm.email2.readOnly=true;
            findForm.email2.value=findForm.emailSelect.value;
        }
    })

})

// 가입자 확인 & 인증번호 전송 요청 함수
function sendAuthNum (params) {

    fetch("../../controller/member/find.php", {
        method: "POST",
        cache: "no-cache",
        headers: {
          "content-Type": "application/x-www-form-urlencoded; charset=utf-8",
        },
        body: params,
    }).then((res)=>{
        return res.json();
    }).then((data) => {
        console.log("find id js : ",data)
        if (data.status) {
            alert("인증번호를 전송하였습니다.(123456)");
            document.getElementById('commonAuthForm').style.display = 'table-row';

        } else {
            alert("가입되어있지 않은 회원 정보입니다. 다시 진행해주세요");
        return false;
        }
    })
    .catch((error) => console.error("Error:", error));
}

