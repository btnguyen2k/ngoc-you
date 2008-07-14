<form name="{$form->getName()}" action="{$form->getAction()}" method="POST">
    <table border="0" cellpadding="4" cellspacing="5" class="register_form" width="100%">
    <tbody>
    	<tr>
    		<td colspan="3" class="title_form">{$language->getMessage('title.changeEmail')}</td>
    	</tr>
    	
    	{if $form->hasErrorMessage()}
			<tr>
				<td width="35">&nbsp;</td>
				<td colspan="2" class="error" align="center">
					<table border="0" cellpadding="2" cellspacing="0">
					<tr><td class="error">
						{foreach from=$form->getErrorMessages() item=msg}
							{$msg}<br>
						{/foreach}
					</td></tr>
					</table>
				</td>
			<tr>
    	{/if}
    	
    	<tr>
    		<td width="35">&nbsp;</td>
    		<td>{$language->getMessage('email')}</td>
    		<td><span class="bold">{$currentUser->getEmail()}</span></td>
    	</tr>
    	<tr>
    		<td width="35">&nbsp;</td>
    		<td>{$language->getMessage('member.currentPassword')}:</td>
    		<td><input name="password" style="width: 160px;" type="password"></td>
    	</tr>
    	<tr>
    		<td width="35">&nbsp;</td>
    		<td>{$language->getMessage('member.newEmail')}:</td>
    		<td><input name="newEmail" value="{$form->getField('newEmail')}" style="width: 160px;" type="text"></td>
    	</tr>
    	<tr>
    		<td width="35">&nbsp;</td>
    		<td>{$language->getMessage('member.confirmedNewEmail')}:</td>
    		<td><input name="confirmedNewEmail" value="{$form->getField('confirmedNewEmail')}" style="width: 160px;" type="text"></td>
    	</tr>
    	<tr>
    		<td colspan="3" class="title_form">
    			<input value="{$language->getMessage('update')}" type="submit" class="button">&nbsp;&nbsp;&nbsp;&nbsp;
    			<input onclick='location.href="{$form->getCancelAction()}"' value="{$language->getMessage('cancel')}" type="button" class="button"></td>
    	</tr>	
    </tbody>
    </table>
 </form>