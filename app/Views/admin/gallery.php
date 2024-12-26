<?= $this->extend('admin/layouts/main');?>
<?= $this->section('content');?>
<div class="gallery-container">
    <div class="add-photo">
        <input type="file" id="fileInputSingle" name="photo" />
    </div>
    <div class="photo-list">
        <?php if (!empty($photos)): ?>
            <?php foreach ($photos as $photo): ?>
                <div class="photo-item">
                    <img src="<?= base_url('uploads/' . $photo['name']); ?>" alt="Photo">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No photos available.</p>
        <?php endif; ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#fileInputSingle').DragDropLibrary({ allowMultiple: false });
    });
</script>
<?= $this->endSection();?>