tinymce.PluginManager.add('mailto', function(editor, url) {
	
	editor.addButton( 'mailto', {
		
		image: url+'/mailto.gif',
		tooltip: 'Insert MailTo Link',
		onclick: open_window
	});
	
	function open_window() {
		
		// Check if we are in an "a" tag... and populate window
		get_node = editor.selection.getNode();
		
		// If we are inside an a tab (necessary for mailto elements)
		if(get_node.nodeName === 'A' || get_node.nodeName === 'a') {
			
			// Get node 'href' value
			href = get_node.getAttribute('href');
			
			// Split string at "?"
			href = href.split('?');
			
			// First half contains "mailto:whoever@whoever.com.... so need to split again
			form_to = href[0].split(':');
			
			// Set 'to' field for popup window
			var form_to = form_to[1];
			
			// Next, process second half of 'href' which contains "cc=support@wpeditpro.com&bcc=joshlobe@insightbb.com&subject=TESTING AGAIN"
			// Results with "cc=support@wpeditpro.com", "bcc=joshlobe@insightbb.com", "subject=TESTING AGAIN"
			fields = href[1].split('&');
			
			for(i=0; i<fields.length; i++) {
				
				// Check for "cc=" string
				if(fields[i].substring(0, 3) == 'cc=') {
					
					var form_cc = fields[i].replace('cc=', '');
				}
				
				// Check for "bcc=" string
				if(fields[i].substring(0, 4) == 'bcc=') {
					
					var form_bcc = fields[i].replace('bcc=', '');
				}
				
				// Check for "subject=" string
				if(fields[i].substring(0, 8) == 'subject=') {
					
					var form_subject = fields[i].replace('subject=', '');
				}
			}
			
			// Set 'link text' field
			if(editor.selection.getContent() == '') {
				link_text = get_node.innerHTML;
			}
			else{
				link_text = editor.selection.getContent();
			}
		}
		else {
				
			link_text = editor.selection.getContent();
		}
		
		// Open main window
		editor.windowManager.open({
			
			'title': 'Insert MailTo Link',
			body: [{
				type: 'form',
				items: [{
					type: 'textbox',
					name: 'link_text',
					label: 'Link Text:',
					value: link_text
				},
				{
					type: 'textbox',
					name: 'to',
					label: 'To:',
					value: form_to
				},
				{
					type: 'textbox',
					name: 'cc',
					label: 'Cc:',
					value: form_cc
				},
				{
					type: 'textbox',
					name: 'bcc',
					label: 'Bcc:',
					value: form_bcc
				},
				{
					type: 'textbox',
					name: 'subject',
					label: 'Subject',
					value: form_subject
				}]
			}],
			onsubmit: function(t) {
				
				// Check link text not empty
				if(t.data.link_text === '') {
					
					t.preventDefault();
					editor.windowManager.alert('The "Link Text" field must not be empty');
					return;
				}
				// Check to not empty
				else if(t.data.to === '') {
					
					t.preventDefault();
					editor.windowManager.alert('The "To" field must not be empty');
					return;
				}
				
				// Build link to send back to editor
				final_link = '<a href="mailto:'+t.data.to+'?';
				
				if(t.data.cc != '') {
					
					final_link += 'cc='+t.data.cc+'&';
				}
				if(t.data.bcc != '') {
					
					final_link += 'bcc='+t.data.bcc+'&';
				}
				if(t.data.subject != '') {
					
					final_link += 'subject='+t.data.subject+'&';
				}
				
				// Remove last character from final link
				final_link = final_link.slice(0, -1);
				
				// Finish building final link
				final_link += '">'+t.data.link_text+'</a>';
				
				// Send final link back to editor
				editor.execCommand('mceInsertContent', !1, final_link);
			}
		});
	};
});