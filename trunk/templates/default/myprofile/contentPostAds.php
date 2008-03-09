<center>
<h1><?=$LANG['MY_PROFILE_TITLE']?></h1>
</center>
<center>
<h2><?=$LANG['MY_PROFILE_TITLE_POST_ADS']?></h2>
</center>
<?php $_FORM = $PAGE['form']; ?>
<form method="POST" action="<?=$_FORM['action']?>"
	enctype="multipart/form-data"><input type="hidden" name="html"
	value="0">
<table border="0" cellpadding="4" cellspacing="1" align="center">
<?php
if ( $_FORM['errorMessage'] !== "" ) {
    ?>
	<tr>
		<td colspan="2" class="errorMessage" align="center"><?=$_FORM['errorMessage']?>
		</td>
	</tr>
	<?php
}
?>
	<tr>
		<td valign="top"><?=$LANG['CATEGORY']?>:</td>
		<td><select name="<?=$_FORM['fieldCategory']?>">
			<option value="0">&nbsp;</option>
			<?php
			foreach ( $PAGE['categoryTree'] as $cat ) {
			    echo '<optgroup label="', htmlspecialchars($cat->getName()), '">';
			    foreach ( $cat->getChildren() as $child ) {
			        if ( $child->getId() === $PAGE['form']['valueCategory'] ) {
			            echo '<option value="', $child->getId(), '" selected>';
			        } else {
			            echo '<option value="', $child->getId(), '">';
			        }
			        echo htmlspecialchars($child->getName()), '</option>';
			    }
			    echo '</optgroup>';
			}
			?>
		</select>
		<br>
		<?=$LANG['ADS_TYPE']?>: <input
		<?=$_FORM['valueAdsType']===0?"checked":""?> type="radio"
			name="<?=$_FORM['fieldAdsType']?>" value="0"> <?=$LANG['ADS_TYPE_SELL']?>
		<input <?=$_FORM['valueAdsType']!==0?"checked":""?> type="radio"
			name="<?=$_FORM['fieldAdsType']?>" value="1"> <?=$LANG['ADS_TYPE_BUY']?>
		&nbsp;<span style="border-left: 1px solid #000000; height: 100%;">&nbsp;</span>
		<?=$LANG['ADS_PRICE']?>: <script language="javascript"
			type="text/javascript">
			function selectPrice(formEl) {
				if ( formEl.selectedIndex === 0 ) {
					//contact
					formEl.form.<?=$_FORM['fieldAdsPrice']?>.readOnly=true;
					formEl.form.<?=$_FORM['fieldAdsPrice']?>.className='textbox_disabled';
					formEl.form.<?=$_FORM['fieldAdsPrice']?>.value='';
				} else if ( formEl.selectedIndex === 1 ) {
					//free
					formEl.form.<?=$_FORM['fieldAdsPrice']?>.readOnly=true;
					formEl.form.<?=$_FORM['fieldAdsPrice']?>.className='textbox_disabled';
					formEl.form.<?=$_FORM['fieldAdsPrice']?>.value='0';
				} else {
					//specify
					formEl.form.<?=$_FORM['fieldAdsPrice']?>.readOnly=false;
					formEl.form.<?=$_FORM['fieldAdsPrice']?>.className='textbox_blue';
					formEl.form.<?=$_FORM['fieldAdsPrice']?>.value='0';
				}
			}
			</script> <select name="price_temp" onchange="selectPrice(this)">
			<option <?=!isset($_FORM['valueAdsPrice']) ? "selected" : ""?>><?=$LANG['ADS_PRICE_CONTACT']?></option>
			<option
			<?=isset($_FORM['valueAdsPrice'])&&$_FORM['valueAdsPrice']<=0 ? "selected" : ""?>><?=$LANG['ADS_PRICE_FREE']?></option>
			<option
			<?=isset($_FORM['valueAdsPrice'])&&$_FORM['valueAdsPrice']>0 ? "selected" : ""?>><?=$LANG['ADS_PRICE_SPECIFY']?></option>
		</select>
		<input <?=!isset($_FORM['valueAdsPrice'])||$_FORM['valueAdsPrice']<=0 ? 'readonly class="textbox_disabled" ' : 'class="textbox_blue"'?>
			type="text" name="<?=$_FORM['fieldAdsPrice']?>" style="width: 64px"
			value="<?=htmlspecialchars($_FORM['valueAdsPrice'])?>"> VND <br>
			<?=$LANG['ADS_LOCATION']?>: <select
			name="<?=$_FORM['fieldAdsLocation']?>">
			<option value="0">-----</option>
			<?php
			foreach ( $PAGE['locations'] as $key=>$value ) {
			    if ( isset($_FORM['valueAdsLocation']) && $_FORM['valueAdsLocation']===$key ) {
			        echo '<option selected value="'.($key+0).'">';
			    } else {
			        echo '<option value="'.($key+0).'">';
			    }
			    echo htmlspecialchars($value);
			    echo '</option>';
			}
			?>
		</select></td>
	</tr>

	<tr>
		<td valign="top"><?=$LANG['ADS_TITLE']?>:</td>
		<td><input class="textbox_blue" name="<?=$_FORM['fieldAdsTitle']?>"
			value="<?=htmlspecialchars($_FORM['valueAdsTitle'])?>" type="text"
			style="width: 400px"></td>
	</tr>
	<tr>
		<td valign="top"><?=$LANG['ADS_CONTENT']?>:</td>
		<td><?php
		if ( WYSIWYG==='xinha' ) {
		    require_once 'templates/'.TEMPLATE.'/xinha.php';
		    xinha($_FORM['fieldAdsContent'], $_FORM['valueAdsContent'], 512, 300);
		} elseif ( WYSIWYG==='fckeditor' ) {
		    require_once 'templates/'.TEMPLATE.'/fckeditor.php';
		    fckeditor($_FORM['fieldAdsContent'], $_FORM['valueAdsContent'], 512, 300);
		} else {
		    echo '<textarea class="textbox_blue" name="', $_FORM['fieldAdsContent'];
		    echo '" id="', $_FORM['fieldAdsContent'], '" rows="25" style="width: 512px">';
		    echo htmlspecialchars($_FORM['valueAdsContent']), '</textarea>';
		}
		?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input class="button_default" type="submit"
			value="<?=$LANG['POST_ADS']?>"> <input
			onclick="location='<?=$_SERVER['PHP_SELF'].'?'.GET_PARAM_ACTION.'='.ACTION_MY_ADS?>'"
			style="width: 64px" class="button" type="button"
			value="<?=$LANG['CANCEL']?>"></td>
	</tr>
	<?php
	if ( isset($PAGE['config']['MAX_UPLOAD_FILES']) && $PAGE['config']['MAX_UPLOAD_FILES'] > 0 ) {
	    ?>
	<tr>
		<td valign="top"><?=$LANG['ATTACH_IMAGES']?>:</td>
		<td><?=$LANG['ALLOWED_UPLOAD_FILE_TYPES']?>: <b><?=$PAGE['config']['ALLOWED_UPLOAD_FILE_TYPES']?></b>
		<br>
		<?=$LANG['MAX_UPLOAD_SIZE']?>: <b><?=$PAGE['config']['MAX_UPLOAD_SIZE']?>
		bytes</b> <br>
		<br>
		<?php
		for ( $i = 0; $i < $PAGE['config']['MAX_UPLOAD_FILES']; $i++ ) {
		    ?> <input type="file" class="textbox_blue" style="width: 300px"
			name="<?=$_FORM['fieldAttachImage'].$i?>"><br>
			<?php
}
?></td>
	</tr>
	<?php
}
?>
</table>
</form>
