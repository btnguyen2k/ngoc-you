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
{if $page.form->hasErrorMessage()}
	<tr>
		<td class="error" align="center">
			<table border="0" cellpadding="2" cellspacing="0">
			<tr>
				<td class="error">
					{foreach from=$page.form->getErrorMessages() item=msg}
						{$msg}<br>
					{/foreach}
				</td>
			</tr>
			</table>
		</td>
	<tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
{/if}
<tr>
	<td>
		<form method="POST" name="{$page.form->getName()}" action="{$page.form->getAction()}">
			<table border="0" width="100%" cellspacing="0" cellpadding="4" class="table_list">
    		<tr>
    			<td class="head_list">{$language->getMessage('advancedSearch')}</td>
    		</tr>
    		<tr>
				<td class="list_row1" align="center">
					<script language="javascript" type="text/javascript">
                    {literal}
                    function textboxFocus(el, defaultValue) {
                    	if ( defaultValue != null )	{
                    		if ( el.value == defaultValue ) {
                    			el.value = '';
                    		}
                    	}
                    }
                    
                    function textboxBlur(el, defaultValue) {
                    	if ( defaultValue != null )	{
                    		if ( el.value == '' ) {
                    			el.value = defaultValue;
                    		}
                    	}
                    }
                    {/literal}
                    </script>
					<table border="0" cellpadding="4" cellspacing="0">
					<tr>
						<td colspan="2">
							<input type="text" name="q" style="width: 100%" value="{$page.form->getField('q')}">
								<!--
								value="{$language->getMessage('search')}"
								onfocus="textboxFocus(this, '{$language->getMessage('search')}');"
        						onblur="textboxBlur(this, '{$language->getMessage('search')}');"
        						-->
						</td>
					</tr>
					<tr>
						<td>
							Location:
							{include file='inc_displayLocationSelectionList.tpl' FIELD_NAME='l' LOCATIONS=$page.content.locationList SELECTED_VALUE=$page.form->getField('l')}
						</td>
						<td>
							Category:
							<select name="c" size="1">
            					{* we allow 2 levels of category only! *}
            					<option value="0">-----</option>
            					{foreach from=$page.content.categoryTree item=catL1}
        							<optgroup label="{$catL1->getName()}">
        								<option value="{$catL1->getId()}" {if $catL1->getId() == $page.form->getField('c')}selected{/if}>--- {$catL1->getName()} ---</option>
        								{foreach from=$catL1->getChildren() item=catL2}
            								<option value="{$catL2->getId()}" {if $catL2->getId() == $page.form->getField('c')}selected{/if}>{$catL2->getName()}</option>
        								{/foreach}
        							</optgroup>
            					{/foreach}
            				</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right">
							<input type="submit" value="{$language->getMessage('search')}" class="button">
						</td>
					</tr>
					</table>
				</td>
			</tr>
    		</table>
		</form>
		{*
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
				{$page.content.ads->getContentForDisplay()}
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
		*}
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