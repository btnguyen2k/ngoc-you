<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td class="level1">
		<a class="link_leftmenu_l1" href="{$commonUrls.adminCp}">{$language->getMessage('adminControlPanel')}</a>
	</td>
</tr>
<tr>
	<td class="level2">
		<a class="link_leftmenu_l2" href="{$commonUrls.adminCp}">{$language->getMessage('home')}</a>
	</td>
</tr>
<tr>
	<td class="level2">
		<a class="link_leftmenu_l2" href="{$urlCreator->createUrl('adminEmailSettings')}">{$language->getMessage('admin.emailSettings')}</a>
	</td>
</tr>
<tr>
	<td class="level2">
		<a class="link_leftmenu_l2" href="{$urlCreator->createUrl('adminSiteSettings')}">{$language->getMessage('admin.siteSettings')}</a>
	</td>
</tr>
<tr>
	<td class="level2">
		<a class="link_leftmenu_l2" href="{$urlCreator->createUrl('adminUploadSettings')}">{$language->getMessage('admin.uploadSettings')}</a>
	</td>
</tr>
<tr>
	<td class="level2">
		<a class="link_leftmenu_l2" href="{$urlCreator->createUrl('adminMiscSettings')}">{$language->getMessage('admin.miscSettings')}</a>
	</td>
</tr>
<tr>
	<td class="level1">
		<a class="link_leftmenu_l1" href="{$urlCreator->createUrl('adminCategoryList')}">{$language->getMessage('admin.categoryManagement')}</a>
	</td>
</tr>
<tr>
	<td class="level2">
		<a class="link_leftmenu_l2" href="{$urlCreator->createUrl('adminCategorySettings')}">{$language->getMessage('admin.categorySettings')}</a>
	</td>
</tr>
<tr>
	<td class="level2">
		<a class="link_leftmenu_l2" href="{$urlCreator->createUrl('adminCategoryList')}">{$language->getMessage('admin.categoryList')}</a>
	</td>
</tr>
<tr>
	<td class="level2">
		<a class="link_leftmenu_l2" href="{$urlCreator->createUrl('adminCreateCategory')}">{$language->getMessage('admin.createCategory')}</a>
	</td>
</tr>

<tr>
	<td class="level1">
		<a class="link_leftmenu_l1" href="{$commonUrls.logout}">{$language->getMessage('logout')}</a>
	</td>
</tr>
</table>
