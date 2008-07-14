<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td class="level1">
		<a class="link_leftmenu_l1" href="{$commonUrls.adminCp}">{$language->getMessage('adminControlPanel')}</a>
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