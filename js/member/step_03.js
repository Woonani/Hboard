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

        }).then((data)=>{

            if(data.status == 'success'){
                signInForm.id_chk.value = 1;
                alert(data.message);
            } else {
                signInForm.id_chk.value = 0;
                signInForm.id.value="";                
                signInForm.id.focus();                
                alert(data.message);
            }
        }).catch(error => console.log('Error:', error));  
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

/* */  
    // 입력값 유효성 체크
    // signInBtn.addEventListener('submit', (event)=>{
        signInForm.addEventListener('submit', function(event) {
        event.preventDefault();
        console.log("e : ",event);    
        
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
        if (signInForm.id_chk.value==0) {
            alert("아이디 중복체크를 해주세요!");
            return;
        }
        if (signInForm.pw1.value.trim()==""){
            alert('필수입력사항입니다.')
            signInForm.pw1.focus();
            return;
        }
        // if (signInForm.pw2.value.trim()==""){
        //     alert('필수입력사항입니다.')
        //     signInForm.pw2.focus();
        //     return;
        // }
        // if (signInForm.email1.value.trim()==""){
        //     alert('필수입력사항입니다.')
        //     signInForm.email1.focus();
        //     return;
        // }
        // if (signInForm.email2.value.trim()==""){
        //     alert('필수입력사항입니다.')
        //     signInForm.email2.focus();
        //     return;
        // }
        
        // if (signInForm.adrr1.value.trim()==""){
        //     alert('필수입력사항입니다.')
        //     signInForm.adrr1.focus();
        //     return;
        // }
        // if (signInForm.adrr2.value.trim()==""){
        //     alert('필수입력사항입니다.')
        //     signInForm.adrr2.focus();
        //     return;
        // }
        
        //변수 세팅해서 regist.php로 보내야겠다...
        let data = new URLSearchParams({
            'name' : signInForm.name.value,
            'id' : signInForm.id.value,
            'pw' : signInForm.pw1.value,
            'email' : signInForm.email1.value,
            'phone' : signInForm.phone1.value+signInForm.phone2.value+signInForm.phone3.value,
            'tel' : signInForm.tel1.value+signInForm.tel2.value+signInForm.tel3.value,
            'postal_code' : signInForm.zipcode.value,
            'address' : signInForm.adrr1.value,
            'address_detail' : signInForm.adrr2.value,
            'sms_opt' : signInForm.sms_opt.value,
            'email_opt' : signInForm.email_opt.value,
        });

        /*
        let data2 = {
            'name' : signInForm.name.value,
            'id' : signInForm.id.value,
            'pw' : signInForm.pw1.value,
            'email' : signInForm.email1.value,
            'phone' : signInForm.phone1.value+signInForm.phone2.value+signInForm.phone3.value,
            'tel' : signInForm.tel1.value+signInForm.tel2.value+signInForm.tel3.value,
            'postal_code' : signInForm.zipcode.value,
            'address' : signInForm.adrr1.value,
            'address_detail' : signInForm.adrr2.value,
            'sms_opt' : signInForm.sms_opt.value,
            'email_opt' : signInForm.email_opt.value,
        };

        console.log("data", data2)
        */

    // })
      
    // 2. 폼전송
    
    // signInBtn.addEventListener('submit', (e)=>{

        // window.location.href = '../member/index.php?mode=regist';
        
        fetch('../controller/regist.php', {
            method: 'POST',
            cache: 'no-cache',
            headers: {
                'content-Type' : 'application/x-www-form-urlencoded; charset=utf-8'
            },
            body: data
        }).then((res)=>{

            return res.json();

        }).then((data)=>{
    
            if(data.status == 'success'){
                alert(data.message);
                location.href = "../../member/index.php?mode=complete";
                
            }else if(data.status == 'fail') {
                alert(data.message+"다시 진행해주세요");
            }

        }).catch(error => {
            console.error('Error:', error);
            if (error.message.includes('Unexpected token')) {
                console.error('Received HTML response instead of JSON');
                // HTML 응답을 처리하는 방법을 추가
            }
        });

    })
  
    
})


