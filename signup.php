<?php
session_start();
?>
<!-- Google Website Optimizer Control Script -->
<script>
function utmx_section(){}function utmx(){}
(function(){var k='2637776227',d=document,l=d.location,c=d.cookie;function f(n){
if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.indexOf(';',i);return c.substring(i+n.
length+1,j<0?c.length:j)}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;
d.write('<sc'+'ript src="'+
'http'+(l.protocol=='https:'?'s://ssl':'://www')+'.google-analytics.com'
+'/siteopt.js?v=1&utmxkey='+k+'&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='
+new Date().valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
'" type="text/javascript" charset="utf-8"></sc'+'ript>')})();
</script><script>utmx("url",'A/B');</script>
<!-- End of Google Website Optimizer Control Script -->

<?
require_once('classes/user.php');
require_once('classes/version.php');
require_once('lib/twitter.php');
require('init_smarty.php');

$twitter_updates = getGitdocsUpdates(3);
$smarty->assign('twitter_updates', $twitter_updates);

$recent_global_docs = Version::getRecentGlobalVersionsClean(5);
$smarty->assign('recent_global_docs', $recent_global_docs);
$smarty->assign('gitdocs_description', "<p>Why study for tests in isolation? Want to share notes but not sure how to do so effectively? 
Gitdocs allows you to upload your class notes and manage sections of notes from your classmates,
choosing only those contributions you feel will be helpful to your version of your notes.</p>");
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
