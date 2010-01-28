<?
session_start();
require('init_smarty.php');
require('lib/simplediff.php');

// temp..
$smarty->assign('d_name', 'CS294 Class Notes');
$smarty->assign('v_name', 'winter 2010');
$smarty->assign('u_name', 'mlinsey');
$smarty->assign('other_u_name', 'mlee');
$smarty->assign('other_v_name', 'winter 2010');

// we should flesh out all the different phrases instead of doing this:
$smarty->assign(history, array(
	array("left", "images/mlinsey.jpg","you are now editing <span class='v_name'>winter 2010</span>, which you saved 5m ago"),
	array("right", "images/dtran.jpg","you started from dtran's <span class='v_name'>winter 2010</span> 5m ago"),

	));
$smarty->assign(others, array(
	array('images/mlee.jpg', '<a class="v_name">winter 2010</a><br/>by mlee 8h ago'),
	array('images/dtran.jpg', '<a class="v_name">winter 2010</a><br />by dtran 1d ago'),
	array('images/bella8.jpg', '<a class="v_name">fall 2008</a><br />by bella8 2y ago'),
	));


// copied from diff_example.php which is from http://svn.kd2.org/svn/misc/libs/diff/
$old = 'This part of the document has stayed the
same from version to version.  It shouldn\'t
be shown if it doesn\'t change.  Otherwise, that
would not be helping to
compress the size of the
changes.

This paragraph contains
text that is outdated.
It will be deleted in the
near future.

It is important to spell
check this dokument. On
the other hand, a
misspelled word isn\'t
the end of the world.
Nothing in the rest of
this paragraph needs to
be changed. Things can
be added after it.


';

$new = 'This is an important notice! It should
therefore be located at the beginning of this
document! 
This part of the document has stayed the
same from version to version.  It shouldn\'t
be shown if it doesn\'t change.  Otherwise, that
would not be helping to compress anything.

It is important to spell
check this document. On
the other hand, a
misspelled word isn\'t
the end of the world.
Nothing in the rest of
this paragraph needs to
be changed. Things can
be added after it.  This paragraph contains 
important 
new additions to this document.';


    $diff = simpleDiff::diff_to_array(false, $old, $new, 10);

    $out = '';
    $prev = key($diff);

    foreach ($diff as $i=>$line)
    {
        if ($i > $prev + 1)
        {
            $out .= '<tr><td colspan="5" class="separator"><hr /></td></tr>';
        }

        list($type, $old, $new) = $line;

        $class1 = $class2 = '';
        $t1 = $t2 = '';

        if ($type == simpleDiff::INS)
        {
            $class2 = 'ins';
            $t2 = '+';
        }
        elseif ($type == simpleDiff::DEL)
        {
            $class1 = 'del';
            $t1 = '-';
        }
        elseif ($type == simpleDiff::CHANGED)
        {
            $class1 = 'del';
            $class2 = 'ins';
            $t1 = '-';
            $t2 = '+';

            $lineDiff = simpleDiff::wdiff($old, $new);

            // Don't show new things in deleted line
            $old = preg_replace('!\{\+(?:.*)\+\}!U', '', $lineDiff);
            $old = str_replace('  ', ' ', $old);
            $old = str_replace('-] [-', ' ', $old);
            $old = preg_replace('!\[-(.*)-\]!U', '<del>\\1</del>', $old);

            // Don't show old things in added line
            $new = preg_replace('!\[-(?:.*)-\]!U', '', $lineDiff);
            $new = str_replace('  ', ' ', $new);
            $new = str_replace('+} {+', ' ', $new);
            $new = preg_replace('!\{\+(.*)\+\}!U', '<ins>\\1</ins>', $new);
        }

        $out .= '<tr>';
        $out .= '<td class="line">'.($i+1).'</td>';
        $out .= '<td class="leftChange">'.$t1.'</td>';
        $out .= '<td class="leftText '.$class1.'">'.$old.'</td>';
        $out .= '<td class="rightChange">'.$t2.'</td>';
        $out .= '<td class="rightText '.$class2.'">'.$new.'</td>';
        $out .= '</tr>';

        $prev = $i;
    }

    $out .= '';

$smarty->assign('diff', $out);

$smarty->display('compare.tpl');
?>
