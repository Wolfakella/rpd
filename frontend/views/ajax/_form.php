<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>

<div class="plan-form">
<?= Html::button(Yii::t('app', 'Set data'), ['class' => 'btn btn-primary autocompleteStart']) ?>

<div class="hidden autocompleteForm">
    <?= Html::beginForm('', 'post', ['class' => 'form-inline']); ?>
    <?= Html::input('text', 'query', null, ['class' => 'form-control autocomplete']) ?>
    <?= Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-success form-control autocompleteButton']) ?>
    <?= Html::endForm(); ?>
</div>

</div>
