<?php

class eZSVGType extends eZDataType
{
    const DATA_TYPE_STRING = "ezsvg";

    function eZSVGType()
    {
        $this->eZDataType( self::DATA_TYPE_STRING, ezpI18n::tr( 'kernel/classes/datatypes', "Image (SVG)", 'Datatype name' ),
                           array( 'serialize_supported' => true ) );
    }

    /*!
     Sets the default value.
    */
    function initializeObjectAttribute( $contentObjectAttribute, $currentVersion, $originalContentObjectAttribute )
    {
        if ( $currentVersion != false )
        {
            $dataText = $originalContentObjectAttribute->attribute( "data_text" );
            if( $dataText != '' )
            {
                // update the path top newest image version
                $contentObject = eZContentObject::fetch( $originalContentObjectAttribute->attribute( 'contentobject_id' ) );
                if( $contentObject instanceof eZContentObject && $dataText != NULL && $dataText != '' )
                {
                    $data = $this->updateImagePath( $dataText, $contentObject, $originalContentObjectAttribute );
                    $dataText = $data['data_text'];
                }
                $dataInt = $originalContentObjectAttribute->attribute( "data_int" );
                $contentObjectAttribute->setAttribute( "data_text", $dataText );
                $contentObjectAttribute->setAttribute( "data_int", $dataInt );
            }
        }
    }

