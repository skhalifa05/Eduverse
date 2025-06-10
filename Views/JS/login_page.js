const password= document.getElementById('password');
const toggle= document.getElementById('toggle');
const myicoin= document.getElementById('myicon');

function showHidePass(){
    if(password.type === "password"){
        password.setAttribute('type' , 'text');
        toggle.classList.add('hide');
        myicoin.classList.replace("fa-eye","fa-eye-slash")
    }
    else{
        password.setAttribute('type' , 'password');
        toggle.classList.remove('hide');
        myicoin.classList.replace("fa-eye-slash","fa-eye")
    }
}

/*************************fasel*********************************/

let whereSection = document.querySelector(".where");

function hide(){
    whereSection.style.display="none";
}
function show(){
    whereSection.style.display="block";
}
