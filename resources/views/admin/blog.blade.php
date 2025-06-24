@extends('admin.layout')

@section('title', __('lang.Manage Blogs'))

@section('content')
     <div id="main-content" class="file_manager">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>{{ __('lang.All Blogs') }}</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>                            
                            <li class="breadcrumb-item">{{ __('lang.Blogs') }}</li>
                            <li class="breadcrumb-item active">{{ __('lang.All Blogs') }}</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="page_action">
                                <a class="btn btn-secondary" href="{{ route('localized.admin.blog-create')}}" >{{ __('lang.Post New') }}</a>
                            </div>
                            <div class="p-2 d-flex">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row clearfix">
               @foreach($blogs->sortByDesc('created_at') as $blog)
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="card">
                        <div class="file">
                            <a href="javascript:void(0);">
                                <div class="action">
                                    
                                    <a class="btn btn-icon btn-info" href="{{ route('localized.admin.blog.edit', ['blog' => $blog->id]) }}"><i class="fa fa-edit"></i></a>
                                    
                                    <form id="delete-form-{{ $blog->id }}" 
                                        action="{{ route('localized.admin.blog.destroy', ['id' => $blog->id]) }}" 
                                        method="POST" 
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete({{ $blog->id }})"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                                <div class="image">
                                    <img src="{{ asset('storage/' . $blog->thumb) }}" alt="img" class="img-fluid">
                                </div>
                                <div class="file-name">
                                    <p class="m-b-5 text-muted">{{ $blog->title}}</p>
                                    <small>{{__('lang.Created by:') }} {{ ($blog->creater)->name ??  __('lang.Unknown') }}<span class="date text-muted">{{ $blog->created_at->format('F d, Y h:i A')}}</span></small>
                                </div>
                            </a> 
                        </div>
                    </div>
                </div>   
                @endforeach                         
            </div>
            
        </div>
    </div>

    <script>
        function confirmDelete(blogId) {
            Swal.fire({
                title: '{{ __('lang.Are you sure?') }}',
                text: "{{ __('lang.You won\'t be able to revert this!') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '{{ __('lang.Yes, delete it!') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + blogId).submit();
                }
            });
        }
    </script>

    
@endsection
