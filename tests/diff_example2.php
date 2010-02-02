<?php
// adjust file paths as per your local configuration!

include_once "../lib/Diff/Diff.php";
include_once "../lib/Diff/Diff/Renderer.php";
include_once "../lib/Diff/Diff/Renderer/unified.php";
include_once "../lib/Diff/Diff/Renderer/inline.php";
include_once "../lib/Diff/Diff/Renderer/context.php";

/*
// define files to compare
$file1 = "data1.txt";
$file2 = "data2.txt";

// perform diff, print output
$diff = &new Text_Diff(file($file1), file($file2));

$ar = $diff->getDiff();

$renderer = &new Text_Diff_Renderer();
//$renderer = &new Text_Diff_Renderer_unified();
//$renderer = &new Text_Diff_Renderer_inline();
//$renderer = &new Text_Diff_Renderer_context();
echo $renderer->render($diff);
*/

$patch = file_get_contents('../tests/example.patch');
$diff = new Text_Diff('string', array($patch));
$renderer = new Text_Diff_Renderer_inline();
echo $renderer->render($diff);

?>
