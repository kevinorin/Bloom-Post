jQuery(document).ready(function($) {
	
	tinymce.PluginManager.add( 'imgmap', function( ed, url ) {
		
		// Register button
		ed.addButton( 'imgmap', {
			
			image : url + '/images/imgmap.png',
			title: ed.getLang('imgmap.desc'),
			onPostRender: function() { imgmapButton = this; },
			onPostRender: function() {
				
				var ctrl = this;
				
				ctrl.disabled(false);
				ctrl.active(false);
				
				ed.on('NodeChange', function(e) {
					
					if ( e.element.nodeName == "IMG" ) {
						
						node = tinymce.activeEditor.selection != 'undefined' ? tinymce.activeEditor.selection.getNode() : null;
						if (ed.dom.getAttrib( node, 'usemap' ) != '') {
							
							ctrl.disabled( false );
							ctrl.active( true );
						}
						else {
						
							ctrl.disabled( false );
							ctrl.active( false );
						}
					}
					else {
						
						ctrl.disabled( true );
						ctrl.active( false );
					}
				});
			},
			onclick: imgmap_onclick
		});
		
		function imgmap_onclick() {
				
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

			ed.windowManager.open({
				
				title: 'Image Map Editor',
				file : url + '/popup.html',
				width : winW*.8,
				height : winH*.85,
				inline : 1
			}, {
				plugin_url : url
			});
		}
	});
});













/*
(function() {
	
	tinymce.create('tinymce.plugins.imgmapPlugin', {
		
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceimgmapPopup', function() {
				var e = ed.selection.getNode();

				// Internal image object like a flash placeholder
				if (ed.dom.getAttrib(e, 'class').indexOf('mceItem') != -1)
					return;
					
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

				ed.windowManager.open({
					title: 'Image Map Editor',
					file : url + '/popup.html',
					width : winW*.8,
					height : winH*.85,
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('imgmap', {
				title : ed.getLang('imgmap.desc'),
				cmd : 'mceimgmapPopup',
				image : url + '/images/imgmap.png',
				onPostRender: function() {
					
					var ctrl = this;
					
					// Setup node change function; set active and disabled states for each node change
					ed.on('NodeChange', function(e) {
						
						node = tinymce.activeEditor.selection != 'undefined' ? tinymce.activeEditor.selection.getNode() : null;
						
						if (node == null)
							return;
							
						do {
							
							if (node.nodeName == "IMG" &&  ed.dom.getAttrib(node, 'class').indexOf('mceItem') == -1) {
								
								// Node is an image, and already has an image map
								if (ed.dom.getAttrib(node, 'usemap') != '') {
									ctrl.disabled(false);
									ctrl.active(true);
								}
								// Node is an image, but does NOT have an image map
								else {
									ctrl.disabled(false);
									ctrl.active(false);
								}
								return true;
							}
						}
						while ((node = node.parentNode));
						
						// Set button to disabled and not active by default
						ctrl.disabled(true);
						ctrl.active(false);
						return true;
					});
				}
			});
		}
	});

	// Register plugin
	tinymce.PluginManager.add('imgmap', tinymce.plugins.imgmapPlugin);
})();


var TinyMCE_imgmapPlugin = {
	
	execCommand : function(editor_id, element, command, user_interface, value) {
		switch (command) {
			case "mceimgmapPopup":
				var template = new Array();
				template['file']   = 'popup.html';
				template['width']  = 700;
				template['height'] = 670;

				var inst = tinyMCE.getInstanceById(editor_id);
				var elm  = inst.getFocusElement();

				if (elm != null && tinyMCE.getAttrib(elm, 'class').indexOf('mceItem') != -1)
					return true;

				tinyMCE.openWindow(template, {editor_id : editor_id, scrollbars : "yes", resizable: "yes"});
				return true;
		}
		return false;
	},
	handleNodeChange : function(editor_id, node, undo_index, undo_levels, visual_aid, any_selection) {

		if (node == null)
			return;
			
		//check parents
		//if image parent already has imagemap, toggle selected state, if simple image, use normal state
		do {
			console.log(node.nodeName);
			if (node.nodeName == "IMG" && tinyMCE.getAttrib(node, 'class').indexOf('mceItem') == -1) {
				if (tinyMCE.getAttrib(node, 'usemap') != '') {
					tinyMCE.switchClass(editor_id + '_imgmap', 'mceButtonSelected');
				}
				else {
					tinyMCE.switchClass(editor_id + '_imgmap', 'mceButtonNormal');
				}
				return true;
			}
		}
		while ((node = node.parentNode));

		//button disabled by default
		tinyMCE.switchClass(editor_id + '_imgmap', 'mceButtonDisabled');
		return true;
	}
};
*/
