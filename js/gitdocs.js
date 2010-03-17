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
				+ '<td style="width:300px;"><span class="'+ note['type'] +'_title">' + note['dName'] + '</span> -- ' + ((note['vName'] == null)?'':note['vName']) + '</td><td style="width:100px; text-align: right;" class="time small_text " id="' + note['timestamp'] + '">' + note['timestamp'] + '</td></tr>';
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
	for (var doc_id in docs) {
		docHtml += '<tr style="background-color: #EEECEF;" onclick=window.location="viewall.php?d_id='+ doc_id +'"><td>'+ '<span class="bold '+ docs[doc_id][0]['type'] + '_title">' + docs[doc_id][0]["dName"] + '</span> -- '+ docs[doc_id][0]["course"] +'</td><td style="background-color: #EEECEF;"></td></tr>';
		for (var index in docs[doc_id]) {
			var update = docs[doc_id][index];
			docHtml += "<tr onclick=window.location='" + update["link"] + "'>"
							+ "<td style='width:500px;'><img style='padding:5px 5px 5px 10px; float: left; vertical-align:middle;' src='"+ update["iconPtr"] +"'>"
							+ "<div style='float: left; padding-top: 10px;'>" + update['vName']+ "<br/><span class='username'>"+ update["displayName"] + "</span></div></td>"
							+ "<td><p class='time small_text' id='" + update['timestamp'] + "'>" + update['timestamp']+"</p></td></tr>";						
		}
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


