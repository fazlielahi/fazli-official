@php
    $editUser = auth()->user();
    $canRemovePhoto = $editUser->photo && ! in_array($editUser->photo, ['default.svg', 'default.png', 'images/default.png'], true);
    $profileEditI18n = [
        'fileLabel' => __('lang.File:'),
        'sizeLabel' => __('lang.Size:'),
        'invalidImage' => __('lang.Please select a valid image file.'),
        'photoErrorSize' => __('lang.PhotoErrorSize'),
        'imageSelected' => __('lang.Image selected successfully!'),
        'photoRemoved' => __('lang.Current photo will be removed on save.'),
    ];
@endphp

<div
    class="profile-edit-modal"
    id="profileEditModal"
    hidden
    aria-hidden="true"
    data-open-on-load="{{ (request()->query('edit') === 'profile' || session('open_profile_edit') || ($errors->any() && ($errors->has('name') || $errors->has('photo')))) ? '1' : '0' }}"
    data-i18n="{{ json_encode($profileEditI18n) }}"
>
    <div class="profile-edit-modal__backdrop" data-close-profile-edit tabindex="-1" aria-hidden="true"></div>

    <div
        class="profile-edit-modal__dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="profileEditModalTitle"
    >
        <header class="profile-edit-modal__header">
            <h2 class="profile-edit-modal__title" id="profileEditModalTitle">{{ __('lang.Personal Information') }}</h2>
            <button type="button" class="profile-edit-modal__close" data-close-profile-edit aria-label="{{ __('lang.Cancel') }}">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </header>

        <div class="profile-edit-modal__body">
            @if($errors->any())
                <ul class="profile-edit__errors">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('localized.profile-update', ['lang' => app()->getLocale()]) }}" enctype="multipart/form-data" id="profileEditForm">
                @csrf

                <div class="profile-edit__field">
                    <label class="profile-edit__label" for="profileEditName">{{ __('lang.Name') }}</label>
                    <input
                        type="text"
                        name="name"
                        id="profileEditName"
                        value="{{ old('name', $editUser->name) }}"
                        placeholder="{{ __('lang.Enter Your Name') }}"
                        class="profile-edit__input"
                        required
                    >
                </div>

                <div class="profile-edit__field">
                    <label class="profile-edit__label" for="profileEditPhoto">{{ __('lang.Profile Photo') }}</label>

                    <div class="profile-edit__dropzone" id="profileEditDropzone">
                        <div class="profile-edit__dropzone-icon" aria-hidden="true">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>
                        <p class="profile-edit__dropzone-text">{{ __('lang.Drag & drop your photo here') }}</p>
                        <p class="profile-edit__dropzone-hint">{{ __('lang.or click to browse files') }}</p>
                        <p class="profile-edit__dropzone-hint">{{ __('lang.CV form photo hint') }}</p>
                        <input type="file" name="photo" class="profile-edit__file-input" id="profileEditPhoto" accept="image/*">
                    </div>

                    <div class="profile-edit__file-info" id="profileEditFileInfo">
                        <i class="fa-solid fa-circle-info"></i>
                        <span id="profileEditFileName"></span>
                        <span id="profileEditFileSize"></span>
                    </div>

                    <div class="profile-edit__message profile-edit__message--error" id="profileEditError"></div>
                    <div class="profile-edit__message profile-edit__message--success" id="profileEditSuccess"></div>
                </div>

                <div class="profile-edit__preview" id="profileEditPreview" data-initial-has-remove="{{ $canRemovePhoto ? '1' : '0' }}" data-photo-url="{{ userPhotoUrl($editUser) }}">
                    <div class="profile-edit__preview-wrap">
                        <img
                            src="{{ userPhotoUrl($editUser) }}"
                            alt="{{ e($editUser->name ?? 'Profile photo') }}"
                            class="profile-edit__preview-img"
                            id="profileEditPreviewImg"
                            data-default-src="{{ asset('images/default.svg') }}"
                            onerror="this.onerror=null;this.src='{{ asset('images/default.svg') }}';"
                        >
                        @if($canRemovePhoto)
                            <button type="button" class="profile-edit__preview-remove" id="profileEditRemovePhoto" aria-label="{{ __('lang.Remove') }}">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <input type="hidden" name="remove_photo" id="profileEditRemovePhotoFlag" value="">

                <footer class="profile-edit-modal__footer">
                    <button type="button" class="profile-edit-modal__cancel" data-close-profile-edit>{{ __('lang.Cancel') }}</button>
                    <button type="submit" class="profile-edit__submit">
                        <i class="fa-solid fa-check"></i>
                        {{ __('lang.Update') }}
                    </button>
                </footer>
            </form>
        </div>
    </div>
</div>
