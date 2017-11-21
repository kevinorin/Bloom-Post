/**
 *
 *
 * @author Josh Lobe
 * http3://wpeditpro.com
 */
 

jQuery(document).ready(function($) {

	tinymce.PluginManager.add('codemagic', function(editor, url) {
		
		editor.addButton('codemagic', {
			
			image: url + '/images/codemagic.png',
			tooltip: editor.getLang('wpep_langs.codem_title'),
			onclick: open_codemagic
		});
		
		function open_codemagic() {
			
			editor.windowManager.open({
					
				title: editor.getLang('wpep_langs.codem_title'),
				width: 900,
				height: 700,
				url: url+'/codemagic.php'
			})
		}
		
	});
});