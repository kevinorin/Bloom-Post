/**
 *
 *
 * @author Josh Lobe
 * http://ultimatetinymcepro.com
 */

jQuery(document).ready(function($) {


	tinymce.PluginManager.add('advlink', function(editor, url) {
		
		
		editor.addButton('advlink', {
			
			image: url + '/images/advlink.png',
			tooltip: editor.getLang('wpep_langs.advlink_tooltip'),
			onclick: open_advlink,
			disabled: true,
			onPostRender: function() {
				var ctrl = this;	
		 
				editor.on('click', function(e) {
					
					// Check editor to see if a selection was made (highlihted text)
					selection = editor.selection.getContent({format : 'text'});
					if(selection != '') {
						ctrl.disabled(false);
						if(editor.selection.getNode().nodeName == 'A') {
							ctrl.active(true);
						}else{
							ctrl.active(false);
						}
					}
					else {
						ctrl.disabled(true);
						ctrl.active(false);
					}
					
					// Check editor nodename to see if we are in an <a> tag
					get_nodename = editor.selection.getNode().nodeName;
					if(get_nodename == 'A' || get_nodename == 'a') {
						ctrl.disabled(false);
						ctrl.active(true);
					}
				});
			}

		});
		
		function open_advlink() {
			
			var winW = 630, winH = 460;
			if (document.body && document.body.offsetWidth) {
				winW = document.body.offsetWidth;
				winH = document.body.offsetHeight;
			}
			if (document.compatMode=='CSS1Compat' &&
				document.documentElement &&
				document.documentElement.offsetWidth ) {
				winW = document.documentElement.offsetWidth;
				winH = document.documentElement.offsetHeight;
			}
			if (window.innerWidth && window.innerHeight) {
				winW = window.innerWidth;
				winH = window.innerHeight;
			}
			
			editor.windowManager.open({
					
				title: editor.getLang('wpep_langs.advlink_tooltip'),
				width: winW*.3,
				height: winH*.75,
				url: url+'/advlink.php'
			}, {
				wpeditpro_ajaxurl: wp_edit_pro_vars.wpeditpro_ajaxurl
			})
		}
		
	});
});