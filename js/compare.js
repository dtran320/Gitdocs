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
		var type = (orig_txt.indexOf("<del>") != -1) ? "del" : "ins";
		if (type == "del") {
			var mod = $(".inline_change" + index + " ~ .mod");
			if (mod != null) {
				type = "change";
				var ins_txt = mod.html();
				orig_txt += "!@!@" + ins_txt;
			}
		}
	}

	elem.html("<span class='like' onclick='like" + view_type + "(" + index +  ");'>like | </span> <span class='dislike' onclick='dislike" + view_type + "(" + index + ");'>dislike</span><span class='orig' style='display: none;'>" + orig_txt + "</span><span class='undo displaynone' onclick='undo" +view_type +  "(" + index + ");'>undo</span>");

	var form_txt = $('#merge_form').html();
	$('#merge_form').html(form_txt + ' <input type="hidden" id="hidden' + index + '" name="hidden' + index + '" value="boo">'
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
	elem.find('.like').addClass('displaynone');
	elem.find('.dislike').addClass('displaynone');
	elem.find('.undo').removeClass('displaynone');

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
	var elem = $('.inline_ld').slice(num, num+1);
	elem.find('.like').addClass('displaynone');
	elem.find('.dislike').addClass('displaynone');
	elem.find('.undo').removeClass('displaynone');

	$('#hidden' + num).attr('value', 'dislike');
}

function undo_inline(num) {
	var selector = ".inline_change" + num;
	var elem = $('.inline_ld').slice(num, num+1);
	var txt = elem.find('.orig').html();	
	$(selector).html(txt);
	elem.find('.like').removeClass('displaynone');
	elem.find('.dislike').removeClass('displaynone');
	elem.find('.undo').addClass('displaynone');
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

function like_2col(num) {
	var selector = ".inline_change" + num;
	var css_float = $(selector).css("float");
	
	if (css_float == "right") {
		// insert
		$(selector).css("float", "left");
		$(selector).css("clear", "both");
	} else {
		// delete or change
		var mod = $(selector).next(); // buggish
		if (mod.hasClass("mod")) {
			mod.css("float", "left");
			mod.css("clear", "both");
		}
		$(selector).css("display", "none");
	}

	var elem = $('.inline_ld').slice(num, num+1);
	elem.find('.like').addClass('displaynone');
	elem.find('.dislike').addClass('displaynone');
	elem.find('.undo').removeClass('displaynone');

	placeLinks();
	$('#hidden' + num).attr('value', 'like');
}

//. for now..
function dislike_2col(num) {
	var selector = ".inline_change" + num;
	var css_float = $(selector).css("float");
	
	if (css_float == "right") {
		$(selector).css("height", "10px");
		$(selector).css("overflow", "hidden");
	} else {
		// delete or change
		var mod = $(selector).next(); // buggish
		if (mod.hasClass("mod")) {
			mod.css("height", "10px");
			mod.css("overflow", "hidden");
		}
		var txt = $(selector).html();
		txt = txt == null ? "" : txt.replace("<del>", "");
		txt = txt.replace("</del>", "");
		$(selector).html(txt);
	}

	var elem = $('.inline_ld').slice(num, num+1);
	elem.find('.like').addClass('displaynone');
	elem.find('.dislike').addClass('displaynone');
	elem.find('.undo').removeClass('displaynone');

	placeLinks();
	$('#hidden' + num).attr('value', 'dislike');
}

function undo_2col(num){
	var elem = $('.inline_ld').slice(num, num+1);
	elem.find('.like').removeClass('displaynone');
	elem.find('.dislike').removeClass('displaynone');
	elem.find('.undo').addClass('displaynone');

	var orig_txt = elem.find('.orig').html();
	var selector = '.inline_change' + num;
	var index = orig_txt == null ? -1 : orig_txt.indexOf("!@!@");
	if (index != -1) {
		$(selector).css("display", "block");
		$(selector).html(orig_txt.substring(0, index));
		var mod = $(selector).next();
		if (mod.hasClass("mod")) {
			mod.css("float", "right");
			mod.css("height", "");		
			mod.css("clear", "none");
		}
	} else if ((orig_txt == null ? "" : orig_txt).indexOf("<ins>") != -1) {
		$(selector).css("float", "right");
		$(selector).css("height", "");
		$(selector).css("clear", "both");
									
	}
	placeLinks();
	$('#hidden' + num).attr('value', 'undo');

}

function likeAll_2col() {
	var arr = new Array();
	var i = 0;
	$('.like').each(function(index) {
			if($(this).css('display') != 'none') {
				arr[i] = index;
				i++;
		}
	}); 
	for (var j = 0; j < i; j++) {
		like_2col(arr[j]);
	}
}

function dislikeAll_2col() {
	var arr = new Array();
	var i = 0;
	$('.dislike').each(function(index) {
			if($(this).css('display') != 'none') {
				arr[i] = index;
				i++;
		}
	}); 
	for (var j = 0; j < i; j++) {
		dislike_2col(arr[j]);
	}
}

function undoAll_2col() {
	var arr = new Array();
	var i = 0;
	$('.undo').each(function(index) {
			if($(this).css('display') != 'none') {
				arr[i] = index;
				i++;
		}
	}); 
	for (var j = 0; j < i; j++) {
		undo_2col(arr[j]);
	}
}


