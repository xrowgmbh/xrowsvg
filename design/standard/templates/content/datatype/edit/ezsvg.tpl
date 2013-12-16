{ezscript_require( array( 'ezjsc::jqueryio', 'xrowsvg.js' ) )}
{def $design = $attribute.content.data_int
     $content = $attribute.content.data_text}
<div id="xrowsvgol_{$attribute.id}_error" style="color: red"></div>
<div class="block">
{if ezini_hasvariable( 'Settings', 'Templates', 'xrowsvg.ini' )}
<input type="hidden" value="{$attribute.contentobject_id}" id="xrowsvgol_{$attribute.id}_contentobject_id" />
<input type="hidden" value="{$attribute.id}" id="xrowsvgol_{$attribute.id}_attribute_id" />
Wähle hier die Designvorlage:
<select name="{$attribute_base}_data_design_{$attribute.id}" id="xrowsvgol_{$attribute.id}" class="xrow_svg_option_list">
    <option value="0"></option>
    {foreach ezini( 'Settings', 'Templates', 'xrowsvg.ini' ) as $index => $templateName}
    <option value="{$index}"{if $design|eq( $index )} selected="selected"{/if}>{$templateName}</option>
	{if $design|eq( $index )}{def $selected = true()}{/if}
    {/foreach}
</select>
<input class="button loadSVGEditor" type="button" name="ContentObjectAttribute_xrowsvg[{$attribute.id}]" id="xrowsvgol_{$attribute.id}_loadeditor" value="Vorlage bearbeiten" {if or( is_set( $selected )|not(), $selected|not() )}disabled="disabled"{/if} />
<input type="hidden" id="xrowsvgol_{$attribute.id}_loadeditor_url" value={concat( 'xrowsvg/load/', $attribute.contentobject_id, '/', $attribute.id )|ezurl()} />
{default attribute_base='ContentObjectAttribute'
         html_class='full'}
<textarea id="xrowsvgol_{$attribute.id}_loadeditor_content" class="{eq( $html_class, 'half' )|choose( 'box', 'halfbox' )} ezcc-{$attribute.object.content_class.identifier} ezcca-{$attribute.object.content_class.identifier}_{$attribute.contentclass_attribute_identifier}" name="{$attribute_base}_data_text_{$attribute.id}" cols="50" rows="5">{$content}</textarea>
{/default}
{else}
Es fehlen Designvorlagen in der xrowsvg.ini!
{/if}
</div>