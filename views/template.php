<?php $id = $this->getUniqueId(); ?>
<?php $class = $this->container_class != null ? $this->container_class : ''; ?>

<div id="<?php echo $id; ?>_box">
    <input type="hidden" rel="<?php echo $id; ?>" class="countdown" value="<?php echo $this->total_seconds; ?>">
    <div id="<?php echo $id; ?>" class="<?php echo $class; ?>"></div>
</div>
