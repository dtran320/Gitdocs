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

function change_selection(n) {
	$(".selected").removeClass("selected");
	$("#td_" + n).addClass("selected");
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
	var status = data=="1"? "Document saved." : "Error saving document.";
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