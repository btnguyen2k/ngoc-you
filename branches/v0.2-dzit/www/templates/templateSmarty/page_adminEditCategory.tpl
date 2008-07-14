<form method="POST" name="{$page.form->getName()}" action="{$page.form->getAction()}">
	<table border="0" width="100%" cellspacing="3" cellpadding="0" class="table_view">
	<tr>
		<td class="title_form">{$language->getMessage('admin.editCategory')}</td>
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
	{/if}
    
    <tr>
    	<td>
    		<table border="0" width="100%" cellspacing="0" cellpadding="0">
    		<tr>
    			<td width="40%">{$language->getMessage('category.parent')}</td>
    			<td width="60%">
    				<select name="categoryParentId" size="1">
    					{* we allow 2 levels of category only! *}
    					<option value="0">-----</option>
    					{foreach from=$page.content.categoryTree item=category}
    						{if $category->getId() === $page.form->getField('categoryParentId')}
    							<option selected value="{$category->getId()}">{$category->getName()}</option>
    						{else}
    							<option value="{$category->getId()}">{$category->getName()}</option>
    						{/if}
    					{/foreach}
    				</select>
    			</td>
    		</tr>
    		<tr>
    			<td width="40%">{$language->getMessage('category.name')}</td>
    			<td width="60%">
    				<input name="categoryName" value="{$page.form->getField('categoryName')}" style="width: 440px;" type="text">
    			</td>
    		</tr>
    		<tr>
    			<td width="40%">{$language->getMessage('category.description')}</td>
    			<td width="60%">
    				<textarea name="categoryDescription" style="width: 440px;" rows="8">{$page.form->getField('categoryDescription')}</textarea>
    			</td>
    		</tr>
    		</table>
    	</td>
    </tr>
    <tr>
    	<td class="title_form">
        	<input value="{$language->getMessage('update')}" type="submit" class="button">&nbsp;&nbsp;&nbsp;&nbsp;
        	<input onclick='location.href="{$page.form->getCancelAction()}"' value="{$language->getMessage('cancel')}" type="button" class="button">
        </td>
    </tr>
    </tbody>
    </table>
</form>
