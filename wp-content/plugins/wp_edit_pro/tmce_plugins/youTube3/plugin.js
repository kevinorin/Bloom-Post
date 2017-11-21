/**
 *
 *
 * @author Josh Lobe
 * https://wpeditpro.com
 */
 

jQuery(document).ready(function($) {


	tinymce.PluginManager.add('youTube3', function(editor, url) {
		
		
		editor.addButton('youTube3', {
			
			image: url + '/images/youtube.png',
			tooltip: editor.getLang('wpep_langs.youtube_button_label'),
			onclick: open_youTube
		});
		
		function open_youTube() {
			
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
					
				title: editor.getLang('wpep_langs.youtube_window_label'),
				width: winW*.5,
				height: winH*.85,
				url: url+'/youTube.php'
			})
		}
		
	});
});