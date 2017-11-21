

jQuery(document).ready(function($) {
	
	// Set paginator options
	 var options = {
		currentPage: 1,
		totalPages: 10,
		alignment:'center',
		useBootstrapTooltip: true,
		numberOfPages: 10,
		itemContainerClass: function (type, page, current) {
			return (page === current) ? "active" : "pointer-cursor";
		},
		itemTexts: function (type, page, current) {
			switch (type) {
			case "first":
				return top.tinyMCE.activeEditor.getLang('wpep_langs.flickr_first');
			case "prev":
				return top.tinyMCE.activeEditor.getLang('wpep_langs.flickr_prev');
			case "next":
				return top.tinyMCE.activeEditor.getLang('wpep_langs.flickr_next');
			case "last":
				return top.tinyMCE.activeEditor.getLang('wpep_langs.flickr_last');
			case "page":
				return page;
			}
		}
	}
	// Execute paginator
	$('#pagination_div').bootstrapPaginator(options);
	
	// Hide results divs
	$('#pagination_div').hide();
	$('#pagination_count_div').hide();
	$('#loading-indicator').hide();

	// When user clicks to search
	$('#search_text_submit').click(function() {
	
		// Get input search field
		search_text = $('#search_text').val();
		page = '1';
		
		if(search_text == '') {
			
			// Display error message
			$('#search_term_error').html(top.tinyMCE.activeEditor.getLang('wpep_langs.flickr_search_error'));
			$('#search_term_error').slideDown('slow');
			
			// Clear html results div
			$('#search_results_div').html('');
			$('#pagination_div').hide();
			$('#pagination_count_div').hide();
			$('#loading-indicator').hide();
			
			return false;
		}
				
		// Reset pagination options
		options = {
			currentPage: 1
		}
		$('#pagination_div').bootstrapPaginator(options);
		
		// Clear old results
		$('#search_results_div').html('');
		$('#pagination_div').hide();
		$('#pagination_count_div').hide();
		
		// Make flickr request
		make_flickr_request(search_text, page);
	});
		
	// Keyup function for search input field
	$('#search_text').on('keyup', function() {
		
		// Remove search error message
		$('#search_term_error').html('');
		$('#search_term_error').slideUp('fast');
	});
	
	// Helper function to make flickr request
	function make_flickr_request(search_text, page) {
		
		// Show loading ajax
		$('#loading-indicator').show();
		// Hide paginator
		$('#pagination_div').hide();
		// Hide Count
		$('#pagination_count_div').hide();
		
		// Set api options
		options = { 
		  "api_key": "d3128d35b86012a00103d050793d1ba8",
		  "method": "flickr.photos.search", // You can replace this with whatever method
		  "format": "json",
		  "nojsoncallback": "1",
		  "per_page": "18",
		  "content_type": "7",
		  "text": search_text,
		  "page": page
		}
		
		url = "https://api.flickr.com/services/rest/";
		first = true;
		$.each(options, function(key, value) { 
			url += (first ? "?" : "&") + key + "=" + value;
			first = false; 
		});
		
		// Get api results
		$.get(url, function(data) { 
		
			// Check if results are returned
			if(typeof data.photos.photo !== 'undefined' && data.photos.photo.length > 0){
				
				content = '<div class="row">';
					$.each(data.photos.photo, function(i, item){
							
						// Set image divs
						src = "http://farm"+ item.farm +".static.flickr.com/"+ item.server +"/"+ item.id +"_"+ item.secret +".jpg";
						src_m = "http://farm"+ item.farm +".static.flickr.com/"+ item.server +"/"+ item.id +"_"+ item.secret +"_m.jpg";
						content += '<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">';
							content += '<div class="img_box" style="background:url('+src_m+');" data-source="'+src+'">';
								content += '<div class="img_overlay">';
								
									content += '<span class="img_plus"><span class="view_full">' + top.tinyMCE.activeEditor.getLang('wpep_langs.flickr_view') + '</span><br /><br /><span class="insert_post">' + top.tinyMCE.activeEditor.getLang('wpep_langs.flickr_insert') + '</span></span>';
								content += '</div>';
							content += '</div>';
						content += '</div>';
					});
				content += '</div>';
					
				// Append results to search results div
				$(content).appendTo("#search_results_div");
				
				// Reset pagination options
				options = {
					totalPages: data.photos.pages,
					onPageClicked: function(e, originalEvent, type, page){
						
						// Clear old results
						$('#search_results_div').html('');
						
						// Recall request
						make_flickr_request(search_text, page);
					}
				}
				$('#pagination_div').bootstrapPaginator(options);
				
				// Update pagination count
				$('#pagination_count_div span.page_number').html(page);
				$('#pagination_count_div span.results_number').html(data.photos.pages);
				
				// Show pagination div
				$('#pagination_div').show();
				$('#pagination_count_div').show();
				$('#loading-indicator').hide();
			}
			// Else no items were returned
			else {
				
				$('#search_results_div').html(top.tinyMCE.activeEditor.getLang('wpep_langs.flickr_no_results'));
				$('#loading-indicator').hide();
			}
		});
	}
	
	// Insert image into post
	$(document).on('click', '.insert_post', function() {
		
		// Get image source
		img_src = $(this).parent().parent().parent().attr('data-source');
		img = '<img src="'+img_src+'" />';
		
		// Insert image into post
		top.tinyMCE.activeEditor.execCommand('mceInsertContent', false, img);
		
		// Close overlay window
		top.tinyMCE.activeEditor.windowManager.close();
	});
	
	
	// View full image
	$(document).on('click', '.view_full', function() {
		
		// Get image source
		img_src = $(this).parent().parent().parent().attr('data-source');
		img = '<img src="'+img_src+'" />';
		
		// Display in lightbox
		$.featherlight(img);
	});
});
