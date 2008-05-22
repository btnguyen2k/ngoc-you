<div align="center">
	<table border="0" width="970" id="table10" cellspacing="0" cellpadding="0">
	<tr>
		<td width="970" class="celltop">&nbsp;</td>
	</tr>
	<tr>
		<td width="970" class="cellcenter">
			<div align="center">
				<form method="POST" action="{$form->getAction()}" name="{$form->getName()}">
    				<table border="0" cellpadding="4" cellspacing="5" id="table30" class="register_form" width="400">
    				<tbody>
    					<tr>
    						<td colspan="3" class="title_form">{$language->getMessage('title.register')}</td>
    					</tr>
    					<!--
    					<tr>
        					<td width="35">&nbsp;</td>
        					<td>&nbsp;</td>
    						<td>&nbsp;</td>
    					</tr>
    					-->

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
    						<td>{$language->getMessage('loginName')}:</td>
    						<td>
    							<input name="loginName" value="{$form->getField('loginName')}" style="width: 160px;" type="text">
    							<span class="mandatory_field">*</span>
    						</td>
    					</tr>
    					<tr>
    						<td width="35">&nbsp;</td>
    						<td>{$language->getMessage('password')}:</td>
    						<td>
    							<input name="password" style="width: 160px;" type="password">
    							<span class="mandatory_field">*</span>
    						</td>
    					</tr>
    					<tr>
    						<td width="35">&nbsp;</td>
    						<td>{$language->getMessage('register.confirmedPassword')}:</td>
    						<td>
    							<input name="confirmedPassword" style="width: 160px;" type="password">
    							<span class="mandatory_field">*</span>
    						</td>
    					</tr>
    					<tr>
    						<td width="35">&nbsp;</td>
    						<td>{$language->getMessage('email')}:</td>
    						<td>
    							<input name="email" value="{$form->getField('email')}" style="width: 160px;" type="text">
    							<span class="mandatory_field">*</span>
    						</td>
    					</tr>
    					<tr>
    						<td width="35">&nbsp;</td>
    						<td>{$language->getMessage('fullName')}:</td>
    						<td>
    							<input name="fullName" value="{$form->getField('fullName')}" style="width: 160px;" type="text">
    						</td>
    					</tr>
    					<tr>
    						<td width="35">&nbsp;</td>
    						<td>&nbsp;</td>
    						<td><img src="images/img_register.jpg" border="0"></td>
    					</tr>
    					<tr>
    						<td width="35">&nbsp;</td>
    						<td>{$language->getMessage('captchaCode')}:</td>
    						<td>
    							<input name="captcha" style="width: 160px;" type="text" value="">
    							<span class="mandatory_field"> *</span>
    						</td>
    					</tr>
    					<tr>
    						<td width="35">&nbsp;</td>
    						<td>&nbsp;</td>
    						<td>&nbsp;</td>
    					</tr>	
    					<tr>
    						<td colspan="3" class="title_form">
    							<input value="Register" type="submit" class="button">&nbsp;&nbsp;&nbsp;&nbsp;
    							<input onclick='location.href="{$form->getCancelAction()}"' value="Cancel" type="button" class="button">
    						</td>
    					</tr>
    				</tbody>
    				</table>
				</form>
			</div>
		</td>
	</tr>
	<tr>
		<td width="970">&nbsp;</td>
	</tr>
	</table>
</div>