//elem is the blank elem which we want to put a loader into
function showLoader(elem) {
	$("#"+elem).show();
}

function hideLoader(elem) {
	$("#"+elem).hide();
}

function postShowAllMyDocuments(docs) {
	$('#show_my_recent_docs').html('Retrieving <img src="images/ajax-loader.gif">');
	var docHtml = '';

	for(var i=0; i<docs.length; i++) {
		docHtml += "<tr><td><a href='" + docs[i]["link"]+"'><p class='no_line_height'>"+docs[i]['dName'] +" - " + (docs[i]['vName']? docs[i]['vName'] : "")+ "</p><p class='small_text no_line_height'>"+docs[i]['timestamp']+"</p></a></td></tr>";
	}
	$('#my_recent_docs').html(docHtml);

	$('#show_my_recent_docs').hide();
}

function showAllMyDocuments() {
	$.post("actions/fetchdocs.php", { "action": "showMine" },
	   function(data){
		postShowAllMyDocuments(data)
	   }, "json");
}

