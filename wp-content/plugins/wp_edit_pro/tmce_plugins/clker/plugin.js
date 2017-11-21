/**
 *
 *
 * @author Josh Lobe
 * http://ultimatetinymcepro.com
 */

jQuery(document).ready(function($) {

	tinymce.PluginManager.add('clker', function(editor, url) {
      

		// Register clker button
		editor.addButton('clker', {
			
			image : url + '/img/clker.png',
			tooltip : editor.getLang('wpep_langs.clker_tooltip'),
			onclick : mceclker
		});
		  
		  
		// Run windowmanager function
		function mceclker() {
			
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
				
				title: editor.getLang('wpep_langs.clker_tooltip'),
				url : url + '/clker.htm',
				width: winW*.5,
				height: winH*.7
		  });
		}
	
	});
});