<?
require('init_smarty.php');

$smarty->assign('d_name', 'Twilight Fanfic:Edward and Jacob!!');
$smarty->assign('v_name', 'forest2');
$smarty->assign('v_text', '<p>“Coming out with us Masen?”</p>

				<p>“No thanks,” Edward replied, barely taking a glimpse at Newton<span class="your_changes" id="text_change1">, who was standing way too close to him for his liking</span>.</p>

				<p>“Two nights in a row? This aint like you.”</p>

				<p>Shaking his head, Edward rolled his eyes at the Cubs’ first baseman and then turned to finish towel-drying his hair. He’d spend tonight just as he had spent last night; lying in his hotel room, reading one of the books Bella let him borrow. And he planned to call Bella first because he wanted to hear her voice, even though she’d most likely pick on him again for losing another game – their fourth straight.</p>

				<p>Last night, when he’d called her, she was hanging out with her friends and she started going over every mistake he had made on the field. It honestly didn’t bother him at first because it was Bella and he had started to just accept her as the fan that she was. She was actually quite cute as she discussed baseball with him – it was the first time she had openly spoke about it so passionately – probably because she had been drinking. It was when Emmett grabbed the phone from her and started giving him a pep talk that he decided to end the call.</p>

				<p>It still bothered Edward that Bella hung out with her ex-boyfriend, but he didn’t understand why exactly. He knew it was an irrational feeling, as they were obviously just friends, yet it still upset him. Emmett had been her first in everything, she had told him, and Edward would never be with her in that way. Maybe that was why it upset him so much – he’d never be as close to her as Emmett was because they shared a special bond. Besides, on top of that, it was plain to Edward that she didn’t look at him as he looked at her.</p>

				<p>When he took care of her while she was sick, it had been as if she were trying to get rid of him. Most people – girls – he knew loved being taken care of by their men. Edward thought of the time Esme boasted to him about how Carlisle cared for her when she had the flu. You would think Carlisle could walk on water the way she spoke of him. But Bella didn’t want him caring for her. Bella didn’t want him at her townhome – it was painfully obvious. It didn’t deter him though because she was his friend.</p>

				<p>Keep telling yourself that, Masen! His inner monologue argued.</p>

				<p>“I heard you’re going out with Newton,” Jazz said, startling Edward as he put on his deodorant.</p>

				<p>“No, I’m heading back. You?”</p>
	');

$smarty->assign(history, array(
	array("left", "images/mlinsey.jpg","you are now editing <span class='v_name'>forest2</span>, which you saved 2m ago"),
	array("right", "images/mlee.jpg","you combined parts from mlee's <span class='v_name'>desc. of Edward</span> 2m ago"),
	array("left", "images/mlinsey.jpg","you edited <span class='v_name'>forest2</span> 4m ago"),
	array("right", "images/dtran.jpg","you started from dtran's <span class='v_name'>forest</span> 5m ago"),

	));

$smarty->assign(others, array(
	array('images/mlee.jpg', '<a href="compare.php" class="v_name">new desc. of Edward</a><p class="med_text no_line_height">by mlee 8h ago</p>'),
	array('images/dtran.jpg', '<a class="v_name">forest</a><br />by dtran 1d ago'),
	array('images/bella8.jpg', '<a class="v_name">forest</a><br />by bella8 2d ago'),
	));

$smarty->display('editor.tpl');
?>
