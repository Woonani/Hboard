document.addEventListener("DOMContentLoaded", () => {
    const modifyFormBtn = document.querySelector('#modifyFormBtn');

    // 로그인 유저 정보 불러오기 바로 실행
    fetch("../../controller/modify.php?mode=enter")
    .then((res) => res.json())
    .then((data) => {
        // console.log("data ",data);
        if (data.status == 'success') {
            const formData = data.data;

            document.modifyForm.id.value = formData.user_id;
            // document.modifyForm.pw1.value = formData.password; // 보통 비밀번호는 비워져있음
            // document.modifyForm.pw2.value = formData.password;
            let emailAddr = formData.email.split("@");
            document.modifyForm.email1.value = emailAddr[0];
            document.modifyForm.email2.value = emailAddr[1];

            let phoneNum = formData.home_phone.split("-");
            document.modifyForm.tel1.value = phoneNum[0];
            document.modifyForm.tel2.value = phoneNum[1];
            document.modifyForm.tel3.value = phoneNum[2];

            document.modifyForm.zipcode.value = formData.postal_code;
            document.modifyForm.addr1.value = formData.address;
            document.modifyForm.addr2.value = formData.address_detail;
            document.modifyForm.sms_opt.value = formData.sms_opt;
            document.modifyForm.email_opt.value = formData.email_opt;
            return false;
        }
    })
    .catch((error) => console.error("Error:", error));


    modifyForm.id_chk.addEventListener('change', ()=>{
        // 아이디 수정할 경우 중복체크 버튼 하도록
        modifyForm.id_chk.value="0";
    })
///////////////////// modifyFormBtn
    modifyForm.modifyFormBtn.addEventListener('submit',(e)=>{
        e.preventDefault();

        let ret = true;

        ret = checkInput();

        if(!ret){
            return;
        }   

        // input 세팅
        let data = new URLSearchParams({
            // 'name' : modifyForm.name.value,
            'id' : modifyForm.id.value,
            'pw' : modifyForm.pw1.value,
            'email' : modifyForm.email1.value,
            'phone' : modifyForm.phone1.value+"-"+modifyForm.phone2.value+"-"+modifyForm.phone3.value,
            'tel' : modifyForm.tel1.value+"-"+modifyForm.tel2.value+"-"+modifyForm.tel3.value,
            'postal_code' : modifyForm.zipcode.value,
            'address' : modifyForm.adrr1.value,
            'address_detail' : modifyForm.adrr2.value,
            'sms_opt' : modifyForm.sms_opt.value,
            'email_opt' : modifyForm.email_opt.value,
        });

        // 폼전송        
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
            }
        });


    })

// 아이디 중복체크 버튼
dupChek.addEventListener('click', ()=>{
        
    let params = new URLSearchParams({
        mode: "id_dup_chk",
        data: modifyForm.id.value,
      });

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
            modifyForm.id_chk.value = 1;
            alert(data.message);
        } else {
            modifyForm.id_chk.value = 0;
            modifyForm.id.value="";                
            modifyForm.id.focus();                
            alert(data.message);
        }
    }).catch(error => console.log('Error:', error));  
} )

    // 우편번호 찾기 다음 API
    adrrBtn.addEventListener('click',()=>{
        new daum.Postcode({
            oncomplete: function(data) {
                console.log("data ",data)
                modifyForm.zipcode.value = data.zonecode;
                if(data.userSelectedType == 'R') {
                    modifyForm.adrr1.value = data.roadAddress;
                } else {
                    modifyForm.adrr1.value = data.jibunAddress;                    
                }
            }
        }).open();
    })

      // 아이디 형식 확인
      modifyForm.id.addEventListener("blur",()=>{
        const pattern = /^[a-z][a-z0-9]{3,14}$/;

        if(modifyForm.id.value.trim()!="" && !pattern.test(modifyForm.id.value)) {
            alert('유효하지 않은 형식입니다. id는 영문자로 시작하는 4~15자의 영문소문자, 숫자로 작성해주세요.')
            modifyForm.id.value = "";
            modifyForm.id.focus();
        }
    })

    // 비밀번호 형식 확인
    modifyForm.pw1.addEventListener("blur",()=>{
        const pattern = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,15}$/;

        if(modifyForm.pw1.value.trim()!="" && !pattern.test(modifyForm.pw1.value)) {
            alert('유효하지 않은 형식입니다. 비밀번호는 영문자로 시작하는 4~15자의 영문소문자, 숫자로 작성해주세요.')
            modifyForm.pw1.value = "";
            modifyForm.pw1.focus();
        }
    })

    // 비밀번호 일치 확인
    modifyForm.pw2.addEventListener("blur",()=>{
        if(modifyForm.pw2.value.trim()!="" && modifyForm.pw1.value != modifyForm.pw2.value) {
            alert('비밀번호가 일치하지 않습니다. 다시 확인해주세요.')
            modifyForm.pw2.value = "";
            modifyForm.pw2.focus();
        }
    })

});

function checkInput () {
    if (modifyForm.pw1.value.trim()==""){
        alert('정보수정을 위해서는 비밀번호를 입력해야합니다.')
        modifyForm.pw1.focus();
        return false;
    }
    if (modifyForm.pw2.value.trim()==""){
        alert('비밀번호 확인을 입력해주세요.')
        modifyForm.pw2.focus();
        return false;
    }

    if (modifyForm.id.value.trim()==""){
        alert('아이디는 필수입력사항입니다.')
        modifyForm.id.focus();
        return false;
    }
    if (modifyForm.id_chk.value==0) {
        alert("아이디 중복체크를 해주세요!");
        return false;
    }
    

    if (modifyForm.email1.value.trim()==""){
        alert('이메일 주소는 필수입력사항입니다.')
        modifyForm.email1.focus();
        return false;
    }
    if (modifyForm.email2.value.trim()==""){
        alert('이메일 주소는 필수입력사항입니다.')
        modifyForm.email2.focus();
        return false;
    }
    
    if (modifyForm.adrr1.value.trim()==""){
        alert('주소는 필수입력사항입니다.')
        modifyForm.adrr1.focus();
        return false;
    }
    if (modifyForm.adrr2.value.trim()==""){
        alert('상세주소를 입력해주세요.')
        modifyForm.adrr2.focus();
        return false;
    }

    return true;
}