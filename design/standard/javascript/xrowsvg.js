function supportsSvg() {
    if(document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Shape", "1.0") || document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1"))
        return true;
    return false;
}
jQuery( document ).ready(function($) {
    var svgSupport = supportsSvg();
    if (!svgSupport) 
    {
        if($('.svg-view-content').length)
        {
            $('.svg-view-content').each(function(index) {
                var src = $(this).attr('dataSrc'),
                    title = $(this).attr('dataTitle');
                $(this).html('<img border="0" src='+src+' alt="'+title+'" />');
            });
        }
    }
    
    if($('.xrow_svg_option_list').length)
    {
        $('.xrow_svg_option_list').bind( 'change', function(e)
        {
            var templateID = $(this).attr('value'),
                id = $(this).attr('id')
                contentobjectID = $('#'+id+'_contentobject_id').val(),
                attributeID = $('#'+id+'_attribute_id').val();
            $.ez( 'xrowsvg::loadTemplate', {'templateID': templateID,
                                            'contentobjectID': contentobjectID,
                                            'attributeID': attributeID},
                function( data )
                {
                    if ( data.error_text )
                    {
                        $('#'+id+'_error').html(data.error_text);
                    }
                    else if ( data.content.error )
                    {
                        $('#'+id+'_error').html(data.content.error);
                    }
                    else
                    {
                        if(templateID > 0)
                        {
                            $('#'+id+'_loadeditor').removeAttr('disabled');
                        }
                        else
                        {
                        
                            $('#'+id+'_loadeditor').attr('disabled', 'disabled');
                        }                    
                        $('#'+id+'_error').html('');
                        $('#'+id+'_loadeditor_content').attr('value', data.content);
                    
                    }
                }
            );
        });
    }

    if ($('.loadSVGEditor'))
    {
        $('body').delegate('.loadSVGEditor', 'click', function(e) {
            var idArray = $(this).attr('id').split('_'),
                url = $('input#'+$(this).attr('id')+'_url').val(),
                page_top = e.pageY - 100,
                body_half_width = $('body').width() / 2,
                content = $.trim($('input#'+$(this).attr('id')+'_content').val());
                //alert(body_half_width);
            if (body_half_width > 510)
            {
                var page_left = body_half_width - 300;
            }
            else
            {
                var page_left = body_half_width - 500;
            }
            var innerHTML =
            '<div id="mce_' + idArray[1] + '" class="clearlooks2" style="width: 800px; height: 500px; top: ' + page_top + 'px; left: ' + page_left + 'px; overflow: auto; z-index: 300020;">'
          + '    <div id="mce_' + idArray[1] + '_top" class="mceTop"><div class="mceLeft"></div><div class="mceCenter"></div><div class="mceRight"></div><span id="mce_' + idArray[1] + '_title">Image (SVG) Editor</span></div>'
          + '    <div id="mce_' + idArray[1] + '_middle" class="mceMiddle">'
          + '        <div id="mce_' + idArray[1] + '_left" class="mceLeft"></div>'
          + '        <span id="mce_' + idArray[1] + '_content">'
          + '            <iframe src="' + url + '" class="loadSVGEditor_xrowsvg" id="' + $(this).attr('id')+'_con" name="loadSVGEditor_' + $(this).attr('id') + '" style="border: 0pt none; width: 800px; height: 480px;" />'
          + '        </span>'
          + '        <div id="mce_' + idArray[1] + '_right" class="mceRight"></div>'
          + '    </div>'
          + '    <div id="mce_' + idArray[1] + '_bottom" class="mceBottom"><div class="mceLeft"></div><div class="mceCenter"></div><div class="mceRight"></div><span id="mce_' + idArray[1] + '_status">Content</span></div>'
          + '    <a class="mceClose" id="mce_' + idArray[1] + '_close"></a>'
          + '</div>',
                blocker = '<div id="mceModalBlocker' + idArray[1] + '" class="clearlooks2_modalBlocker" style="z-index: 300017; display: block;"></div>';
            $('body').append(innerHTML);
            $('body').append(blocker);

            /*$('body').delegate('a#mce_' + idArray[1] + '_close', 'click', function(e) {
                $('#mce_' + idArray[1]).remove();
                $('#mceModalBlocker').remove();
            });*/
        });
    }
});