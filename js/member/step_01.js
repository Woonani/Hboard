document.addEventListener("DOMContentLoaded", ()=>{
    const chkBtn01 = document.querySelector("#member_chk01")
    const chkBtn02 = document.querySelector("#member_chk02")
    const chkBtn03 = document.querySelector("#member_chk03")
    const nxtBtn = document.querySelector("#member_nxtBtn")
    const form = document.step01_form;

    chkBtn01.addEventListener("click", ()=>{
        if(chkBtn01.checked == true &&chkBtn02.checked == true){
            chkBtn03.checked = true;
        }else if(chkBtn01.checked == false){
            chkBtn03.checked = false;
        }
    })

    chkBtn02.addEventListener("click", ()=>{
        if(chkBtn02.checked == true && chkBtn01.checked == true){
            chkBtn03.checked = true;
        }else if(chkBtn02.checked == false){
            chkBtn03.checked = false;
        } 
    })
    
    chkBtn03.addEventListener("click", ()=>{
        if(chkBtn03.checked == true){
            console.log("1")
            chkBtn01.checked = true;
            chkBtn02.checked = true;
        }else{
            console.log("2")
            chkBtn01.checked = false;
            chkBtn02.checked = false;

        }
        
        return false;
    })

    nxtBtn.addEventListener("click", ()=>{
        if(chkBtn03.checked==true){
            form.mode.value = "step_02";
            // console.log("form",form);
            form.submit();
        }else{
            alert("이용약관에 모두 동의하셔야 다음단계로 진행이 가능합니다.")
        }
    })
    

})