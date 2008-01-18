<?php
/*
Butter Style
Ref: http://tango.freedesktop.org/Tango_Icon_Theme_Guidelines
BG1: #fce94f (Heavy highlighted title)
BG2: #edd400 (Highlighted title, Heavy highlighted content)
BG3: #c4a000 (Highlighted content)
*/
header("Content-type: text/css");
$color1 = '#fce94f';
$color2 = '#edd400';
$color3 = '#c4a000';

$colorHR = $color1;

$colorLink			= $color3;
$colorLinkVisited	= $color3;
$colorLinkHover		= $color2;

$colorPageMainTitleBg = $color3;
$colorPageMainTitleFg = '#ffffff';

$colorTopLvlCatTitleBg = $color2;
$colorTopLvlCatTitleFg = '#000000';
?> 

HR { height: 1px; color: <?=$colorHR?>; }

A:link { color: <?=$colorLink?>; text-decoration: none; }
A:visited { color: <?=$colorLinkVisited?>; text-decoration: none; }
A:hover { color: <?=$colorLinkHover?>; text-decoration: underline; }

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