<?php 
    $task = strip_tags( $_POST['task'] );
    echo '<li><span>'.$task.'</span></li>';
    echo '<input name="menu_item['.$task.']" value="'.$task.'" type="hidden">';
?>
