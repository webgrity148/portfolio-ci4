(function ($) {
    function DragDropLibrary(element, options) {
        this.element = element;
        this.options = $.extend({}, DragDropLibrary.DEFAULTS, options);
        this.init();
    }

    DragDropLibrary.DEFAULTS = {
        allowMultiple: false,
        previewContainer: null
    };

    DragDropLibrary.prototype.init = function () {
        console.log('DragDropLibrary initialized');
        const inputField = this.element;
        if (!inputField || inputField.type !== "file") {
            console.error(`Element must be an input field of type file.`);
            return;
        }

        // Set the multiple attribute based on allowMultiple
        if (this.options.allowMultiple) {
            inputField.setAttribute('multiple', 'multiple');
        } else {
            inputField.removeAttribute('multiple');
        }

        // Create a wrapper for drag-and-drop
        const wrapper = document.createElement("div");
        wrapper.className = "drag-drop-wrapper";
        wrapper.style.border = "2px dashed #ccc";
        wrapper.style.padding = "20px";
        wrapper.style.textAlign = "center";
        wrapper.style.cursor = "pointer";

        // Add placeholder text
        const placeholder = document.createElement("p");
        if (!this.options.allowMultiple) {
            placeholder.textContent = "Drag and drop a file here or click to browse.";
        } else {
        placeholder.textContent = "Drag and drop files here or click to browse.";
        }

        placeholder.style.margin = "10px 0";

        // Hide the original file input
        inputField.style.display = "none";

        // Append elements
        wrapper.appendChild(placeholder);
        inputField.parentNode.insertBefore(wrapper, inputField);
        wrapper.appendChild(inputField);

        // Add event listeners for drag-and-drop
        wrapper.addEventListener("dragover", (e) => {
            e.preventDefault();
            wrapper.style.borderColor = "#000";
        });

        wrapper.addEventListener("dragleave", () => {
            wrapper.style.borderColor = "#ccc";
        });

        wrapper.addEventListener("drop", (e) => {
            e.preventDefault();
            wrapper.style.borderColor = "#ccc";
           
            const files = e.dataTransfer.files;
            if (!this.options.allowMultiple && files.length > 1) {
                console.error("Multiple files are not allowed.");
                placeholder.textContent = "Multiple files are not allowed.";
                return;
            }
            inputField.files = files;
            placeholder.textContent = files.length + " file(s) selected.";
            this.showPreviews(files);
        });

        wrapper.addEventListener("click", () => {
            inputField.click();
        });

        inputField.addEventListener("change", () => {
            const files = inputField.files;
            placeholder.textContent = files.length + " file(s) selected.";
            this.showPreviews(files);
        });
    };

    DragDropLibrary.prototype.showPreviews = function (files) {
        if (!this.options.previewContainer) return;

        const previewContainer = document.querySelector(this.options.previewContainer);
        if (!previewContainer) {
            console.error(`Preview container not found: ${this.options.previewContainer}`);
            return;
        }

        previewContainer.innerHTML = ''; // Clear previous previews

        Array.from(files).forEach(file => {
            const fileElement = document.createElement('div');
            fileElement.style.margin = '10px';

            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.style.maxWidth = '100px';
                img.style.maxHeight = '100px';
                fileElement.appendChild(img);
            } else {
                const icon = document.createElement('span');
                icon.textContent = '📄'; // Placeholder icon for non-image files
                fileElement.appendChild(icon);
            }

            const fileName = document.createElement('p');
            fileName.textContent = file.name;
            fileElement.appendChild(fileName);

            previewContainer.appendChild(fileElement);
        });
    };

    $.fn.DragDropLibrary = function (options) {
        return this.each(function () {
            new DragDropLibrary(this, options);
        });
    };
})(jQuery);