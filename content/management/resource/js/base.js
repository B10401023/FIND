$(function(){
	var dirname=$("#baseJS").attr("src");
	dirname=dirname.substring(0,dirname.lastIndexOf("/")+1)
	$("ul.nav").find("a[href]").each(function(){ 
		if(window.location.href.indexOf($(this).attr("href"))!=-1){ 
			$(".active-menu").removeClass("active-menu");
			$(this).addClass("active-menu");
		}
	});
	$("ul.nav.nav-tabs").find("a[href]").each(function(){
		if(window.location.hash==$(this).attr("href")){
			$(this).trigger("click");
		}
	});
	$("body").on("click","[data-confirm]",function(){
		return window.confirm($(this).attr("data-confirm"));
	});
	$(".datepicker").attr("readonly",true).datepicker();
	$(".datetimepicker").attr("readonly",true).datetimepicker();
	$("select[data-value]").val(function(){
		return $(this).attr("data-value");
	}).trigger("change");
	$("input[type='radio'],input[type='checkbox']").each(function(){
		if($(this).attr("data-value")==$(this).val()){
			$(this).prop("checked",true).trigger("change");
		}
	});
	tinymce.init({
		selector: 'textarea.editor',
		height: 500,
		language_url: dirname+'tinymce/langs/zh_TW.js',
		plugins: [
			"advlist autolink autosave link image lists print preview hr anchor",
			"searchreplace visualblocks visualchars code fullscreen media",
			"table contextmenu directionality textcolor paste textcolor colorpicker imagetools"
		],
		toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontsizeselect | forecolor backcolor",
		toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media | code preview",
		toolbar3: "table | hr removeformat | subscript superscript | print fullscreen | ltr rtl | visualchars visualblocks",
		image_advtab: true,
		menubar: false,
		toolbar_items_size: 'small',
		convert_urls: false
	});
});