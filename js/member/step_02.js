console.log("js파일 불러옴")
document.addEventListener("DOMContentLoaded", ()=>{
    const mobileAuthNum = document.querySelector("#mobileAuthNum")
    const num1 = document.querySelector("#mo_input_01");
    const num2 = document.querySelector("#mo_input_02");
    const num3 = document.querySelector("#mo_input_03");
    const authNum = document.querySelector("#mo_input_04");
    let sendNum = false;
    const authChkBtn = document.querySelector("#authChkBtn")
    // const mobileForm = document.mobileForm;

    mobileAuthNum.addEventListener("click", ()=>{
        if(num1==""||num2==""||num3==""){
            sendNum = false;
            alert("올바른 번호를 입력해 주세요");
        }else{
            let phoneNum = num1.value.trim() + "-" + num2.value.trim() + "-" + num3.value.trim();
            let regPhone = /^01([0|1|6|7|8|9])-([0-9]{3,4})-([0-9]{4})$/;
            if(regPhone.test(phoneNum)){
                sendNum = true;
                console.log(phoneNum)
                // AJAX로 서버에 핸드폰 번호 보냄
                // 핸드폰 번호 받은거 확인하고 세션에 인증번호, 폰번호 저장
                let params = new URLSearchParams({
                    'mode' : 'phone_auth',
                    'data' : phoneNum,
                })
                console.log(params.toString());
                fetch('../../controller/step_02.php', {
                    method: 'POST',
                    cache: 'no-cache',
                    headers: {
                        'content-Type' : 'application/x-www-form-urlencoded; charset=utf-8'
                    },
                    body: params
                }).then((data)=>{
                    if(data.ok){
                        alert("인증번호를 전송하였습니다.(123456)");
                    }else{
                        alert("다시 진행해주세요");
                        location.reload(true);
                    }
                }).catch(error => console.error('Error:', error));  
            }else{
                sendNum = false;
                alert("올바른 번호를 입력해 주세요");
            }
        }
    })

    

    authChkBtn.addEventListener("click", ()=>{
        // 인증번호 받기를 먼저 수행했는지와 인증번호 빈값체크
        console.log("인증번호 받기여부?", sendNum);
        if(!sendNum){ 
            alert("인증번호 받기를 먼저 해주세요!");
            return;
        }
        if(authNum.value.trim()==""){
            alert("인증번호를 입력해주세요!");
            return;
        }
        
        console.log("authNum.value ", authNum.value)

        // AJAX로 서버에 인증번호 일치 확인 요청보냄
        fetch('../../controller/step_02.php', {
            method: 'POST',
            cache: 'no-cache',
            headers: {
                'content-Type' : 'application/x-www-form-urlencoded; charset=utf-8'
            },
            body: new URLSearchParams({
                'mode' : 'auth_num_chk',
                'data' : authNum.value,
            })
        }).then((data)=>{
            if(data.ok){
                alert("인증성공! 다음단계로 진행합니다.");
                location.href = "../../member/index.php?mode=step_03";
                // window.location.replace("http://lpass.hackers.com/member/index.php?mode=step_03");

            }else{
                alert("다시 진행해주세요");
            }
        }).catch(error => console.error('Error:', error));  
                    

    })   

})
