<?php

$position_css = "";
if ($position == 'top-left'){
    $position_css = "top: 0; left: 0;";
}else if ($position == 'top-right'){
    $position_css = "top: 0; right: 0;";
}else if ($position == 'bottom-left'){
    $position_css = "bottom: 0; left: 0;";
}else if ($position == 'bottom-right'){
    $position_css = "bottom: 0; right: 0;";
}

switch ( $type ) {
    case 'text':
    case 'custom':
        ?>
        .yith-wcbm-badge-<?php echo $id_badge ?>
        {
        color: <?php echo $txt_color ?>;
        background-color: <?php echo $bg_color ?>;
        width: <?php echo $width ?>px;
        height: <?php echo $height ?>px;
        line-height: <?php echo $height ?>px;
        <?php echo $position_css ?>
        }
        <?php
        break;

    case 'image':
        ?>
        .yith-wcbm-badge-<?php echo $id_badge ?>
        {
        <?php echo $position_css ?>
        }
        <?php
        break;
}


?>


