<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
	<td>
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				{foreach from=$page.content.navigator item=nav name=navigator}
					{if !$smarty.foreach.navigator.first}
						&nbsp;<img border="0" src="images/icon_arrow.gif" width="9" height="5">&nbsp;
					{/if}
					{if $nav->hasUrl()}<a class="link_orange" href="{$nav->getUrl()}"><b>{/if}
					{$nav->getLabel()}
					{if $nav->hasUrl()}</b></a>{/if}
				{/foreach}
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td class="cell_dotted">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="2" class="table_list">
		<tr>
			<td class="head_list" width="55%">{$language->getMessage('ads.title')}</td>
			<td class="head_list" width="20%">{$language->getMessage('ads.location')}</td>
			<td class="head_list" width="10%">{$language->getMessage('ads.numViews')}</td>
			<td class="head_list" width="15%">{$language->getMessage('ads.postDate')}</td>
		</tr>
		{foreach from=$page.content.searchResult->getAdsList() item=ads}
			{cycle values="list_row1, list_row2" assign="rowStyle"}
			<tr>
				<td class="{$rowStyle}">
					<img border="0" width="8" src="{if $ads->hasAttachment()}images/icon_attachment.gif{else}images/bullet1.gif{/if}">
					<a class="link_entry" href="{$ads->getUrlView()}">{$ads->getTitle()}</a>
					<br>
					{$language->getMessage('ads.price')}:
					{if $ads->getPrice()==''}{$language->getMessage('ads.price.contact')}
					{elseif $ads->getPrice()<0}{$language->getMessage('ads.price.free')}
					{else}{$ads->getPrice()}{/if}
				</td>
				<td class="{$rowStyle}_center">{if $ads->getLocationStr()!=''}{$ads->getLocationStr()}{else}&nbsp;{/if}</td>
				<td class="{$rowStyle}_center">{$ads->getNumViews()}</td>
				<td class="{$rowStyle}_center">{$ads->getPostDate()}</td>
			</tr>
		{foreachelse}
			<tr>
				<td class="list_row1" colspan="4">{$language->getMessage('noData')}</td>
			</tr>
		{/foreach}
		</table>
	</td>
</tr>
<tr>
	<td>&nbsp;<br>&nbsp;</td>
</tr>
<tr>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0" class="cate_bottom">
		<tr>
			<td class="cellcenter">
				{php}
					$this->assign('numCols', 4);
					$this->assign('colWidth', 100/$this->get_template_vars('numCols'));
				{/php}
				<table border="0" width="95%" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td class="cellcenter cate_orange" colspan="{$numCols}">
						{foreach from=$page.content.categoryTree item=cat name=mainCats}
							{if !$smarty.foreach.mainCats.first}&nbsp; &nbsp{/if}
							<a class="link_cate_orange" href="{$cat->getUrlView()}">{$cat->getName()}</a>
							{if !$smarty.foreach.mainCats.last}&nbsp; &nbsp|{/if}
						{/foreach}
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>