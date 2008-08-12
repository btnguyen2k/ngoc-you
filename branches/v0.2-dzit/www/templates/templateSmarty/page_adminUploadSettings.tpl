<form method="POST" name="{$page.form->getName()}" action="{$page.form->getAction()}">
	<table border="0" width="100%" cellspacing="3" cellpadding="0" class="table_view">
	<tr>
		<td class="title_form">{$language->getMessage('admin.uploadSettings')}</td>
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
    			<td width="40%">{$language->getMessage('admin.uploadSetting.allowedFileTypes')}</td>
    			<td width="60%">
    				<input name="allowedFileTypes" value="{$page.form->getField('allowedFileTypes')}" style="width: 440px;" type="text">
    			</td>
    		</tr>
    		<tr>
    			<td width="40%">{$language->getMessage('admin.uploadSetting.maxFilesPerAds')}</td>
    			<td width="60%">
    				<input name="maxFiles" value="{$page.form->getField('maxFiles')}" style="width: 440px;" type="text">
    			</td>
    		</tr>
    		<tr>
    			<td width="40%">{$language->getMessage('admin.uploadSetting.maxSizePerAds')}</td>
    			<td width="60%">
    				<input name="maxSize" value="{$page.form->getField('maxSize')}" style="width: 440px;" type="text">
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
