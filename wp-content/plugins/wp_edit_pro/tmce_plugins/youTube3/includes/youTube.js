jQuery(document).ready(function($) {

	// Determine if enter key was pressed on search field
	$("#query").keyup(function(event){
		if(event.keyCode == 13){
			$("#search-button").click();  // Run 'Search' button function
			$('#query').blur();  // Blur input field (dismiss autocomplete)
		}
	});
	
	// Height slider control
	$( "#width_slider" ).slider({
		max: 1000,
		min: 100,
		value: 380,
		step: 1
	});
	$( "#height_slider" ).slider({
		max: 1000,
		min: 100,
		value: 250,
		step: 1
	});
	
	// Get editor selection; Populate settings if previous youtube video is loaded
	selection = top.tinymce.activeEditor.selection.getContent({format : 'html'});
	if (selection.indexOf('<iframe') >= 0 && selection.indexOf('class="ytplayer') >= 0) {
		
		width = $(selection).attr('width');
		height = $(selection).attr('height');
		
		// Populate width and height values
		$('#video_width').val(width);
		$('#video_height').val(height);
		// Populate slider width and height values
		$("#width_slider").slider( "option", "value", width );
		$("#height_slider").slider( "option", "value", height );
		
		src = $(selection).attr('src');  // Get source url
		arr = src.split('?');  // Split string at '?'; url = arr[0]; params = arr[1]
		
		// Get video id
		video_id = arr[0].replace("http://www.youtube.com/embed/", "");
		
		// Load video into preview area
		$('#preview-container').html('<iframe class="ytplayer" type="text/html" width="100%" height="100%" src="http://www.youtube.com/embed/'+video_id+'" frameborder="0"/>');
		// Append video ID to use for inserting back into content editor
		$('#preview-container').append('<p id="editor_video_id">'+video_id+'</p>');
		
		// Split parameters
		params = arr[1].split('&');
		// Loop each parameter
		if(params) {
			$.each(params, function(i,v) {
				
				// Split parameter at '='
				values = v.split('=');
				
				// If 'start' param is set
				if(values[0] === 'start') {
					// Populate 'start' input box
					$('.numbersOnly').val(values[1]);
				}
				else {
					// Populate radio boxes
					$radios = $('input:radio[name='+values[0]+']');
					$radios.filter('[value='+values[1]+']').prop('checked', true);
				}
			});
		}
	}
	
	// Set tabs
	$("#tabs").tabs();
	
	// YouTube search autocomplete
	$("#query").autocomplete({
		
		source: function(request, response){
			
			var apiKey = 'AI39si7ZLU83bKtKd4MrdzqcjTVI3DK9FvwJR6a4kB_SW_Dbuskit-mEYqskkSsFLxN5DiG1OBzdHzYfW0zXWjxirQKyxJfdkg';
			var query = request.term;
			
			// Send ajax request to google for youtube client autocomplete library
			$.ajax({
				
				url: "//suggestqueries.google.com/complete/search?hl=en&ds=yt&client=youtube&hjson=t&cp=1&q="+query+"&key="+apiKey+"&format=5&alt=json&callback=?",  
				dataType: 'jsonp',
				success: function(data, textStatus, request) { 
				
					response( $.map( data[1], function(item) {
						
						return {
							label: item[0],
							value: item[0]
						}
					}));
				}
			});
		},
		// Run search function when user clicks an autocomplete selection
		select: function( event, ui ) {
			
			$("#search-button").click();
		}
	});
	
	// Click function for video preview
	$(document).on('click', '.thumbnail', function() {
		
		// Clear preview container
		$('#preview-container').html('');
		
		// Get video ID
		videoId = $(this).next('.videoId').html();
		
		// Generate live preview
		$('#preview-container').append('<iframe class="ytplayer" type="text/html" width="100%" height="100%" src="http://www.youtube.com/embed/'+videoId+'" frameborder="0"/>');
		// Append video ID to use for inserting back into content editor
		$('#preview-container').append('<p id="editor_video_id">'+videoId+'</p>');
		
		// Scroll to preview area
		$('html, body').animate({
			scrollTop: $("#preview-container").offset().top
		}, 1000);
	});
	
	// Click function to load next page
	$('#next_page').click(function() {
		
		// Get next page token
		nextToken = $('#nextToken').html();
		if(nextToken === undefined) {
			
			$('<div title="Oops..."><p>There are no results to display. Please enter a new search term above.</p></div>')
		   .dialog({
			   autoOpen: true,
			   modal: true,
			   close: function(event,ui) {
				  $(this).dialog('close');
				  // Scroll to top for mobile devices
				  $("html, body").animate({ scrollTop: 0 }, "fast");
			   },
			   buttons: {
				  OK: function() {
					  $(this).dialog('close');
					  // Scroll to top for mobile devices
					  $("html, body").animate({ scrollTop: 0 }, "fast");
				  }
			  }
			})
		}
		else {
			makeRequest(nextToken);
			// Scroll to top for mobile devices
			$("html, body").animate({ scrollTop: 0 }, "fast");
		}
	});
	
	// Click function to load previous page
	$('#prev_page').click(function() {
		
		// Get previous page token
		prevToken = $('#prevToken').html();
		if(prevToken === undefined) {
			
			$('<div title="Oops..."><p>There are no results to display. Please enter a new search term above.</p></div>')
		   .dialog({
			   autoOpen: true,
			   modal: true,
			   close: function(event,ui) {
				  $(this).dialog('close');
				  // Scroll to top for mobile devices
				  $("html, body").animate({ scrollTop: 0 }, "fast");
			   },
			   buttons: {
				  OK: function() {
					  $(this).dialog('close');
					  // Scroll to top for mobile devices
					  $("html, body").animate({ scrollTop: 0 }, "fast");
				  }
			  }
			})
		}
		else {
			makeRequest(prevToken);
			// Scroll to top for mobile devices
			$("html, body").animate({ scrollTop: 0 }, "fast");
		}
	});
	
	// Update input box with slider values
	$( "#width_slider" ).on( "slide", function( event, ui ) { 
		$('#video_width').val(ui.value); 
	});
	$( "#height_slider" ).on( "slide", function( event, ui ) { 
		$('#video_height').val(ui.value); 
	});
	
	// Update slider with input box values
	$('#video_width').blur(function() {
		$("#width_slider").slider( "option", "value", $(this).val() );
	});
	$('#video_height').blur(function() {
		$("#height_slider").slider( "option", "value", $(this).val() );
	});
	
	// Set options button
	$('#set_options_opt').click(function() {
		$( "#tabs" ).tabs( "option", "active", 1 );
	});
	// Back to search button
	$('#back_to_search').click(function() {
		$('#tabs').tabs('option', 'active', 0);
	});
	
	// Cancel button
	$('#youTube_cancel, #cancel_opt').click(function() {
		
		top.tinymce.activeEditor.windowManager.close();
	});
	
	$('.numbersOnly').keyup(function () { 
		this.value = this.value.replace(/[^0-9\.]/g,'');
	});
	
	// Insert button
	$('#youTube_insert, #insert_video_opt').click(function(e) {
		
		// Get preview video editor ID
		video_id = $('#editor_video_id').html();
		
		// Check that a video has been loaded into the preview area
		if(!video_id){
			
			$('<div title="Oops..."><p>Please load a video into the preview area first.</p></div>')
		   .dialog({
			   autoOpen: true,
			   modal: true,
			   close: function(event,ui) {
				  $(this).dialog('close');
			   },
			   buttons: {
				  OK: function() {
					  $(this).dialog('close');
				  }
			  }
			})
		}
		else {
			
			// Get radio selection
			insert_vid_type = $('input[name=insert_vid_as]:checked').val();
			
			if(!insert_vid_type) {
				
				$('<div title="Oops..."><p>Please select how to insert the video (iframe, div or object).</p></div>')
			   .dialog({
				   autoOpen: true,
				   modal: true,
				   close: function(event,ui) {
					  $(this).dialog('close');
				   },
				   buttons: {
					  OK: function() {
						  $(this).dialog('close');
					  }
				  }
				})
				
				return false;
			}
			
			
			url_link = '';
			param_list = '';
			
			width = $('#video_width').val();
			height = $('#video_height').val();
			
			autohide = $('input[name=autohide]:checked').val();
			autoplay = $('input[name=autoplay]:checked').val();
			cc_load_policy = $('input[name=cc_load_policy]:checked').val();
			color = $('input[name=color]:checked').val();
			disablekb = $('input[name=disablekb]:checked').val();
			loop = $('input[name=loop]:checked').val();
			modestbranding = $('input[name=modestbranding]:checked').val();
			rel = $('input[name=rel]:checked').val();
			showinfo = $('input[name=showinfo]:checked').val();
			theme = $('input[name=theme]:checked').val();
			start = $('input[name=start]').val();
			
			
			// Start building url link
			url_link += 'http://www.youtube.com/embed/'+video_id;
			
			// Build parameters list
			if(autohide !== '2')
				param_list += '&autohide='+autohide;
			if(autoplay !== '0')
				param_list += '&autoplay='+autoplay;
			if(cc_load_policy !== '0')
				param_list += '&cc_load_policy='+cc_load_policy;
			if(color !== 'red')
				param_list += '&color='+color;
			if(disablekb !== '0')
				param_list += '&disablekb='+disablekb;
			if(loop !== '0')
				param_list += '&loop='+loop;
			if(modestbranding !== '0')
				param_list += '&modestbranding='+modestbranding;
			if(rel !== '1')
				param_list += '&rel='+rel;
			if(showinfo !== '1')
				param_list += '&showinfo='+showinfo;
			if(theme !== 'dark')
				param_list += '&theme='+theme;
			if(start !== '')
				param_list += '&start='+start;
				
			// Rebuild parameters list
			param_list = param_list.substring(1, param_list.length);  // Remove first '&'
			if(param_list !== '')
				param_list = '?'+param_list; // Add '?' to beginning of string
				
			
			// If inserting as an iframe	
			if(insert_vid_type == 'iframe') {
			
				// Insert into editor
				top.tinymce.activeEditor.execCommand(
					'mceInsertContent', 
					!1, 
					'<iframe class="ytplayer" type="text/html" width="'+width+'" height="'+height+'" src="http://www.youtube.com/embed/'+video_id+param_list+'" frameborder="0"></iframe>'
				);
			}
			// Else if inserting an object
			else if(insert_vid_type == 'object') {
				
				insert_div = '';
				insert_div = '<object width="' + width + '" height="' + height + '">' + 
					'<param name="movie" value="http://www.youtube.com/embed/' + video_id + '?html5=1&amp;rel=' + rel + '&amp;autoplay=' + autoplay + '&amp;color=' + color + '&amp;loop=' + loop + '&amp;modestbranding=' + modestbranding + '&amp;theme=' + theme + '&amp;start=' + start + '&amp;hl=en_US&amp;version=3"/>' + 
					'<param name="allowFullScreen" value="true"/>' + 
					'<param name="allowscriptaccess" value="always"/>' + 
					'<embed width="640" height="360" src="http://www.youtube.com/embed/' + video_id + '?html5=1&amp;rel=' + rel + '&amp;autoplay=' + autoplay + '&amp;color=' + color + '&amp;loop=' + loop + '&amp;modestbranding=' + modestbranding + '&amp;theme=' + theme + '&amp;start=' + start + '&amp;hl=en_US&amp;version=3" class="youtube-player" type="text/html" allowscriptaccess="always" allowfullscreen="true"/>' + 
				'</object>';
				
				top.tinymce.activeEditor.execCommand(
					'mceInsertContent', 
					!1, 
					insert_div
				);
			}
			
			// Close window
			top.tinymce.activeEditor.windowManager.close();
		}
	});
});

