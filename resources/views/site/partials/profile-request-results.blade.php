@if($blogs->count() > 0)
    @foreach($blogs as $blog)
        <div class="blog-card-blogs profile-draft-card profile-request-card">
            <div class="blog-two__single">
                <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug]) }}">
                    <div class="blog-two__img">
                        @include('site.partials.blog-thumb', ['blog' => $blog])
                        <div class="profile-blog-card__actions">
                            <a class="profile-blog-card__action profile-blog-card__action--edit"
                               href="{{ route('localized.admin.blog.edit', ['lang' => app()->getLocale(), 'blog' => $blog->id, 'return' => url()->full()]) }}"
                               title="{{ __('lang.Edit') }}"
                               aria-label="{{ __('lang.Edit') }}">
                                <i class="fa-solid fa-pen" aria-hidden="true"></i>
                            </a>
                            <form id="delete-form-{{ $blog->id }}"
                                  action="{{ route('localized.admin.blog.destroy', ['lang' => app()->getLocale(), 'id' => $blog->id]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="profile-blog-card__action profile-blog-card__action--delete"
                                        onclick="confirmDelete({{ $blog->id }})"
                                        title="{{ __('lang.Delete') }}"
                                        aria-label="{{ __('lang.Delete') }}">
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </a>
                <div class="blog-two__content">
                    <div class="blog-card__meta-row">
                        @if($blog->category)
                            <span class="blog-card__category blog-card__category--static">
                                {{ $blog->category->name }}
                            </span>
                        @endif
                        <span class="blog-card__read-time">
                            {{ __('lang.Blogs min read', ['count' => blogReadTime($blog->content)]) }}
                        </span>
                        <span class="profile-request-card__badge">{{ __('lang.Requested') }}</span>
                    </div>
                    <div class="blog-two__meta-box blog-profile">
                        <div class="profile-container">
                            <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}" class="mb-0 text-muted">
                                <img
                                    src="{{ userPhotoUrl($blog->creater) }}"
                                    width="100%"
                                    class="profile-pic"
                                    alt="{{ $blog->creater ? 'Photo of ' . $blog->creater->name : 'Default profile image' }}"
                                    onerror="this.onerror=null;this.src='{{ asset('images/default.svg') }}';">
                            </a>
                            <div>
                                <span class="username">
                                    <a href="{{ route('localized.user-profile', ['lang' => app()->getLocale(), $blog->creater->id]) }}">
                                        {{ $blog->creater->name ?? __('lang.unknown') }}
                                    </a>
                                </span>
                                <span class="blog-time text-muted">
                                    {{ $blog->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @php
                        $textDirection = getTextDirection($blog->title);
                    @endphp
                    <h4 class="blog-two__title" style="text-align: {{ $textDirection }} !important;">
                        <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug]) }}">
                            {{ Str::limit(html_entity_decode(strip_tags($blog->title)), 45) }}
                        </a>
                    </h4>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="no-blogs-message">
        <i class="fas fa-clock fa-3x mb-3" aria-hidden="true"></i>
        <h4>
            {{ __('lang.Profile no request blogs', ['name' => explode(' ', $user->name)[0]]) }}
        </h4>
        <p>{{ !empty($selectedCategory) ? __('lang.Profile no request blogs filtered') : __('lang.Profile request empty hint') }}</p>
    </div>
@endif

@if($blogs->hasPages())
    <nav class="blogs-pagination" aria-label="{{ __('lang.Requested') }}">
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
