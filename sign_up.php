<?php
session_start();
require_once('classes/user.php');
require_once('classes/version.php');
require_once('lib/twitter.php');
require('init_smarty.php');

$twitter_updates = getGitdocsUpdates(3);
$smarty->assign('twitter_updates', $twitter_updates);

$recent_global_docs = Version::getRecentGlobalVersionsClean(5);
$smarty->assign('recent_global_docs', $recent_global_docs);
$smarty->assign('gitdocs_description', "<p style='float: center;'><img src='images/gitdocs_landing_350x200_blue.png'></p>");
$smarty->display('signup.tpl');

?>
<!-- Google Website Optimizer Tracking Script -->
<script type="text/javascript">
if(typeof(_gat)!='object')document.write('<sc'+'ript src="http'+
(document.location.protocol=='https:'?'s://ssl':'://www')+
'.google-analytics.com/ga.js"></sc'+'ript>')</script>
<script type="text/javascript">
try {
var gwoTracker=_gat._getTracker("UA-9743398-2");
gwoTracker._trackPageview("/2637776227/test");
}catch(err){}</script>
<!-- End of Google Website Optimizer Tracking Script -->
