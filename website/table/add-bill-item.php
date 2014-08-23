<?php 
    $task = strip_tags( $_POST['task'] );

    echo '<li><span>'.$task.'</span></li>';
    echo '<input id="task" value="'.$task.'" type="hidden">';
?>
