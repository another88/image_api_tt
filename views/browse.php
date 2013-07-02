<div id="content">
<?php $images = $model->getAllImages(); ?>
<?php if(count($images)): ?>
    <?php foreach ($model->getAllImages() as $key => $value): ?>
        <div class = "image_item">
            <img width="200" src="<?php echo $model->getImageUrl($value['name']) ?>" class="img-polaroid">
            <div class = "crearfix"></div>
            <a href="/browse?delete=<?php echo $value['id']; ?>"><i class="icon-trash"></i>Delete</a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-error">No images</p>
<?php endif; ?>
</div>