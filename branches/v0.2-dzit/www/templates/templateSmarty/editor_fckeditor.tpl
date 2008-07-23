<input type="hidden" id="{$FIELD_NAME}_temp" name="{$FIELD_NAME}_temp" value="{$FIELD_VALUE|escape:'html'}">
<script type="text/javascript" src="{$config.templateUri}/fckeditor/fckeditor.js"></script>
<script type="text/javascript">	
    var oFCKeditor			= new FCKeditor('{$FIELD_NAME}');	
    oFCKeditor.BasePath		= '{$config.templateUri}/fckeditor/';
    oFCKeditor.Config["CustomConfigurationsPath"]
    						= "{$config.templateUri}/myfckconfig.js"  ;
    oFCKeditor.Height		= {$FIELD_HEIGHT};
    oFCKeditor.Width		= {$FIELD_WIDTH};
    oFCKeditor.Value		= document.{$FORM_NAME}.{$FIELD_NAME}_temp.value;
    oFCKeditor.ToolbarSet	= 'MyFCKToolbar' ;
    oFCKeditor.Create();
    document.{$FORM_NAME}.html.value = 1;
</script>
