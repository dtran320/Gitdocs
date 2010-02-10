//elem is the blank elem which we want to put a loader into
function showLoader(elem) {
	$("#"+elem).show();
}

function hideLoader(elem) {
	$("#"+elem).hide();
}

function postShowAllMyDocuments(docs) {
	var currHtml = $('#show_my_recent_docs').html();
	$('#show_my_recent_docs').html(currHtml + '<img src="images/ajax-loader.gif">');
	
	for
	$('#show_my_recent_docs').hide();
}

function showAllMyDocuments() {
	$.post("actions/fetchdocs.php", { "action": "showMine" },
	   function(data){
		postShowAllMyDocuments(data)
	   }, "json");
}

