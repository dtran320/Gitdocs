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

	for (var course_name in docs) {
		docHtml += '<table class="document_list">'
						+ '<tr><td><strong>' + course_name + '</strong></td></tr>';
		for (index in docs[course_name]) {
			var note = docs[course_name][index];
			docHtml += '<tr onclick="window.location=\'' + note['link'] + '\'">'
				+ '<td style="width:300px;" class="ellipsis">' + note['dName'] + ' ' + note['vName'] + '</td><td style="width:100px; text-align: right;" class="time small_text " id="' + note['timestamp'] + '">' + note['timestamp'] + '</td></tr>';
		}
		docHtml += '</table>';
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
		docHtml += "<tr onclick=window.location='" + docs[i]["link"] + "'>"
						+ "<td><img style='padding:5px;' src='"+ docs[i]["iconPtr"] +"'></td>"
						+ "<td><p><span class='username'>"+ docs[i]["displayName"] + "</span> updated "
						+ "<span class='" + docs[i]['type'] +"_title'>"+docs[i]['dName'] + "</span>" 
						+ docs[i]['vName']+ "</td>"
						+ "<td><p class='time small_text' id='" + docs[i]['timestamp'] + "'>" + docs[i]['timestamp']+"</p></td></tr>";
	}
	$('#my_version_feed').html(docHtml);
	$('.time').prettyDate();
	
}

function setFilter(klass) {
	$('#filter .option').removeClass("selected");
	$('#filter #' + klass).addClass("selected");
	$('#my_version_feed').html('Retrieving <img src="images/ajax-loader.gif">');
	$.post("actions/getfeed.php", { "filter" : $('#filter .selected').text() },
	   function(data){
		fetchRecentVersions(data); }, "json");
}


