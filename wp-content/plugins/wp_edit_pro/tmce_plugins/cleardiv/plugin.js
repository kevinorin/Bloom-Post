/**
 *
 *
 * @author Josh Lobe
 * http://ultimatetinymcepro.com
 */
 

tinymce.PluginManager.add('cleardiv', function(editor, url) {
	
	// Declare variable which will insert clear div image
	var clearHTML = '<img src="' + url + '/images/trans.gif" style="clear:$1;" class="mceClear mceClear$1 mceItemNoResize" title="Clear" />';
	
	// Insert clear div image
	function insertClear(clear) {
		
		html = clearHTML.replace(/\$1/g, clear);
		editor.execCommand('mceInsertContent', false, html);
	};
	
	
	// Add split button dropdown for clear options
	editor.addButton('cleardiv', {
		
		type: 'splitbutton',
		tooltip: editor.getLang('wpep_langs.cdiv_tooltip'),
		image: url + '/images/cleardiv.png',
		menu: 
		[
			{
				text: editor.getLang('wpep_langs.cdiv_cleft'),
				onclick: function() { insertClear('left'); }  // Execute function to clear left
			},
			{
				text: editor.getLang('wpep_langs.cdiv_cright'),
				onclick: function() { insertClear('right'); }  // Execute function to clear right
			},
			{
				text: editor.getLang('wpep_langs.cdiv_cboth'),
				onclick: function() { insertClear('both'); }  // Execute function to clear both
			}
		]
			
	});
	
	
	// Run function on initialization to load css file
	editor.on('init', function() {
		
		editor.dom.loadCSS(url + '/css/clear.css');
	});
	
	// Run function before editor content is set to turn html code back into clear div images
	editor.on('BeforeSetContent', function(e) {
		
		e.content = e.content.replace(/<div clear=" *([^" ]+) *"><\/div>/g, clearHTML);
		e.content = e.content.replace(/<div style="clear: *([^"; ]+) *;?"><\/div>/g, clearHTML);
	});
	
	// Run function on PostProcess to turn clear div images into actual html code
	editor.on('PostProcess', function(e) {
		
		if (e.get) e.content = e.content.replace(/<img[^>]+>/g, function (html) {
			
			if (html.indexOf('class="mceClear') !== -1) {
				
				var m, clear = (m = html.match(/mceClear([a-z]+)/)) ? m[1] : '';
				html = '<div style="clear:' + clear + ';"></div>';
			}
			return html;
		});
	});
	
});