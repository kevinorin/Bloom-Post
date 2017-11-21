

jQuery(document).ready(function($) {
	
	var ed = top.tinyMCE.activeEditor;
	
	// Select column number
	$('#select_column_number').change(function() {
		
		// Clear preview html
		$('#size_preview').html('');
		
		// Get current column selection
		get_columns = $(this).val();
		
		select_size = '<hr /><p style="font-size:18px;">' + ed.getLang('wpep_langs.cshort_sel_size') + ':</p><select id="select_column_size">';
		
		if(get_columns === 'two') {
			
			select_size += 
				'<option value="">' + ed.getLang('wpep_langs.cshort_select') + '</option>'+
				'<option value="1656">1/6 - 5/6</option>'+
				'<option value="1545">1/5 - 4/5</option>'+
				'<option value="1434">1/4 - 3/4</option>'+
				'<option value="1323">1/3 - 2/3</option>'+
				'<option value="1212">1/2 - 1/2</option>'+
				'<option value="2313">2/3 - 1/3</option>'+
                                '<option value="2535">2/5 - 3/5</option>'+
				'<option value="3414">3/4 - 1/4</option>'+
                                '<option value="3525">3/5 - 2/5</option>'+
				'<option value="4515">4/5 - 1/5</option>'+
				'<option value="5616">5/6 - 1/6</option>';
		}
		
		if(get_columns === 'three') {
			
			select_size += 
				'<option value="">' + ed.getLang('wpep_langs.cshort_select') + '</option>'+
				'<option value="161623">1/6 - 1/6 - 2/3</option>'+
				'<option value="161312">1/6 - 1/3 - 1/2</option>'+
				'<option value="161213">1/6 - 1/2 - 1/3</option>'+
				'<option value="162316">1/6 - 2/3 - 1/6</option>'+
				'<option value="151535">1/5 - 1/5 - 3/5</option>'+
				'<option value="152525">1/5 - 2/5 - 2/5</option>'+
				'<option value="153515">1/5 - 3/5 - 1/5</option>'+
				'<option value="141214">1/4 - 1/2 - 1/4</option>'+
				'<option value="141412">1/4 - 1/4 - 1/2</option>'+
				'<option value="131313">1/3 - 1/3 - 1/3</option>'+
				'<option value="131612">1/3 - 1/6 - 1/2</option>'+
				'<option value="131216">1/3 - 1/2 - 1/6</option>'+
				'<option value="121316">1/2 - 1/3 - 1/6</option>'+
				'<option value="121613">1/2 - 1/6 - 1/3</option>'+
				'<option value="121414">1/2 - 1/4 - 1/4</option>'+
				'<option value="231616">2/3 - 1/6 - 1/6</option>'+
				'<option value="251525">2/5 - 1/5 - 2/5</option>'+
				'<option value="252515">2/5 - 2/5 - 1/5</option>'+
				'<option value="351515">3/5 - 1/5 - 1/5</option>';
		}
		
		if(get_columns === 'four') {
			
			select_size += 
				'<option value="">' + ed.getLang('wpep_langs.cshort_select') + '</option>'+
				'<option value="16161612">1/6 - 1/6 - 1/6 - 1/2</option>'+
				'<option value="16161216">1/6 - 1/6 - 1/2 - 1/6</option>'+
				'<option value="16121616">1/6 - 1/2 - 1/6 - 1/6</option>'+
				'<option value="16161313">1/6 - 1/6 - 1/3 - 1/3</option>'+
				'<option value="16131613">1/6 - 1/3 - 1/6 - 1/3</option>'+
				'<option value="16131316">1/6 - 1/3 - 1/3 - 1/6</option>'+
				'<option value="15151525">1/5 - 1/5 - 1/5 - 2/5</option>'+
				'<option value="15152515">1/5 - 1/5 - 2/5 - 1/5</option>'+
				'<option value="15251515">1/5 - 2/5 - 1/5 - 1/5</option>'+
				'<option value="14141414">1/4 - 1/4 - 1/4 - 1/4</option>'+
				'<option value="13131616">1/3 - 1/3 - 1/6 - 1/6</option>'+
				'<option value="13161613">1/3 - 1/6 - 1/6 - 1/3</option>'+
				'<option value="13161316">1/3 - 1/6 - 1/3 - 1/6</option>'+
				'<option value="12161616">1/2 - 1/6 - 1/6 - 1/6</option>'+
				'<option value="25151515">2/5 - 1/5 - 1/5 - 1/5</option>';
		}
		
		if(get_columns === 'five') {
			
			select_size += 
				'<option value="">' + ed.getLang('wpep_langs.cshort_select') + '</option>'+
				'<option value="1515151515">1/5 - 1/5 - 1/5 - 1/5 - 1/5</option>'+
				'<option value="1616161613">1/6 - 1/6 - 1/6 - 1/6 - 1/3</option>'+
				'<option value="1616161316">1/6 - 1/6 - 1/6 - 1/3 - 1/6</option>'+
				'<option value="1616131616">1/6 - 1/6 - 1/3 - 1/6 - 1/6</option>'+
				'<option value="1613161616">1/6 - 1/3 - 1/6 - 1/6 - 1/6</option>'+
				'<option value="1316161616">1/3 - 1/6 - 1/6 - 1/6 - 1/6</option>';
		}
		
		if(get_columns === 'six') {
			
			select_size += 
				'<option value="">' + ed.getLang('wpep_langs.cshort_select') + '</option>'+
				'<option value="161616161616">1/6 - 1/6 - 1/6 - 1/6 - 1/6 - 1/6</option>';
		}
		
		select_size += '</select>';
		
		// Populate hidden div with select column sizes
		$('#populate_select_sizes').html(select_size);
	});
	
	
	// Select column sizes select button change function
	$(document).on('change', '#select_column_size', function() {
		
		
		get_size = $(this).val();
		editor_text = '';
		preview_html = '<hr /><p style="font-size:18px;">' + ed.getLang('wpep_langs.cshort_preview') + ':</p>';
		
		// ********************************
		//  Get columns equals 'two'
		// ********************************
		if(get_size === '1656') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_five_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][five_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/five_sixth_last]';
		}
		
		if(get_size === '1545') {
			
			preview_html += '<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_four_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][four_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/four_fifth_last]';
		}
		
		if(get_size === '1434') {
			
			preview_html += '<div class="jwl_one_fourth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_three_fourth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_fourth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fourth][three_fourth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/three_fourth_last]';
		}
		
		if(get_size === '1323') {
			
			preview_html += '<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_two_third last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][two_third_last]' + ed.getLang('wpep_langs.cshort_content') + '[/two_third_last]';
		}
		
		if(get_size === '1212') {
			
			preview_html += '<div class="jwl_one_half">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_half last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_half]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half][one_half_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half_last]';
		}
		
		if(get_size === '2313') {
			
			preview_html += '<div class="jwl_two_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[two_third]' + ed.getLang('wpep_langs.cshort_content') + '[/two_third][one_third_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third_last]';
		}
		
		if(get_size === '2535') {
			
			preview_html += '<div class="jwl_two_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_three_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[two_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/two_fifth][three_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/three_fifth_last]';
		}
		
		if(get_size === '3414') {
			
			preview_html += '<div class="jwl_three_fourth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fourth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[three_fourth]' + ed.getLang('wpep_langs.cshort_content') + '[/three_fourth][one_fourth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fourth_last]';
		}
		
		if(get_size === '3525') {
			
			preview_html += '<div class="jwlthree_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_two_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[three_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/three_fifth][two_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/two_fifth_last]';
		}
		
		if(get_size === '4515') {
			
			preview_html += '<div class="jwl_four_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[four_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/four_fifth][one_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth_last]';
		}
		
		if(get_size === '5616') {
			
			preview_html += '<div class="jwl_five_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[five_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/five_sixth][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		
		// ********************************
		//  Get columns equals 'three'
		// ********************************
		if(get_size === '161623') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_two_third last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][two_third_last]' + ed.getLang('wpep_langs.cshort_content') + '[/two_third_last]';
		}
		
		if(get_size === '161312') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_half last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_half_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half_last]';
		}
		
		if(get_size === '161213') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_half">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_half]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half][one_third_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third_last]';
		}
		
		if(get_size === '162316') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_two_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][two_third]' + ed.getLang('wpep_langs.cshort_content') + '[/two_third][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		if(get_size === '151535') {
			
			preview_html += '<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_three_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][three_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/three_fifth_last]';
		}
		
		if(get_size === '152525') {
			
			preview_html += '<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_two_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_two_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][two_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/two_fifth][two_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/two_fifth_last]';
		}
		
		if(get_size === '153515') {
			
			preview_html += '<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_three_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][three_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/three_fifth][one_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth_last]';
		}
		
		if(get_size === '141214') {
			
			preview_html += '<div class="jwl_one_fourth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_half">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fourth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_fourth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fourth][one_half]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half][one_fourth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fourth_last]';
		}
		
		if(get_size === '141412') {
			
			preview_html += '<div class="jwl_one_fourth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fourth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_half last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_fourth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fourth][one_fourth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fourth][one_half_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half_last]';
		}
		
		if(get_size === '131313') {
			
			preview_html += '<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_third_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third_last]';
		}
		
		if(get_size === '131612') {
			
			preview_html += '<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_half last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_half_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half_last]';
		}
		
		if(get_size === '131216') {
			
			preview_html += '<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_half">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_half]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		if(get_size === '121316') {
			
			preview_html += '<div class="jwl_one_half">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_half]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half][one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		if(get_size === '121613') {
			
			preview_html += '<div class="jwl_one_half">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_half]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_third_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third_last]';
		}
		
		if(get_size === '121414') {
			
			preview_html += '<div class="jwl_one_half">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fourth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fourth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_half]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half][one_fourth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fourth][one_fourth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fourth_last]';
		}
		
		if(get_size === '231616') {
			
			preview_html += '<div class="jwl_two_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[two_third]' + ed.getLang('wpep_langs.cshort_content') + '[/two_third][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		if(get_size === '251525') {
			
			preview_html += '<div class="jwl_two_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_two_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[two_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/two_fifth][one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][two_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/two_fifth_last]';
		}
		
		if(get_size === '252515') {
			
			preview_html += '<div class="jwl_two_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_two_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[two_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/two_fifth][two_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/two_fifth][one_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth_last]';
		}
		
		if(get_size === '351515') {
			
			preview_html += '<div class="jwl_three_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[three_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/three_fifth][one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][one_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth_last]';
		}
		
		
		// ********************************
		//  Get columns equals 'four'
		// ********************************
		if(get_size === '16161612') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_half last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_half_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half_last]';
		}
		
		if(get_size === '16161216') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_half">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_half]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		if(get_size === '16121616') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_half">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_half]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		if(get_size === '16161313') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_third_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third_last]';
		}
		
		if(get_size === '16131613') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_third_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third_last]';
		}
		
		if(get_size === '16131316') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		if(get_size === '15151525') {
			
			preview_html += '<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_two_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][two_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/two_fifth_last]';
		}
		
		if(get_size === '15152515') {
			
			preview_html += '<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_two_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][two_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/two_fifth][one_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth_last]';
		}
		
		if(get_size === '15251515') {
			
			preview_html += '<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_two_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][two_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/two_fifth][one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][one_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth_last]';
		}
		
		if(get_size === '14141414') {
			
			preview_html += '<div class="jwl_one_fourth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fourth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fourth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fourth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_fourth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fourth][one_fourth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fourth][one_fourth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fourth][one_fourth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fourth_last]';
		}
		
		if(get_size === '13131616') {
			
			preview_html += '<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		if(get_size === '13161613') {
			
			preview_html += '<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_third_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third_last]';
		}
		
		if(get_size === '13161316') {
			
			preview_html += '<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		if(get_size === '12161616') {
			
			preview_html += '<div class="jwl_one_half">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_half]' + ed.getLang('wpep_langs.cshort_content') + '[/one_half][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		if(get_size === '25151515') {
			
			preview_html += '<div class="jwl_two_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[two_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/two_fifth][one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][one_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth_last]';
		}
		
		
		
		// ********************************
		//  Get columns equals 'five'
		// ********************************
		if(get_size === '1515151515') {
			
			preview_html += '<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_fifth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][one_fifth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth][one_fifth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_fifth_last]';
		}
		
		if(get_size === '1616161613') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_third_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third_last]';
		}
		
		if(get_size === '1616161316') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		if(get_size === '1616131616') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		if(get_size === '1613161616') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		if(get_size === '1316161616') {
			
			preview_html += '<div class="jwl_one_third">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="' + ed.getLang('wpep_langs.cshort_insert') + '" class="button-primary" />';
							
			editor_text = '[one_third]' + ed.getLang('wpep_langs.cshort_content') + '[/one_third][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		
		// ********************************
		//  Get columns equals 'six'
		// ********************************
		if(get_size === '161616161616') {
			
			preview_html += '<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div class="jwl_one_sixth last">' + ed.getLang('wpep_langs.cshort_content') + '</div>'+
							'<div style="clear:both;"></div>'+
							'<br /><br /><input type="button" id="submit_preview" value="Insert" class="button-primary" />';
							
			editor_text = '[one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth][one_sixth_last]' + ed.getLang('wpep_langs.cshort_content') + '[/one_sixth_last]';
		}
		
		// Populate hidden div with preview
		$('#size_preview').html(preview_html);
	});
	
        // Insert button
        $(document).on('click', '#submit_preview', function() {

            // Insert editor text
            top.tinymce.activeEditor.execCommand('mceInsertContent', !1, editor_text);
            // Close shortcodes window
            top.tinymce.activeEditor.windowManager.close();
        });
});