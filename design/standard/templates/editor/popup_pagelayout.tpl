{* eZ Online Editor MCE popup pagelayout *}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Image (SVG) Editor</title>
{def $skin = ezini('EditorSettings', 'Skin', 'ezoe.ini',,true() )}
<link rel="stylesheet" href="/extension/xrowsvg/design/standard/javascript/svg-edit/jgraduate/css/jPicker.css" type="text/css"/>
<link rel="stylesheet" href="/extension/xrowsvg/design/standard/javascript/svg-edit/jgraduate/css/jgraduate.css" type="text/css"/>
<link rel="stylesheet" href="/extension/xrowsvg/design/standard/javascript/svg-edit/svg-editor.css" type="text/css"/>
<link rel="stylesheet" href="/extension/xrowsvg/design/standard/javascript/svg-edit/spinbtn/JQuerySpinBtn.css" type="text/css"/>
<link rel="stylesheet" href="/extension/xrowsvg/design/standard/stylesheets/fonts.css" type="text/css"/>
<link rel="stylesheet" href="/extension/molimage/design/np/stylesheets/svganimation.css" type="text/css"/>
{if ezini_hasvariable('StylesheetSettings', 'EditorDialogCSSFileList', 'design.ini',,true())}
{foreach ezini('StylesheetSettings', 'EditorDialogCSSFileList', 'design.ini',,true()) as $css}
<link type="text/css" rel="stylesheet" href={concat( 'stylesheets/', $css|explode( '<skin>' )|implode( $skin ))|ezdesign} />
{/foreach}
{/if}

<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/jquery.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/js-hotkeys/jquery.hotkeys.min.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/jquerybbq/jquery.bbq.min.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/svgicons/jquery.svgicons.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/jgraduate/jquery.jgraduate.min.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/spinbtn/JQuerySpinBtn.min.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/contextmenu/jquery.contextMenu.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/browser.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/svgtransformlist.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/math.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/units.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/svgutils.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/sanitize.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/history.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/select.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/draw.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/path.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/svgcanvas.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/svg-editor.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/locale/locale.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/contextmenu.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/jquery-ui/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="/extension/xrowsvg/design/standard/javascript/svg-edit/jgraduate/jpicker.min.js"></script>
{ezscript_load( array( 'tiny_mce_popup.js', 'ezoe/popup_validate.js', $module_result.persistent_variable.scripts ) )}

</head>
<body>

    <div class="block" style="height: 500px">
    {$module_result.content}
    </div>

</body>
</html>