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
                alert("인증번호를 전송하였습니다.(123456)");
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
        fetch("/practice/Hboard/util/member.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json;charset=utf-8;",
            },
            body: JSON.stringify({
                authNum : "123456"
            })
        }).then((response) => console.log(response));

        // mobileForm.submit();
    })   

})

