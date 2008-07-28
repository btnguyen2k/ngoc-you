<table border="0" width="100%" cellspacing="3" cellpadding="0" class="table_view">
<tr>
	<td class="title_form">{$language->getMessage('admin.reportedAds')}</td>
</tr>
<tr>
	<td>
        <table border="0" width="100%" cellspacing="0" cellpadding="2" class="table_list">
		<tr>
			<td class="head_list" width="55%">{$language->getMessage('ads.title')}</td>
			<td class="head_list" width="10%">{$language->getMessage('ads.poster')}</td>
			<td class="head_list" width="20%">{$language->getMessage('ads.postDate')}</td>
			<td class="head_list" width="15%">{$language->getMessage('action')}</td>
		</tr>
        {foreach from=$page.content.reportedAds item=ads}
			{cycle values="list_row1, list_row2" assign="rowStyle"}
			<tr>
				<td class="{$rowStyle}">
					<img border="0" width="8" src="{if $ads->hasAttachment()}images/icon_attachment.gif{else}images/bullet1.gif{/if}">
					<a class="link_entry" href="{$ads->getUrlReviewReported()}">{$ads->getTitle()}</a>
					<br>
					{$language->getMessage('ads.price')}:
					{if $ads->getPrice()==''}{$language->getMessage('ads.price.contact')}
					{elseif $ads->getPrice()<0}{$language->getMessage('ads.price.free')}
					{else}{$ads->getPrice()}{/if}
                    |
                    {$language->getMessage('ads.location')}: {$ads->getLocationStr()}
				</td>
				<td class="{$rowStyle}_center">{$ads->getPosterName()}</td>
				<td class="{$rowStyle}_center">{$ads->getPostDate()}</td>
				<td class="{$rowStyle}_center"><a href="{$ads->getUrlReviewReported()}" class="link_entry">{$language->getMessage('review')}</a></td>
			</tr>
		{foreachelse}
			<tr>
				<td class="list_row1" colspan="4">{$language->getMessage('noData')}</td>
			</tr>
		{/foreach}
		</table>
	</td>
</tr>
</table>
