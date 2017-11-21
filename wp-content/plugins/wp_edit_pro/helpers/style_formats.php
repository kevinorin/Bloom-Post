<?php

//************************************************
// Custom Styles - if database contains values
//***********************************************/
//$options_styles = $this->wp_edit_pro_options_array['wp_edit_pro_styles'];
$function_opts = $this->get_wp_edit_pro_function_opts();
$options_styles = $function_opts['wp_edit_pro_styles'];
$options_custom_styles = isset($options_styles['custom_styles']) ? $options_styles['custom_styles'] : '';

if(!empty($options_custom_styles)) {
	
	// Set arrays
	$inline = array();
	$block = array();
	$selector = array();
	
	// Iterate db options and create custom style formats
	foreach($options_custom_styles as $style) {
		
		// If there are custom styles
		if($style['styles']) {
			
			// Get all styles and set up array of key => value pairs
			preg_match_all('/([^:]*?):([^;]*);?/', $style['styles'], $matches);
			$final_styles = array_combine($matches[1], $matches[2]);
			
		}
		// Else there are no custom styles
		else {
			
			// We have to pass an empty array
			$final_styles = array();
		}
		
		if($style['type'] == 'inline') {
			
			// Build final array to pass back to settings
			$inline[] = 
			array(
				'title' => $style['title'],
				$style['type'] => $style['element'],
				'classes' => $style['classes'],
				'styles' => $final_styles,
				'wrapper' => $style['wrapper']
			);
		}
		if($style['type'] == 'block') {
			
			$block[] = 
			array(
				'title' => $style['title'],
				'block' => $style['element'],
				'classes' => $style['classes'],
				'styles' => $final_styles
			);
		}
		if($style['type'] == 'selector') {
			
			$selector[] = 
			array(
				'title' => $style['title'],
				'selector' => $style['element'],
				'classes' => $style['classes'],
				'styles' => $final_styles,
				'wrapper' => $style['wrapper']
			);
		}
	}
	$merge_custom_styles = array_merge($inline, $block, $selector);
	
	// Sort multidimensional array by 'title' value
	//usort( $merge_custom_styles, function($a, $b){ return strcmp($a["title"], $b["title"]); } );
	
	// Above sort removed to provide in class (this one uses class function) (replaced for php 5.2 backward compability (inline functions))
	usort( $merge_custom_styles, array( $this, 'array_compare' ) );
	
	
	// Finally... intiialize styles
	$style_formats_custom = array(
	
		array(
			'title' => __('Custom Styles', 'wp_edit_pro'),
			'items' => $merge_custom_styles
		)
	);
}
//************************************************
// END Custom Styles
//***********************************************/	
	
	
	

//*************************************
// Predefined Styles - if user selected
//************************************/
$enable_predefined = isset($options_styles['add_predefined_styles']) ? $options_styles['add_predefined_styles'] : 0;

