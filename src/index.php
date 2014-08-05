<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>BackEnd-Dev</title>
    <meta charset="utf-8">
</head>
<body>
    <? include_once("TestQuery.php"); ?> 

    <?
        $query1 = new IQuery();
        $query2 = new TestQuery();

        echo "query result : " . $query1->execute() . "<br>";
        echo "query result : " . $query2->execute() . "<br>";
    ?>


</body>
</html>
