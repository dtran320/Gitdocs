/* -----------------------------------------------------------------------------------------------
 * Versions sidebar switching
 *-----------------------------------------------------------------------------------------------*/
function DisplayOthers() {
	 $("#myversionspanel").hide();
	 $("#otherversionspanel").show();
	 $("#myversions_selected").hide();
         $("#othersversions_selected").show();

}

function DisplayMine() {
 	$("#myversionspanel").show();
        $("#otherversionspanel").hide();
	 $("#myversions_selected").show();
         $("#othersversions_selected").hide();
}

// changes ckeditor to display selected version's text
function change_selection(n, v_id) {
	$(".selected").removeClass("selected");
	$("#td_" + n).addClass("selected");	

// this will go to ?v_id of whatever page we were on (editor or viewer)
//	window.location = window.location.href.substring(0, window.location.href.indexOf("?")) + "?v_id="+v_id;
	window.location = "viewer.php?v_id=" + v_id;
}


/* -----------------------------------------------------------------------------------------------
 * Saving and renaming
 *-----------------------------------------------------------------------------------------------*/

function updateElement() {
	CKEDITOR.instances.editor1.updateElement();
}

function preSaveVersion(formData, jqForm, options) {
	//do any validation?
	return true;
}

function postSaveVersion(data) {
	var status = (data=="0"? "Error saving document." : data);
	$("#save_status").html(status);
}

function changeDName(elem, d_id) {
	var dName = prompt("Enter a new document name:", $(elem).val());
	$(elem).val(dName);
	$.post("actions/saveshare.php", { action: 'renameD', d_id: d_id, d_name : dName });
}

function changeVName(elem, d_id, u_id) {
	var vName = prompt("Enter a new version name (subtitle):", $(elem).val());
	$(elem).val(vName);
	$.post("actions/saveshare.php", { action: 'renameV', d_id: d_id, u_id : u_id, v_name : vName });
}

function changeClass(elem, d_id) {
	var className = $(elem).val();
	$.post("actions/saveshare.php", { action: 'renameClass', d_id: d_id, class_name: className });
}	
	
