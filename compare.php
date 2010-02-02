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
$old = file_get_contents('tests/data1.txt');
$diff_from_file = file_get_contents('tests/example_alligator.txt');
$diff = simpleDiff::diff_to_array($diff_from_file, $old, false, 100);

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
		$likeable = 'likeable';

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
    } else {
				$likeable = 'notlikeable';
		}


    $out .= '<tr class="' . $likeable . '" id="line'. ($i+1).'">';
    $out .= '<td class="line">'.($i+1).'</td>';
    $out .= '<td class="leftChange">'.$t1.'</td>';
    $out .= '<td class="leftText '.$class1.'"><span class="visibleText">'.$old.'</span><span style="display: none" id="origLeft' .($i+1) .'">' . $old . '</span></td>';
    $out .= '<td class="rightChange">'.$t2.'</td>';
    $out .= '<td class="rightText '.$class2.'"><span class="visibleText">'.$new.'</span><span style="display: none" id="origRight' . ($i+1) .'">' . $new . '</span></td>';
// prototyping shtuff
		$out .= '<td class="likedislike"><span class="like" onclick="like('. ($i+1).');">like</span> | <span class="dislike" onclick="dislike('. ($i+1).');">dislike</span></td>';
// gotta do some studies on this..
    $out .= '</tr>';

    $prev = $i;
}

$out .= '';

$smarty->assign('diff', $out);

$smarty->display('compare.tpl');
?>
