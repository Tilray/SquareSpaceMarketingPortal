<?php

$left_dir = "./data-old/";
$right_dir = "./data-new/";

$left_files = scandir($left_dir);
$right_files = scandir($right_dir);

?>
<table>
<?php

function wrap_single($content){
    ?>
    <tr>
        <td colspan="2">
            <?= $content ?>
        </td>
    </tr>
    <?php
}

function wrap_double($content_left, $content_right){
    ?>
    <tr>
        <td>
            <?= $content_left ?>
        </td>
        <td>
            <?= $content_right ?>
        </td>
    </tr>
    <?php
}


foreach($left_files as $left_file) {
    if ($left_file === "." || $left_file === "..")
        continue;

    $left_file_path = $left_dir . $left_file;
    $right_file_path = $right_dir . $left_file;

    if (!in_array($left_file, $right_files)){
        wrap_double("Only in left: " . $left_file . "<br><img src='" . $left_file_path . "'/>", "");
        continue;
    }


    $left_image = new imagick($left_file_path);
    $right_image = new imagick($right_file_path);

    if ($left_image->getImageSignature() == $right_image->getImageSignature()){
        wrap_single("Identical: " . $left_file);
        continue;
    }

    //files are different, display both side by side
    wrap_double("<img src='$left_file_path'/>", "<img src='$right_file_path'/>");
}


//still need to find stuff that's only in the right dir
foreach($right_files as $right_file) {
    if ($right_file === "." || $right_file === "..")
        continue;

    $right_file_path = $right_dir . $right_file;

    if (!in_array($right_file, $left_files)){
        wrap_double("", "Only in right: " . $right_file . "<br><img src='" . $right_file_path . "'/>");
    }
}

?>
</table>
<?php
