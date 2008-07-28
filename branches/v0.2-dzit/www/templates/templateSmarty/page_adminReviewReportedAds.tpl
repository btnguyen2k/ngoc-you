<table border="0" width="100%" cellspacing="3" cellpadding="0" class="table_view">
<tr>
	<td class="title_form">{$language->getMessage('ads.review')}</td>
</tr>
<tr>
	<td align="center">
		{$language->getMessage('ads.review.confirmation')}
	</td>
</tr>
<tr>
	<td align="center">
		<form method="POST" name="frmReviewAds" action="">
			<script language="javascript" type="text/javascript">
			{literal}
				function submitReviewAds(form, url) {
					form.action = url;
					form.submit();
				}
			{/literal}
			</script>
    		<br>
    		<input onclick="submitReviewAds(this.form, '{$page.content.ads->getUrlDeleteReported()}');" value="{$language->getMessage('delete')}" type="button" class="button_highlighted">&nbsp;&nbsp;&nbsp;&nbsp;
    		<input onclick="submitReviewAds(this.form, '{$page.content.ads->getUrlUnreport()}');" value="{$language->getMessage('ads.unreport')}" type="button" class="button">&nbsp;&nbsp;&nbsp;&nbsp;
        	<input onclick='location.href="{$page.form->getCancelAction()}"' value="{$language->getMessage('cancel')}" type="button" class="button">
    		<br><br>
    	</form>
	</td>
</tr>
<tr>
	<td>	
		<table border="0" width="100%" cellspacing="0" cellpadding="3" class="table_list">
		<tr>
			<td class="head_list">{$page.content.ads->getTitle()}</td>
		</tr>
		<tr>
			<td class="list_row1">{$page.content.ads->getContentForDisplay()}</td>
		</tr>
		<tr>
			<td class="list_row2" align="center">
				<small>
					{$language->getMessage('ads.postedBy')}: <b>{$page.content.ads->getPosterName()}</b>
					|
					{$language->getMessage('ads.postDate')}: <b>{$page.content.ads->getPostDate()}</b>
					|
					{$language->getMessage('ads.expiry')}: <b>{$page.content.ads->getExpiryDate()}</b>
				</small>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
