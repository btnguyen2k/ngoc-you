<form method="POST" name="{$page.form->getName()}" action="{$page.form->getAction()}">
	<table border="0" width="100%" cellspacing="3" cellpadding="0" class="table_view">
	<tr>
		<td class="title_form">{$language->getMessage('admin.customPageContentSettings')}</td>
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
    			<td width="30%">{$language->getMessage('admin.customPageContentSetting.left')}</td>
    			<td width="70%">
    				<textarea style="width: 100%; height: 64px" name="left">{$page.form->getField('left')|escape}</textarea>
    			</td>
    		</tr>
    		<tr>
    			<td width="30%">{$language->getMessage('admin.customPageContentSetting.top')}</td>
    			<td width="70%">
    				<textarea style="width: 100%; height: 64px" name="top">{$page.form->getField('top')|escape}</textarea>
    			</td>
    		</tr>
    		<tr>
    			<td width="30%">{$language->getMessage('admin.customPageContentSetting.bottom')}</td>
    			<td width="70%">
    				<textarea style="width: 100%; height: 64px" name="bottom">{$page.form->getField('bottom')|escape}</textarea>
    			</td>
    		</tr>
    		<tr>
    			<td width="30%">{$language->getMessage('admin.customPageContentSetting.right')}</td>
    			<td width="70%">
    				<textarea style="width: 100%; height: 64px" name="right">{$page.form->getField('right')|escape}</textarea>
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
