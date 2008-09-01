<form method="POST" name="{$page.form->getName()}" action="{$page.form->getAction()}">
	<table border="0" width="100%" cellspacing="3" cellpadding="0" class="table_view">
	<tr>
		<td class="title_form">{$language->getMessage('admin.adsSettings')}</td>
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
    			<td width="40%">{$language->getMessage('admin.adsSetting.expiryDays')}</td>
    			<td width="60%">
    				<input name="adsExpiryDays" value="{$page.form->getField('adsExpiryDays')}" style="width: 440px;" type="text">
    			</td>
    		</tr>
    		<tr>
    			<td width="40%">{$language->getMessage('admin.adsSetting.autoDeleteExpired')}</td>
    			<td width="60%" valign="middle">
    				<input name="autoDeleteExpiredAds" value="1" type="radio" 
    					{if $page.form->getField('autoDeleteExpiredAds') > 0}checked{/if}> {$language->getMessage('yes')}
    				<input name="autoDeleteExpiredAds" value="0" type="radio"
    					{if $page.form->getField('autoDeleteExpiredAds') == 0}checked{/if}> {$language->getMessage('no')}
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
