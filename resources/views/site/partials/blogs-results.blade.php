                @if($blogs->count() > 0)
                @foreach($blogs as $blog)
                    @include('site.partials.blog-card', [
                        'blog' => $blog,
                        'likedBlogIds' => $likedBlogIds,
                        'hideExcerpt' => $hideExcerpt ?? false,
                    ])
                @endforeach
                @else
                @if(!empty($profileGrid))
                    <div class="no-blogs-message">
                        <i class="fas fa-blog fa-3x mb-3" aria-hidden="true"></i>
                        <h4>
                            {{ $emptyTitle ?? ($search ? __('lang.Blogs no search results') : __('lang.No blogs uploaded yet')) }}
                        </h4>
                        @if(!empty($emptyHint))
                            <p>{{ $emptyHint }}</p>
                        @endif
                    </div>
                @else
                    <div class="col-12 text-center py-5">
                        <div class="no-blogs-message">
                            <i class="fas fa-blog fa-3x mb-3" aria-hidden="true"></i>
                            <h4>
                                {{ $emptyTitle ?? ($search ? __('lang.Blogs no search results') : __('lang.No blogs uploaded yet')) }}
                            </h4>
                            @if(!empty($emptyHint))
                                <p>{{ $emptyHint }}</p>
                            @endif
                        </div>
                    </div>
                @endif
                @endif

                @if($blogs->hasPages())
                    <nav class="blogs-pagination" aria-label="{{ __('lang.Blogs') }}">
                        <ul class="pagination justify-content-center">
                            @if($blogs->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $blogs->previousPageUrl() }}">&laquo;</a></li>
                            @endif

                            @foreach($blogs->getUrlRange(max(1, $blogs->currentPage() - 2), min($blogs->lastPage(), $blogs->currentPage() + 2)) as $page => $url)
                                <li class="page-item {{ $page == $blogs->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            @if($blogs->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $blogs->nextPageUrl() }}">&raquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif
                        </ul>
                    </nav>
                @endif
