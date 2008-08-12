<form method="POST" name="{$page.form->getName()}" action="{$page.form->getAction()}" enctype="multipart/form-data">
	<input type="hidden" name="html" value="0">
	<table border="0" width="100%" cellspacing="3" cellpadding="0" class="table_view">
	<tr>
		<td class="title_form">{$language->getMessage('ads.edit')}</td>
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
    		<table border="0" width="100%" cellspacing="1" cellpadding="4">
    		<tr>
    			<td width="30%" valign="top">{$language->getMessage('ads.category')}</td>
    			<td width="70%">
    				<select name="categoryId" size="1">
    					{* we allow 2 levels of category only! *}
    					<option value="0">-----</option>
    					{foreach from=$page.content.categoryTree item=catL1}
							<optgroup label="{$catL1->getName()}">
								{foreach from=$catL1->getChildren() item=catL2}
									{if $catL2->getId() === $page.form->getField('categoryId')}
		    							<option selected value="{$catL2->getId()}">{$catL2->getName()}</option>
		    						{else}
    									<option value="{$catL2->getId()}">{$catL2->getName()}</option>
    								{/if}
								{/foreach}
							</optgroup>
    					{/foreach}
    				</select>
    			</td>
    		</tr
    		<tr>
    			<td width="30%" valign="top">&nbsp;</td>
    			<td>
    				{$language->getMessage('ads.type')}:
    				<input class="radio" type="radio" name="adsType" value="0"
    					{if $page.form->getField('adsType')===0}checked{/if}> {$language->getMessage('ads.type.sell')}
    				<input class="radio" type="radio" name="adsType" value="1"
    					{if $page.form->getField('adsType')===1}checked{/if}> {$language->getMessage('ads.type.buy')}
    				<span style="border-left: 1px solid #000000; height: 100%;">&nbsp;</span>
    				{$language->getMessage('ads.price')}:
    				{literal}
        				<script language="javascript" type="text/javascript">
    					function selectPrice(formEl) {
    						if ( formEl.selectedIndex === 0 ) {
    							//contact
    							formEl.form.adsPrice.readOnly=true;
    							formEl.form.adsPrice.className='readonly';
    							formEl.form.adsPrice.value='';
    						} else if ( formEl.selectedIndex === 1 ) {
    							//free
    							formEl.form.adsPrice.readOnly=true;
    							formEl.form.adsPrice.className='readonly';
    							formEl.form.adsPrice.value='0';
    						} else {
    							//specify
    							formEl.form.adsPrice.readOnly=false;
    							formEl.form.adsPrice.className='';
    							formEl.form.adsPrice.value='0';
    						}
    					}
    					</script>
					{/literal}
					<select name="price_temp" onchange="selectPrice(this)">
						<option {if $page.form->getField('adsValue')===''}selected{/if}>{$language->getMessage('ads.price.contact')}</option>
						<option {if $page.form->getField('adsValue')!=='' && $page.form->getField('adsValue')<=0}selected{/if}>{$language->getMessage('ads.price.free')}</option>
						<option {if $page.form->getField('adsValue')>0}selected{/if}>{$language->getMessage('ads.price.specify')}</option>
					</select>
					<input readonly class="readonly" type="text" name="adsPrice" style="width: 64px"
						value="{$page.form->getField('adsPrice')}"> VND
       				<script language="javascript" type="text/javascript">
       				selectPrice(document.{$page.form->getName()}.price_temp);
					</script>
					<br>
					{$language->getMessage('ads.location')}:
					{include file='inc_displayLocationSelectionList.tpl' FIELD_NAME='adsLocation' SELECTED_VALUE=$page.form->getField('adsLocation') LOCATIONS=$page.content.adsLocationList}
    			</td>
    		</tr>
    		<tr>
    			<td width="30%">{$language->getMessage('ads.title')}</td>
    			<td width="70%">
    				<input name="adsTitle" value="{$page.form->getField('adsTitle')}" style="width: 440px;" type="text">
    			</td>
    		</tr>
    		<tr>
    			<td width="30%">{$language->getMessage('ads.content')}</td>
    			<td width="70%">
                    {php}
                        $page = $this->get_template_vars('page');
                        $this->assign('FORM_NAME', $page['form']->getName());
                        $this->assign('FIELD_NAME', 'adsContent');
                        $this->assign('FIELD_VALUE', $page['form']->getField('adsContent'));
                        $this->assign('FIELD_HEIGHT', 400);
                        $this->assign('FIELD_WIDTH', 440);
                    {/php}
                    {include file='editor_fckeditor.tpl'}
                    <!--
    				<textarea name="adsContent" style="width: 440px; height: 256px">{$page.form->getField('adsContent')}</textarea>
                    -->
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
    {if $page.content.ads->hasAttachment() || $page.content.adsMaxUploadFiles > 0}
		<tr>
			<td>
				<table border="0" width="100%" cellspacing="1" cellpadding="4">
				<tr>
        			<td width="30%" valign="top">
        				{$language->getMessage('ads.attachments')}
        			</td>
        			<td width="70%">
        				{if $page.content.ads->hasAttachment()}
        					<table border="0" cellpadding="4" cellspacing="1"><tr>
	        					{foreach from=$page.content.ads->getAllAttachments() item=attachment name="existingAttachments"}
	        						<td valign="top" align="center">
	        							<input type="checkbox" value="1" name="adsDeleteAttachment{$attachment->getId()}">
	        							<br>
	        							<img border="1" src="{$attachment->getUrlThumbnail()}">
	        						</td>
    	    					{/foreach}
    	    				</tr></table><br>
        				{/if}
        				{$language->getMessage('ads.attachment.allowedTypes')}: <b>{$page.content.adsAllowedUploadFiletypes}</b>
        				<br>
        				{$language->getMessage('ads.attachment.maxSize')}: <b>{$page.content.adsMaxUploadSize}</b> bytes
        				<br><br>
            			{php}
							$maxUploadFiles = Array();
							$page = $this->get_template_vars('page');
							$numAttachments = $page['content']['ads']->countAttachments();
							for ( $i = 0; $i < $page['content']['adsMaxUploadFiles']-$numAttachments; $i++ ) {
								$maxUploadFiles[] = $i;
							}
            				$this->assign('maxUploadFiles', $maxUploadFiles);
            			{/php}
        				{foreach from=$maxUploadFiles item=i}
							<input type="file" class="file" style="width: 440px" name="adsAttachment{$i}"><br>
        				{/foreach}
        			</td>
        		</tr>
        		</table>
			</td>
		</tr>
	{/if}
    </table>
</form>
