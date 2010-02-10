//we don't want to use this global -- probably move to a class

/* 
 * for compare_inline.php's inline diff view
 */

// make addlikedislikelinks() use this laters
function placeLinks() {
	var left_val = 650;
	$('.inline_ld').each(function(index) {
		var selector = ".inline_change" + index;
		var top_val = $(selector).offset().top;

		if ($(selector).css("display") == "none") {
			top_val = $(selector).next().next().offset().top;
		}

		$(this).offset({left: left_val, top: top_val});
	});
}

function addLikeDislikeLinks(view_type) {
 var left_val = 650;
 var top_val = $("#column_top").offset().top;
 $('.likedislike').offset({left: left_val, top: top_val});
 $('.inline_change').each(function(index) {
	$(this).addClass('inline_change'+index);
	$(this).removeClass('inline_change');
	top_val = $(this).offset().top;	var elem = $('.inline_ld').slice(index, index+1);
	elem.offset({left: left_val, top: top_val});
	var orig_txt = $(this).html();

	if(view_type == '_inline') {
  	var type = (orig_txt.indexOf("<del>") != -1) ? "del" : "ins";
		if (type == "del") {
		type = (orig_txt.indexOf("<ins>") != -1) ? "change" : "del";
		}
	} else {
		var type = ($(this).hasClass("del")) ? "del" : "ins";
		if (type == "del") {
			var mod = $(".inline_change" + index + " ~ .mod");
			if (mod != null) {
				type = "change";
				var ins_txt = mod.html();
				orig_txt += "!@!@" + ins_txt;
			}
		}
	}

	elem.html("<span class='like' onclick=\"makeMergeChoice" + view_type + "(" + index +  ", 'like');\">like | </span>" 
					+ "<span class='dislike' onclick=\"makeMergeChoice" + view_type + "(" + index + ", 'dislike');\">dislike</span>" 
					+ "<span class='orig' style='display: none;'>" + orig_txt + "</span>" 
					+ "<span class='undo displaynone' onclick=\"makeMergeChoice" +view_type +  "(" + index + ", 'undo');\">undo</span>");

	var form_txt = $('#merge_form').html();
	$('#merge_form').html(form_txt + ' <input type="hidden" id="hidden' + index + '" name="hidden' + index + '" value="boo">'
	 + ' <input type="hidden" id="type' + index + '" name="type' + index + '" value="'+ type + '">');
	});
}

function makeMergeChoice_inline(num, choice) {
	if (choice == "like") {
		like_inline(num);
	} else if (choice == "dislike") {
		dislike_inline(num);
	} else {
		undo_inline(num);
	}
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

	toggleLinks(num);
	$('#hidden' + num).attr('value', 'like');
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


	toggleLinks(num);
	$('#hidden' + num).attr('value', 'dislike');
}

function undo_inline(num) {
	var selector = ".inline_change" + num;
	var elem = $('.inline_ld').slice(num, num+1);
	var txt = elem.find('.orig').html();	
	$(selector).html(txt);

	toggleLinks(num);
	$('#hidden' + num).attr('value', 'undo');
}

function likeAll_inline() {
	var arr = new Array();
	var i = 0;
	$('.like').each(function(index) {
			if(!$(this).hasClass('displaynone')) {
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
			if(!$(this).hasClass('displaynone')) {
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
			if(!$(this).hasClass('displaynone')) {
				arr[i] = index;
				i++;
		}
	}); 
	for (var j = 0; j < i; j++) {
		undo_inline(arr[j]);
	}
}

function toggleLinks(num) {
	var elem = $(".inline_ld").slice(num, num+1);
	if (elem.find(".like").hasClass("displaynone")) {
		elem.find(".like").removeClass("displaynone");
		elem.find(".dislike").removeClass("displaynone");
		elem.find(".undo").addClass("displaynone");
	} else {
		elem.find(".like").addClass("displaynone");
		elem.find(".dislike").addClass("displaynone");
		elem.find(".undo").removeClass("displaynone");		
	}
}

function makeMergeChoice_2col(num, choice) {
	var diff = $(".inline_change" + num);
	var mod = diff.next();
	if (choice == "undo") {
		diff.removeClass("ins_like");
		diff.removeClass("ins_dislike");
		diff.removeClass("del_like");
		diff.removeClass("del_dislike");
		if (mod != null && mod.hasClass("mod")) {
			mod.removeClass("mod_like");
			mod.removeClass("mod_dislike");
		}
	} else {
		if (diff.hasClass("ins")) {
			diff.addClass("ins_" + choice);
		} else {
			diff.addClass("del_" + choice);
			if (mod != null && mod.hasClass("mod")) {
				mod.addClass("mod_" + choice);
			}
		}
	}

	toggleLinks(num);
	placeLinks();
	$('#hidden' + num).attr('value', choice);
}

function makeAllMergeChoices_2col(choice) {
	var arr = new Array();
	var i = 0;
	$('.' + choice).each(function(index) {
			if($(this).css('display') != 'none') {
				arr[i] = index;
				i++;
		}
	}); 
	for (var j = 0; j < i; j++) {
			makeMergeChoice_2col(arr[j], choice);
	}
}