    /*!
     Validates the input and returns true if the input was
     valid for this datatype.
    */
    function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        $classAttribute = $contentObjectAttribute->contentClassAttribute();
        if ( $http->hasPostVariable( $base . '_data_text_' . $contentObjectAttribute->attribute( 'id' ) ) && $http->hasPostVariable( $base . '_data_design_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {
            $data = $http->postVariable( $base . '_data_text_' . $contentObjectAttribute->attribute( 'id' ) );
            $dataDesign = $http->postVariable( $base . '_data_design_' . $contentObjectAttribute->attribute( 'id' ) );

            if ( $data == "" )
            {
                if ( !$classAttribute->attribute( 'is_information_collector' ) and
                     $contentObjectAttribute->validateIsRequired() )
                {
                    $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                                                                         'Input required.' ) );
                    return eZInputValidator::STATE_INVALID;
                }
            }
            if ( $dataDesign == 0 )
            {
                if ( !$classAttribute->attribute( 'is_information_collector' ) and
                     $contentObjectAttribute->validateIsRequired() )
                {
                    $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                                                                         'Input required.' ) );
                    return eZInputValidator::STATE_INVALID;
                }
            }
        }
        else if ( !$classAttribute->attribute( 'is_information_collector' ) and $contentObjectAttribute->validateIsRequired() )
        {
            $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes', 'Input required.' ) );
            return eZInputValidator::STATE_INVALID;
        }

        return eZInputValidator::STATE_ACCEPTED;
    }

    function validateCollectionAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . '_data_text_' . $contentObjectAttribute->attribute( 'id' ) ) && $http->hasPostVariable( $base . '_data_design_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {
            $data = $http->postVariable( $base . '_data_text_' . $contentObjectAttribute->attribute( 'id' ) );
            $dataDesign = $http->postVariable( $base . '_data_design_' . $contentObjectAttribute->attribute( 'id' ) );

            if ( $data == "" )
            {
                if ( $contentObjectAttribute->validateIsRequired() )
                {
                    $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                                                                              'Input required.' ) );
                    return eZInputValidator::STATE_INVALID;
                }
            }
            if ( $dataDesign == "" )
            {
                if ( $contentObjectAttribute->validateIsRequired() )
                {
                    $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                                                                              'Input required.' ) );
                    return eZInputValidator::STATE_INVALID;
                }
            }
            return eZInputValidator::STATE_ACCEPTED;
        }
        else
            return eZInputValidator::STATE_INVALID;
    }

    /*!
     Fetches the http post var string input and stores it in the data instance.
    */
    function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) ) && $http->hasPostVariable( $base . '_data_design_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {
            $dataText = $http->postVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) );
            if( $dataText != '' )
            {
                $dataDesign = $http->postVariable( $base . "_data_design_" . $contentObjectAttribute->attribute( "id" ) );
                // update the path top newest image version
                $contentObject = eZContentObject::fetch( $contentObjectAttribute->attribute( 'contentobject_id' ) );
                if( $contentObject instanceof eZContentObject )
                {
                    $data = $this->updateImagePath( $dataText, $contentObject, $contentObjectAttribute );
                    $dataText = $data['data_text'];
                    // for saving replace fonts from system font to css font
                    $xrowsvg_ini = eZINI::instance( 'xrowsvg.ini' );
                    if( $xrowsvg_ini->hasVariable( 'FontSettings', 'FontToReplace' ) )
                    {
                        foreach(  $xrowsvg_ini->variable( 'FontSettings', 'FontToReplace' ) as $cssFont => $systemFont )
                        {
                            $dataText = preg_replace( '/' . $systemFont . '/', $cssFont, $dataText );
                        }
                    }
                }
            }
            else
            {
                $dataDesign = 0;
            }
            $contentObjectAttribute->setAttribute( "data_text", $dataText );
            $contentObjectAttribute->setAttribute( "data_int", $dataDesign );

            return true;
        }
        return false;
    }

    /*!
     Fetches the http post variables for collected information
    */
    function fetchCollectionAttributeHTTPInput( $collection, $collectionAttribute, $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) ) && $http->hasPostVariable( $base . "_data_design_" . $contentObjectAttribute->attribute( "id" ) ) )
        {
            $dataText = $http->postVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) );
            if( $dataText != '' )
            {
                $dataDesign = $http->postVariable( $base . "_data_design_" . $contentObjectAttribute->attribute( "id" ) );
                // update the path top newest image version
                $contentObject = eZContentObject::fetch( $contentObjectAttribute->attribute( 'contentobject_id' ) );
                if( $contentObject instanceof eZContentObject )
                {
                    $data = $this->updateImagePath( $dataText, $contentObject, $contentObjectAttribute );
                    $dataText = $data['data_text'];

                    // for saving replace fonts from system font to css font
                    $xrowsvg_ini = eZINI::instance( 'xrowsvg.ini' );
                    if( $xrowsvg_ini->hasVariable( 'FontSettings', 'FontToReplace' ) )
                    {
                        foreach(  $xrowsvg_ini->variable( 'FontSettings', 'FontToReplace' ) as $cssFont => $systemFont )
                        {
                            $dataText = preg_replace( '/' . $systemFont . '/', $cssFont, $dataText );
                        }
                    }
                }
            }
            else
            {
                $dataDesign = 0;
            }
            $collectionAttribute->setAttribute( 'data_text', $dataText );
            $collectionAttribute->setAttribute( 'data_int', $dataDesign );

            return true;
        }
        return false;
    }

    function onPublish( $contentObjectAttribute, $contentObject, $publishedNodes )
    {
        if ( $contentObjectAttribute->hasContent() )
        {
            $image = $contentObjectAttribute->storedFileInformation( $contentObject, $contentObject->attribute( 'current_version' ), $contentObjectAttribute->attribute( 'language_code' ), $contentObjectAttribute );
            if( is_array( $image ) && array_key_exists( 'url', $image ) )
            {
                $embedImagePath = $image['url'];
            }

            try
            {
                $svgFileCachePath = $this->uploadSVGFile( $contentObjectAttribute, $embedImagePath );
                if( $svgFileCachePath )
                {
                    try
                    {
                        $this->convertSVGtoPNG( $svgFileCachePath, $embedImagePath, $contentObjectAttribute, $contentObject );
                    }
                    catch( Exception $e )
                    {
                        $contentObjectAttribute->setValidationError( $e->getMessage() );
                        return eZInputValidator::STATE_INVALID;
                    }
                }
            }
            catch( Exception $e )
            {
                $contentObjectAttribute->setValidationError( $e->getMessage() );
                return eZInputValidator::STATE_INVALID;
            }
        }
        else
        {
            $this->deleteStoredObjectAttribute( $contentObjectAttribute, $contentObjectAttribute->attribute( 'version' ) );
        }
    }

    function uploadSVGFile( $contentObjectAttribute, $pngFilePath )
    {
        $dataText = $contentObjectAttribute->attribute( 'data_text' );
        // for saving replace fonts from css font to system font
        $xrowsvg_ini = eZINI::instance( 'xrowsvg.ini' );
        if( $xrowsvg_ini->hasVariable( 'FontSettings', 'FontToReplace' ) )
        {
            foreach(  $xrowsvg_ini->variable( 'FontSettings', 'FontToReplace' ) as $cssFont => $systemFont )
            {
                $dataText = preg_replace( '/' . $cssFont . '/', $systemFont, $dataText );
            }
        }
        $svgFileCachePath = eZSys::cacheDirectory() . DIRECTORY_SEPARATOR . $contentObjectAttribute->attribute( 'id' ) . '.svg';
        $xml = new SimpleXMLElement( $dataText );
        $images = $xml->{'g'}->{'image'};
        if( $images != null )
        {
            foreach( $images as $image )
            {
                foreach( $image->attributes() as $attrName => $attrValue )
                {
                    if( $attrName == 'class' && (string)$attrValue->{0} == 'svg-background-image' )
                    {
                        $image->attributes('xlink', true)->href = 'file://' . eZSys::rootDir() . $image->attributes('xlink', true)->href;
                        break;
                    }
                }
            }
        }
        $dataText = $xml->saveXML();
        try
        {
            eZFile::create( $svgFileCachePath, false, $dataText );
            eZImageHandler::changeFilePermissions( $svgFileCachePath );
            return $svgFileCachePath;
        }
        catch( Exception $e )
        {
            if ( file_exists( $svgFileCachePath ) )
            {
                @unlink( $svgFileCachePath );
            }
            throw new Exception( $e->getMessage() );
        }
    }

    function convertSVGtoPNG( $svgFileCachePath, $embedImagePath, $contentObjectAttribute, $contentObject, $version = null )
    {
        // copy embeded image to local
        $file = eZClusterFileHandler::instance( $embedImagePath );
        if ( is_object( $file ) )
        {
            $file->fileFetch( $embedImagePath );
        }
        $imagePathArray = explode( DIRECTORY_SEPARATOR, $embedImagePath );
        $imageFile = array_pop( $imagePathArray );
		if( $version === null )
		{
		    $version = $contentObject->attribute( 'current_version' );
		}
        $imageFile = preg_replace( '/(.jpg|.gif)/', '_' . $version . '.png', $imageFile );
        $pngFolder = implode( DIRECTORY_SEPARATOR, $imagePathArray ) . DIRECTORY_SEPARATOR . 'png';
        if ( !file_exists( $pngFolder ) )
        {
            if ( !eZDir::mkdir( $pngFolder, false, true ) )
            {
                throw new Exception( 'Could not create folder ' . $pngFolder . ', ' . __METHOD__ );
            }
        }
        $pngFilePath = $pngFolder . DIRECTORY_SEPARATOR . $imageFile;

        $xrowsvg_ini = eZINI::instance( 'xrowsvg.ini' );
        $path = false;
        $executable = false;
        $path = $xrowsvg_ini->variable( 'ShellSettings', 'ConvertPath' );
        $executable = $xrowsvg_ini->variable( 'ShellSettings', 'Executable' );
        if ( $path )
        {
            $executable = $path . eZSys::fileSeparator() . $executable;
        }
        if ( eZSys::osType() == 'win32' )
        {
            $executable = "\"$executable\"";
        }
        $argumentList[] = $executable;
        $argumentList[] = eZSys::escapeShellArgument( $pngFilePath );
        $argumentList[] = eZSys::escapeShellArgument( $svgFileCachePath );
        #eZDebug::writeNotice( array( $argumentList ), 'SVG inkscape PARAMS' );
        // convert .svg to .png
        $systemString = implode( ' ', $argumentList );
        if ( eZSys::osType() == 'win32' )
        {
            $systemString = "\"$systemString\"";
        }
        system( $systemString, $returnCode );
        #eZDebug::writeNotice( $systemString, 'SVG inkscape string' );

        if ( $returnCode == 0 )
        {
            if ( !file_exists( $pngFilePath ) )
            {
                throw new Exception( 'File ' . $pngFilePath . ' does not exist, ' . __METHOD__ );
            }
            try
            {
                eZImageHandler::changeFilePermissions( $pngFilePath );
                try
                {
                    $this->storePNG( $pngFilePath );
                    // delete the local image
                    if ( is_object( $file ) )
                    {
                        $file->fileDeleteLocal( $pngFilePath );
                    }
                    if ( file_exists( $svgFileCachePath ) )
                    {
                        @unlink( $svgFileCachePath );
                    }
                    return $pngFilePath;
                }
                catch( Exception $e )
                {
                    throw new Exception( $e->getMessage() );
                }
            }
            catch( Exception $e )
            {
                throw new Exception( $e->getMessage() );
            }
        }
    }

    function storePNG( $pngFilePath )
    {
        // Clustering
        $file = eZClusterFileHandler::instance();
        $remove = true;
        if ( is_object( $file ) )
        {
            if( file_exists( $pngFilePath ) )
            {
                $mimeData = eZMimeType::findByFileContents( $pngFilePath );
                try
                {
                    $file->fileStore( $pngFilePath, 'image', $remove, $mimeData['name'] );
                }
                catch( Exception $e )
                {
                    throw new Exception( $e->getMessage() );
                }
            }
        }
        return true;
    }

    function deleteStoredObjectAttribute( $contentObjectAttribute, $version = null )
    {
        if( $contentObjectAttribute instanceof eZContentObjectAttribute )
        {
            $contentObject = eZContentObject::fetch( $contentObjectAttribute->attribute( 'contentobject_id' ) );
            #eZDebug::writeNotice( 'Version: ' . $version, 'SVG deleteStoredPNG' );
            if( $contentObject instanceof eZContentObject )
            {
                $image = $contentObjectAttribute->storedFileInformation( $contentObject, $contentObject->attribute( 'current_version' ), $contentObjectAttribute->attribute( 'language_code' ), $contentObjectAttribute );
                if( is_array( $image ) && array_key_exists( 'url', $image ) )
                {
                    $imagePathArray = explode( DIRECTORY_SEPARATOR, $image['url'] );
                    $imageFile = array_pop( $imagePathArray );
                    $pngFolder = implode( DIRECTORY_SEPARATOR, $imagePathArray ) . DIRECTORY_SEPARATOR . 'png';
                    if( $version !== null )
                    {
                        $imageFile = $pngFolder . DIRECTORY_SEPARATOR . preg_replace( '/(.jpg|.gif)/', '_' . $version . '.png', $imageFile );
                        $file = eZClusterFileHandler::instance( $imageFile );
                        #eZDebug::writeNotice( array( 'FILEHANDLER: ' => $file, 'FilePath: ' => $imageFile, 'Version: ' => $version ), 'SVG deleteStoredPNG' );
                        if ( is_object( $file ) && $file->exists() )
                        {
                            $file->fileDelete( $imageFile );
                            #eZDebug::writeNotice( 'Deleted file ' . $imageFile, 'SVG deleteStoredPNG' );
                        }
                    }
                    else
                    {
                        $file = eZClusterFileHandler::instance();
                        $prePath = implode( DIRECTORY_SEPARATOR, $imagePathArray );
                        $dirName = 'png';
                        $postPath = preg_replace( '/(.jpg|.gif)/', '', $imageFile );
                        if( $file->fileDeleteByDirList( $prePath, $dirName, $postPath ) )
                        {
                            eZDebug::writeError( 'Deleted file ' . $prePath . '/' . $dirName . '/' . $postPath . '% did not work', 'SVG deleteStoredPNG' );
                        }
                    }
                }
            }
        }
    }

    /*!
     Store the content.
    */
    function storeObjectAttribute( $attribute )
    {}

    /*!
     Simple string insertion is supported.
    */
    function isSimpleStringInsertionSupported()
    {
        return false;
    }

    /*!
     Returns the content.
    */
    function objectAttributeContent( $contentObjectAttribute )
    {
        $pngFilePath = '';
        $show_png = false;
        $alt = '';
        $contentObject = eZContentObject::fetch( $contentObjectAttribute->attribute( 'contentobject_id' ) );
        if( $contentObject instanceof eZContentObject )
        {
            $image = $contentObjectAttribute->storedFileInformation( $contentObject, $contentObject->attribute( 'current_version' ), $contentObjectAttribute->attribute( 'language_code' ), $contentObjectAttribute );
            if( is_array( $image ) && array_key_exists( 'url', $image ) )
            {
                $embedImagePath = $image['url'];
                $imagePathArray = explode( DIRECTORY_SEPARATOR, $embedImagePath );
                $imageFile = array_pop( $imagePathArray );
                $imageFile = preg_replace( '/(.jpg|.gif)/', '_' . $contentObject->attribute( 'current_version' ) . '.png', $imageFile );
                $pngFolder = implode( DIRECTORY_SEPARATOR, $imagePathArray ) . DIRECTORY_SEPARATOR . 'png';
                if ( !file_exists( $pngFolder ) )
                {
                    eZDir::mkdir( $pngFolder, false, true );
                }
                // copy embeded image to local
                $file = eZClusterFileHandler::instance( $pngFolder . DIRECTORY_SEPARATOR . $imageFile );
                if ( is_object( $file ) && $file->exists() )
                {
                    $pngFilePath = $pngFolder . DIRECTORY_SEPARATOR . $imageFile;
                    #eZDebug::writeNotice( $pngFilePath, 'Fallback PNG' );
                    $xml = new SimpleXMLElement( $contentObjectAttribute->attribute( "data_text" ) );
                    $texts = $xml->{'g'}->{'text'};
                    if( $texts != null )
                    {
                        foreach( $texts as $text )
                        {
                            $altArray[] = (string)$text->{0};
                        }
                    }
                    $alt = implode( ', ', $altArray );
                    #eZDebug::writeNotice( $alt, 'PNG Alt-Text' );
                }
                else
                {
                    $pngFilePath = $embedImagePath;
                }
            }
        }
        $attributeContent = array( "data_text" => $contentObjectAttribute->attribute( "data_text" ),
                                   "data_int" => $contentObjectAttribute->attribute( "data_int" ),
                                   "data_png" => array( 'src' => $pngFilePath,
                                                        'alt' => $alt ) );

        return $attributeContent;
    }

    function fetchClassAttributeHTTPInput( $http, $base, $classAttribute )
    {
        return true;
    }

    function hasStoredFileInformation( $object, $objectVersion, $objectLanguage, $objectAttribute )
    {
        return true;
    }

    function storedFileInformation( $object, $objectVersion, $objectLanguage, $objectAttribute )
    {
        $xrowsvgini = eZINI::instance( 'xrowsvg.ini' );
        if( $xrowsvgini->hasVariable( 'Settings', 'ImageIdentifiers' ) )
        {
            $imageAttributes = $object->fetchAttributesByIdentifier( (array)$xrowsvgini->variable( 'Settings', 'ImageIdentifiers' ) );
            foreach( $imageAttributes as $imageAttribute )
            {
                $content = $imageAttribute->content();
                if ( $content )
                {
                    if( $imageAttribute->attribute( 'data_type_string' ) == 'ezobjectrelation' )
                    {
                        $dataMap = $content->dataMap();
                        $imageAttribute = $dataMap['image'];
                        $content = $imageAttribute->content();
                    }

                    if( $content->attribute( 'is_valid' ) )
                    {
                        if( $xrowsvgini->hasVariable( 'Settings', 'ImageAlias' ) )
                        {
                            $imageAlias = $xrowsvgini->variable( 'Settings', 'ImageAlias' );
                            $image = $content->attribute( $imageAlias );
                            if( is_array( $image ) )
                            {
                                return $image;
                            }
                        }
                        else
                        {
                            $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                                                                                      'No ImageAlias in xrowsvg.ini for ezsvg' ) );
                            return eZInputValidator::STATE_INVALID;
                        }
                    }
                    else
                    {
                        continue;
                    }
                }
                else
                {
                    continue;
                }
            }
        }
        return false;
    }

    function hasObjectAttributeContent( $contentObjectAttribute )
    {
        return trim( $contentObjectAttribute->attribute( 'data_text' ) ) != '';
    }

    function isIndexable()
    {
        return true;
    }

    function isInformationCollector()
    {
        return true;
    }

    function supportsBatchInitializeObjectAttribute()
    {
        return true;
    }

    function updateImagePath( $dataText, $contentObject, $originalContentObjectAttribute )
    {
        // read the newest image version
        $filePath = '';
        $image = $originalContentObjectAttribute->storedFileInformation( $contentObject, $contentObject->attribute( 'current_version' ), $originalContentObjectAttribute->attribute( 'language_code' ), $originalContentObjectAttribute );
        if( is_array( $image ) )
        {
            $filePath = DIRECTORY_SEPARATOR . $image['url'];
            try
            {
                $xml = new SimpleXMLElement( $dataText );
                $images = $xml->{'g'}->{'image'};
                if( $images != null )
                {
                    foreach( $images as $image )
                    {
                        foreach( $image->attributes() as $attrName => $attrValue )
                        {
                            if( $attrName == 'class' && (string)$attrValue->{0} == 'svg-background-image' )
                            {
                                $image->attributes('xlink', true)->href = $filePath;
                                break;
                            }
                        }
                    }
                }
                return array( 'data_text' => $xml->saveXML(),
                              'file_path' => $filePath );
            }
            catch( Exception $e )
            {
                $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                                                                          'The content of Image (SVG) is not valid.' ) );
                return eZInputValidator::STATE_INVALID;
            }
        }
    }
}

eZDataType::register( eZSVGType::DATA_TYPE_STRING, "eZSVGType" );