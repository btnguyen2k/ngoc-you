<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
	<td class="level1">
		<a class="link_leftmenu_l1" href="{$commonUrls.myprofile}">{$language->getMessage('myprofile')}</a>
	</td>
</tr>
<tr>
	<td class="level2">
		<a class="link_leftmenu_l2" href="{$urlCreator->createUrl('changeEmail')}">{$language->getMessage('member.changeEmail')}</a>
	</td>
</tr>
<tr>
	<td class="level2">
		<a class="link_leftmenu_l2" href="{$urlCreator->createUrl('changeFullName')}">{$language->getMessage('member.changeFullName')}</a>
	</td>
</tr>
<tr>
	<td class="level2">
		<a class="link_leftmenu_l2" href="{$urlCreator->createUrl('changePassword')}">{$language->getMessage('member.changePassword')}</a>
	</td>
</tr>
<tr>
	<td class="level1">{$language->getMessage('member.adsManagement')}</td>
</tr>
<tr>
	<td class="level2">
		<a class="link_leftmenu_l2" href="{$urlCreator->createUrl('myAds')}">{$language->getMessage('member.myAds')}</a>
	</td>
</tr>
<tr>
	<td class="level2">
		<a class="link_leftmenu_l2" href="{$urlCreator->createUrl('postAds')}">{$language->getMessage('member.postAds')}</a>
	</td>
</tr>
<tr>
	<td class="level1">
		<a class="link_leftmenu_l1" href="{$commonUrls.logout}">{$language->getMessage('logout')}</a>
	</td>
</tr>
</table>