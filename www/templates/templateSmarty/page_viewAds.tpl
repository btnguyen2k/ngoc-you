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
		<table border="0" width="100%" cellspacing="0" cellpadding="4" class="table_list">
		<tr>
			<td class="head_list">{$page.content.ads->getTitle()}</td>
		</tr>
		<tr>
			<td class="list_row2" align="center">
				<small>
					{$language->getMessage('ads.postedBy')}: <b>{$page.content.ads->getPosterName()}</b>
					|
					{$language->getMessage('ads.postDate')}: <b>{$page.content.ads->getPostDate()}</b>
					|
					{$language->getMessage('ads.expiry')}: <b>{$page.content.ads->getExpiryDate()}</b>
				</small>
			</td>
		</tr>
		<tr>
			<td class="list_row1">
				<div id="VietAd">
				{$page.content.ads->getContentForDisplay()}
				</div>
			</td>
		</tr>
		<tr>
			<td class="list_row2" align="center">
				<a href="{$page.content.ads->getUrlReport()}">{$language->getMessage('ads.report')}</a>
				|
				<a href="{$page.content.ads->getUrlContactPoster()}">{$language->getMessage('ads.contactPoster')}</a>
			</td>
		</tr>
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