
jQuery(document).ready(function($) {
	
	tinymce.PluginManager.add('advhr', function(editor, url) {
	
		
		// Register buttons
		editor.addButton('advhr', {
			image: url + '/images/advhr.png',
			tooltip : editor.getLang('wpep_langs.advhr_tooltip'),
			onclick : open_advhr
		});
		
		function open_advhr() {
			
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
					
				title: editor.getLang('wpep_langs.advhr_tooltip'),
				width: winW*.2,
				height: winH*.3,
				url: url+'/advhr.php'
			})
			
		}
		
	});
});