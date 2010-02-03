//we don't want to use this global -- probably move to a class

// THIS IS SO UGLY I AM SORRY I WILL FIX THIS :P
function addLikeDislikeLinks() {
 $('.likedislike').offset({left: 600});
 $('.inline_change').each(function(index) {
	$(this).addClass('inline_change'+index);
	$(this).removeClass('inline_change');
	var left_val = 600;
	var top_val = $(this).offset().top;
	var orig_txt = $(this).html();
	var elem = $('.inline_ld').slice(index, index+1);
	elem.offset({left: left_val, top: top_val});
	elem.html("<span style='display:inline-block;' class='like' onclick='like_inline(" + index +  ");'>like | </span> <span style='display:inline-block;' class='dislike' onclick='dislike_inline(" + index + ");'>dislike</span><span class='orig' style='display: none;'>" + orig_txt + "</span><span class='undo' onclick='undo_inline(" + index + ");' style='display:none;'>undo</span>");
	var form_txt = $('#compare_form').html();

	var type = (orig_txt.indexOf("<del>") != -1) ? "del" : "ins";
	if (type == "del") {
		type = (orig_txt.indexOf("<ins>") != -1) ? "change" : "ins";
	}
	
	$('#compare_form').html(form_txt + ' <input type="hidden" id="hidden' + index + '" name="hidden' + index + '" value="boo">'
	 + ' <input type="hidden" id="type' + index + '" name="type' + index + '" value="'+ type + '">');
	});
}

function like_inline(num) {
	var selector = ".inline_change" + num;
	var txt =	$(selector).html();
	if (txt != null) {
		txt = txt.replace("<ins>", "<span class='grayed'>");
		txt = txt.replace("</ins>", "</span>");
	}
	$(selector).html(txt);
	$(selector + ' del').addClass('faded');
	var elem = $('.inline_ld').slice(num, num+1);
	elem.find('.like').css('display', 'none');
	elem.find('.dislike').css('display', 'none');
	elem.find('.undo').css('display', 'inline-block'); 

	$('#hidden' + num).attr('value', 'like');
	// i had no idea inline-block existed!
	// do i like changing the display or replacing the entire thingie... HUM
	// should prob do it the way i do for 2 column where the orig text is in the other div.
	// does removing instead of changing display since make finding remaining 'likes' easier? or maybe it doesn't matter..
}

function dislike_inline(num) {
	var selector = ".inline_change" + num;
	var txt =	$(selector).html();
	if (txt != null) {
		txt = txt.replace("<del>", "<span class='grayed'>");
		txt = txt.replace("</del>", "</span>");
	}
	$(selector).html(txt);
	$(selector + ' ins').addClass('faded');
	var elem = $('.inline_ld').slice(num, num+1);
	elem.find('.like').css('display', 'none');
	elem.find('.dislike').css('display', 'none');
	elem.find('.undo').css('display', 'inline-block');

	$('#hidden' + num).attr('value', 'dislike');
}

function undo_inline(num) {
	var selector = ".inline_change" + num;
	var elem = $('.inline_ld').slice(num, num+1);
	var txt = elem.find('.orig').html();	
	$(selector).html(txt);
	elem.find('.like').css('display', 'inline-block');
	elem.find('.dislike').css('display', 'inline-block');
	elem.find('.undo').css('display', 'none');
	$('#hidden' + num).attr('value', 'undo');
}

function likeAll_inline() {
	var arr = new Array();
	var i = 0;
	$('.like').each(function(index) {
			if($(this).css('display') != 'none') {
				arr[i] = index;
				i++;
		}
	}); 
	for (var j = 0; j < i; j++) {
		like_inline(arr[j]);
	}
}

function dislikeAll_inline() {
	var arr = new Array();
	var i = 0;
	$('.dislike').each(function(index) {
			if($(this).css('display') != 'none') {
				arr[i] = index;
				i++;
		}
	}); 
	for (var j = 0; j < i; j++) {
		dislike_inline(arr[j]);
	}
}

function undoAll_inline() {
	var arr = new Array();
	var i = 0;
	$('.undo').each(function(index) {
			if($(this).css('display') != 'none') {
				arr[i] = index;
				i++;
		}
	}); 
	for (var j = 0; j < i; j++) {
		undo_inline(arr[j]);
	}
}

