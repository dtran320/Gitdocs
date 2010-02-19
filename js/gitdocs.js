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
		docHtml += "<tr onclick=window.location='"+ docs[i]["link"] + "'><td><strong>" + docs[i]['course'] + "</strong>" +docs[i]['dName'] + docs[i]['vName']+ "</td><td class='time small_text' id='" + docs[i]['timestamp'] + "'>" + docs[i]['timestamp']+"</a></td></tr>";
	}
	$('#my_recent_docs').html(docHtml);
	$('.time').prettyDate();
	$('#show_my_recent_docs').hide();
}

function showAllMyDocuments() {
	$.post("actions/fetchdocs.php", { "action": "showMine" },
	   function(data){
		postShowAllMyDocuments(data)
	   }, "json");
}

function fetchRecentVersions(docs) {
	var docHtml = '';
	
	for(var i=0; i<docs.length; i++) {
		docHtml += "<tr onclick=window.location='" + docs[i]["link"] + "'><td><img src="+ docs[i]["iconPtr"] +"></td><td>"+ docs[i]["displayName"] + " saved a version of </td><td>"+docs[i]['dName'] + docs[i]['vName']+ "</td><td><p class='time small_text' id='" + docs[i]['timestamp'] + "'>" + docs[i]['timestamp']+"</p></td></tr>";
	}
	$('#my_version_feed').html(docHtml);
	$('.time').prettyDate();
	
}

function setFilter(class) {
	$('#filter .option').removeClass("selected");
	$('#filter #' + class).addClass("selected");
	$('#my_version_feed').html('Retrieving <img src="images/ajax-loader.gif">');
	$.post("actions/getfeed.php", { "filter" : $('#filter .selected').text() },
	   function(data){
		fetchRecentVersions(data); }, "json");
}


