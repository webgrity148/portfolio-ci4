<?= $this->extend('admin/layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="card p-2">
    <div class="card-body">
    <?php $cv = getMetaData('cv'); ?>
    <?php if ($cv): ?>
        <p>Your current CV: <?= $cv ?></p>
        <p>
        <a href="<?= base_url('uploads/documents/' . $cv) ?>" id="confirmDwonload" class="btn btn-info  btn-icon-split" download>
                <span class="icon text-white-50">
                <i class="fa-solid fa-cloud-arrow-down"></i>
                </span>
                <span class="text">Download CV</span>
            </a>
        <button  id="viewCV" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                <i class="fa-solid fa-eye"></i>
                </span>
                <span class="text">View CV</span>
            </button>

        </p>
        <div id="pdfViewer" style="display:none;">
            <iframe src="<?= base_url('uploads/documents/' . $cv) ?>" width="100%" height="500px"></iframe>
        </div>
    <?php endif; ?>
        <h5 class="card-title">Manage CV</h5>
        <div id="droppable" class="custom-drag-drop">
            <p>Drop here or click to choose a file</p>
        </div>
        <form id="uploadForm" action="<?= base_url('admin/manage-cv/upload') ?>" method="post" enctype="multipart/form-data" style="display:none;">
            <input type="file" id="fileInput" name="file" accept=".pdf,.doc,.docx">
        </form>
        <div id="filePreview" style="display:none;">
            <p>File ready to upload: <span id="fileName"></span></p>
            <button id="confirmUpload" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                <i class="fa-solid fa-upload"></i>
                </span>
                <span class="text">Confirm Upload</span>
            </button>
        </div>
    </div>
    <script>
        $(function() {
            var $droppable = $("#droppable");
            var $fileInput = $("#fileInput");
            var $filePreview = $("#filePreview");
            var $fileName = $("#fileName");

            $droppable.on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass("drag-over");
            });

            $droppable.on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass("drag-over");
            });

            $droppable.on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass("drag-over").addClass("ui-state-highlight").find("p").html("File ready to upload!");

                var files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    $fileInput.prop('files', files);
                    showPreview(files[0]);
                }
            });

            $droppable.on('click', function() {
                $fileInput.click();
            });

            $fileInput.on('change', function() {
                var files = this.files;
                if (files.length > 0) {
                    showPreview(files[0]);
                }
            });

            function showPreview(file) {
                $fileName.text(file.name);
                $filePreview.show();
            }

            $("#confirmUpload").on('click', function() {
                $("#uploadForm").submit();
            });

            $("#viewCV").on('click', function() {
                $("#pdfViewer").toggle();
            });

            $(document).on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
            });

            $(document).on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
            });
        });
    </script>
    <style>
        .custom-drag-drop {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }

        .custom-drag-drop.drag-over {
            border-color: #000;
        }

        .custom-drag-drop.ui-state-highlight {
            border-color: #4CAF50;
            background-color: #dff0d8;
        }
    </style>
    <?= $this->endSection(); ?>