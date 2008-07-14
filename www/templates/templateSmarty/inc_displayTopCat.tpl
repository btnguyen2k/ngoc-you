{*******************************************************************************
Parameters:
- CSS_CLASS
- CATEGORY
- NUM_COLUMNS
*******************************************************************************}
<table border="0" width="100%" cellpadding="0" class="{$CSS_CLASS}" cellspacing="0">
<tr>
	<td width="10" class="{$CSS_CLASS}_icon"><img border="0" width="10" src="images/dot_bkground.gif" alt="blank"></td>
	<td class="{$CSS_CLASS}_bg">{$CATEGORY->getName()}</td>
</tr>
<tr>
	<td colspan="2">
		{if $CATEGORY->getNumChildren() === 0}
			<span style="margin: 13px">{$language->getMessage('noData')}</span>
		{else}
			<table border="0" width="100%" cellspacing="0" cellpadding="3">
			{foreach from=$CATEGORY->getChildren() item=child name=children}
				{if $smarty.foreach.children.index % $NUM_COLUMNS === 0}
					{* first column *}
					<tr>
						<td width="4"><img border="0" width="4" src="images/dot_bkground.gif" alt="blank"></td>
						<td class="link_cate" onMouseOver="this.className='link_cate_hover';"
								onMouseOut="this.className='link_cate_out';"
								onclick='location.href="{$child->getUrlView()}";'>
							<img border="0" src="images/bullet2.gif" width="5" height="5"> {$child->getName()}
						</td>
					{if $NUM_COLUMNS < 2}<td width="4"><img border="0" width="4" src="images/dot_bkground.gif" alt="blank"></td></tr>{/if}
				{elseif $smarty.foreach.children.index % $NUM_COLUMNS === $NUM_COLUMNS-1}
					{* last column *}
						<td>&nbsp;</td>
						<td class="link_cate" onMouseOver="this.className='link_cate_hover';"
								onMouseOut="this.className='link_cate_out';"
								onclick='location.href="{$child->getUrlView()}";'>
							<img border="0" src="images/bullet2.gif" width="5" height="5"> {$child->getName()}
						</td>
						<td width="4"><img border="0" width="4" src="images/dot_bkground.gif" alt="blank"></td>
					</tr>
				{else}
					{* mid columns *}
						<td>&nbsp;</td>
						<td class="link_cate" onMouseOver="this.className='link_cate_hover';"
								onMouseOut="this.className='link_cate_out';"
								onclick='location.href="{$child->getUrlView()}";'>
							<img border="0" src="images/bullet2.gif" width="5" height="5"> {$child->getName()}
						</td>
						<td width="4"><img border="0" width="4" src="images/dot_bkground.gif" alt="blank"></td>
				{/if}
			{/foreach}
			{if $CATEGORY->getNumChildren() % $NUM_COLUMNS !== 0}{* special case: last row *}</tr>{/if}
			</table>
		{/if}
	</td>
</tr>
{if $CATEGORY->getNumChildren() > 0}
	<tr>
		<td colspan="2" class="more_portlet">
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<span class="text_orange">{$CATEGORY->getNumEntriesIncChildren()}</span>
					{if $CATEGORY->getNumEntriesIncChildren() > 1}{$language->getMessage('entries')}{else}{$language->getMessage('entry')}{/if}
				</td>
				<td class="cellright cell_xemthem">
					<a class="link_more" href="{$CATEGORY->getUrlView()}">{$language->getMessage('view')}</a>
					<img border="0" src="images/bullet1.gif" width="8" height="7">
				</td>
			</tr>
			</table>
		</td>
	</tr>
{else}
	<tr><td colspan="2"><img border="0" height="4" src="images/dot_bkground.gif" alt="blank"></td></tr>
{/if}
</table>
<br>