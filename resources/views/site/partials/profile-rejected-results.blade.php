@if($blogs->count() > 0)
    @foreach($blogs as $blog)
        <div class="blog-card-blogs profile-draft-card profile-rejected-card">
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
                        <span class="profile-rejected-card__badge">{{ __('lang.Rejected') }}</span>
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
                <div class="profile-rejected-card__footer">
                    <button type="button"
                            class="profile-rejected-card__reason-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#whyRejectedModal{{ $blog->id }}">
                        <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                        {{ __('lang.Why Rejected?') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade profile-rejected-modal" id="whyRejectedModal{{ $blog->id }}" tabindex="-1" aria-labelledby="whyRejectedModalLabel{{ $blog->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content profile-rejected-modal__content">
                    <div class="modal-header profile-rejected-modal__header">
                        <h5 class="modal-title profile-rejected-modal__title" id="whyRejectedModalLabel{{ $blog->id }}">{{ __('lang.Rejection Details') }}</h5>
                        <button type="button" class="profile-rejected-modal__close" data-bs-dismiss="modal" aria-label="{{ __('lang.Close') }}">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                    @php
                        $isRtl = app()->getLocale() === 'ar' || app()->getLocale() === 'ur';
                    @endphp
                    <div class="modal-body profile-rejected-modal__body" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
                        <dl class="profile-rejected-modal__details">
                            <div class="profile-rejected-modal__detail">
                                <dt>{{ __('lang.Reason:') }}</dt>
                                <dd>{{ $blog->rejection_message ?? __('lang.unknown') }}</dd>
                            </div>
                            <div class="profile-rejected-modal__detail">
                                <dt>{{ __('lang.Rejected By:') }}</dt>
                                <dd>{{ $blog->rejected_by_user->name ?? __('lang.unknown') }}</dd>
                            </div>
                            <div class="profile-rejected-modal__detail">
                                <dt>{{ __('lang.Rejected At:') }}</dt>
                                <dd>
                                    @if($blog->rejected_at)
                                        {{ $blog->rejected_at->format('d/m/Y h:i A') }}
                                    @else
                                        {{ __('lang.unknown') }}
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                    <div class="modal-footer profile-rejected-modal__footer">
                        <button type="button" class="profile-rejected-modal__dismiss" data-bs-dismiss="modal">{{ __('lang.Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="no-blogs-message">
        <i class="fas fa-circle-xmark fa-3x mb-3" aria-hidden="true"></i>
        <h4>
            {{ __('lang.Profile no rejected blogs', ['name' => explode(' ', $user->name)[0]]) }}
        </h4>
        <p>{{ !empty($selectedCategory) ? __('lang.Profile no rejected blogs filtered') : __('lang.Profile rejected empty hint') }}</p>
    </div>
@endif

@if($blogs->hasPages())
    <nav class="blogs-pagination" aria-label="{{ __('lang.Rejected') }}">
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
