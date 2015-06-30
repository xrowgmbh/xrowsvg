<?php

class xrowSVGJscoreFunctions extends ezjscServerFunctions
{
    public static function loadTemplate()
    {
        $tpl = eZTemplate::factory();
        $http = eZHTTPTool::instance();
        
        if( $http->hasPostVariable( 'templateID' ) && $http->hasPostVariable( 'contentobjectID' ) && $http->hasPostVariable( 'attributeID' ) )
        {
            $contentObject = eZContentObject::fetch( $http->postVariable( 'contentobjectID' ) );
            if( $contentObject instanceof eZContentObject )
            {
                $contentObjectAttribute = eZContentObjectAttribute::fetch( $http->postVariable( 'attributeID' ), $contentObject->attribute( 'current_version' ) );
                if( $contentObjectAttribute instanceof eZContentObjectAttribute )
                {
                    $image = $contentObjectAttribute->storedFileInformation( $contentObject, $contentObject->attribute( 'current_version' ), $contentObjectAttribute->attribute( 'language_code' ), $contentObjectAttribute );
                }
            }
            if( $image )
            {
                if( isset( $image['url'] ) && strpos( $image['url'], '/images-versioned/' ) === false )
				{
                    $tpl->setVariable( 'attributeID', $http->postVariable( 'attributeID' ) );
                    $tpl->setVariable( 'image', $image );
                    $tpl->setVariable( 'contentObject', $contentObject );
                    return $tpl->fetch( 'design:xrowsvg/' . $http->postVariable( 'templateID' ) . '.tpl' );
                }
                else
                {
                    $error = true;
                }
            }
            else
            {
                $error = true;
            }
            if( $error )
            {
                return array( 'error' => 'Kein valides Bild im Artikel mit der ObjectID ' . $http->postVariable( 'contentobjectID' ) . ' gefunden. Bitte laden Sie zuerst ein Bild hoch. Nach einer erfolgreichen Veröffentlichung können Sie den Artikel erneut bearbeiten und den SVG Editor nutzen.' );
            }
        }
        return false;
    }
}