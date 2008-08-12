<form method="POST" name="{$page.form->getName()}" action="{$page.form->getAction()}">
	<table border="0" width="100%" cellspacing="3" cellpadding="0" class="table_view">
	<tr>
		<td class="title_form">{$language->getMessage('admin.miscSettings')}</td>
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
    			<td width="40%">{$language->getMessage('admin.miscSetting.dateFormat')}</td>
    			<td width="60%">
    				<input name="dateFormat" value="{$page.form->getField('dateFormat')}" style="width: 440px;" type="text">
    			</td>
    		</tr>
    		<tr>
    			<td width="40%">{$language->getMessage('admin.miscSetting.datetimeFormat')}</td>
    			<td width="60%">
    				<input name="datetimeFormat" value="{$page.form->getField('datetimeFormat')}" style="width: 440px;" type="text">
    			</td>
    		</tr>
    		<tr>
    			<td width="40%">{$language->getMessage('admin.miscSetting.templateUri')}</td>
    			<td width="60%">
    				<input name="templateUri" value="{$page.form->getField('templateUri')}" style="width: 440px;" type="text">
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