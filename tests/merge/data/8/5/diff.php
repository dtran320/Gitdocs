<?php
array_push($diffArray, new Diff($doc->docId,0,0,UserDiffAction::rejected, DiffType::del,0));
array_push($diffArray, new Diff($doc->docId,0,0,UserDiffAction::rejected, DiffType::ins,1));
?>
