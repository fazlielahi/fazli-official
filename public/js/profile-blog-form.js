(function () {
    function setupImagePreview(inputSelector, previewContainerId) {
        var input = document.querySelector(inputSelector);
        var preview = document.getElementById(previewContainerId);
        if (!input || !preview) {
            return;
        }

        var invalidMsg = input.getAttribute('data-invalid-msg') || 'Please select a valid image file.';
        var sizeMsg = input.getAttribute('data-size-msg') || 'File size must be less than 5MB.';

        input.addEventListener('change', function (e) {
            var file = e.target.files[0];
            if (!file) {
                return;
            }

            if (!file.type.startsWith('image/')) {
                alert(invalidMsg);
                input.value = '';
                return;
            }

            var maxSize = 5 * 1024 * 1024;
            if (file.size > maxSize) {
                alert(sizeMsg);
                input.value = '';
                return;
            }

            var reader = new FileReader();
            reader.onload = function (ev) {
                preview.innerHTML = '';

                var wrapper = document.createElement('div');
                wrapper.className = 'profile-edit__preview-wrap';

                wrapper.innerHTML =
                    '<img src="' + ev.target.result + '" class="profile-edit__preview-img" alt="">' +
                    '<button type="button" class="profile-edit__preview-remove" aria-label="Remove">' +
                    '<i class="fa-solid fa-times" aria-hidden="true"></i></button>';

                wrapper.querySelector('.profile-edit__preview-remove').addEventListener('click', function () {
                    input.value = '';
                    preview.innerHTML = '';
                });

                preview.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        });
    }

    window.initProfileBlogForm = function () {
        setupImagePreview('.profile-blog-form__thumb-input', 'thumb-preview-container');
        setupImagePreview('.profile-blog-form__image-input', 'image-preview-container');
        setupExistingImageRemoval();
    };

    function setupExistingImageRemoval() {
        var form = document.getElementById('profileBlogEditForm');
        if (!form) {
            return;
        }

        form.querySelectorAll('.profile-blog-form__remove-existing').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var target = btn.getAttribute('data-target');
                var containerId = target === 'thumb' ? 'thumb-preview-container' : 'image-preview-container';
                var inputId = target === 'thumb' ? 'thumb' : 'image';
                var hiddenName = target === 'thumb' ? 'remove_thumb' : 'remove_image';
                var msg = form.getAttribute(target === 'thumb' ? 'data-remove-thumb-msg' : 'data-remove-image-msg') || '';

                if (form.querySelector('input[name="' + hiddenName + '"]')) {
                    return;
                }

                var hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = hiddenName;
                hidden.value = '1';
                form.appendChild(hidden);

                var container = document.getElementById(containerId);
                if (container) {
                    container.innerHTML = '';
                }

                var input = document.getElementById(inputId);
                if (input) {
                    input.value = '';
                }

                if (msg) {
                    alert(msg);
                }
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', window.initProfileBlogForm);
    } else {
        window.initProfileBlogForm();
    }
})();
