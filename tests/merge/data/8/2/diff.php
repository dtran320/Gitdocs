<?php
array_push($diffArray, new Diff($doc->docId,0,0,UserDiffAction::accepted, DiffType::del,0));
array_push($diffArray, new Diff($doc->docId,0,0,UserDiffAction::accepted, DiffType::ins,1));
?>
