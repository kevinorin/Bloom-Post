/**
 *
 *
 * @author Josh Lobe
 * http://wpeditpro.com
 */

jQuery(document).ready(function($) {


	tinymce.PluginManager.add('advimage', function(editor, url) {
		
		
		editor.addButton('advimage', {
			
			image: url + '/images/advimage.png',
			tooltip: editor.getLang('wpep_langs.advimg_tooltip'),
			onclick: open_advimage,
			onPostRender: function() {
				var ctrl = this;	
		 
				editor.on('click', function(e) {
					
				});
			}

		});
		
		function open_advimage() {
			
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
					
				title: editor.getLang('wpep_langs.advimg_tooltip'),
				width: winW*.6,
				height: winH*.6,
				url: url+'/advimage.php'
			})
		}
		
	});
});