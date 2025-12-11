const AdminApp = {
    init: function () {
        console.log('Admin App Initializing...');
        // DEBUG ALERT
        // alert('Admin JS Loaded - System Ready'); 
        this.setupCategoryLegacy();
        this.setupImagePreviews();
        this.showStatus('JS LOADED SUCCESS');
    },

    setupCategoryLegacy: function () {
        const categorySelect = document.getElementById('category_id');
        if (categorySelect) {
            categorySelect.addEventListener('change', function () {
                var text = this.options[this.selectedIndex].text;
                const legacyInput = document.getElementById('category_legacy');
                if (legacyInput) {
                    legacyInput.value = text;
                }
            });
        }
    },

    setupImagePreviews: function () {
        // Initialize for standard IDs
        this.bindImagePreview('image', 'imagePreviewContainer', 'imagePreview', 'currentImageContainer');
    },

    bindImagePreview: function (inputId, previewContainerId, previewImageId, currentContainerId) {
        const imageInput = document.getElementById(inputId);
        const previewContainer = document.getElementById(previewContainerId);
        const previewImage = document.getElementById(previewImageId);
        const currentContainer = currentContainerId ? document.getElementById(currentContainerId) : null;

        if (!imageInput) {
            console.log(`Image input #${inputId} not found on this page.`);
            return;
        }

        console.log(`Binding preview to #${inputId}`);

        // VISUAL DEBUG: Proves JS touched this element
        imageInput.style.border = "3px solid red";
        imageInput.setAttribute('data-js-bound', 'true');

        imageInput.addEventListener('change', function (e) {
            console.log('File interaction detected');
            const file = e.target.files[0];

            if (file) {
                // Validate type
                if (!file.type.match('image.*')) {
                    alert('Please select a valid image file (JPG, PNG, GIF).');
                    this.value = '';
                    if (previewContainer) previewContainer.style.display = 'none';
                    if (currentContainer) currentContainer.style.display = 'block';
                    return;
                }

                // Validate size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB.');
                    this.value = '';
                    if (previewContainer) previewContainer.style.display = 'none';
                    if (currentContainer) currentContainer.style.display = 'block';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    if (previewImage) {
                        previewImage.src = e.target.result;
                    }
                    if (previewContainer) previewContainer.style.display = 'block';
                    if (currentContainer) currentContainer.style.display = 'none';
                }
                reader.readAsDataURL(file);
            } else {
                if (previewContainer) previewContainer.style.display = 'none';
                if (currentContainer) currentContainer.style.display = 'block';
            }
        });
    },

    showStatus: function (msg) {
        const statusDiv = document.getElementById('js-connection-status');
        if (statusDiv) {
            statusDiv.style.background = 'green';
            statusDiv.innerText = msg;
            setTimeout(() => statusDiv.style.display = 'none', 3000);
        }
    }
};

// Robust Loading
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => AdminApp.init());
} else {
    AdminApp.init();
}
