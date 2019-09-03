tinyMCE.init({
			mode : "textareas",
			//elements : "ajaxfilemanager",
			theme : "advanced",
			plugins : "advimage,advlink,media,contextmenu",
			
			elements : "notaPost,notaPost2,notaPost3,notaPost4,notaPost5,notaPost6,notaPost7",
			theme_advanced_buttons1 : "bold,italic,underline,bullist,numlist,undo,redo,link,unlink,justifyleft,justifycenter,justifyright,justifyfull,image,code",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			
			/*theme_advanced_buttons1_add_before : "newdocument,separator",
			theme_advanced_buttons1_add : "fontselect,fontsizeselect",
			theme_advanced_buttons2_add : "separator,forecolor,backcolor,liststyle",
			theme_advanced_buttons2_add_before: "cut,copy,separator,",
			theme_advanced_buttons3_add_before : "",
			theme_advanced_buttons3_add : "media",*/
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			//extended_valid_elements : "hr[class|width|size|noshade]",
			//file_browser_callback : "ajaxfilemanager",
			
			external_image_list_url : "example_image_list.js",
				//flash_external_list_url : "example_flash_list.js",
	file_browser_callback : "fileBrowserCallBack",
			
			paste_use_dialog : false,
			theme_advanced_resizing : true,
			theme_advanced_resize_horizontal : true,
			apply_source_formatting : true,
			force_br_newlines : true,
			force_p_newlines : false,	
			relative_urls : true
		});






/*tinyMCE.init({
	theme : "simple",
	mode : "exact",
	elements : "notaPost,notaPost2,notaPost3,notaPost4,notaPost5,notaPost6,notaPost7",		
	plugins : "table,save,advimage,advlink,emotions,preview,flash,paste,directionality,noneditable",
	theme_advanced_buttons1_add_before : "save,newdocument,separator",
	theme_advanced_buttons1_add : "fontsizeselect",
	theme_advanced_buttons2_add : "separator,preview,separator,forecolor,backcolor",
	theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator",
	theme_advanced_buttons3_add_before : "tablecontrols,separator",
	theme_advanced_buttons3_add : "emotions,flash,separator,ltr,rtl",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	content_css : "include/css/example_full.css",
    extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	external_link_list_url : "example_link_list.js",
	external_image_list_url : "example_image_list.js",
	flash_external_list_url : "example_flash_list.js",
	file_browser_callback : "fileBrowserCallBack",
	theme_advanced_resize_horizontal : false,
	theme_advanced_resizing : true,


valid_elements : ""
//+"a[href|target],"
+"b,"
+"br,"
//+"font[color|face|size],"
//+"img[src|id|width|height|align|hspace|vspace],"
+"i,"
+"li,"
+"p[align|class],"
//+"h1,"
//+"h2,"
//+"h3,"
//+"h4,"
//+"h5,"
//+"h6,"
//+"span[class],"
//+"textformat[blockindent|indent|leading|leftmargin|rightmargin|tabstops],"
+"u"



});*/

function fileBrowserCallBack(field_name, url, type, win) {
	campo = field_name;
	direccion = url;
	tipo = type;
	ventana = win;
	var nuevaVentana = window.open("../../../../../subir-img.php","Imagenes","width=308,height=100,top=100,left=100,menubar=no");
}
