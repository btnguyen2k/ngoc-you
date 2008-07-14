<table border="0" width="100%" cellspacing="3" cellpadding="0" class="table_view">
<tr>
	<td class="title_form">{$language->getMessage('admin.categoryList')}</td>
</tr>
<tr>
	<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		{foreach from=$page.content.categoryTree item=category}
			{php}
				$this->assign('param0', Array());
				$this->assign('param1', Array('id' => $this->get_template_vars('category')->getId()));
			{/php}
			<tr>
				<td width="68%" class="value1">
					+ {$category->getName()}
				</td>
				<td width="8%" class="value1" align="center">
					<a href="{$urlCreator->createUrl('adminEditCategory', $param0, $param1)}" class="link_orange">{$language->getMessage('edit')}</a>
				</td>
				<td width="8%" class="value1" align="center">
					<a href="{$urlCreator->createUrl('adminDeleteCategory', $param0, $param1)}" class="link_orange">{$language->getMessage('delete')}</a>
				</td>
				<td width="8%" class="value1" align="center">
					<a href="{$urlCreator->createUrl('adminMoveupCategory', $param0, $param1)}" class="link_orange">{$language->getMessage('moveup')}</a>
				</td>
				<td width="8%" class="value1" align="center">
					<a href="{$urlCreator->createUrl('adminMovedownCategory', $param0, $param1)}" class="link_orange">{$language->getMessage('movedown')}</a>
				</td>
			</tr>
			{if $category->getNumChildren() > 0}
				{foreach from=$category->getChildren() item=child}
					{php}
        				$this->assign('param0', Array());
        				$this->assign('param2', Array('id' => $this->get_template_vars('child')->getId()));
        			{/php}
    				<tr>
        				<td width="68%" class="value1">
        					&nbsp;&nbsp;&nbsp;&nbsp;+ {$child->getName()}
        				</td>
        				<td width="8%" class="value1" align="center">
        					<a href="{$urlCreator->createUrl('adminEditCategory', $param0, $param2)}" class="link_orange">{$language->getMessage('edit')}</a>
        				</td>
        				<td width="8%" class="value1" align="center">
        					<a href="{$urlCreator->createUrl('adminDeleteCategory', $param0, $param2)}" class="link_orange">{$language->getMessage('delete')}</a>
        				</td>
        				<td width="8%" class="value1" align="center">
        					<a href="{$urlCreator->createUrl('adminMoveupCategory', $param0, $param2)}" class="link_orange">{$language->getMessage('moveup')}</a>
        				</td>
        				<td width="8%" class="value1" align="center">
        					<a href="{$urlCreator->createUrl('adminMovedownCategory', $param0, $param2)}" class="link_orange">{$language->getMessage('movedown')}</a>
        				</td>
        			</tr>
				{/foreach}
			{/if}
		{/foreach}
		</table>
	</td>
</tr>
</table>
