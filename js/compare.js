//we don't want to use this global -- probably move to a class

function like(num) {
	var origRightSelector = "#origRight"+num;
	var rightSelector = '#line' + num + ' td.rightText .visibleText';
	var leftSelector = "#line" + num + ' td.leftText .visibleText';

	var rightText = $(origRightSelector).html();

	rightText = rightText.replace("<ins>", "");
	rightText = rightText.replace("</ins>", "");
	$(rightSelector).html(rightText);
	$(leftSelector).html(rightText);

	$('#line'+num + ' td.leftText').addClass('faded');
	$('#line'+num + ' td.rightText').addClass('faded');

	$("#line"+num + " td.likedislike").html('<span class="undo" onclick="undo('+ num +');">undo</span>');
}

function undo(num) {
	var origRightSelector = "#origRight"+num;
	var origLeftSelector = "#origLeft" + num;

	var rightSelector = "#line"+num + " td.rightText .visibleText";
	var leftSelector = "#line"+num + " td.leftText .visibleText";

	$(leftSelector).html($(origLeftSelector).html());
	$(rightSelector).html($(origRightSelector).html());

	$('#line'+num + ' td.leftText').removeClass('faded');
	$('#line'+num + ' td.rightText').removeClass('faded');

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

	$('#line'+num + ' td.leftText').addClass('faded');
	$('#line'+num + ' td.rightText').addClass('faded');

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

	$('table.diff th span.likedislike').html('<span class="undo" onclick="undoAll();">undo</span>');
	
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

	$('table.diff th span.likedislike').html('<span class="undo" onclick="undoAll();">undo</span>');
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
