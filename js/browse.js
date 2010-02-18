function showNotesForClass(className) {
	$.post("actions/fetchnotes.php", { action: 'showNotes', class_name: className },
		function(data) {
			postShowNotesForClass(data)
		}, "json");
}	

function postShowNotesForClass(notes) {
	var notesHtml = '';
	for(var i = 0; i < notes.length; i++) {
		notesHtml += '<tr><td onclick="window.location=\'viewall.php?d_id=' + notes[i]['doc_id']+'\'"><p>'+ notes[i]['name'] + '</p></td></tr>';
	} 
	$('#notes_for_class').html(notesHtml);
}



