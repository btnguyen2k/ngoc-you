{*******************************************************************************
Displays list of locations as a combobox.
Parameters:
- FIELD_NAME (string): form field name of the combobox
- SELECTED_VALUE (mixed): selected value
- LOCATIONS (Array): list of locations
*******************************************************************************}
<select size="1" name="{$FIELD_NAME}">
	<option value="0">-----</option>
	{foreach from=$LOCATIONS item=location}
		<option {if $SELECTED_VALUE===$location.key}selected{/if} value="{$location.key}">{$location.value}</option>
	{/foreach}
</select>
