console.log("js파일 불러옴")
document.addEventListener("DOMContentLoaded", ()=>{
    const dupChek = document.querySelector("#dupChek")
    const adrrBtn = document.querySelector("#adrrBtn")
    const signInBtn = document.querySelector("#signInBtn")
    
    // 페이지 들어오면 휴대전화번호 바인딩
    fetch('../../controller/step_03.php', {
        method: 'GET',
        cache: 'no-cache',
        headers: {
            'content-Type' : 'application/x-www-form-urlencoded; charset=utf-8'
        }
    }).then((res)=>{
        return res.json();
        // return res;
    }).then((data)=>{
        if(data.status == 'success'){
            let phoneNum = data.data.split("-");
            console.log("확인 : ",phoneNum)
            signInForm.phone1.value=phoneNum[0];
            signInForm.phone2.value=phoneNum[1];
            signInForm.phone3.value=phoneNum[2];
        }
    }).catch(error => console.error('Error:', error));  
          
    // 아이디 중복체크 버튼
    dupChek.addEventListener('click', ()=>{

        let params = new URLSearchParams({
            mode: "id_dup_chk",
            data: signInForm.id.value,
          });
        console.log("유저아이디 : ", params)

        fetch('../../controller/step_03.php', {
            method: 'POST',
            cache: 'no-cache',
            headers: {
                'content-Type' : 'application/x-www-form-urlencoded; charset=utf-8'
            },
            body: params
        }).then((res)=>{
            return res.json(); // Unexpected end of JSON input
            // return res; 
        }).then((data)=>{
            console.log("응답 : ", data)
            if(data.status == 'success'){
                alert(data.message);
                signInForm.id_chk.value = 1;
            } else {
                alert(data.message);
                signInForm.id_chk.value = 0;
                signInForm.id.value="";                
                signInForm.id.focus();                
            }
        }).catch(error => console.error('Error:', error));  
    } )

    // 우편번호 찾기 다음 API
    adrrBtn.addEventListener('click',()=>{
        new daum.Postcode({
            oncomplete: function(data) {
                console.log("data ",data)
                signInForm.zipcode.value = data.zonecode;
                if(data.userSelectedType == 'R') {
                    signInForm.adrr1.value = data.roadAddress;
                } else {
                    signInForm.adrr1.value = data.jibunAddress;                    
                }
            }
        }).open();
    })


    // 폼 전송 버튼 
    signInBtn.addEventListener('click', ()=>{
        // 1. 입력값 유효성 체크
        if (signInForm.name.value.trim()==""){
            alert('필수입력사항입니다.')
            signInForm.name.focus();
            return;
        }
        if (signInForm.id.value.trim()==""){
            alert('필수입력사항입니다.')
            signInForm.id.focus();
            return;
        }
        if (!signInForm.id_chk.value) {
        alert("아이디 중복체크를 해주세요!");
            return;
        }
        if (signInForm.pw1.value.trim()==""){
            alert('필수입력사항입니다.')
            signInForm.pw1.focus();
            return;
        }
        if (signInForm.pw2.value.trim()==""){
            alert('필수입력사항입니다.')
            signInForm.pw2.focus();
            return;
        }
        if (signInForm.email1.value.trim()==""){
            alert('필수입력사항입니다.')
            signInForm.email1.focus();
            return;
        }
        if (signInForm.email2.value.trim()==""){
            alert('필수입력사항입니다.')
            signInForm.email2.focus();
            return;
        }
        
        if (signInForm.adrr1.value.trim()==""){
            alert('필수입력사항입니다.')
            signInForm.adrr1.focus();
            return;
        }
        if (signInForm.adrr2.value.trim()==""){
            alert('필수입력사항입니다.')
            signInForm.adrr2.focus();
            return;
        }
        
        // 2. 폼전송
        fetch('../../controller/step_03.php', {
            method: 'POST',
            cache: 'no-cache',
            headers: {
                'content-Type' : 'application/x-www-form-urlencoded; charset=utf-8'
            },
            body: new URLSearchParams({
                'mode' : 'sign_in',
                'username' : signInForm.name.value,
                'user_id' : signInForm.id.value,
                'password' : signInForm.password.value,
                'email' : signInForm.email.value,
                'mobile_phone' : signInForm.phone1.value+signInForm.phone2.value+signInForm.phone3.value,
                'home_phone' : signInForm.tel1.value+signInForm.tel2.value+signInForm.tel3.value,
                'postal_code' : signInForm.zipcode.value,
                'address' : signInForm.adrr1.value,
                'address_detail' : signInForm.adrr2.value,
                'sms_opt' : signInForm.sms_opt.value,
                'email_opt' : signInForm.email_opt.value,
            })
        }).then((res)=>{
            // return res.json();
            console.log("폼전송 ", res)
            return res;
        }).then((data)=>{
    
            if(data.status == 'success'){
                alert(data.message);
                location.href = "../../member/index.php?mode=regist";
                
            }else if(data.status == 'fail') {
                alert(data.message+"다시 진행해주세요");
            }

        }).catch(error => {console.error('Error:', error)});  

    })
  
    
})
