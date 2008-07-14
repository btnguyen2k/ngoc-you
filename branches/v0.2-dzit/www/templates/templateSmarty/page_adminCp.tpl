<table border="0" width="100%" cellspacing="3" cellpadding="0" class="table_view">
<tr>
	<td class="title_form">{$language->getMessage('adminControlPanel')}</td>
</tr>
<tr>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td class="caption">{$language->getMessage('numberUserAccounts')}</td>
			<td class="value">{$page.content.numberUserAccounts}</td>
			<td class="value1">&nbsp;</td>
		</tr>
		<tr>
			<td class="caption">{$language->getMessage('numberCategories')}</td>
			<td class="value">{$page.content.numberCategories}</td>
			<td class="value1"><a href="{$urlCreator->createUrl('adminCategoryList')}" class="link_orange">{$language->getMessage('admin.categoryList')}</a></td>
		</tr>
		<tr>
			<td class="caption">{$language->getMessage('numberAds')}</td>
			<td class="value">{$page.content.numberAds}</td>
			<td class="value1">&nbsp;</td>
		</tr>
		<tr>
			<td class="caption">{$language->getMessage('numberExpiredAds')}</td>
			<td class="value">{$page.content.numberExpiredAds}</td>
			<td class="value1"><a href="{$urlCreator->createUrl('adminDeleteExpiredAds')}" class="link_orange">{$language->getMessage('admin.deleteExpiredAds')}</a></td>
		</tr>
		<tr>
			<td class="caption">{$language->getMessage('numberReportedAds')}</td>
			<td class="value">{$page.content.numberReportedAds}</td>
			<td class="value1"><a href="{$urlCreator->createUrl('adminViewReportedAds')}" class="link_orange">{$language->getMessage('admin.viewReportedAds')}</a></td>
		</tr>
		</table>
	</td>
</tr>
</table>
