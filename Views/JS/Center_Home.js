const body = document.querySelector("body"),
    modeToggle = body.querySelector(".mode-toggle");
sidebar = body.querySelector("nav");
sidebarToggle = body.querySelector(".sidebar-toggle");
let header_style = document.querySelector(".heading");

let getMode = localStorage.getItem("mode");
if (getMode && getMode === "dark") {
  body.classList.toggle("dark");
  header_style.className = "heading2";
}

let getStatus = localStorage.getItem("status");
if (getStatus && getStatus === "close") {
  sidebar.classList.toggle("close");
}

modeToggle.addEventListener("click", () => {
  body.classList.toggle("dark");
  if (body.classList.contains("dark")) {
    localStorage.setItem("mode", "dark");
    header_style.className = "heading2";
  } else {
    localStorage.setItem("mode", "light");
    header_style.className = "heading";
  }
});

sidebarToggle.addEventListener("click", () => {
  sidebar.classList.toggle("close");
  if (sidebar.classList.contains("close")) {
    localStorage.setItem("status", "close");
  } else {
    localStorage.setItem("status", "open");
  }
})


/******************************************************************************* */
const targetDiv = document.querySelector(".change-pass-box");
const btn = document.querySelector(".ca");
const change = document.querySelector(".fa-edit");
const submit = document.querySelector(".submit");
const background = document.querySelector(".profile-details");
const background2 = document.querySelector(".top");
const background3 = document.querySelector(".timetable");
const background4 = document.querySelector(".t1");
const background5 = document.querySelector(".t2");

if(btn){
  btn.onclick = function () {
    if (targetDiv.style.display !== "none") {
      targetDiv.style.display = "none";
      background.setAttribute("style", "filter: blur(0px);");
      background2.setAttribute("style", "filter: blur(0px);");
      background3.setAttribute("style", "filter: blur(0px);");
      background4.setAttribute("style", "filter: blur(0px);");
      background5.setAttribute("style", "filter: blur(0px);");
    } else {
      targetDiv.style.display = "flex";
    }
  };
}

if(submit){
  submit.onclick = function () {
    if (targetDiv.style.display !== "none") {
      targetDiv.style.display = "none";
      background.setAttribute("style", "filter: blur(0px);");
      background2.setAttribute("style", "filter: blur(0px);");
      background3.setAttribute("style", "filter: blur(0px);");
      background4.setAttribute("style", "filter: blur(0px);");
      background5.setAttribute("style", "filter: blur(0px);");
    } else {
      targetDiv.style.display = "flex";
    }
  };
}

if(change){
  change.onclick = function () {
    targetDiv.style.display = "flex";
    background.setAttribute("style", "filter: blur(5px);");
    background2.setAttribute("style", "filter: blur(5px);");
    background3.setAttribute("style", "filter: blur(5px);");
    background4.setAttribute("style", "filter: blur(5px);");
    background5.setAttribute("style", "filter: blur(5px);");
  };
}