if($enable_predefined == 1) {
	
	$style_formats_predefined = array(
		
		// Our Predefined Styles need to be added as well
		array(
			'title' => __('Defined Styles', 'wp_edit_pro'),
			'items' => array( 
			
				array(
					'title' => __('Text Styles', 'wp_edit_pro'),
					'items' => array( 
					
						array(
							'title' => __('Bold Black Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#000',
								'fontWeight' => 'bold'
							)
						),
						array(
							'title' => __('Italic Black Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#000',
								'fontStyle' => 'italic'
							)
						),
						array(
							'title' => __('Bold Italic Black Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#000',
								'fontWeight' => 'bold',
								'fontStyle' => 'italic'
							)
						),
						array(
							'title' => __('Bold Red Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#f00',
								'fontWeight' => 'bold'
							)
						),
						array(
							'title' => __('Italic Red Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#f00',
								'fontStyle' => 'italic'
							)
						),
						array(
							'title' => __('Bold Italic Red Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#f00',
								'fontWeight' => 'bold',
								'fontStyle' => 'italic'
							)
						),
						array(
							'title' => __('Bold Blue Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#0040FF',
								'fontWeight' => 'bold'
							)
						),
						array(
							'title' => __('Italic Blue Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#0040FF',
								'fontStyle' => 'italic'
							)
						),
						array(
							'title' => __('Bold Italic Blue Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#0040FF',
								'fontWeight' => 'bold',
								'fontStyle' => 'italic'
							)
						),
						array(
							'title' => __('Bold Green Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#0BEA43',
								'fontWeight' => 'bold'
							)
						),
						array(
							'title' => __('Italic Green Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#0BEA43',
								'fontStyle' => 'italic'
							)
						),
						array(
							'title' => __('Bold Italic Green Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#0BEA43',
								'fontWeight' => 'bold',
								'fontStyle' => 'italic'
							)
						)
					)
				),
				
				array(
					'title' => __('Text Outlines', 'wp_edit_pro'),
					'items' => array( 
					
						array(
							'title' => __('Text Outline Black', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '-1px 0 #000, 0 1px #000, 1px 0 #000, 0 -1px #000'
								)
						),
						array(
							'title' => __('Text Outline Red', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '-1px 0 #f00, 0 1px #f00, 1px 0 #f00, 0 -1px #f00'
								)
						),
						array(
							'title' => __('Text Outline Blue', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '-1px 0 #0040FF, 0 1px #0040FF, 1px 0 #0040FF, 0 -1px #0040FF'
								)
						),
						array(
							'title' => __('Text Outline Green', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '-1px 0 #0BEA43, 0 1px #0BEA43, 1px 0 #0BEA43, 0 -1px #0BEA43'
								)
						),
						array(
							'title' => __('Text Outline Violet', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '-1px 0 #F731B5, 0 1px #F731B5, 1px 0 #F731B5, 0 -1px #F731B5'
								)
						),
						// Added 7-18-12
						array(
							'title' => __('Text Outline Teal', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '-1px 0 #4FDCF5, 0 1px #4FDCF5, 1px 0 #4FDCF5, 0 -1px #4FDCF5'
								)
						),
						array(
							'title' => __('Text Outline Gold', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '-1px 0 #FDBF5D, 0 1px #FDBF5D, 1px 0 #FDBF5D, 0 -1px #FDBF5D'
								)
						),
						array(
							'title' => __('Text Outline Purple', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '-1px 0 #C17FAD, 0 1px #C17FAD, 1px 0 #C17FAD, 0 -1px #C17FAD'
								)
						)
					)
				),
				
				
				
				
				array(
					'title' => __('Text Decoration', 'wp_edit_pro'),
					'items' => array( 
					
						array(
							'title' => __('3D Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'font-size' => '28px',
								'text-shadow' => '0px 0px 0 rgb(198,198,198),1px 1px 0 rgb(163,163,163),2px 2px 0 rgb(127,127,127),3px 3px 0 rgb(91,91,91), 4px 4px 0 rgb(55,55,55),5px 5px 4px rgba(0,0,0,0.35),5px 5px 1px rgba(0,0,0,0.5),0px 0px 4px rgba(0,0,0,.2)'
								)
						),
						array(
							'title' => __('Text Shadow', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '2px 2px 2px #000'
								)
						),
						array(
							'title' => __('Blurry Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => 'transparent',
								'text-shadow' => '0 0 5px rgba(0,0,0,0.8)',
								'font-size' => '28px'
								)
						),
						array(
							'title' => __('Milky Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#fff',
								'background' => '#fff',
								'text-shadow' => '1px 1px 4px#000'
								)
						),
						array(
							'title' => __('Mystery Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'color' => '#000',
								'background' => '#000',
								'text-shadow' => '1px 1px 4px #fff'
								)
						),
						array(
							'title' => __('Engrave Text', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '1px 1px white, -1px -1px #444',
								'color' => '#fff'
								)
						),
						array(
							'title' => __('Small Caps', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'font-variant' => 'small-caps'
								)
						)
					)
				),
				
				array(
					'title' => __('Text Glows', 'wp_edit_pro'),
					'items' => array( 
					
						array(
							'title' => __('Glow Green', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '0 0 0.2em #B8F9BB, 0 0 0.2em #B8F9BB, 0 0 0.2em #B8F9BB'
								)
						),
						array(
							'title' => __('Glow Blue', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '0 0 0.2em #BFF8FC, 0 0 0.2em #BFF8FC, 0 0 0.2em #BFF8FC'
								)
						),
						array(
							'title' => __('Glow Yellow', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '0 0 0.2em #FCFCBD, 0 0 0.2em #FCFCBD, 0 0 0.2em #FCFCBD'
								)
						),
						array(
							'title' => __('Glow Violet', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '0 0 0.2em #F7CAE8, 0 0 0.2em #F7CAE8, 0 0 0.2em #F7CAE8'
								)
						),
						array(
							'title' => __('Glow Red', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '0 0 0.2em #FCB3AE, 0 0 0.2em #FCB3AE, 0 0 0.2em #FCB3AE'
								)
						),
						// Added 7-18-12
						array(
							'title' => __('Glow Teal', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '0 0 0.2em #4FDCF5, 0 0 0.2em #4FDCF5, 0 0 0.2em #4FDCF5'
								)
						),
						array(
							'title' => __('Glow Gold', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '0 0 0.2em #FDBF5D, 0 0 0.2em #FDBF5D, 0 0 0.2em #FDBF5D'
								)
						),
						array(
							'title' => __('Glow Purple', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'text-shadow' => '0 0 0.2em #C17FAD, 0 0 0.2em #C17FAD, 0 0 0.2em #C17FAD'
								)
						)
					)
				),
				
				
						
				array(
					'title' => __('Highlights', 'wp_edit_pro'),
					'items' => array( 
					
						array(
							'title' => __('Highlight Green', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#B8F9BB',
								'border' => '1px solid #419B44',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px'
							)
						),
						array(
							'title' => __('Highlight Blue', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#BFF8FC',
								'border' => '1px solid #506EF4',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px'
							)
						),
						array(
							'title' => __('Highlight Yellow', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#FFFF35',
								'border' => '1px solid #E5D02D',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px'
							)
						),
						array(
							'title' => __('Highlight Violet', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#F7CAE8',
								'border' => '1px solid #F731B5',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px'
							)
						),
						array(
							'title' => __('Highlight Red', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#FCB3AE',
								'border' => '1px solid #F73325',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px'
							)
						),
						// Added 7-18-12
						array(
							'title' => __('Highlight Teal', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#4FDCF5',
								'border' => '1px solid #0CB4D3',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px'
							)
						),
						array(
							'title' => __('Highlight Gold', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#FDBF5D',
								'border' => '1px solid #FDAB2A',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px'
							)
						),
						array(
							'title' => __('Highlight Purple', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#C17FAD',
								'border' => '1px solid #813F6D',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px'
							)
						)
					)
				),
				
				array(
					'title' => __('Inset Box Styles', 'wp_edit_pro'),
					'items' => array( 
					
						array(
							'title' => __('Inset Box Green', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#B8F9BB',
								'border' => '1px solid #419B44',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '0 1px 10px #666 inset'
							)
						),
						array(
							'title' => __('Inset Box Blue', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#BFF8FC',
								'border' => '1px solid #506EF4',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '0 1px 10px #666 inset'
							)
						),
						array(
							'title' => __('Inset Box Yellow', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#FFFF35',
								'border' => '1px solid #E5D02D',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '0 1px 10px #666 inset'
							)
						),
						array(
							'title' => __('Inset Box Violet', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#F7CAE8',
								'border' => '1px solid #F731B5',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '0 1px 10px #666 inset'
							)
						),
						array(
							'title' => __('Inset Box Red', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#FCB3AE',
								'border' => '1px solid #F73325',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '0 1px 10px #666 inset'
							)
						),
						array(
							'title' => __('Inset Box Steel', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '0 1px 10px #666 inset'
							)
						),
						// Added 7-18-12
						array(
							'title' => __('Inset Box Teal', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#4FDCF5',
								'border' => '1px solid #0CB4D3',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '0 1px 10px #666 inset'
							)
						),
						array(
							'title' => __('Inset Box Gold', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#FDBF5D',
								'border' => '1px solid #FDAB2A',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '0 1px 10px #666 inset'
							)
						),
						array(
							'title' => __('Inset Box Purple', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#C17FAD',
								'border' => '1px solid #813F6D',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '0 1px 10px #666 inset'
							)
						)
					)
				),
				
				array(
					'title' => __('Box Shadows', 'wp_edit_pro'),
					'items' => array( 
					
						array(
							'title' => __('Box Shadow Green', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#B8F9BB',
								'border' => '1px solid #419B44',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '5px 5px 2px #888888'
							)
						),
						array(
							'title' => __('Box Shadow Blue', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#BFF8FC',
								'border' => '1px solid #506EF4',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '5px 5px 2px #888888'
							)
						),
						array(
							'title' => __('Box Shadow Yellow', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#FFFF35',
								'border' => '1px solid #E5D02D',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '5px 5px 2px #888888'
							)
						),
						array(
							'title' => __('Box Shadow Violet', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#F7CAE8',
								'border' => '1px solid #F731B5',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '5px 5px 2px #888888'
							)
						),
						array(
							'title' => __('Box Shadow Red', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#FCB3AE',
								'border' => '1px solid #F73325',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '5px 5px 2px #888888'
							)
						),
						// Added 7-18-12
						array(
							'title' => __('Box Shadow Teal', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#4FDCF5',
								'border' => '1px solid #0CB4D3',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '5px 5px 2px #888888'
							)
						),
						array(
							'title' => __('Box Shadow Gold', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#FDBF5D',
								'border' => '1px solid #FDAB2A',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '5px 5px 2px #888888'
							)
						),
						array(
							'title' => __('Box Shadow Purple', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#C17FAD',
								'border' => '1px solid #813F6D',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '5px 5px 2px #888888'
							)
						)
					)
				),
				
				array(
					'title' => __('Hover Boxes', 'wp_edit_pro'),
					'items' => array( 
					
						array(
							'title' => __('Hover Box Green', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#B8F9BB',
								'border' => '1px solid #419B44',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '10px 10px 5px #888888'
							)
						),
						array(
							'title' => __('Hover Box Blue', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#BFF8FC',
								'border' => '1px solid #506EF4',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '10px 10px 5px #888888'
							)
						),
						array(
							'title' => __('Hover Box Yellow', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#FFFF35',
								'border' => '1px solid #E5D02D',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '10px 10px 5px #888888'
							)
						),
						array(
							'title' => __('Hover Box Violet', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#F7CAE8',
								'border' => '1px solid #F731B5',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '10px 10px 5px #888888'
							)
						),
						array(
							'title' => __('Hover Box Red', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#FCB3AE',
								'border' => '1px solid #F73325',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '10px 10px 5px #888888'
							)
						),
						// Added 7-18-12
						array(
							'title' => __('Hover Box Teal', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#4FDCF5',
								'border' => '1px solid #0CB4D3',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '10px 10px 5px #888888'
							)
						),
						array(
							'title' => __('Hover Box Gold', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#FDBF5D',
								'border' => '1px solid #FDAB2A',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '10px 10px 5px #888888'
							)
						),
						array(
							'title' => __('Hover Box Purple', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'background-color' => '#C17FAD',
								'border' => '1px solid #813F6D',
								'padding' => '2px 5px 2px 5px',
								'border-radius' => '3px',
								'box-shadow' => '10px 10px 5px #888888'
							)
						)
					)
				),
				
				array(
					'title' => __('Download Links', 'wp_edit_pro'),
					'items' => array( 
					
						array(
							'title' => __('Download Link Green', 'wp_edit_pro'),
							'selector' => 'a',
							'styles' => array(
								'color' => '#3B9634',
								'fontWeight' => 'bold',
								'background-color' => '#ACF9A7',
								'border-radius' => '5px',
								'border' => '1px solid #71C66B',
								'padding' => '5px',
								'text-shadow' => '1px 1px 6px #fff'
							)
						),
						array(
							'title' => __('Download Link Blue', 'wp_edit_pro'),
							'selector' => 'a',
							'styles' => array(
								'color' => '#46ADC4',
								'fontWeight' => 'bold',
								'background-color' => '#9FF4EA',
								'border-radius' => '5px',
								'border' => '1px solid #46ADC4',
								'padding' => '5px'
								)
						),
						array(
							'title' => __('Download Link Yellow', 'wp_edit_pro'),
							'selector' => 'a',
							'styles' => array(
								'color' => '#A5A51A',
								'fontWeight' => 'bold',
								'background-color' => '#FCFCAB',
								'border-radius' => '5px',
								'border' => '1px solid #F2F200',
								'padding' => '5px'
								)
						),
						array(
							'title' => __('Download Link Violet', 'wp_edit_pro'),
							'selector' => 'a',
							'styles' => array(
								'color' => '#F202A2',
								'fontWeight' => 'bold',
								'background-color' => '#F7CAE8',
								'border-radius' => '5px',
								'border' => '1px solid #F731B5',
								'padding' => '5px'
								)
						),
						array(
							'title' => __('Download Link Red', 'wp_edit_pro'),
							'selector' => 'a',
							'styles' => array(
								'color' => '#F73325',
								'fontWeight' => 'bold',
								'background-color' => '#FCB3AE',
								'border-radius' => '5px',
								'border' => '1px solid #F73325',
								'padding' => '5px'
								)
						),
						// Added 7-18-12
						array(
							'title' => __('Download Link Teal', 'wp_edit_pro'),
							'selector' => 'a',
							'styles' => array(
								'color' => '#0CB4D3',
								'fontWeight' => 'bold',
								'background-color' => '#4FDCF5',
								'border-radius' => '5px',
								'border' => '1px solid #0CB4D3',
								'padding' => '5px'
								)
						),
						array(
							'title' => __('Download Link Gold', 'wp_edit_pro'),
							'selector' => 'a',
							'styles' => array(
								'color' => '#FDAB2A',
								'fontWeight' => 'bold',
								'background-color' => '#FDBF5D',
								'border-radius' => '5px',
								'border' => '1px solid #FDAB2A',
								'padding' => '5px'
								)
						),
						array(
							'title' => __('Download Link Purple', 'wp_edit_pro'),
							'selector' => 'a',
							'styles' => array(
								'color' => '#813F6D',
								'fontWeight' => 'bold',
								'background-color' => '#C17FAD',
								'border-radius' => '5px',
								'border' => '1px solid #813F6D',
								'padding' => '5px'
								)
						)
					)
				),
				
				array(
					'title' => __('3D Buttons', 'wp_edit_pro'),
					'items' => array( 
					
						array(
							'title' => __('3D Button Green', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'border' => '1px solid #006400',
								'background-color' => '#008000',
								'border-radius' => '4px',
								'box-shadow' => 'inset 1px 6px 12px #7CFC00, inset -1px -10px 5px #006400, 1px 2px 1px black',
								'-o-box-shadow' => 'inset 1px 6px 12px #7CFC00, inset -1px -10px 5px #006400, 1px 2px 1px black',
								'-webkit-box-shadow' => 'inset 1px 6px 12px #7CFC00, inset -1px -10px 5px #006400, 1px 2px 1px black',
								'-moz-box-shadow' => 'inset 1px 6px 12px #7CFC00, inset -1px -10px 5px #006400, 1px 2px 1px black',
								'color' => 'white',
								'text-shadow' => '1px 1px 1px black',
								'padding' => '5px 30px',
								)
						),
						array(
							'title' => __('3D Button Blue', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'border' => '1px solid #001563',
								'background-color' => '#0638AD',
								'border-radius' => '4px',
								'box-shadow' => 'inset 1px 6px 12px #5A98FC, inset -1px -10px 5px #001563, 1px 2px 1px black',
								'-o-box-shadow' => 'inset 1px 6px 12px #5A98FC, inset -1px -10px 5px #001563, 1px 2px 1px black',
								'-webkit-box-shadow' => 'inset 1px 6px 12px #5A98FC, inset -1px -10px 5px #001563, 1px 2px 1px black',
								'-moz-box-shadow' => 'inset 1px 6px 12px #5A98FC, inset -1px -10px 5px #001563, 1px 2px 1px black',
								'color' => 'white',
								'text-shadow' => '1px 1px 1px black',
								'padding' => '5px 30px',
								)
						),
						array(
							'title' => __('3D Button Yellow', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'border' => '1px solid #7F7D10',
								'background-color' => '#AAAA06',
								'border-radius' => '4px',
								'box-shadow' => 'inset 1px 6px 12px #F8FC7E, inset -1px -10px 5px #7F7D10, 1px 2px 1px black',
								'-o-box-shadow' => 'inset 1px 6px 12px #F8FC7E, inset -1px -10px 5px #7F7D10, 1px 2px 1px black',
								'-webkit-box-shadow' => 'inset 1px 6px 12px #F8FC7E, inset -1px -10px 5px #7F7D10, 1px 2px 1px black',
								'-moz-box-shadow' => 'inset 1px 6px 12px #F8FC7E, inset -1px -10px 5px #7F7D10, 1px 2px 1px black',
								'color' => 'white',
								'text-shadow' => '1px 1px 1px black',
								'padding' => '5px 30px',
								)
						),
						array(
							'title' => __('3D Button Violet', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'border' => '1px solid #931F90',
								'background-color' => '#D11FB0',
								'border-radius' => '4px',
								'box-shadow' => 'inset 1px 6px 12px #F97CF9, inset -1px -10px 5px #931F90, 1px 2px 1px black',
								'-o-box-shadow' => 'inset 1px 6px 12px #F97CF9, inset -1px -10px 5px #931F90, 1px 2px 1px black',
								'-webkit-box-shadow' => 'inset 1px 6px 12px #F97CF9, inset -1px -10px 5px #931F90, 1px 2px 1px black',
								'-moz-box-shadow' => 'inset 1px 6px 12px #F97CF9, inset -1px -10px 5px #931F90, 1px 2px 1px black',
								'color' => 'white',
								'text-shadow' => '1px 1px 1px black',
								'padding' => '5px 30px',
								)
						),
						array(
							'title' => __('3D Button Red', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'border' => '1px solid #BC2D36',
								'background-color' => '#DB4362',
								'border-radius' => '4px',
								'box-shadow' => 'inset 1px 6px 12px #F97C9C, inset -1px -10px 5px #BC2D36, 1px 2px 1px black',
								'-o-box-shadow' => 'inset 1px 6px 12px #F97C9C, inset -1px -10px 5px #BC2D36, 1px 2px 1px black',
								'-webkit-box-shadow' => 'inset 1px 6px 12px #F97C9C, inset -1px -10px 5px #BC2D36, 1px 2px 1px black',
								'-moz-box-shadow' => 'inset 1px 6px 12px #F97C9C, inset -1px -10px 5px #BC2D36, 1px 2px 1px black',
								'color' => 'white',
								'text-shadow' => '1px 1px 1px black',
								'padding' => '5px 30px',
								)
						)
					)
				),
				
				array(
					'title' => __('Callout Boxes', 'wp_edit_pro'),
					'items' => array( 
					
						array(
							'title' => __('Callout Box Green', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'background-color' => '#B5F4CC',
								'border' => '1px solid #00C648',
								'border-radius' => '10px',
								'padding' => '10px'
								),
							'wrapper' => true
						),
						array(
							'title' => __('Callout Box Blue', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'background-color' => '#BDF9F9',
								'border' => '1px solid #4ABAF7',
								'border-radius' => '10px',
								'padding' => '10px',
								'width' => 'auto'
								),
							'wrapper' => true
						),
						array(
							'title' => __('Callout Box Yellow', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'background-color' => '#FCFCAB',
								'border' => '1px solid #F2F200',
								'border-radius' => '10px',
								'padding' => '10px'
								),
							'wrapper' => true
						),
						array(
							'title' => __('Callout Box Violet', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'background-color' => '#F7CAE8',
								'border' => '1px solid #F731B5',
								'border-radius' => '10px',
								'padding' => '10px',
								'width' => 'auto'
								),
							'wrapper' => true
						),
						array(
							'title' => __('Callout Box Red', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'background-color' => '#FCB3AE',
								'border' => '1px solid #F73325',
								'border-radius' => '10px',
								'padding' => '10px',
								'width' => 'auto'
								),
							'wrapper' => true
						),
						// Added 7-18-12
						array(
							'title' => __('Callout Box Teal', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'background-color' => '#4FDCF5',
								'border' => '1px solid #0CB4D3',
								'border-radius' => '10px',
								'padding' => '10px',
								'width' => 'auto'
								),
							'wrapper' => true
						),
						array(
							'title' => __('Callout Box Gold', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'background-color' => '#FDBF5D',
								'border' => '1px solid #FDAB2A',
								'border-radius' => '10px',
								'padding' => '10px',
								'width' => 'auto'
								),
							'wrapper' => true
						),
						array(
							'title' => __('Callout Box Purple', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'background-color' => '#C17FAD',
								'border' => '1px solid #813F6D',
								'border-radius' => '10px',
								'padding' => '10px',
								'width' => 'auto'
								),
							'wrapper' => true
						)
					)
				),
				
				array(
					'title' => __('Floating Divs', 'wp_edit_pro'),
					'items' => array( 
					
						array(
							'title' => __('Floating Div Green', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'display' => 'inline-block',
								'width' => 'auto',
								'height' => 'auto',
								'margin' => '10px',
								'padding' => '0px 10px',
								'background' => '#6FE27A',
								'box-shadow' => '0 1px 5px #00A805, inset 0 10px 20px #B7FFC1',
								'-o-box-shadow' => '0 1px 5px #00A805, inset 0 10px 20px #B7FFC1',
								'-webkit-box-shadow' => '0 1px 5px #00A805, inset 0 10px 20px #B7FFC1',
								'-moz-box-shadow' => '0 1px 5px #00A805, inset 0 10px 20px #B7FFC1'
								),
							'wrapper' => true
						),
						array(
							'title' => __('Floating Div Blue', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'display' => 'inline-block',
								'width' => 'auto',
								'height' => 'auto',
								'margin' => '10px',
								'padding' => '0px 10px',
								'background' => '#6fb2e5',
								'box-shadow' => '0 1px 5px #0061aa, inset 0 10px 20px #b6f9ff',
								'-o-box-shadow' => '0 1px 5px #0061aa, inset 0 10px 20px #b6f9ff',
								'-webkit-box-shadow' => '0 1px 5px #0061aa, inset 0 10px 20px #b6f9ff',
								'-moz-box-shadow' => '0 1px 5px #0061aa, inset 0 10px 20px #b6f9ff'
								),
							'wrapper' => true
						),
						array(
							'title' => __('Floating Div Yellow', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'display' => 'inline-block',
								'width' => 'auto',
								'height' => 'auto',
								'margin' => '10px',
								'padding' => '0px 10px',
								'background' => '#E2E26F',
								'box-shadow' => '0 1px 5px #E8E409, inset 0 10px 20px #FFFFB7',
								'-o-box-shadow' => '0 1px 5px #E8E409, inset 0 10px 20px #FFFFB7',
								'-webkit-box-shadow' => '0 1px 5px #E8E409, inset 0 10px 20px #FFFFB7',
								'-moz-box-shadow' => '0 1px 5px #E8E409, inset 0 10px 20px #FFFFB7'
								),
							'wrapper' => true
						),
						array(
							'title' => __('Floating Div Violet', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'display' => 'inline-block',
								'width' => 'auto',
								'height' => 'auto',
								'margin' => '10px',
								'padding' => '0px 10px',
								'background' => '#E16FE2',
								'box-shadow' => '0 1px 5px #C410D1, inset 0 10px 20px #FDB7FF',
								'-o-box-shadow' => '0 1px 5px #C410D1, inset 0 10px 20px #FDB7FF',
								'-webkit-box-shadow' => '0 1px 5px #C410D1, inset 0 10px 20px #FDB7FF',
								'-moz-box-shadow' => '0 1px 5px #C410D1, inset 0 10px 20px #FDB7FF'
								),
							'wrapper' => true
						),
						array(
							'title' => __('Floating Div Red', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'display' => 'inline-block',
								'width' => 'auto',
								'height' => 'auto',
								'margin' => '10px',
								'padding' => '0px 10px',
								'background' => '#E26F76',
								'box-shadow' => '0 1px 5px #A8000B, inset 0 10px 20px #FFB7BD',
								'-o-box-shadow' => '0 1px 5px #A8000B, inset 0 10px 20px #FFB7BD',
								'-webkit-box-shadow' => '0 1px 5px #A8000B, inset 0 10px 20px #FFB7BD',
								'-moz-box-shadow' => '0 1px 5px #A8000B, inset 0 10px 20px #FFB7BD'
								),
							'wrapper' => true
						),
						array(
							'title' => __('Floating Div Glass', 'wp_edit_pro'),
							'block' => 'div',
							'styles' => array(
								'display' => 'inline-block',
								'width' => 'auto',
								'height' => 'auto',
								'margin' => '10px',
								'padding' => '0px 10px',
								'border' => ' 1px solid rgba(0,0,0,0.5)',
								'border-radius' => '10px 10px 2px 2px',
								'background' => ' rgba(0,0,0,0.25)',
								'box-shadow' => '0 2px 6px rgba(0,0,0,0.5), inset 0 1px rgba(255,255,255,0.3), inset 0 10px rgba(255,255,255,0.2), inset 0 10px 20px rgba(255,255,255,0.25), inset 0 -15px 30px rgba(0,0,0,0.3)',
								'-o-box-shadow' => '0 2px 6px rgba(0,0,0,0.5), inset 0 1px rgba(255,255,255,0.3), inset 0 10px rgba(255,255,255,0.2), inset 0 10px 20px rgba(255,255,255,0.25), inset 0 -15px 30px rgba(0,0,0,0.3)',
								'-webkit-box-shadow' => '0 2px 6px rgba(0,0,0,0.5), inset 0 1px rgba(255,255,255,0.3), inset 0 10px rgba(255,255,255,0.2), inset 0 10px 20px rgba(255,255,255,0.25), inset 0 -15px 30px rgba(0,0,0,0.3)',
								'-moz-box-shadow' => '0 2px 6px rgba(0,0,0,0.5), inset 0 1px rgba(255,255,255,0.3), inset 0 10px rgba(255,255,255,0.2), inset 0 10px 20px rgba(255,255,255,0.25), inset 0 -15px 30px rgba(0,0,0,0.3)'
								),
							'wrapper' => true
						)
					)
				),
				
				array(
					'title' => __('Borders', 'wp_edit_pro'),
					'items' => array(
					
						array(
							'title' => __('Single Border', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'border' => '1px solid #000',
								'padding' => '2px 10px',
								'border-radius' => '2px'
								)
						),
						array(
							'title' => __('Double Border', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'border' => 'medium double #000',
								'padding' => '2px 10px',
								'border-radius' => '2px'
								)
						),
						array(
							'title' => __('Top & Bottom Border', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'border' => 'medium',
								'border-top-style' => 'double',
								'border-bottom-style' => 'double',
								'border-top-color' => '#000',
								'border-bottom-color' => '#000'
								)
						),
						array(
							'title' => __('Sngl Rainbow Border', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'border' => '1px solid',
								'padding' => '2px 10px 2px 10px',
								'border-color' => 'red blue green orange'
								)
						),
						array(
							'title' => __('Dbl Rainbow Border', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'border' => 'medium',
								'border-style' => 'double',
								'padding' => '2px 10px 2px 10px',
								'border-color' => 'red blue green orange'
								)
						)
					)
				),
				
				array(
					'title' => __('Opacity', 'wp_edit_pro'),
					'items' => array(
					
						array(
							'title' => __('75% Opacity', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'opacity' => '0.75'
								)
						),
						array(
							'title' => __('50% Opacity', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'opacity' => '0.50'
								)
						),
						array(
							'title' => __('25% Opacity', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'opacity' => '0.25'
								)
						)
					)
				),
				
				array(
					'title' => __('Alignment', 'wp_edit_pro'),
					'items' => array(
					
						array(
							'title' => __('Align Left', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'float' => 'left'
							)
						),
						array(
							'title' => __('Align Right', 'wp_edit_pro'),
							'inline' => 'span',
							'styles' => array(
								'float' => 'right'
							)
						)
					)
				)
			)
		)
	);
}

//*************************************
// END Predefined Styles
//************************************/


//**********************************************
// FINALLY... let's put it all back together
//*********************************************/

// First we have to check for empty arrays (perhaps if user didn't enable a certain option)
$style_formats_custom = isset($style_formats_custom) ? $style_formats_custom : array();
$style_formats_predefined = isset($style_formats_predefined) ? $style_formats_predefined : array();

if(isset($init['style_formats'])) {
			
	$new_array = array();
	$json_decode_orig_settings = json_decode($init['style_formats'], true);
	
	// Check to make sure incoming 'style_formats' is an array
	if(is_array($json_decode_orig_settings)) {
		
		$new_array = json_encode(array_merge($json_decode_orig_settings, $style_formats_custom, $style_formats_predefined));
		$init['style_formats'] = $new_array;
	}
} else {
	
	$init['style_formats'] = json_encode(array_merge($style_formats_custom, $style_formats_predefined));
}

// Merge new styles with old styles
isset($init['style_formats_merge']) ? $init['style_formats_merge'] = true : $init['style_formats_merge'] = true;