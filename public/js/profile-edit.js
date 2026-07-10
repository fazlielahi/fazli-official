(function () {
    'use strict';

    var modal = document.getElementById('profileEditModal');
    if (!modal) return;

    var i18n = {};
    try {
        i18n = JSON.parse(modal.getAttribute('data-i18n') || '{}');
    } catch (e) {
        i18n = {};
    }

    var dropzone = document.getElementById('profileEditDropzone');
    var photoInput = document.getElementById('profileEditPhoto');
    var preview = document.getElementById('profileEditPreview');
    var previewImg = document.getElementById('profileEditPreviewImg');
    var fileInfo = document.getElementById('profileEditFileInfo');
    var fileName = document.getElementById('profileEditFileName');
    var fileSize = document.getElementById('profileEditFileSize');
    var errorMessage = document.getElementById('profileEditError');
    var successMessage = document.getElementById('profileEditSuccess');
    var removePhotoFlag = document.getElementById('profileEditRemovePhotoFlag');
    var removePhotoBtn = document.getElementById('profileEditRemovePhoto');
    var lastFocused = null;

    function openModal() {
        lastFocused = document.activeElement;
        modal.hidden = false;
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('profile-edit-modal-open');
        var nameInput = document.getElementById('profileEditName');
        if (nameInput) {
            setTimeout(function () { nameInput.focus(); }, 50);
        }
    }

    function closeModal() {
        modal.hidden = true;
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('profile-edit-modal-open');
        if (lastFocused && typeof lastFocused.focus === 'function') {
            lastFocused.focus();
        }
    }

    window.openProfileEditModal = openModal;
    window.closeProfileEditModal = closeModal;

    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-open-profile-edit]')) {
            e.preventDefault();
            openModal();
        }
        if (e.target.closest('[data-close-profile-edit]')) {
            e.preventDefault();
            closeModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.hidden) {
            closeModal();
        }
    });

    if (modal.getAttribute('data-open-on-load') === '1') {
        openModal();
    }

    if (!dropzone || !photoInput) return;

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(function (eventName) {
        dropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
        }, false);
    });

    ['dragenter', 'dragover'].forEach(function (eventName) {
        dropzone.addEventListener(eventName, function () {
            dropzone.classList.add('is-dragover');
        }, false);
    });

    ['dragleave', 'drop'].forEach(function (eventName) {
        dropzone.addEventListener(eventName, function () {
            dropzone.classList.remove('is-dragover');
        }, false);
    });

    dropzone.addEventListener('drop', function (e) {
        handleFiles(e.dataTransfer.files);
    }, false);

    photoInput.addEventListener('change', function (e) {
        handleFiles(e.target.files);
    });

    dropzone.addEventListener('click', function (e) {
        if (e.target !== photoInput) {
            photoInput.click();
        }
    });

    photoInput.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    function handleFiles(files) {
        if (!files.length) return;

        var file = files[0];

        if (!file.type.startsWith('image/')) {
            showError(i18n.invalidImage || 'Please select a valid image file.');
            return;
        }

        var maxSize = 2 * 1024 * 1024;
        if (file.size > maxSize) {
            showError(i18n.photoErrorSize || 'File is too large.');
            return;
        }

        if (removePhotoFlag) {
            removePhotoFlag.value = '';
        }

        var dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        photoInput.files = dataTransfer.files;

        showFileInfo(file);
        createPreview(file);
        showSuccess(i18n.imageSelected || 'Image selected.');
    }

    function showFileInfo(file) {
        fileName.textContent = (i18n.fileLabel || 'File:') + ' ' + file.name + ' · ';
        fileSize.textContent = (i18n.sizeLabel || 'Size:') + ' ' + formatFileSize(file.size);
        fileInfo.classList.add('is-visible');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        var k = 1024;
        var sizes = ['Bytes', 'KB', 'MB', 'GB'];
        var i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function createPreview(file) {
        var reader = new FileReader();
        reader.onload = function (e) {
            if (!preview) return;
            preview.innerHTML = '';
            var wrap = document.createElement('div');
            wrap.className = 'profile-edit__preview-wrap';
            wrap.innerHTML =
                '<img src="' + e.target.result + '" alt="Preview" class="profile-edit__preview-img">' +
                '<button type="button" class="profile-edit__preview-remove" aria-label="Remove">' +
                '<i class="fa-solid fa-times"></i></button>';
            wrap.querySelector('button').addEventListener('click', clearPreview);
            preview.appendChild(wrap);
        };
        reader.readAsDataURL(file);
    }

    function resetPreview() {
        photoInput.value = '';
        fileInfo.classList.remove('is-visible');
        errorMessage.classList.remove('is-visible');
        successMessage.classList.remove('is-visible');

        if (!preview) return;

        var photoUrl = preview.getAttribute('data-photo-url') || '';
        var hasRemove = preview.getAttribute('data-initial-has-remove') === '1';
        preview.innerHTML =
            '<div class="profile-edit__preview-wrap">' +
            '<img src="' + photoUrl + '" alt="Profile photo" class="profile-edit__preview-img" id="profileEditPreviewImg" onerror="this.onerror=null;this.src=\'' + (previewImg ? previewImg.getAttribute('data-default-src') : '') + '\';">' +
            (hasRemove
                ? '<button type="button" class="profile-edit__preview-remove" id="profileEditRemovePhoto" aria-label="Remove"><i class="fa-solid fa-times"></i></button>'
                : '') +
            '</div>';
        previewImg = document.getElementById('profileEditPreviewImg');
        bindRemovePhoto();
    }

    function clearPreview() {
        resetPreview();
    }

    function showError(message) {
        errorMessage.textContent = message;
        errorMessage.classList.add('is-visible');
        successMessage.classList.remove('is-visible');
        setTimeout(function () {
            errorMessage.classList.remove('is-visible');
        }, 5000);
    }

    function showSuccess(message) {
        successMessage.textContent = message;
        successMessage.classList.add('is-visible');
        errorMessage.classList.remove('is-visible');
        setTimeout(function () {
            successMessage.classList.remove('is-visible');
        }, 3000);
    }

    function bindRemovePhoto() {
        removePhotoBtn = document.getElementById('profileEditRemovePhoto');
        if (!removePhotoBtn) return;
        removePhotoBtn.addEventListener('click', function () {
            if (removePhotoFlag) {
                removePhotoFlag.value = '1';
            }
            photoInput.value = '';
            if (preview) {
                preview.innerHTML = '';
            }
            fileInfo.classList.remove('is-visible');
            showSuccess(i18n.photoRemoved || 'Photo will be removed on save.');
        });
    }

    bindRemovePhoto();
})();
