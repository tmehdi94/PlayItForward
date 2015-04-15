$(document).ready(function(){    
    $("[data-toggle=tooltip]").tooltip();

});

function setMissionId(missionId){
	textInput = document.getElementById("missionId");
	textInput.value = missionId;
}