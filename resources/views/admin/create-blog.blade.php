@extends('admin.layout')

@section('title', __('lang.Create Blog Post'))

@section('content')
 
<div id="main-content">
        <div class="container-fluid">
            <form action="{{ route('localized.admin.blog.store', ['lang' => app()->getLocale()]) }}" method="post" enctype="multipart/form-data">

             @csrf
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>{{ __('lang.New Post') }}</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>                            
                            <li class="breadcrumb-item">{{ __('lang.Blogs') }}</li>
                            <li class="breadcrumb-item active">{{ __('lang.New Post') }}</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="page_action">
                                <a href="{{route('localized.admin.dashboard', ['lang' => app()->getLocale()])}}" class="btn btn-secondary" title="new post">{{ __('lang.Dashboard') }}</a>
                            </div>
                            <div class="p-2 d-flex">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            
                            {{--Display validation errors if any--}}

                            @if($errors->any())

                                @foreach($errors->all() as $error)

                                    <p class="text-danger">{{ $error }}</p>

                                @endforeach

                            @endif
   
                            <div class="form-group">
                                <input type="text"  name="title" value="{{ old('title') }}" class="form-control" placeholder="{{ __('lang.Enter Blog title') }}" />
                            </div>
                            <div class="form-group m-t-20 m-b-20">
                                <label>{{ __('lang.Change Thumbnail') }}</label>
                                <input type="file"  name="thumb" class="image-input-thumb form-control-file" value="{{ old('thumb') }}"  id="exampleInputFile" aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">{{ __('lang.Dimensions: 600x340') }}</small>
                                <div id="thumb-preview-container"></div>
                            </div>
                            <div class="form-group m-t-20 m-b-20">
                                <label>{{__('lang.Change Main Image')}}</label>
                                <input type="file"  name="image" class="image-input-main form-control-file" value="{{ old('image') }}"  id="exampleInputFile" aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">{{ __('lang.Dimensions: 1920x500') }}</small>
                                <div id="image-preview-container"></div>
                            </div>
                            <div class="form-group">
                                <label for="category_id">{{ __('lang.Category') }}</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">{{ __('lang.Select Category') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <textarea  id="content" name="content">
                                {{ old('content') }}
                            </textarea>

                            
                            <div class="form-group m-t-20 m-b-20">
                                <input type="text"  name="meta_title" id="meta_title" value="{{ old('meta_title') }}" class="form-control" placeholder="{{ __('blog.Enter Blog meta title') }}" />
                            </div>

                            <div class="form-group">
                                <label>{{ __('blog.Meta Description') }}</label>
                                <textarea name="meta_description" id="meta_description" class="form-control" placeholder="{{ __('blog.Enter Blog meta description') }}" maxlength="200">{{ old('meta_description') }}</textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="form-text text-muted">{{ __('blog.Brief description for search engines') }}</small>
                                    <small class="form-text" id="desc-char-counter">
                                        <span id="desc-char-count">0</span>/200 characters
                                    </small>
                                </div>
                            </div>

                            <div class="form-group m-t-20 m-b-20">
                                <label>{{ __('blog.Meta Keywords') }}</label>
                                <div class="tags-input-container">
                                    <div class="tags-display" id="tags-display"></div>
                                    <input type="text" id="tag-input" class="form-control" placeholder="{{ __('blog.Type keyword and press Enter') }}" />
                                    <input type="hidden" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}" />
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small class="form-text text-muted">{{ __('blog.Type each keyword and press Enter to add it') }}</small>
                                    
                                </div>
                            </div>

                           
                             @if($user->type === 'super_admin')
                                <label class="mt-3">{{ __('lang.Status') }}</label>
                                <select name="status" class="form-control show-tick">
                                    <option value="draft">{{__('lang.Draft')}}</option>
                                    <option value="published">{{__('lang.Published')}}</option>
                                </select>
                            @else
                                
                                <label class="mt-3">{{ __('lang.Status') }}</label>
                                <select name="status" class="form-control show-tick">
                                    <option selected value="draft">{{__('lang.Draft')}}</option>
                                    <option value="request">{{ __('lang.Request for review') }}</option>
                                </select>
                            @endif

                            <button type="submit" class="btn btn-block btn-primary   m-t-20">{{ __('lang.Post') }}</button>
                        </div>
                    </div>
                </div>            
            </div>
        </form>
        </div>
    </div>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
       CKEDITOR.replace('content', {
            extraAllowedContent: 'img[width,height]{width,height}', // Allow width & height as attributes and styles
            removeFormatAttributes: '',
            image_prefillDimensions: true, 
            allowedContent: true, 
            filebrowserUploadUrl: "{{ route('localized.admin.ckeditor.upload', ['lang' => app()->getLocale()]) }}?_token={{ csrf_token() }}",
            filebrowserUploadMethod: 'form',
            filebrowserUploadMethod: 'xhr'
            
        });
