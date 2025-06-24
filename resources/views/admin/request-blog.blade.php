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
            
             <h5 id="request-section">{{ __('lang.Request for review') }}</h5>
             <hr>
            <div class="row clearfix">
               @foreach($blogs->sortByDesc('created_at') as $blog)
                @if($blog->status === 'request')
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="card pb-2">
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
                        @if($user->type === 'super_admin' && $blog->status === 'request')
                        <div class="btn-group">
                            {{-- Approve Form --}}
                            <form method="POST" action="{{ route('localized.admin.blog.approve', ['blog' => $blog->id]) }}" style="display:inline;">
                                @csrf
                                <input type="hidden" name="message" value="Blog approved and published">
                                <button type="button" class="btn btn-success btn-sm mx-2" onclick="approveBlog(this)">
                                    ✓ Approve
                                </button>
                            </form>
                            
                            {{-- Reject Button --}}
                            <button type="button" class="btn btn-danger btn-sm" onclick="showRejectModal({{ $blog->id }})">
                                ✗ Reject
                            </button>
                        </div>
                    @endif
                    </div>
                </div>   
                @endif
                @endforeach                         
            </div>

            <div class="mb-5 mt-3" style="border-top: 2px dashed #637aae;"></div>

             <h5 id="draft-section">{{ __('lang.Draft Blogs') }}</h5>
             <hr>
            <div class="row clearfix">
               @foreach($blogs->sortByDesc('created_at') as $blog)
               @if($blog->status === 'draft' && $blog->created_by == $user->id)
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
                @endif
                @endforeach                         
            </div>

        </div>
    </div>

    @if($user->type === 'super_admin')
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('lang.Reject Blog') }}</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>{{ __('lang.Reason for rejection:') }}</label>
                        <textarea name="rejection_message" class="form-control" rows="3" required 
                                  placeholder="{{ __('lang.Please provide reason...') }}"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('lang.Cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('lang.Reject Blog') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
    function showRejectModal(blogId) {
        document.getElementById('rejectForm').action = 
            "{{ route('localized.admin.blog.reject', ['blog' => 'BLOG_ID']) }}"
            .replace('BLOG_ID', blogId);
        $('#rejectModal').modal('show');
    }
    </script>
    @endif

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

    <script>
    function approveBlog(button) {
        Swal.fire({
            title: '{{ __('lang.Are you sure?') }}',
            text: "{{ __('lang.Approve and publish this blog?') }}",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '{{ __('lang.Yes, approve it!') }}'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                button.closest('form').submit();
            }
        });
    }
    </script>

    
@endsection
