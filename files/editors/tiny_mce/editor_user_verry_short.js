tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	skin : "default",
	plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,|,justifycenter,justifyfull,formatselect,|,link,unlink,image,|,bullist,numlist,|,outdent,indent,blockquote,|,cleanup,removeformat,code,|,preview,fullscreen",
    theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
    editor_selector : "mce_editor",
});