</script>


<style>
    
    .tags-input-container {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 8px;
        min-height: 42px;
        background: white;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 5px;
    }

    .tags-display {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        align-items: center;
    }

    .tag-item {
        background: #142e49;
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .tag-remove {
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
        line-height: 1;
    }

    .tag-remove:hover {
        color: #ff6b6b;
    }

    #tag-input {
        border: none;
        outline: none;
        flex: 1;
        min-width: 120px;
        font-size: 14px;
        padding: 4px;
    }

    #tag-input:focus {
        box-shadow: none;
    }

    #desc-char-counter {
        font-weight: 500;
    }

    #desc-char-counter.text-success {
        color: #28a745 !important;
    }

    #desc-char-counter.text-warning {
        color: #ffc107 !important;
    }

    #desc-char-counter.text-danger {
        color: #dc3545 !important;
    }

</style>

<script>
    setupImagePreview('.image-input-thumb', 'thumb-preview-container');
    setupImagePreview('.image-input-main', 'image-preview-container');
    setupTagsInput();
    setupDescriptionCounter();

    function setupImagePreview(inputSelector, previewContainerId) {
        const input = document.querySelector(inputSelector);
        const preview = document.getElementById(previewContainerId);

        input.addEventListener('change', e => {
            const file = e.target.files[0]; // Only one file
            if (!file) return;

            const reader = new FileReader();
            reader.onload = ev => {
                // Clear previous preview
                preview.innerHTML = '';

                const wrapper = document.createElement('div');
                wrapper.className = 'image-wrapper';

                wrapper.innerHTML = `
                    <img src="${ev.target.result}" class="preview-img">
                    <span class="remove-btn">&times;</span>
                `;

                // Remove button resets the input and preview
                wrapper.querySelector('.remove-btn').onclick = () => {
                    input.value = ''; // Clear file input
                    preview.innerHTML = ''; // Clear preview
                };

                preview.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        });
    }

    function setupTagsInput() {
        const tagInput = document.getElementById('tag-input');
        const tagsDisplay = document.getElementById('tags-display');
        const hiddenInput = document.getElementById('meta_keywords');
        let tags = [];

        // Load existing tags if any (for edit mode)
        if (hiddenInput.value) {
            tags = hiddenInput.value.split(',').map(tag => tag.trim()).filter(tag => tag);
            updateTagsDisplay();
        }

        tagInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addTag();
            } else if (e.key === 'Backspace' && this.value === '' && tags.length > 0) {
                // Remove last tag if input is empty and backspace is pressed
                removeTag(tags.length - 1);
            }
        });

        tagInput.addEventListener('blur', function() {
            if (this.value.trim()) {
                addTag();
            }
        });

        function addTag() {
            const value = tagInput.value.trim();
            if (value && !tags.includes(value)) {
                tags.push(value);
                updateTagsDisplay();
                updateHiddenInput();
                tagInput.value = '';
            }
        }

        function removeTag(index) {
            tags.splice(index, 1);
            updateTagsDisplay();
            updateHiddenInput();
        }

        function updateTagsDisplay() {
            tagsDisplay.innerHTML = '';
            tags.forEach((tag, index) => {
                const tagElement = document.createElement('span');
                tagElement.className = 'tag-item';
                tagElement.innerHTML = `
                    ${tag}
                    <span class="tag-remove" onclick="removeTagByIndex(${index})">&times;</span>
                `;
                tagsDisplay.appendChild(tagElement);
            });
        }

        function updateHiddenInput() {
            hiddenInput.value = tags.join(', ');
        }

        // Make removeTagByIndex globally accessible
        window.removeTagByIndex = function(index) {
            removeTag(index);
        };
    }

    function setupDescriptionCounter() {
        const descTextarea = document.getElementById('meta_description');
        const descCharCount = document.getElementById('desc-char-count');
        const descCharCounter = document.getElementById('desc-char-counter');
        const maxChars = 200;

        function updateDescriptionCount() {
            const currentLength = descTextarea.value.length;
            descCharCount.textContent = currentLength;

            // Update counter color based on usage
            descCharCounter.className = 'form-text';
            if (currentLength >= maxChars) {
                descCharCounter.classList.add('text-danger');
            } else if (currentLength >= 160) {
                descCharCounter.classList.add('text-warning');
            } else {
                descCharCounter.classList.add('text-success');
            }
        }

        // Update character count on input
        descTextarea.addEventListener('input', updateDescriptionCount);
        descTextarea.addEventListener('keyup', updateDescriptionCount);
        descTextarea.addEventListener('paste', function() {
            setTimeout(updateDescriptionCount, 10);
        });

        // Initial count update
        updateDescriptionCount();
    }
</script>
     
@endsection
