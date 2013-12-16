{ezscript_require( array( 'jquery.browser-check.js', 'xrowsvg.js' ) )}
{if $attribute.has_content}
    <span id="svg-view-content-{$attribute.id}" class="svg-view-content" dataSrc={$attribute.content.data_png.src|ezroot} dataTitle="{$attribute.content.data_png.alt}">{$attribute.content.data_text}</span>
{/if}