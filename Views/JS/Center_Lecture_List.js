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

/****************************************************Show/hide***********************************************************/
$(".alt.attend").on("click",function(){
	$(".att-name.abs").hide();
	$(".att-name.att").show();
});

$(".alt.absent").on("click",function(){
	$(".att-name.att").hide();
	$(".att-name.abs").show();
});
$(".alt.all").on("click",function(){
	$(".att-name.att").show();
	$(".att-name.abs").show();
});


/********************************************** popup show/hide ******************************************************/



$("#myTable").on("click",".att-btn",function() {
	$(".att-popup").show();
});

$(".cancel").on("click",function(){
	$(".att-popup").hide();
});


function searchLectureNames() {
	let input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("myNames");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTable");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[3];
		if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
}



function searchCourseNames() {
	let input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("myIDs");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTable");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[1];
		if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
}