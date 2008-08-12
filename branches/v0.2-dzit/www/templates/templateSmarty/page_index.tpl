{if count($page.content.categoryTree) == 0}
	{$language->getMessage('noData')}
{else}
	{php}
		//split category tree into [firstCat|otherCats]
		/*
		$page = $this->get_template_vars('page');
		$categoryTree = $page['content']['categoryTree'];
		$page['content']['firstCat'] = array_shift($categoryTree);
		$page['content']['otherCats'] = $categoryTree;
		$this->assign('page', $page);
		*/
	{/php}
	
	<!-- scrolling thumbnails -->
	<table border="0" width="100%" cellspacing="0" cellpadding="0" class="table_thumb">
	<tr>
		<td class="thumb_left">&nbsp;</td>
		<td>&nbsp;</td>
		<td class="thumb_right">&nbsp;</td>
	</tr>
	</table>
	
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="celltop">
			<!-- top middle ads banners -->
			<!--
			<table border="0" width="100%" class="xanhla" cellspacing="0" cellpadding="0">
			<tr>
				<td class="celltop">
					<table border="0" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td width="6%">
							<img border="0" src="images/xanhla_icon.gif" width="16" height="19">
						</td>
						<td width="41%" class="xanhla_text">Cộng Đồng</td>
						<td width="7%">&nbsp;</td>
						<td width="45%">&nbsp;</td>
					</tr>
					<tr>
						<td width="6%">&nbsp;</td>
						<td colspan="3">
							<table border="0" width="100%" cellspacing="0" cellpadding="3">
							<tr>
								<td colspan="4">&nbsp;</td>
							</tr>
							<tr>
								<td class="link_cate" onMouseOver="this.className='link_cate_hover';" onMouseOut="this.className='link_cate_out';" onclick='location.href="#";'>
									<img border="0" src="images/bullet2.gif" width="5" height="5"> Tìm bạn trai
								</td>
								<td>&nbsp;</td>
								<td class="link_cate" onMouseOver="this.className='link_cate_hover';" onMouseOut="this.className='link_cate_out';" onclick='location.href="#";'>
									<img border="0" src="images/bullet2.gif" width="5" height="5"> Lost &amp; Found
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class="link_cate" onMouseOver="this.className='link_cate_hover';" onMouseOut="this.className='link_cate_out';" onclick='location.href="#";'>
									<img border="0" src="images/bullet2.gif" width="5" height="5"> Tìm bạn gái
								</td>
								<td>&nbsp;</td>
								<td class="link_cate" onMouseOver="this.className='link_cate_hover';" onMouseOut="this.className='link_cate_out';" onclick='location.href="#";'>
									<img border="0" src="images/bullet2.gif" width="5" height="5"> Các sự kiện
								</td>
								<td>&nbsp;</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td width="6%">&nbsp;</td>
						<td width="41%">&nbsp;</td>
						<td width="7%">&nbsp;</td>
						<td width="45%">&nbsp;</td>
					</tr>
					<tr>
						<td width="6%">&nbsp;</td>
						<td width="41%">
							<img border="0" src="images/banner_clbtinhnguyen.jpg" width="115" height="101">
						</td>
						<td width="7%">&nbsp;</td>
						<td width="45%">
							<img border="0" src="images/banner_clbgame.jpg" width="115" height="101">
						</td>
					</tr>
					</table>
				</td>
				<td class="celltop cellright">
					<table border="0" width="100%" cellspacing="0" cellpadding="5">
					<tr>
						<td>
							<img border="0" src="images/banner_clbbongda.jpg" width="195" height="55">
						</td>
					</tr>
					<tr>
						<td>
							<img border="0" src="images/banner_clbbongro.jpg" width="195" height="55">
						</td>
					</tr>
					<tr>
						<td>
							<img border="0" src="images/banner_clbnghethuat.jpg" width="195" height="55">
						</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
			<br>
			-->
			{foreach from=$page.content.categoryTree item=cat name="topCats"}
				{if $smarty.foreach.topCats.index < $appConfig.NUM_TOP_CATEGORIES}
					{cycle values="cam" assign="tblClass"}
					{include file="inc_displayTopCat.tpl" CATEGORY=$cat CSS_CLASS=$tblClass NUM_COLUMNS=2}
				{/if}
			{/foreach}
		</td>
		<td width="10"><img border="0" width="10" src="images/dot_bkground.gif" alt="blank"></td>
		<td class="celltop">
			{foreach from=$page.content.categoryTree item=cat name="otherCats"}
				{if $smarty.foreach.otherCats.index >= $appConfig.NUM_TOP_CATEGORIES}
					{cycle values="xanhduong, hong, tim" assign="tblClass"}
					{include file="inc_displayTopCat.tpl" CATEGORY=$cat CSS_CLASS=$tblClass NUM_COLUMNS=1}
				{/if}
			{/foreach}
		</td>
	</tr>
	</table>
{/if}