/**
 *
 *
 * @author Josh Lobe
 * http://ultimatetinymcepro.com
 */
 

jQuery(document).ready(function($) {


	tinymce.PluginManager.add('flickrImages', function(editor, url) {
		
		
		editor.addButton('flickrImages', {
			
			image: url + '/images/flickrImages.png',
			tooltip: editor.getLang('wpep_langs.flickr_button_label'),
			onclick: open_flickrImages
		});
		
		function open_flickrImages() {
			
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
					
				title: editor.getLang('wpep_langs.flickr_button_label'),
				width: winW*.8,
				height: winH*.8,
				url: url+'/flickrImages.php'
			},
			{
				wpeditpro_tinymce_jquery_url: wp_edit_pro_vars.wpeditpro_tinymce_jquery_url  // Taken from global var set in main.php for after_wp_tiny_mce() filter
			})
		}
		
	});
});