/*
FCKConfig.ToolbarSets["Default"] = [
['Source','DocProps','-','Save','NewPage','Preview','-','Templates'],
['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],
'/',
['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
['OrderedList','UnorderedList','-','Outdent','Indent','Blockquote'],
['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
['Link','Unlink','Anchor'],
['Image','Flash','Table','Rule','Smiley','SpecialChar','PageBreak'],
'/',
['Style','FontFormat','FontName','FontSize'],
['TextColor','BGColor'],
['FitWindow','ShowBlocks','-','About'] // No comma for the last row.
] ;

FCKConfig.ToolbarSets["Basic"] = [
['Bold','Italic','-','OrderedList','UnorderedList','-','Link','Unlink','-','About']
] ;
*/
FCKConfig.LinkBrowser  = false;
FCKConfig.ImageBrowser = false;
FCKConfig.FlashBrowser = false;
FCKConfig.LinkUpload   = false;
FCKConfig.ImageUpload  = false;
FCKConfig.FlashUpload  = false;
FCKConfig.DefaultLinkTarget   = '_blank';
FCKConfig.LinkDlgHideTarget   = true;
FCKConfig.LinkDlgHideAdvanced = true;

FCKConfig.AutoDetectLanguage = false;
FCKConfig.DefaultLanguage    = 'vi';

FCKConfig.ToolbarSets['MyFCKToolbar'] = [
	[/*'Style','FontFormat','FontName',*/'FontSize'],
	['Bold','Italic','Underline','StrikeThrough'/*,'-','Subscript','Superscript'*/],
	//'/',
	/*['OrderedList','UnorderedList','-','Outdent','Indent','Blockquote'],*/
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
	['Link','Unlink'/*,'Anchor'*/],
	//['Image',/*'Flash',*/'Table'/*,'Rule','Smiley','SpecialChar','PageBreak'*/],
	['Cut','Copy','Paste','PasteText','PasteWord'/*,'-','Print','SpellCheck'*/],
	['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	['FitWindow','ShowBlocks','Source','-','About']
];
