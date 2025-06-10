const body = document.querySelector("body"),
    modeToggle = body.querySelector(".mode-toggle");
sidebar = body.querySelector("nav");
sidebarToggle = body.querySelector(".sidebar-toggle");

let getMode = localStorage.getItem("mode");
if(getMode && getMode ==="dark"){
    body.classList.toggle("dark");
}

let getStatus = localStorage.getItem("status");
if(getStatus && getStatus ==="close"){
    sidebar.classList.toggle("close");
}

modeToggle.addEventListener("click", () =>{
    body.classList.toggle("dark");
    if(body.classList.contains("dark")){
        localStorage.setItem("mode", "dark");
    }else{
        localStorage.setItem("mode", "light");
    }
});

sidebarToggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
    if(sidebar.classList.contains("close")){
        localStorage.setItem("status", "close");
    }else{
        localStorage.setItem("status", "open");
    }
})

function getFinished(selection){
    let query_arr = document.querySelectorAll(".attendance_selector");
    query_arr.forEach(function(ele){
        if(!(ele.className.split(" ").includes(selection))){
            ele.style.display = "none";
        }else{
            ele.style.display = "table-row";
        }
    });
}

function getFinished2(selection, subject){
    let table_id = ".attendance_selector-" + subject;
    let query_arr = document.querySelectorAll(table_id);
    query_arr.forEach(function(ele){
        let id = selection+ '-' +subject;
        if(!(ele.className.split(" ").includes(id))){
            ele.style.display = "none";
        }else{
            ele.style.display = "table-row";
        }
    });
}