function keyWordsearch(){
	gapi.client.setApiKey('AIzaSyAE0iMOe4AtR1k5-CcFlPLV_gDbudr-6sc');
	gapi.client.load('youtube', 'v3', function() {
			makeRequest('');
	});
}
function makeRequest(pageToken) {
	
	var q = jQuery('#query').val();
	var request = gapi.client.youtube.search.list({
		q: q,
		part: 'snippet',
		pageToken: pageToken,
		maxResults: 10,
		type: 'video',
		videoEmbeddable: 'true'            
	});
	
	// Clear prior search results
	jQuery('#search-container').html('');
	
	request.execute(function(response) {
		
		video_ids = [];
		video_id_str = '';
		
		// Loop response to display each video
		jQuery.each(response.items, function(key, val) {
			
			// Convert 'publishedAt' ISO8601 date format
			dtstr = val.snippet.publishedAt.replace(/\D/g," ");
			dtcomps = dtstr.split(" ");
			// modify month between 1 based ISO 8601 and zero based Date
			dtcomps[1]--;
			convdt = new Date(Date(dtcomps[0],dtcomps[1],dtcomps[2],dtcomps[3],dtcomps[4],dtcomps[5])).toLocaleDateString();;
			
			jQuery('#search-container').append(
				'<div class="video_tile">'+
					'<p class="title" title="'+val.snippet.title+'">'+val.snippet.title.substring(0,50)+'</p>'+
					'<p class="thumb"><img class="thumbnail" src="'+val.snippet.thumbnails.default.url+'" title="Click to load preview." />'+
						'<span class="videoId">'+val.id.videoId+'</span>'+
						'<span id="'+val.id.videoId+'" class="duration"></span>'+
						'<br />'+
						'<span class="published"><strong>Published</strong>: '+convdt+'</span>'+
					'</p>'+
					'<p class="desc" title="'+val.snippet.description+'" style="clear:both;">'+val.snippet.description.substring(0,180)+'</p>'+
				'</div>');
			
			// Build array of video id's
			video_ids.push(val.id.videoId);
		});
		
		// Build string from video id's
		jQuery.each(video_ids, function(key, val) {
			video_id_str += val+'%2C';
		});
		
		// Append page tokens for pagination
		jQuery('#search-container').append('<p id="nextToken">'+response.nextPageToken+'</p>');
		jQuery('#search-container').append('<p id="prevToken">'+response.prevPageToken+'</p>');
		
		// Call youtube to get content durations... UGH
		jQuery.get( "https://www.googleapis.com/youtube/v3/videos?id="+video_id_str+"&part=contentDetails&key=AIzaSyAE0iMOe4AtR1k5-CcFlPLV_gDbudr-6sc", function( data ) {
		  jQuery.each(data.items, function(i,v) {
			 
			 jQuery('#'+v.id).html('<strong>Duration</strong>: '+v.contentDetails.duration.replace("PT","").replace("H","hour ").replace("M","min ").replace("S","sec"));
		  });
		});
	});
}