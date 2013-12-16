<?php

$http = eZHTTPTool::instance();
$tpl = eZTemplate::factory();
$Module = $Params['Module'];
$namedParameters = $Module->NamedParameters;
$image = false;
// check if a node was given
if( array_key_exists( 'ObjectID', $namedParameters ) )
{
    $contentobjectID = $namedParameters['ObjectID'];
}
else
{
    eZDebug::writeError( 'ObjectID fehlt im Aufruf des Modules /xrowsvg/load', __METHOD__ );
    return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
}
if( array_key_exists( 'AttributeID', $namedParameters ) )
{
    $attributeID = $namedParameters['AttributeID'];
}
else
{
    eZDebug::writeError( 'AttributeID fehlt im Aufruf des Modules /xrowsvg/load', __METHOD__ );
    return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
}

$user = eZUser::currentUser();
if ( $user instanceOf eZUser )
{
    $result = $user->hasAccessTo( 'xrowsvg', 'loadeditor' );
}
else
{
    $result = array('accessWord' => 'no');
}
if ( $result['accessWord'] === 'no' )
{
   echo ezpI18n::tr( 'design/standard/error/kernel', 'Your current user does not have the proper privileges to access this page.' );
   eZExecution::cleanExit();
}
$contentObject = eZContentObject::fetch( $contentobjectID );
$xml = '';
if( $contentObject instanceof eZContentObject )
{
    $version = $contentObject->attribute( 'current_version' );
    $contentObjectAttribute = eZContentObjectAttribute::fetch( $attributeID, $version );
    if( $contentObjectAttribute instanceof eZContentObjectAttribute )
    {
        if( $contentObjectAttribute->hasContent() && $contentObjectAttribute->attribute( 'data_text' ) !== null && $contentObjectAttribute->attribute( 'data_text' ) != '' )
        {
            $xml = $contentObjectAttribute->attribute( 'data_text' );
        }
    }
    else
    {
        eZDebug::writeError( 'AttributeID ' . $attributeID. ' ist keine Instanz von eZContentObjectAttribute', __METHOD__ );
    }
}
$tpl->setVariable( 'content', $xml );
$Result = array();
$Result['content'] = $tpl->fetch( 'design:editor/svg-editor.tpl' );
$Result['pagelayout'] = 'design:editor/popup_pagelayout.tpl';

return $Result;