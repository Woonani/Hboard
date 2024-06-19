// console.log("js파일 불러옴")
document.addEventListener("DOMContentLoaded", ()=>{
    const dupChek = document.querySelector("#dupChek")
    const adrrBtn = document.querySelector("#adrrBtn")
    const signInBtn = document.querySelector("#signInBtn")
    
    // 페이지 들어오면 휴대전화번호 바인딩
    fetch('../../controller/member/step_03.php', {
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

        fetch('../../controller/member/step_03.php', {
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
        

    // 아이디 형식 확인
    signInForm.id.addEventListener("blur",()=>{
        const pattern = /^[a-z][a-z0-9]{3,14}$/;

        if(signInForm.id.value.trim()!="" && !pattern.test(signInForm.id.value)) {
            alert('유효하지 않은 형식입니다. id는 영문자로 시작하는 4~15자의 영문소문자, 숫자로 작성해주세요.')
            signInForm.id.value = "";
            signInForm.id.focus();
        }
    })

    // 비밀번호 형식 확인
    signInForm.pw1.addEventListener("blur",()=>{
        const pattern = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,15}$/;

        if(signInForm.pw1.value.trim()!="" && !pattern.test(signInForm.pw1.value)) {
            alert('유효하지 않은 형식입니다. 비밀번호는 영문자로 시작하는 4~15자의 영문소문자, 숫자로 작성해주세요.')
            signInForm.pw1.value = "";
            signInForm.pw1.focus();
        }
    })

    // 비밀번호 일치 확인
    signInForm.pw2.addEventListener("blur",()=>{
        if(signInForm.pw2.value.trim()!="" && signInForm.pw1.value != signInForm.pw2.value) {
            alert('비밀번호가 일치하지 않습니다. 다시 확인해주세요.')
            signInForm.pw2.value = "";
            signInForm.pw2.focus();
        }
    })

    // 이메일 형식 확인
    signInForm.email1.addEventListener("blur",()=>{
        let emailAddr = signInForm.email1.value.trim();
        const regEmail = /^[a-zA-Z0-9]$/;

        if (signInForm.email1.value!="" && !regEmail.test(emailAddr)) {
            alert("형식에 맞지 않는 이메일 입니다. \n example@example.com");
            signInForm.email1.value="";
            signInForm.email1.focus();
            return false;
        }
    });
    signInForm.email2.addEventListener("blur",()=>{
        let emailAddr = signInForm.email2.value.trim();
        const regEmail = /^[a-zA-Z]+\.(com|net|org|ac\.kr)$/;

        if (signInForm.email2.value!="" && !regEmail.test(emailAddr)) {
            alert("형식에 맞지 않는 이메일 입니다. \n example@example.com");
            signInForm.email2.value="";
            signInForm.email2.focus();
            return false;
        }
    });


    // signInBtn.addEventListener('submit', (event)=>{
    signInForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        let ret = true;

        ret = checkInput();
        
        if(!ret){
            return;
        }       
        
        // input 세팅
        let emailAddr = signInForm.email1.value.trim() + "@" + signInForm.email2.value.trim();

        let data = new URLSearchParams({
            'name' : signInForm.name.value,
            'id' : signInForm.id.value,
            'pw' : signInForm.pw1.value,
            'email' : emailAddr,
            'phone' : signInForm.phone1.value+"-"+signInForm.phone2.value+"-"+signInForm.phone3.value,
            'tel' : signInForm.tel1.value+"-"+signInForm.tel2.value+"-"+signInForm.tel3.value,
            'postal_code' : signInForm.zipcode.value,
            'address' : signInForm.adrr1.value,
            'address_detail' : signInForm.adrr2.value,
            'sms_opt' : signInForm.sms_opt.value,
            'email_opt' : signInForm.email_opt.value,
        });


      
        // 2. 폼전송        
        fetch('../controller/member/regist.php', {
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
            }
        });

    })

    // 이메일 select onChange 이벤트
    signInForm.emailSelect.addEventListener('change', ()=>{
        console.log("선택함")
        if(signInForm.emailSelect.value==""){
            signInForm.email2.readOnly=false;
            signInForm.email2.value="";
        }else{
            signInForm.email2.readOnly=true;
            signInForm.email2.value=signInForm.emailSelect.value;
        }
    })
})

// input 값 체크
function checkInput () {
    if (signInForm.name.value.trim()==""){
        alert('이름는 필수입력사항입니다.')
        signInForm.name.focus();
        return false;
    }
    if (signInForm.id.value.trim()==""){
        alert('아이디는 필수입력사항입니다.')
        signInForm.id.focus();
        return false;
    }
    if (signInForm.id_chk.value==0) {
        alert("아이디 중복체크를 해주세요!");
        return false;
    }
    if (signInForm.pw1.value.trim()==""){
        alert('비밀번호는 필수입력사항입니다.')
        signInForm.pw1.focus();
        return false;
    }
    if (signInForm.pw2.value.trim()==""){
        alert('비밀번호 확인을 입력해주세요.')
        signInForm.pw2.focus();
        return false;
    }

    if (signInForm.email1.value.trim()==""){
        alert('이메일 주소는 필수입력사항입니다.')
        signInForm.email1.focus();
        return false;
    }
    if (signInForm.email2.value.trim()==""){
        alert('이메일 주소는 필수입력사항입니다.')
        signInForm.email2.focus();
        return false;
    }
    
    if (signInForm.adrr1.value.trim()==""){
        alert('주소는 필수입력사항입니다.')
        signInForm.adrr1.focus();
        return false;
    }
    if (signInForm.adrr2.value.trim()==""){
        alert('상세주소를 입력해주세요.')
        signInForm.adrr2.focus();
        return false;
    }

    return true;
}