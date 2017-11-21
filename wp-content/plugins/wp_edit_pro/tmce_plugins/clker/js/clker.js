/**
 *
 *
 * @author Josh Lobe
 * http://ultimatetinymcepro.com
 */


jQuery(document).ready(function($) {
	
	var wpep_langs = top.tinyMCE.activeEditor.getLang('wpep_langs');
	
	// Set focus to 'search' input field
	$('#search').focus();
	
	var page = 1;
	var pages = 0;
	
	var ClkerDialog = {
		
		// Insert selected decoded url and close window
		inserturl : function(url){
			
			top.tinymce.activeEditor.execCommand('mceInsertContent', !1, Base64.decode(url));
			top.tinymce.activeEditor.windowManager.close();
		},
		
		// Begin page number at 1
		gotostart : function() {
			
			page = 1;
			this.search();
		},
		
		// Decrease page number by 1
		gotobefore : function() {
			
			page -= 1;
			if (page < 1) page = 1;
			this.search();
		},
		
		// Increaes page number by 1
		gotonext : function() {
			
			page += 1;
			if (page > pages) page = pages;
			this.search();
		},
		
		// Go to last page
		gotoend : function() {
			
			page = pages;
			this.search();
		},
		
		// Function to take search term; make ajax call for results; and populate table
		search : function() {
				
			search_value = $('#search').val();
			
			// Send ajax request to clker for matched results
			$.ajax({
				
				beforeSend: function() {
					
					$('#results').html('<img class="placeholder" src="img/loader.gif" title="' + wpep_langs.clker_loading_t + '" /><br />' + wpep_langs.clker_loading);
				},
				
				// Call php file to make clker request
				url: 'search.php?ps=12&page='+page+'&words='+search_value,
				success: function (data) {
					
					xml = data;
					lines = xml.split("\n");
					pages = lines[1] - 0;
					
					
					// Clker window populated controls section
					htres = "<div class='clker_controls'>";
					htres += "<h2>"+lines[0] + " " + wpep_langs.clker_entries + " entries found</h2>";
					htres += " <table class='center'><tr>";
					htres += " <td><img class='clker_goto_start' src='img/start.png' /></td>";
					htres += " <td><img class='clker_goto_before' src='img/before.png' /></td>";
					htres += " <td valign='center'><b>Page "+lines[2]+"/"+lines[1]+"</b></td>";
					htres += " <td><img class='clker_goto_next' src='img/next.png' /></td>";
					htres += " <td><img class='clker_goto_end' src='img/end.png' /></td>";
					htres += " </tr></table>";
					htres += "</div>";
					
					// Clker window populated table results
					htres += "<table class='center loaded_results'><tr>";
					for(i = 0; i<lines.length - 3; ++i){
						
						if (lines[i + 3].length < 3) continue;
						row = lines[i + 3].split(",");
						
						htres += "<td valign='bottom'>";
						
						large = "<a href='"+row[0]+"' target='_blank'><img class='clker_image' src='"+row[2]+".hi.png' title='"+row[1]+"'/></a>";
						large = Base64.encode(large);
						med = "<a href='"+row[0]+"' target='_blank'><img class='clker_image' src='"+row[2]+".med.png' title='"+row[1]+"'/></a>";
						med = Base64.encode(med);
						sml = "<a href='"+row[0]+"' target='_blank'><img class='clker_image' src='"+row[2]+".thumb.png' title='"+row[1]+"'/></a>";
						sml = Base64.encode(sml);
						
						htres += "<div class='thumb'>";
						htres += "<img src='"+row[2]+".thumb.png' title='"+row[1]+"'/></a>";
						htres += "</div>";
						
						htres += "<span class='insert_buttons'>";
						htres += "<a class='inserturl_small' href='#'>" + wpep_langs.clker_sml + "<input type='hidden' value='" + sml + "' /></a> ";
						htres += "<a class='inserturl_med' href='#'>" + wpep_langs.clker_med + "<input type='hidden' value='" + med + "' /></a> ";
						htres += "<a class='inserturl_large' href='#'>" + wpep_langs.clker_lrg + "<input type='hidden' value='" + large + "' /></a>";
						htres += "</span>";
						htres += "</td>";
						
						if ( (i + 1)%6 == 0 ){
							
							htres += "</tr><tr>";
						}
					}
			
					htres += "</tr></table>";
					
					// Populate div with results
					$("#results").html(htres);
				},
				// Throw error alert if ajax fails
				error: function () {
					
					alert(wpep_langs.clker_error);
				}
			});
		}
	};
	
	// Click function for search button
	$('#insert').click(function() {
		
		ClkerDialog.gotostart();
	});
	
	// Click function for cancel button
	$('#cancel').click(function() {
		
		top.tinymce.activeEditor.windowManager.close();
	});
	
	// Add binding click function to goto next button
	$('body').on('click', '.clker_goto_next', function() {
		
		ClkerDialog.gotonext();
	});
	// Add binding click function to goto before button
	$('body').on('click', '.clker_goto_before', function() {
		
		ClkerDialog.gotobefore();
	});
	// Add binding click function to goto start button
	$('body').on('click', '.clker_goto_start', function() {
		
		ClkerDialog.gotostart();
	});
	// Add binding click function to goto end button
	$('body').on('click', '.clker_goto_end', function() {
		
		ClkerDialog.gotoend();
	});
	
	// Add binding click function to goto end button
	$('body').on('click', '.inserturl_small', function() {
		
		get_input_value = $(this).children('input').val();  // Get current image from hidden input value
		ClkerDialog.inserturl(get_input_value);
	});
	// Add binding click function to goto end button
	$('body').on('click', '.inserturl_med', function() {
		
		get_input_value = $(this).children('input').val();  // Get current image from hidden input value
		ClkerDialog.inserturl(get_input_value);
	});
	// Add binding click function to goto end button
	$('body').on('click', '.inserturl_large', function() {
		
		get_input_value = $(this).children('input').val();  // Get current image from hidden input value
		ClkerDialog.inserturl(get_input_value);
	});
	
	// Determine if enter key was pressed on search field
	$("#search").keyup(function(event){
		if(event.keyCode == 13){
			
			ClkerDialog.gotostart();  // Run 'Search' button function
		}
	});
	
	
	
	/**
	*
	*  Base64 encode / decode
	*  http://www.webtoolkit.info/
	*
	**/
	
	var Base64 = {
	
		// Private property
		_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
	
		// Public method for encoding
		encode : function (input) {
			var output = "";
			var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
			var i = 0;
	
			input = Base64._utf8_encode(input);
	
			while (i < input.length) {
	
				chr1 = input.charCodeAt(i++);
				chr2 = input.charCodeAt(i++);
				chr3 = input.charCodeAt(i++);
	
				enc1 = chr1 >> 2;
				enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
				enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
				enc4 = chr3 & 63;
	
				if (isNaN(chr2)) {
					enc3 = enc4 = 64;
				} else if (isNaN(chr3)) {
					enc4 = 64;
				}
	
				output = output +
				this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
				this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
	
			}
	
			return output;
		},
	
		// Public method for decoding
		decode : function (input) {
			var output = "";
			var chr1, chr2, chr3;
			var enc1, enc2, enc3, enc4;
			var i = 0;
	
			input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
	
			while (i < input.length) {
	
				enc1 = this._keyStr.indexOf(input.charAt(i++));
				enc2 = this._keyStr.indexOf(input.charAt(i++));
				enc3 = this._keyStr.indexOf(input.charAt(i++));
				enc4 = this._keyStr.indexOf(input.charAt(i++));
	
				chr1 = (enc1 << 2) | (enc2 >> 4);
				chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
				chr3 = ((enc3 & 3) << 6) | enc4;
	
				output = output + String.fromCharCode(chr1);
	
				if (enc3 != 64) {
					output = output + String.fromCharCode(chr2);
				}
				if (enc4 != 64) {
					output = output + String.fromCharCode(chr3);
				}
	
			}
	
			output = Base64._utf8_decode(output);
	
			return output;
	
		},
	
		// Private method for UTF-8 encoding
		_utf8_encode : function (string) {
			string = string.replace(/\r\n/g,"\n");
			var utftext = "";
	
			for (var n = 0; n < string.length; n++) {
	
				var c = string.charCodeAt(n);
	
				if (c < 128) {
					utftext += String.fromCharCode(c);
				}
				else if((c > 127) && (c < 2048)) {
					utftext += String.fromCharCode((c >> 6) | 192);
					utftext += String.fromCharCode((c & 63) | 128);
				}
				else {
					utftext += String.fromCharCode((c >> 12) | 224);
					utftext += String.fromCharCode(((c >> 6) & 63) | 128);
					utftext += String.fromCharCode((c & 63) | 128);
				}
	
			}
	
			return utftext;
		},
	
		// Private method for UTF-8 decoding
		_utf8_decode : function (utftext) {
			var string = "";
			var i = 0;
			var c = c1 = c2 = 0;
	
			while ( i < utftext.length ) {
	
				c = utftext.charCodeAt(i);
	
				if (c < 128) {
					string += String.fromCharCode(c);
					i++;
				}
				else if((c > 191) && (c < 224)) {
					c2 = utftext.charCodeAt(i+1);
					string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
					i += 2;
				}
				else {
					c2 = utftext.charCodeAt(i+1);
					c3 = utftext.charCodeAt(i+2);
					string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
					i += 3;
				}
	
			}
	
			return string;
		}
	
	}
	
});
