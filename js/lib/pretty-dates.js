/*
 * JavaScript Pretty Date
 * Copyright (c) 2008 John Resig (jquery.com)
 * Licensed under the MIT license.
 * ------------------------------------------
 * dtran
 * Added support from a week to 20 years, changed to use
 * inner html for jquery selector
 */

// Takes an ISO time and returns a string representing how
// long ago the date represents.
function prettyDate(time){
	var date = new Date((time || "").replace(/-/g,"/").replace(/[TZ]/g," ")),
		diff = (((new Date()).getTime() - date.getTime()) / 1000),
		day_diff = Math.floor(diff / 86400);

	if ( isNaN(day_diff) || day_diff < 0 || day_diff >= 7300 )
		return;

	return day_diff == 0 && (
			diff < 5 && "Just now" ||
			diff < 60 && Math.round(diff) + " seconds ago" ||
			diff < 120 && "1 minute ago" ||
			diff < 3600 && Math.floor( diff / 60 ) + " minutes ago" ||
			diff < 7200 && "1 hour ago" ||
			diff < 86400 && Math.floor( diff / 3600 ) + " hours ago") ||
			day_diff == 1 && "Yesterday" ||
			day_diff < 7 && day_diff + " days ago" ||
			day_diff == 7 && "1 week ago" ||
			day_diff < 31 && Math.round( day_diff / 7 ) + " weeks ago" ||
			day_diff == 31 && "1 month ago" ||
			day_diff < 365 && Math.round(day_diff / 31) + " months ago" ||
			day_diff == 365 && "1 year ago" ||
			day_diff < 7300 && Math.round(day_diff / 365) + " years ago";
}

// If jQuery is included in the page, adds a jQuery plugin to handle it as well
if ( typeof jQuery != "undefined" )
	jQuery.fn.prettyDate = function() {
		return this.each(function(){
			var date = prettyDate($(this).attr("id"));
			if ( date )
				jQuery(this).text( date );
		});
	};