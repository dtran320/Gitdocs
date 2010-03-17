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

// array of lecture notes
// array of reading responses
function postShowNotesForClass(info) {
	var notes = info['notes'];

	if (notes.length == 0) {
		var first = '<tr><td>You\'re the first to take notes in this class!</td></tr>'
		$('#notes_for_class').html(first);
		return;
	}
	var notesHtml = '<tr><td>Lecture Notes</td><td>Reading Responses</td><td>Study Guides</td><td>Date</td></tr>';

	for(var i = 0; i < notes.length; i++) {
		notesHtml += '<tr>' 
							+ '<td style="width:200px;">'
									+'<a class="lecture_title" href="viewall.php?d_id='+notes[i]['lecture_id'] +'">' 
									+ notes[i]['lecture']+'</a></td>'
							+ '<td style="width:200px;">'
									+'<a class="reading_title" href="viewall.php?d_id='+notes[i]['reading_id'] +' ">' 
									+ notes[i]['reading'] + '</a></td>'
							+ '<td style="width:200px;">'
									+'<a class="final_title" href="viewall.php?d_id='+notes[i]['final_id'] +' ">' 
									+ notes[i]['final'] + '</a></td>'
							+'<td style="width:100px;">' + notes[i]['lecture_date'] + '</td>'
							+ '</tr>';
	} 
	var table = $('#notes_for_class');
	table.html(notesHtml);
	$('.time').prettyDate();
	var selected = $('.selected');
	var top_val = selected.offset().top;
	table.offset({top: top_val});

/*
 // 	do we want avatars or not?

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
*/
}




