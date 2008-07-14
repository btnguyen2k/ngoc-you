<table border="0" width="100%" cellspacing="3" cellpadding="0" class="table_view">
<tr>
	<td class="title_form">{$language->getMessage('myprofile')}</td>
</tr>
<tr>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td class="caption">{$language->getMessage('member.userId')}</td>
			<td class="value">{$currentUser->getId()}</td>
			<td class="value1">&nbsp;</td>
		</tr>
		<tr>
			<td class="caption">{$language->getMessage('loginName')}</td>
			<td class="value">{$currentUser->getLoginName()}</td>
			<td class="value1">&nbsp;</td>
		</tr>
		<tr>
			<td class="caption">{$language->getMessage('fullName')}</td>
			<td class="value">{$currentUser->getFullName()}</td>
			<td class="value1"><a href="{$urlCreator->createUrl('changeFullName')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		<tr>
			<td class="caption">{$language->getMessage('email')}</td>
			<td class="value">{$currentUser->getEmail()}</td>
			<td class="value1"><a href="{$urlCreator->createUrl('changeEmail')}" class="link_orange">{$language->getMessage('update')}</a></td>
		</tr>
		</table>
	</td>
</tr>
</table>
