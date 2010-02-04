
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

function saveVersion(evt) {
	evt.preventDefault();
	$("#doc_text").val(CKEDITOR.instances.editor1.getData());
	$("#save_form").ajaxSubmit({
		url: "actions/version.php",
		success: save
	});
}

function save(data) {
	$("#save_status").html("Document saved.");
}