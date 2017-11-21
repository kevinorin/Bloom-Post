tinymce.PluginManager.add( 'shortcodes', function( editor, url ) {
    
    var this_url = url;
    
    // 
    // Add editor button
    editor.addButton('shortcodes', {
        
        tooltip : 'Shortcodes',
        image : url + '/shortcodes.gif',
        onclick: insert_link
    });
    
    
    // Run onclick function
    function insert_link() {
		
		//
		// Setup form fields
		var form_fields = [
            {
                type: 'container',
                name: 'container',
                html: 'Remember, some shortcodes may need closing tags or other shortcode properties. <br />This list is to be used as a guide; it is not a definitive list of shortcode attributes.<br /><br />'
            },
			{
				type: 'listbox',
				name: 'shortcodes',
				label: 'Select Shortcode',
				'values': wp_edit_pro_shortcodes
			},
			{
                type: 'container',
                name: 'container_wrap_selection',
                html: '<br /><br />This option (when checked) will wrap the currently selected editor content with a closing shortcode tag.<br />If left unchecked, just the shortcode will be inserted without a closing tag.'
            },
			{
				type: 'checkbox',
				name: 'wrap_selection',
				label: 'Wrap Editor Selection'
			}
		];
        
        
        editor.windowManager.open({
			
			onPostRender: function(t) {
				
				//alert('This Works!');
			},
			
			title : 'Shortcodes',
			body: [
				{
					type: 'form',
					items: form_fields
				}
			],
			onsubmit: function (t) {
            
            	shortcode = t.data.shortcodes;
				wrap_selection = t.data.wrap_selection;
				final_shortcode = '';
				
				// Get primary shortcode
                final_shortcode = '['+shortcode+']';
				
				// Wrap selection?
				if(wrap_selection === true) {
					
					get_content = top.tinyMCE.activeEditor.selection.getContent({format: 'text'});
					
					final_shortcode = '['+shortcode+']'+get_content+'[/'+shortcode+']';
				}
            
				editor.execCommand('mceInsertContent', !1, final_shortcode);
        		
			}
        })
    };
});