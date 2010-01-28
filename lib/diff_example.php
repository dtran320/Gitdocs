<?php

//from http://svn.kd2.org/svn/misc/libs/diff/
error_reporting(E_ALL);

require dirname(__FILE__) . '/simplediff.php';

$original = 'This part of the
document has stayed the
same from version to
version.  It shouldn\'t
be shown if it doesn\'t
change.  Otherwise, that
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
be added after it.';

$updated = 'This is an important
notice! It should
therefore be located at
the beginning of this
document!

This part of the
document has stayed the
same from version to
version.  It shouldn\'t
be shown if it doesn\'t
change.  Otherwise, that
would not be helping to
compress anything.

It is important to spell
check this document. On
the other hand, a
misspelled word isn\'t
the end of the world.
Nothing in the rest of
this paragraph needs to
be changed. Things can
be added after it.

This paragraph contains
important new additions
to this document.';

echo '
<style type="text/css">
.ins { background: #cfc; }
.del { background: #fcc; }
ins { background: #9f9; }
del { background: #f99; }
hr { background: none; border: none; border-top: 2px dotted #000; color: #fff; }
</style>
<pre>
';

echo html_diff($original, $updated);

function html_diff($old, $new)
{
    $diff = simpleDiff::diff_to_array(false, $old, $new, 1);

    $out = '<table class="diff">';
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

    $out .= '</table>';
    return $out;
}

?>
