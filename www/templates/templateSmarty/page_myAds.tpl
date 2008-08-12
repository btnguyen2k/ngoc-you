<table border="0" width="100%" cellspacing="3" cellpadding="0" class="table_view">
<tr>
	<td class="title_form">{$language->getMessage('member.myAds')}</td>
</tr>
<tr>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="3" class="table_list">
		<tr>
			<td class="head_list" width="50%">{$language->getMessage('ads.title')}</td>
			<td class="head_list" width="10%">{$language->getMessage('ads.numViews')}</td>
			<td class="head_list" width="20%">{$language->getMessage('ads.expiry')}</td>
			<td class="head_list" width="20%" colspan="2">{$language->getMessage('action')}</td>
		</tr>
		{foreach from=$page.content.adsList item=ads}
			{cycle assign="tdclass" values="list_row1, list_row2"}
			<tr>
				<td class="{$tdclass}" width="50%" target="_blank"><img border="0" width="8"
					src="{if $ads->hasAttachment()}images/icon_attachment.gif{else}images/bullet1.gif{/if}">
					<a href="{$ads->getUrlView()}">{$ads->getTitle()}</a></td>
				<td class="{$tdclass}" width="10%" align="center">{$ads->getNumViews()}</td>
				<td class="{$tdclass}" width="20%" align="center">{$ads->getExpiryDate()}</td>
				<td class="{$tdclass}" width="10%" align="center"><a href="{$ads->getUrlEdit()}">{$language->getMessage('edit')}</a></td>
				<td class="{$tdclass}" width="10%" align="center"><a href="{$ads->getUrlDelete()}">{$language->getMessage('delete')}</a></td>
			</tr>
		{foreachelse}
			<tr>
				<td class="list_row1" colspan="5">{$language->getMessage('noData')}</td>
			</tr>
		{/foreach}
		</table>
	</td>
</tr>
</table>
