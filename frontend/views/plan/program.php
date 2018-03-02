<?php
/* @var $this yii\web\View */

$this->title = $subject->title;
$this->params['breadcrumbs'][] = ['label' => 'Учебные планы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->header, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div id="rpd" class="col-xs-offset-2 col-xs-8">
<h2>Аннотация</br>рабочей программы дисциплины</br><?= $subject->code ?> "<?= $subject->title ?>"</h2>
<p>Общая трудоемкость (объем) дисциплины составляет <?= $subject->units ?> зачетн<?php 
		if($subject->units % 10 == 1) 			print('ую');
		else if(1 < $subject->units % 10 && $subject->units % 10< 5) 	print('ые');
		else									print('ых');
		?>
 единиц<?php 	if($subject->units % 10 == 1) 			print('у');
		else if(1 < $subject->units % 10 && $subject->units % 10 < 5) 	print('ы');
		?>
 (ЗЕ),  <?= $subject->totalHours ?> академическ<?php 
 		if($subject->totalHours % 10 == 1) 			print('ий');
 		else									print('их');
 		?> час<?php 
 		if(1 < $subject->totalHours % 10 && $subject->totalHours % 10 < 5) 	print('а');
 		else									print('ов'); 		
 		?>.</p>
<h2>Объем дисциплины по видам учебных занятий (в часах)</h2>
<table cellpadding="10" border="1">
	<tr>
		<th><center>Объем дисциплины</center></th>
		<th class="hoursCell"><center>Всего</center></th>
	</tr>
	<tr>
		<td>Общая трудоемкость дисциплины, ЗЕ/часы</td>
		<td class="hoursCell"><?= $subject->units ?>/<?= $subject->totalHours ?></td>
	</tr>
	<tr>
		<td>Контактная работа обучающихся с преподавателем (по видам учебных занятий), всего</td>
		<td class="hoursCell"><?= $subject->getClassHours() ?></td>
	</tr>
	<tr>
		<td>Аудиторная работа по учебному плану (всего):</td>
		<td class="hoursCell"><?= $subject->getClassHours() ?></td>
	</tr>
	<tr>
		<td>в том числе:</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class='tab'>Лекции</td>
		<td class="hoursCell"><?= $subject->lecturesHours != 0 ? $subject->lecturesHours : '-' ?></td>
	</tr>
	<tr>
		<td class='tab'>Практические занятия</td>
		<td class="hoursCell"><?= $subject->practicHours != 0 ? $subject->practicHours : '-' ?></td>
	</tr>
	<tr>
		<td class='tab'>Лабораторные работы</td>
		<td class="hoursCell"><?= $subject->labHours != 0 ? $subject->labHours : '-' ?></td>
	</tr>
	<tr>
		<td>Самостоятельная работа обучающихся (всего)</td>
		<td class="hoursCell"><?= $subject->srs ?></td>
	</tr>
	<?php if($subject->kontrStr != ""): ?>
		<tr>
			<td>Контрольная работа</td>
			<td class="hoursCell">&nbsp;</td>
		</tr>
		<tr>
			<td class="tab"><?= $subject->zaoch ? 'Курс' : 'Семестр'?> обучения</td>
			<td class="hoursCell"><?= $subject->kontrStr ?></td>
		</tr>
	<?php endif; ?>
	<?php if($subject->zachStr != ""): ?>
		<tr>
			<td>Вид промежуточной аттестации обучающегося – зачет</td>
			<td class="hoursCell"><?= $subject->zaoch ? $subject->zachHours : 'Зачет' ?></td>
		</tr>
		<tr>
			<td class="tab"><?= $subject->zaoch ? 'Курс' : 'Семестр'?> обучения</td>
			<td class="hoursCell"><?= $subject->zachStr ?></td>
		</tr>
	<?php endif; ?>
	<?php if($subject->kursStr != ""): ?>
		<tr>
			<td>Вид промежуточной аттестации обучающегося – курсовая работа</td>
			<td class="hoursCell">курсовая</td>
		</tr>
		<tr>
			<td class="tab"><?= $subject->zaoch ? 'Курс' : 'Семестр'?> обучения</td>
			<td class="hoursCell"><?= $subject->kursStr ?></td>
		</tr>
	<?php endif; ?>
	<?php if($subject->examStr != ""): ?>
		<tr>
			<td>Вид промежуточной аттестации обучающегося – экзамен</td>
			<td class="hoursCell"><?= $subject->examHours ?></td>
		</tr>
		<tr>
			<td class="tab"><?= $subject->zaoch ? 'Курс' : 'Семестр'?> обучения</td>
			<td class="hoursCell"><?= $subject->examStr ?></td>
		</tr>
	<?php endif; ?>
</table>
</br>
<h2>Перечень планируемых результатов обучения, соотнесенных с планируемыми результатами освоения образовательной программы</h2>
<table cellpadding="10" border="1">
<tr>
	<td><center>Коды</br>компетенции (по ФГОС ВО)</center></td>
	<td><center>Результаты освоения ОП</br>Содержание компетенций согласно ФГОС ВО</center></td>
</tr>
<?php foreach($subject->competencies as $item) : ?>
<tr>
  <td><center><strong><?= $item['code'] ?></strong></center></td>
  <td><?= $item['text'] ?></td>
</tr>
<?php endforeach; ?>
</table>
</br>
<h2>Распределение часов по <?= $subject->zaoch ? 'курс' : 'семестр'?>ам и по видам учебных занятий</h2>
<table class="semesters" border="1">
<tr>
	<td rowspan="2">
	<?= $subject->zaoch ? 'Курс' : 'Семестр'?>
	</td>
	<td colspan="5">
	Объем в часах по видам учебной работы
	</td>
</tr>
<tr>
	<td>Всего</td>
	<td>Лекции</td>
	<td>Практические</br>занятия</td>
	<td>Лабораторные</br>работы</td>
	<td>СРС</td>
</tr>
<?php foreach($subject->semesters as $num => $semester) : ?>
<tr class="bold">
	<td><?= $num ?></td>
	<td><?= $semester->total != 0 ? $semester->total : '-' ?></td>
	<td><?= $semester->lectures != 0 ? $semester->lectures : '-' ?></td>
	<td><?= $semester->practics != 0 ? $semester->practics : '-' ?></td>
	<td><?= $semester->labs != 0 ? $semester->labs : '-' ?></td>
	<td><?= $semester->srs != 0 ? $semester->srs : '-' ?></td>
</tr>
<?php endforeach; ?>
<tr class="bold">
	<td>Итого</td>
	<td><?= $subject->totalHours ?></td>
	<td><?= $subject->lecturesHours != 0 ? $subject->lecturesHours : '-' ?></td>
	<td><?= $subject->practicHours != 0 ? $subject->practicHours : '-' ?></td>
	<td><?= $subject->labHours != 0 ? $subject->labHours : '-' ?></td>
	<td><?= $subject->srs != 0 ? $subject->srs : '-' ?></td>
</tr>
</table>
</div>
</div>
