
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

function preSaveVersion(evt) {
	$("#doc_text").val(CKEDITOR.instances.editor1.getData());
}

function postSaveVersion(data) {
	$("#save_status").html("Document saved.");
}