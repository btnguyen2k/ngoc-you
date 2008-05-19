<html>
<head>
<base href="http://localhost/ngocyou2/templates/templateSmarty/" />
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
{$config.homeUri}
<table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0">
	<tr>
		<td class="head">
		<table border="0" width="970" id="table2" cellspacing="0" cellpadding="0">
			<tr>
				<td width="42">
				<img border="0" src="images/02.gif" width="108" height="75"></td>
				<td class="headbanner">
				<table border="0" width="230" id="table4" cellspacing="0" cellpadding="0">
					<tr>
						<td class="login_left">&nbsp;</td>
						<td class="login_center">
						<table border="0" width="90%" id="table5" cellspacing="7" cellpadding="0">
							<tr>
								<td>
<input type="text" value="Tài khoản" onfocus="textboxFocus(this, 'Tài khoản');" onblur="textboxBlur(this, 'Tài khoản');" size="13" name="T4"></td>
								<td>
<input type="text" value="Mật khẩu" onfocus="textboxFocus(this, 'Mật khẩu');" onblur="textboxBlur(this, 'Mật khẩu');" size="13" name="T2"></td>
								<td>
								<img border="0" src="images/login_button.gif" width="17" height="17"></td>
							</tr>
							<tr>
								<td colspan="3" class="cellcenter">
								<a class="link_login" href="#">Quên mật khẩu</a> 
								| <a class="link_login" href="#">Đăng ký tài khoản mới</a></td>
							</tr>
						</table>
						</td>
						<td class="login_right">&nbsp;</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td width="42">
				<img border="0" src="images/04.gif" width="108" height="23"></td>
				<td>
				<table border="0" width="468" id="table3" cellspacing="0" cellpadding="0">
					<tr>
						<td class="menu"><a class="link_menu" href="#">trang chủ</a></td>
						<td class="menu_seperate"></td>
						<td class="menu"><a class="link_menu" href="#">trang cá nhân</a></td>
						<td class="menu_seperate"></td>
						<td class="menu"><a class="link_menu" href="#">đăng tin mới</a></td>
						<td class="menu_seperate"></td>
						<td class="menu"><a class="link_menu" href="#">etvee&#39;s blog</a></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class="head1">
		<table border="0" width="970" id="table6" cellspacing="0" cellpadding="0">
			<tr>
				<td class="bg_timkiem">
				<table border="0" width="80%" id="table7" cellspacing="5" cellpadding="0">
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp; </td>
						<td><span class="text_bold text_upper">tìm kiếm</span></td>
						<td><input type="text" name="T3" size="33"></td>
						<td><select size="1" name="D1">
						<option selected>------------ Tất cả ------------
						</option>
						</select></td>
						<td>
						<img border="0" src="images/icon_search.gif" width="16" height="16"></td>
						<td><a href="#">Tìm kiếm nâng cao</a></td>
					</tr>
				</table>
				</td>
				<td class="bg_timkiem cellright">
				<table border="0" width="80%" id="table8" cellspacing="5" cellpadding="0">
					<tr>
						<td><span class="text_normal">Xem tin trên </span><span class="text_bold">64 tỉnh/ thành </span></td>
						<td>
						<img border="0" src="images/b_dropdown.gif" width="15" height="16"></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td class="cellcenter">
		<table border="0" width="970" id="table9" cellspacing="0" cellpadding="0">
			<tr>
				<td class="bg_chude"><span class="text_bold">Chủ đề được tìm kiếm nhiều nhất: </span>
				<a class="link_orange" href="#">Gia sư</a>, <a class="link_orange" href="#">Thiết kế web</a>, <a class="link_orange" href="#">Phát triển phần mềm</a>, <a class="link_orange" href="#">Kỹ sư phần cứng / 
				mạng</a>, <a class="link_orange" href="#">Kế toán/Tài chính</a>, <a class="link_orange" href="#">Thẩm mỹ viện / Spa / Nails, Bảo vệ</a> </td>
			</tr>
		</table>
		</td>
	</tr>
</table>