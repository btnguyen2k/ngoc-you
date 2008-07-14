<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
	<td>
		<form>
			<script language="javascript" type="text/javascript">
			{literal}
			function changeMainCat(sel) {
				location.href = sel.options[sel.selectedIndex].value;
			}
			
			function changeSubCat(selSub, selMain) {
				var url;
				url = selSub.options[selSub.selectedIndex].value;
				if ( url == "" ) {
					url = selMain.options[selMain.selectedIndex].value;
				}
				location.href = url;
			}
			{/literal}
			</script>
			<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>{$language->getMessage('category')}</td>
				<td class="cell_space">&nbsp;</td>
				<!-- <td class="cell_cate1 cellright"> -->
				<td>
					<select name="selMainCat" onchange="changeMainCat(this);">
						{foreach from=$page.content.categoryTree item=category}
							<option value="{$category->getUrlView()}"
								{if $category->getId()==$page.content.category->getId()
									|| $category->getId()==$page.content.category->getParentId()}selected{/if}>{$category->getName()}</option>
    					{/foreach}
    				</select>
    				<!--
    				<img border="0" src="images/icon_drop1.gif" width="15" height="14">
    				-->
    			</td>
    			<td class="cell_space">&nbsp;</td>
    			<td width="9">
    				<img border="0" src="images/icon_arrow.gif" width="9" height="5">
    			</td>
    			<td class="cell_space">&nbsp;</td>
    			<!-- <td class="cell_cate2 cellright"> -->
    			<td>
    				<select name="selSubCat" onchange="changeSubCat(this, this.form.selMainCat);">
    					<option value="">-----</option>
    					{foreach from=$page.content.subCatList item=subCat}
							<option value="{$subCat->getUrlView()}"
								{if $subCat->getId()==$page.content.category->getId()}selected{/if}>{$subCat->getName()}</option>
    					{/foreach}
    				</select>
    				<!-- 
    				<img border="0" src="images/icon_drop2.gif" width="15" height="14">
    				-->
    			</td>
    		</tr>
    		</table>
		</form>
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
		Page: {$page.content.pageNum}
		<!--  
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				Xem
				<select size="1" name="D3">
					<option selected>15</option>
					<option>20</option>
					<option>25</option>
					<option>30</option>
				</select>
				tin
			</td>
			<td class="cellright">
				<table border="0" width="45%" cellspacing="0" cellpadding="2">
				<tr>
					<td>
						<img border="0" src="images/b_pageprevious_invi.gif" width="17" height="17">
					</td>
					<td>Trang</td>
					<td>
						<input type="text" name="T6" size="3" class="input_page" value="1">
					</td>
					<td>của tổng cộng <span class="text_orange">100</span> trang</td>
					<td>
						<img border="0" src="images/b_pagenext.gif" width="17" height="17"></td>
					</tr>
				</table>
			</td>
		</tr>
		</table>
		-->
	</td>
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
		{foreach from=$page.content.adsList item=ads}
			{cycle values="list_row1, list_row2" assign="rowStyle"}
			<tr>
				<td class="{$rowStyle}">
					<img border="0" src="images/bullet1.gif" width="8" height="7">
					<a class="link_entry" href="{$ads->getUrlView()}">{$ads->getTitle()}</a>
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
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
		Page: {$page.content.pageNum}
		<!--  
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				Xem
				<select size="1" name="D3">
					<option selected>15</option>
					<option>20</option>
					<option>25</option>
					<option>30</option>
				</select>
				tin
			</td>
			<td class="cellright">
				<table border="0" width="45%" cellspacing="0" cellpadding="2">
				<tr>
					<td>
						<img border="0" src="images/b_pageprevious_invi.gif" width="17" height="17">
					</td>
					<td>Trang</td>
					<td>
						<input type="text" name="T6" size="3" class="input_page" value="1">
					</td>
					<td>của tổng cộng <span class="text_orange">100</span> trang</td>
					<td>
						<img border="0" src="images/b_pagenext.gif" width="17" height="17"></td>
					</tr>
				</table>
			</td>
		</tr>
		</table>
		-->
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
				{foreach from=$page.content.subCatList item=subCat name=subCats}
					{if $smarty.foreach.subCats.index % $numCols === 0}
						<tr>
					{/if}
						<td width="{$colWidth}%">
							{if $page.content.category->getId() == $subCat->getId()}
								<span class="text_orange">{$subCat->getName()}
								{if $subCat->getNumEntries() > 0}[{$subCat->getNumEntries()}]{/if}</span>
							{else}
								<a class="link_cate_bottom" href="{$subCat->getUrlView()}">{$subCat->getName()}
								{if $subCat->getNumEntries() > 0}[{$subCat->getNumEntries()}]{/if}</a>
							{/if}
    					</td>
					{if $smarty.foreach.children.index % $numCols === $numCols-1}
						</tr>
					{/if}
				{/foreach}
				<tr>
					<td colspan="{$numCols}">&nbsp;</td>
				</tr>
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