function like(num) {
	var origRightSelector = "#origRight"+num;
	var rightSelector = '#line' + num + ' td.rightText .visibleText';
	var leftSelector = "#line" + num + ' td.leftText .visibleText';

	var rightText = $(origRightSelector).html();

	rightText = rightText.replace("<ins>", "");
	rightText = rightText.replace("</ins>", "");
	$(rightSelector).html(rightText);
	$(leftSelector).html(rightText);

	$('#line'+num + ' td.leftText').addClass('grayed');
	$('#line'+num + ' td.rightText').addClass('grayed');

	$("#line"+num + " td.likedislike").html('<span class="undo" onclick="undo('+ num +');">undo</span>');
}

function undo(num) {
	var origRightSelector = "#origRight"+num;
	var origLeftSelector = "#origLeft" + num;

	var rightSelector = "#line"+num + " td.rightText .visibleText";
	var leftSelector = "#line"+num + " td.leftText .visibleText";

	$(leftSelector).html($(origLeftSelector).html());
	$(rightSelector).html($(origRightSelector).html());

	$('#line'+num + ' td.leftText').removeClass('grayed');
	$('#line'+num + ' td.rightText').removeClass('grayed');

	$("#line"+num + " td.likedislike").html('<span class="like" onclick="like('+ num + ');">like</span> | <span class="dislike" onclick="dislike('+ num +');">dislike</span>');
}

function dislike(num) {
	var leftSelector = "#line" + num + ' td.leftText .visibleText';
	var rightSelector = "#line" + num + ' td.rightText .visibleText';
	
	var leftText = $(leftSelector).html();
	leftText = leftText.replace("<del>", "");
	leftText = leftText.replace("</del>", "");
	$(leftSelector).html(leftText);

	var rightText = $(rightSelector).html();
	rightText = rightText.replace("<ins>", "");
	rightText = rightText.replace("</ins>", "");
	$(rightSelector).html(rightText);

	$('#line'+num + ' td.leftText').addClass('grayed');
	$('#line'+num + ' td.rightText').addClass('grayed');

	$("#line"+num + " td.likedislike").html('<span class="undo" onclick="undo('+ num +');">undo</span>');
}

function likeAll() {
  $('table.diff tr.likeable').each(function(index) {
			var html = $(this).find('.likedislike').html();
			var canLike = html.indexOf("like(");
			if (canLike != -1) {
				var end = html.indexOf(";", canLike);
				var cmd = html.substring(canLike, end);
				eval(cmd);
			}
  });
}

function dislikeAll() {
  $('table.diff tr.likeable').each(function(index) {
			var html = $(this).find('.likedislike').html();
			var canLike = html.indexOf("dislike(");
			if (canLike != -1) {
				var end = html.indexOf(";", canLike);
				var cmd = html.substring(canLike, end);
				eval(cmd);
			}
  });
}

function undoAll() {
  $('table.diff tr.likeable').each(function(index) {
			var html = $(this).find('.likedislike').html();
			var canLike = html.indexOf("undo(");
			if (canLike != -1) {
				var end = html.indexOf(";", canLike);
				var cmd = html.substring(canLike, end);
				eval(cmd);
			}
  });
}

var pendingChanges = 4;


function closeDropdown() {
	$("#compare_help_dropdown").hide();
}

function acceptChange(num) {
	markBubbleDone(num);
	var textName = "#text_change" + num;
	$(textName).removeClass("your_changes");
	$(textName).removeClass("their_changes");
}

function rejectChange(num) {
	markBubbleDone(num);
	var textName = "#text_change" + num;
	$(textName).hide();
}

function acceptAllChanges() {
	for (var i=1; i<=4; i++) {
		var bubbleName = "#change_bubble" + i;
		if(!$(bubbleName).hasClass("bubble_resolved")) {
			acceptChange(i);
		}
	}
}

function rejectAllChanges() {
	for (var i=1; i<=4; i++) {
		var bubbleName = "#change_bubble" + i;
		if(!$(bubbleName).hasClass("bubble_resolved")) {
			rejectChange(i);
		}
	}
}

function markBubbleDone(num) {
	var mergeName = "#bubble_merge" + num;
	$(mergeName).hide();
	var bubbleName = "#change_bubble" + num;
	$(bubbleName).addClass("bubble_resolved");
	pendingChanges--;
	updateRemaining();
}

function updateRemaining() {
	$("#accept_all").html("Accept all remaining(" + pendingChanges + ")");
	$("#reject_all").html("Reject all remaining(" + pendingChanges + ")");
}
