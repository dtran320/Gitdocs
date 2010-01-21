<? include('header.php'); ?>

<?
$query = isset($_GET["query"])? $_GET["query"] : "";
$query = htmlspecialchars($query, ENT_QUOTES);

?>
 <div class="container">
<form id="form_search" class="big_form" action="" method="get">
<input type="text" name="query" value="<?= $query ?>" />
<input type="submit" value="Search" />
</form>

<div>
<table class="table_tag">
<tr><th>Found ## of your documents that matched <?= $query ?></th></tr>
<tr><td>asdfasdf</td></tr>
<tr><td>jkljkljl</td></tr>
<tr><td>eiwuorueoiw</td></tr>
<tr><td>asdfasdfasdf</td></tr>
<tr><td>asdfasdf</td></tr>
</table>
</div>
<table class="table_tag">
<tr><th>Found ## public documents that matched <?= $query ?></th></tr>
<tr><td>asdfasdf -- need to show author/time/....</td></tr>
<tr><td>jkljkljl</td></tr>
<tr><td>eiwuorueoiw</td></tr>
<tr><td>asdfasdfasdf</td></tr>
<tr><td>asdfasdf</td></tr>
</table>
</div>

</div>
<? include('footer.php'); ?>