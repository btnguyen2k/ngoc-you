{include file='header.tpl'}
{if $page.content.errorMessage != NULL && $page.content.errorMessage != ''}
	<br>
    <div align="center">
        <table class="grey block">
        <tr>
            <td>
                <table border="0" cellpadding="4" cellspacing="0">
                <tr>
                    <td valign="top"><img border="0" alt="Warning" src="images/icon_warning.gif"></td>
                    <td valign="top">
                        {$page.content.errorMessage}
                    </td>
                </tr>
                </table>
            </td>
        </tr>
        </table>
    </div>
    </br>
{/if}
{if $page.content.informationMessage != NULL && $page.content.informationMessage != ''}
	<br>
    <div align="center">
        <table class="grey block">
        <tr>
            <td>
                <table border="0" cellpadding="4" cellspacing="0">
                <tr>
                    <td valign="top"><img border="0" alt="Information" src="images/icon_information.gif"></td>
                    <td valign="top">
                        {$page.content.informationMessage}
                    </td>
                </tr>
                </table>
            </td>
        </tr>
        </table>
    </div>
    </br>
{/if}
{if $page.transmission != NULL}
	<br>
    <div align="center">
        <table class="grey block">
        <tr>
            <td>
                <table border="0" cellpadding="4" cellspacing="0">
                <tr>
                    <td valign="top"><img border="0" alt="Information" src="images/icon_information.gif"></td>
                    <td valign="top" style="color: #009010">
                        {$page.transmission->getMessage()}
                    </td>
                </tr>
                </table>
            </td>
        </tr>
        </table>
    </div>
    </br>
{/if}
<br>
<table border="0" width="970" cellspacing="0" cellpadding="0" align="center">
<tr>
	{if $LEFT_COLUMN_PAGE != NULL && $LEFT_COLUMN_PAGE != ''}
		<td width="200" class="celltop">{include file=$LEFT_COLUMN_PAGE}</td>
		<td class="celltop">&nbsp;</td>
	{/if}
	<td class="celltop">
		{if $CONTENT_PAGE != NULL && $CONTENT_PAGE != ''}
			{include file=$CONTENT_PAGE}
		{/if}
	</td>
	{if $RIGHT_COLUMN_PAGE != NULL && $RIGHT_COLUMN_PAGE != ''}
		<td class="celltop">&nbsp;</td>
		<td width="200" class="celltop">{include file=$RIGHT_COLUMN_PAGE}</td>
	{/if}
</tr>
</table>
<br>
{include file='footer.tpl'}