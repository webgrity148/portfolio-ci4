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
<div>
    <input type="text" name="" id="amount" class="form-control" placeholder="Enter amount" />
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
<script>
    $(document).ready(function() {
        // $('#fileInputSingle').DragDropLibrary({ allowMultiple: false });
        $('#amount').inputmask('currency', {
            prefix: '$ ',
            rightAlign: false
        });
    });
</script>
<?= $this->endSection();?>