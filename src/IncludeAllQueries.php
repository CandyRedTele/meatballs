<?php
/**************************************************************************
 *
 * AUTHORS : Team 3, Joseph
 *
 * NAME : IncludeAllQueries.php
 *
 * PURPOSE : Includes all the file named '*Query.php' that are present under
 *           the /src directory.
 *
 * NOTE : Make sure you set_include_path in your code to point to this dir.
 *
 *************************************************************************/
include_once("Logger.php");

$path = get_include_path();
$logger = Logger::getSingleInstace();

if ($handle = opendir($path)) 
{
    $included_files = "[IncludeAllQueries] included files : ( ";

    while (($file = readdir($handle)))
    {
        if ($file === '.' || $file === '..' ) {
            continue;
        }


        if (preg_match('/Query.php$/', $file)) {
            include_once($file);
            $included_files .=  $file." ";
        }
    }

    $included_files .= ")";
    $logger->write($included_files);

    closedir($handle);
}
?>
