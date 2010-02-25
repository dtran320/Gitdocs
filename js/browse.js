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

function postShowNotesForClass(info) {
	var notesHtml = '';
	var notes = info['notes'];
	for(var i = 0; i < notes.length; i++) {
		notesHtml += '<tr onclick="window.location=\'viewall.php?d_id=' + notes[i]['doc_id']+'\'"><td style="width: 385px;"><strong>'+ notes[i]['name'] + '</strong></td>' + '<td style="width: 100px;">' + notes[i]['count'] + '</td><td style="width: 115px;" class="time" id="'+ notes[i]['max_time'] +'">' + notes[i]['max_time'] + '</td></tr>';
	} 
	var table = $('#notes_for_class');
	table.html(notesHtml);
	$('.time').prettyDate();
	var selected = $('.selected');
	var top_val = selected.offset().top;
	table.offset({top: top_val});

	var avatars = info['avatars'];
	var img_start = '<div style="padding:3px; float: left;"><img src="';
	var img_end = '"></div>';
	var avatarsHtml = '';
	for(var i = 0; i < avatars.length; i++) {
		avatarsHtml += img_start + avatars[i] + img_end;
	} 
  var avatars = $('#avatars');
	avatars.html(avatarsHtml);
	avatars.offset({top: top_val});
}




