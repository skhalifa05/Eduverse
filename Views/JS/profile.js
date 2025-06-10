const targetDiv = document.querySelector(".change-pass-box");
const btn = document.querySelector(".ca");
const change = document.querySelector(".fa-edit");
const submit = document.querySelector(".submit");
const background = document.querySelector(".profile-details");
const background2 = document.querySelector(".top");
const background3 = document.querySelector(".timetable");
const background4 = document.querySelector(".t1");
const background5 = document.querySelector(".t2");

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
change.onclick = function () {
 
    targetDiv.style.display = "flex";
    background.setAttribute("style", "filter: blur(5px);");
    background2.setAttribute("style", "filter: blur(5px);");
    background3.setAttribute("style", "filter: blur(5px);");
    background4.setAttribute("style", "filter: blur(5px);");
    background5.setAttribute("style", "filter: blur(5px);");
    
  
};