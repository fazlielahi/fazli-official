@extends('admin.layout')

@section('title', __('lang.Edit Blog Post'))

@section('content')

<div id="main-content">
        <div class="container-fluid">
            <form action="{{ route('localized.admin.blog.update', ['lang' => app()->getLocale(), $blog->id]) }}" method="post" enctype="multipart/form-data">

                @csrf 
                @method('PUT')
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>{{ __('lang.Edit Post') }}</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>                            
                            <li class="breadcrumb-item">{{ __('lang.Blogs') }}</li>
                            <li class="breadcrumb-item active">{{ __('lang.Edit Post') }}</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="page_action">
                                <a href="{{route('localized.admin.blog', ['lang' => app()->getLocale()])}}" class="btn btn-secondary" title="new post">{{ __('lang.Back to Blogs') }}</a>
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
                                <input type="text"  name="title" value="{{ old('title', $blog->title) }}" class="form-control" placeholder="{{ __('lang.Enter Blog title') }}" />
                            </div>
                            <div class="form-group m-t-20 m-b-20">
                                 <label>{{ __('lang.Change Thumbnail') }}</label>
                                <input type="file"  name="thumb" class="image-input-thumb form-control-file" value="{{ old('image', $blog->thumb) }}"  id="exampleInputFile" aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">{{ __('lang.Dimensions: 600x340') }}</small>
                                <div id="thumb-preview-container">
           
                                    @if($blog->thumb)
                                        <img src="{{ asset('storage/' . $blog->thumb) }}" alt="Blog Thumbnail" width="100">
                                    @endif
                                
                                </div>
                            </div>
                            <div class="form-group m-t-20 m-b-20">
                                 <label>{{__('lang.Change Main Image')}}</label>
                                <input type="file"  name="image" class="image-input-main form-control-file" value="{{ old('image', $blog->image) }}"  id="exampleInputFile" aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">{{ __('lang.Dimensions: 1920x500') }}</small>
                                <div id="image-preview-container">
           
                                    @if($blog->image)
                                        <img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" width="100">
                                    @endif
                                
                                </div>
                            </div>
                            <textarea name="content">
                                {{ old('content', $blog->content) }}
                            </textarea>
                            
                                @if($blog->status == 'published')
                                    <input type="hidden" name="status" value="published" />
                                @else
                                    <label class="mt-3">{{ __('lang.Status') }}</label>
                                    <select name="status" class="form-control show-tick">
                                        <option value="draft" @if($blog->status == 'draft') selected @endif>{{__('lang.Draft')}}</option>
                                        <option value="published" @if($blog->status == 'published') selected @endif>{{ __('lang.Publish') }}</option>
                                    </select>
                                @endif
                            <button type="submit" class="btn btn-block btn-primary   m-t-20">{{ __('lang.Update') }}</button>
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

    <script>
        setupImagePreview('.image-input-thumb', 'thumb-preview-container');
        setupImagePreview('.image-input-main', 'image-preview-container');

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
    </script>
   
@endsection
