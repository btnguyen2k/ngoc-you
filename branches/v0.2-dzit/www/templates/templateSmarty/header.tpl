<html>
<head>
<base href="{$config.templateUrl}" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{$page.header.title}</title>
<link rel="stylesheet" type="text/css" href="style/style.css">
<script language="javascript" type="text/javascript">
{literal}
function textboxFocus(el, defaultValue) {
	if ( defaultValue != null )	{
		if ( el.value == defaultValue ) {
			el.value = '';
		}
	}
}

function textboxBlur(el, defaultValue) {
	if ( defaultValue != null )	{
		if ( el.value == '' ) {
			el.value = defaultValue;
		}
	}
}
{/literal}
</script>
</head>
<body>
<table border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
<tr>
	<td class="head">
		<table border="0" width="970" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td width="42"><a href="{$commonUrls.home}"><img border="0" src="images/02.gif" width="108" height="75"></a></td>
			<td class="headbanner" align="right">
				{if $currentUser !== NULL}
				{else}
    				<form name="frmLogin" method="POST" action="{$commonUrls.login}">
        				<table border="0" width="230" cellspacing="0" cellpadding="0">
        				<tr>
        					<td class="login_left">&nbsp;</td>
        					<td class="login_center">
        						<table border="0" width="90%" cellspacing="7" cellpadding="0">
        						<tr>
        							<td><input type="text"
        									name="loginName"
        									value="{$language->getMessage('loginName')}"
        									onfocus="textboxFocus(this, '{$language->getMessage('loginName')}');"
        									onblur="textboxBlur(this, '{$language->getMessage('loginName')}');"
        									size="13" name="T4"></td>
        							<td><input type="password"
        									name="password"
        									value="{$language->getMessage('password')}"
        									onfocus="textboxFocus(this, '{$language->getMessage('password')}');"
        									onblur="textboxBlur(this, '{$language->getMessage('password')}');"
        									size="13" name="T2"></td>
        							<td><input type="image" src="images/login_button.gif" style="border: 0px; height: 17px; width: 17px"></td>
        						</tr>
        						<tr>
        							<td colspan="3" class="cellcenter"><a class="link_login"
        								href="{$commonUrls.forgotPassword}">{$language->getMessage('forgotPassword')}</a>
        								| <a class="link_login" href="{$commonUrls.register}">{$language->getMessage('register')}</a></td>
        						</tr>
        						</table>
        					</td>
        					<td class="login_right">&nbsp;</td>
        				</tr>
        				</table>
    				</form>
				{/if}
			</td>
		</tr>
		<tr>
			<td width="42"><img border="0" src="images/04.gif" width="108" height="23"></td>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td class="menu"><a class="link_menu" href="{$commonUrls.home}">{$language->getMessage('home')}</a></td>
					<td class="menu_seperate"></td>
					<td class="menu"><a class="link_menu" href="{$commonUrls.myprofile}">{$language->getMessage('myprofile')}</a></td>
					<td class="menu_seperate"></td>
					<td class="menu"><a class="link_menu" href="{$urlCreator->createUrl('postAds')}">{$language->getMessage('postAds')}</a></td>
					{if $currentUser !== NULL && $currentUser->canAccessAdminCP()}
						<td class="menu_seperate"></td>
						<td class="menu_green"><a class="link_menu" href="{$urlCreator->createUrl('adminCp')}">{$language->getMessage('adminControlPanel')}</a></td>
					{/if}
					<td align="right">
						{if $currentUser !== NULL}
							{$language->getMessage('member.welcome', $currentUser->getFullName())}
							[<a href="{$commonUrls.logout}">{$language->getMessage('logout')}</a>]
						{else}
							&nbsp;
						{/if}
					</td>
					<!--
					<td class="menu_seperate"></td>
					<td class="menu"><a class="link_menu" href="#">etvee&#39;s blog</a></td>
					-->
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td class="head1">
		<table border="0" width="970" cellspacing="0" cellpadding="0" align="center">
		<tr>
				<td class="bg_timkiem">
				<table border="0" width="80%" cellspacing="5"
					cellpadding="0">
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td><span class="text_bold text_upper">tìm kiếm</span></td>
						<td><input type="text" name="T3" size="33"></td>
						<td><select size="1" name="D1">
							<option selected>------------ Tất cả ------------</option>
						</select></td>
						<td><img border="0" src="images/icon_search.gif" width="16"
							height="16"></td>
						<td><a href="#">Tìm kiếm nâng cao</a></td>
					</tr>
				</table>
				</td>
				<td class="bg_timkiem cellright">
				<table border="0" width="80%" cellspacing="5"
					cellpadding="0">
					<tr>
						<td><span class="text_normal">Xem tin trên </span><span
							class="text_bold">64 tỉnh/ thành </span></td>
						<td><img border="0" src="images/b_dropdown.gif" width="15"
							height="16"></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class="cellcenter">
		<table border="0" width="970" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="bg_chude"><span class="text_bold">Chủ đề được tìm kiếm
				nhiều nhất: </span> <a class="link_orange" href="#">Gia sư</a>, <a
					class="link_orange" href="#">Thiết kế web</a>, <a
					class="link_orange" href="#">Phát triển phần mềm</a>, <a
					class="link_orange" href="#">Kỹ sư phần cứng / mạng</a>, <a
					class="link_orange" href="#">Kế toán/Tài chính</a>, <a
					class="link_orange" href="#">Thẩm mỹ viện / Spa / Nails, Bảo vệ</a>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>