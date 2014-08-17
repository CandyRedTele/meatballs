<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : Path.php
 *
 * HOWTO  1. Copy this file to the folder where your php file is.
 *
 *************************************************************************/
    error_reporting(E_ALL);

    function getSrcPath()
    {
        $root =  $_SERVER['DOCUMENT_ROOT'];

        if (strrpos($root, '/') == strlen($root) - 1) 
        {
            $root = substr($root, 0, -1); // remove trailing '/' (for windows)
        }

        return $root."/comp353-project/src"; 
    }

    // set_include_path(get_include_path(). PATH_SEPARATOR . getSrcPath()); // We had problems with this one on Mac


    ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.getSrcPath());  

?>
