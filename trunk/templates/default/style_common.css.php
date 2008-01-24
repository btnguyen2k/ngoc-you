BODY { font-family: Arial; font-size: 12px; margin: 4px; }

FORM { margin: 0px; }

TD { font-size: 12px; }

SELECT { font-size: 11px; }

HR { height: 1px; color: <?=$colorHR?>; }

A:link { color: <?=$colorLink?>; text-decoration: none; }
A:visited { color: <?=$colorLinkVisited?>; text-decoration: none; }
A:hover { color: <?=$colorLinkHover?>; text-decoration: underline; }
.catList A:link { color: #000000; text-decoration: underline; }
.catList A:visited { color: #000000; text-decoration: underline; }
.catList A:hover { color: <?=$colorLink?>; text-decoration: none; }

.pageMainTitle {
	font-weight: bold;
	font-size: 18px;
	background: <?=$colorPageMainTitleBg?>; 
	color: <?=$colorPageMainTitleFg?>;
}

.topLvlCatTitle {
	font-weight: bold;
	font-size: 14px;
	background: <?=$colorTopLvlCatTitleBg?>; 
	color: <?=$colorTopLvlCatTitleFg?>;
}

table.tblList th {
	color: #000000;
	background: <?=$colorTableHeaderBg?>;
	border: 1px solid <?=$colorTableBorder?>;
	font-size: 12px;
}

table.tblList td {
	color: #000000;
	border: 1px solid <?=$colorTableBorder?>;
	font-size: 12px;
}

table.tblList td a:link {
	text-decoration: underline;
}
table.tblList td a:hover {
	text-decoration: none;
}


.column_left { width: 200px; margin-right: 8px; }
.column_right { width: 200px; margin-left: 8px; }

.blank_separator { margin-top: 8px; }

.errorMessage { color: #FF0000; font-weight: bold; }
.warningMessage { color: #009010; font-weight: bold; }
.infoMessage { color: #009010; font-weight: bold; }

.textbox_disabled {
	color: #000000; background-color: #F0F0F0;
	border: 1px solid #808080; padding: 1px 2px 1px 2px; 
	font-size: 11px;
}
.textbox_blue { border: 1px solid #86AAD0; padding: 1px 2px 1px 2px; font-size: 11px; }
.textbox_orange { border: 1px solid #EA7A00; padding: 1px 2px 1px 2px; font-size: 11px; }
.button_small {
	height: 16px; padding: 0px 8px 0px 8px;
	border: 1px solid #808080; background-color: #F0F0F0;
	font-family: Verdana; font-size :11px; color: #000000;
}
.button { font-size: 11px; }
.button_default { font-size: 11px; font-weight: bold; }

.contentCell_1 { color:#000000; border:1px solid #C0C0C0; font-size:12px; }
.contentCell_2 {
	color: #000000; background-color: #F0F0F0;
	border: 1px solid #C0C0C0; font-size: 12px
}
.contentCell_1 A:link { color:#000000; text-decoration: underline; }
.contentCell_1 A:visited { color:#000000; text-decoration: underline; }
.contentCell_1 A:hover { color:#FF0000; text-decoration: none; }
.contentCell_2 A:link { color:#000000; text-decoration: underline; }
.contentCell_2 A:visited { color:#000000; text-decoration: underline; }
.contentCell_2 A:hover { color:#FF0000; text-decoration: none; }