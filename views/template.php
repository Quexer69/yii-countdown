<?php $id = CountDownWidget::getUniqueId(); ?>

<div id="<?php echo $id; ?>_box">
    <input type="hidden" rel="<?php echo $id; ?>" class="countdown" value="<?php echo $total_seconds; ?>">
    <div id="<?php echo $id; ?>" class="<?php echo $class; ?>"></div>
</div>
