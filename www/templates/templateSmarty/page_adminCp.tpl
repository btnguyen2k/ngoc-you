<table border="0" width="100%" cellspacing="3" cellpadding="0" class="table_view">
<tr>
	<td class="title_form">{$language->getMessage('admin.adsSummary')}</td>
</tr>
<tr>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<!--
		<tr>
			<td class="caption" width="40%">{$language->getMessage('numberUserAccounts')}</td>
			<td class="value" width="30%">{$page.content.numberUserAccounts}</td>
			<td class="value1" width="30%">&nbsp;</td>
		</tr>
		-->
		<tr>
			<td class="caption" width="40%">{$language->getMessage('numberCategories')}</td>
			<td class="value" width="30%">{$page.content.numberCategories}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminCategoryList')}" class="link_orange">{$language->getMessage('admin.categoryList')}</a></td>
		</tr>
		<tr>
			<td class="caption" width="40%">{$language->getMessage('numberAds')}</td>
			<td class="value" width="30%">{$page.content.numberAds}</td>
			<td class="value1" width="30%">&nbsp;</td>
		</tr>
		<tr>
			<td class="caption" width="40%">{$language->getMessage('numberExpiredAds')}</td>
			<td class="value" width="30%">{$page.content.numberExpiredAds}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminDeleteExpiredAds')}" class="link_orange">{$language->getMessage('admin.deleteExpiredAds')}</a></td>
		</tr>
		<tr>
			<td class="caption" width="40%">{$language->getMessage('numberReportedAds')}</td>
			<td class="value" width="30%">{$page.content.numberReportedAds}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminViewReportedAds')}" class="link_orange">{$language->getMessage('admin.viewReportedAds')}</a></td>
		</tr>
		<tr>
			<td class="caption" width="40%">{$language->getMessage('admin.categorySetting.numTopCategories')}</td>
			<td class="value" width="30%">{$appConfig.NUM_TOP_CATEGORIES}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminCategorySettings')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="title_form">{$language->getMessage('admin.emailSettings')}</td>
</tr>
<tr>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td class="caption" width="40%">{$language->getMessage('admin.emailSetting.outgoing')}</td>
			<td class="value" width="30%">{$appConfig.EMAIL_OUTGOING}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminEmailSettings')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		<tr>
			<td class="caption" width="40%">{$language->getMessage('admin.emailSetting.administrator')}</td>
			<td class="value" width="30%">{$appConfig.EMAIL_ADMINISTRATOR}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminEmailSettings')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="title_form">{$language->getMessage('admin.siteSettings')}</td>
</tr>
<tr>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td class="caption" width="40%">{$language->getMessage('admin.siteSetting.name')}</td>
			<td class="value" width="30%">{$appConfig.SITE_NAME}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminSiteSettings')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		<tr>
			<td class="caption" width="40%">{$language->getMessage('admin.siteSetting.title')}</td>
			<td class="value" width="30%">{$appConfig.SITE_TITLE}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminSiteSettings')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		<tr>
			<td class="caption" width="40%">{$language->getMessage('admin.siteSetting.description')}</td>
			<td class="value" width="30%">{$appConfig.SITE_DESCRIPTION}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminSiteSettings')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		<tr>
			<td class="caption" width="40%">{$language->getMessage('admin.siteSetting.keywords')}</td>
			<td class="value" width="30%">{$appConfig.SITE_KEYWORDS}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminSiteSettings')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="title_form">{$language->getMessage('admin.uploadSettings')}</td>
</tr>
<tr>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td class="caption" width="40%">{$language->getMessage('admin.uploadSetting.allowedFileTypes')}</td>
			<td class="value" width="30%">{$appConfig.ALLOWED_UPLOAD_FILE_TYPES}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminUploadSettings')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		<tr>
			<td class="caption" width="40%">{$language->getMessage('admin.uploadSetting.maxFilesPerAds')}</td>
			<td class="value" width="30%">{$appConfig.MAX_UPLOAD_FILES}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminUploadSettings')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		<tr>
			<td class="caption" width="40%">{$language->getMessage('admin.uploadSetting.maxSizePerAds')}</td>
			<td class="value" width="30%">{$appConfig.MAX_UPLOAD_SIZE}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminUploadSettings')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="title_form">{$language->getMessage('admin.miscSettings')}</td>
</tr>
<tr>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td class="caption" width="40%">{$language->getMessage('admin.miscSetting.dateFormat')}</td>
			<td class="value" width="30%">{$appConfig.DATE_FORMAT}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminMiscSettings')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		<tr>
			<td class="caption" width="40%">{$language->getMessage('admin.miscSetting.datetimeFormat')}</td>
			<td class="value" width="30%">{$appConfig.DATETIME_FORMAT}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminMiscSettings')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		<tr>
			<td class="caption" width="40%">{$language->getMessage('admin.miscSetting.templateUri')}</td>
			<td class="value" width="30%">{$appConfig.TEMPLATE_URI}</td>
			<td class="value1" width="30%"><a href="{$urlCreator->createUrl('adminMiscSettings')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		</table>
	</td>
</tr>
</table>
