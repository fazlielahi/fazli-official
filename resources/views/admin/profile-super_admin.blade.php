@extends('admin.layout')

@section('title', __('lang.Profile'))

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2>{{ __('lang.Profile') }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>
                        <li class="breadcrumb-item active">{{ __('lang.Profile') }}</li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="d-flex flex-row-reverse">
                        <div class="page_action">
                             <a class="btn btn-primary" href="{{ route('localized.admin.dashboard') }}"> <i class="fa fa-dashboard"></i> {{ __('lang.Dashboard') }}</a>
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
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                    href="#Settings">{{ __('lang.Settings') }}</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#billings">{{ __('lang.Blogs') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">

                        <div class="tab-pane active" id="Settings">
                    <form method="POST" action="{{route('localized.profile-update')}}" enctype="multipart/form-data" >
                    @csrf
                            <div class="body">
                                <h6>{{ __('lang.Profile Photo') }}</h6>
                                <div class="media">
                                    <div class="media-left m-r-15">
                                        <img src="{{ asset('images/' . $user->photo) }}" class="user-photo media-object" alt="User" width="150">
                                    </div>
                                    <div class="media-body">
                                        <p>{{ __('lang.Upload your photo.') }}<br> <em>{{ __('lang.Image should be at least 140px x 140px') }}</em></p> 
                                        <input type="file" value="{{ $user->photo }}" name="photo">
                                    </div>
                                </div>
                            </div>

                            <div class="body pb-0">
                                <h6>{{ __('lang.Name') }}</h6>
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="{{ __('lang.Your Name') }}" value="{{ $user->name }}">
                                        </div>
                                      
                                       
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('lang.Update') }}</button> &nbsp;&nbsp;
                            </form>
                                <p class="mt-3" style="font-size: 14px;">
                                    {{-- <a href="{{ route('localized.password.request') }}" style="color: #335214; font-weight: 500; text-decoration: underline;">{{ __('lang.Change password') }}</a> --}}
                                </p>
                            </div>

                        </div>
                        <div class="tab-pane" id="billings">

                            <div class="body">
                                <h6>{{ __('lang.My Blogs') }}</h6>

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

                       

                    </div>
                </div>
            </div>
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
            confirmButtonText: '{{ __('lang.Yes, delete it!') }}',
            cancelButtonText: '{{ __('lang.Cancel') }}'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + blogId).submit();
            }
        });
    }
</script>
@endsection