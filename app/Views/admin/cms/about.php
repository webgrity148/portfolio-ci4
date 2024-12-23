<?= $this->extend('admin/layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card p-2">
    <div class="card-body">
        <h5 class="card-title">About</h5>
        <form action="<?= base_url('admin/cms/about') ?>" method="post">
            <div class="form-group">
                <textarea name="about" id="about" class="form-control texteditor" col="10"><?= getMetaData('about') ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
<script>
    tinymce.init({
        selector: '.texteditor',
        plugins: 'preview image media code searchreplace autolink visualblocks visualchars fullscreen link codesample table charmap anchor insertdatetime advlist lists emoticons',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | image media code | forecolor backcolor permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile pageembed link anchor codesample | a11ycheck ltr rtl | showcomments addcomment | add_class',
        style_formats: [
            { title: 'Custom Class', block: 'span', classes: 'custom-class' },
            // ...existing formats...
        ],
        setup: function(editor) {
            editor.ui.registry.addMenuItem("custom_class", {
                text: "Custom Class",
                onAction: function() {
                    tinymce.activeEditor.formatter.apply("custom_class");
                }
            });

            editor.ui.registry.addButton("add_class", {
                tooltip: "Add Custom Class",
                icon: "edit-block",
                onAction: function() {
                    var className = prompt("Enter the class name:");
                    if (className) {
                        var selectedNode = tinymce.activeEditor.selection.getNode();
                        tinymce.activeEditor.dom.addClass(selectedNode, className);
                    }
                }
            });
        },
        height: '500',
        images_upload_url: "/admin/cms/upload",
        media_live_embeds: true,
        images_upload_credentials: true,
        relative_urls: false,
        remove_script_host: false,
    });
</script>
<?= $this->endSection(); ?>