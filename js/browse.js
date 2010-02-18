function showNotesForClass(className) {
	// TODO: not the best way, but good enough for small # of classes
	$('#class_list').find('td').each(function(index) {
		if($(this).html() == '<p>'+className+'</p>') {
			$(this).addClass('selected');
		} else {
			$(this).removeClass('selected');
		}
	});
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
	var table = $('#notes_for_class');
	table.html(notesHtml);
	var selected = $('.selected');
	var cy = selected.offset().top + (selected.height()/2);
	var ctop = cy - (table.height()/2);
	var top_val = ctop < 115 ? 115 : ctop;
	table.offset({top: top_val});
}



