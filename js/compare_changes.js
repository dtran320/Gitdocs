//we don't want to use this global -- probably move to a class

var pendingChanges = 4;
$(document).ready(function() {
	$("#compare_help_dropdown").show();
});

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