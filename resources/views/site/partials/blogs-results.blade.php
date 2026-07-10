                @if($blogs->count() > 0)
                @foreach($blogs as $blog)
                    @include('site.partials.blog-share-modal', ['blog' => $blog])
                    <!--Blog Two Single Start -->
                    <div class="wow fadeInLeft blog-card-blogs" data-wow-delay="100ms">
                        <div class="blog-two__single">
                        <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug]) }}">
                            <div class="blog-two__img">
                                @include('site.partials.blog-thumb', ['blog' => $blog])
                            </div>
                            </a>
                            <div class="blog-two__content">
                                <div class="blog-card__meta-row">
                                    @if($blog->category)
                                        <a href="{{ route('localized.blogs.by-category', ['lang' => app()->getLocale(), 'slug' => $blog->category->slug]) }}"
                                           class="blog-card__category">
                                            {{ $blog->category->name }}
                                        </a>
                                    @endif
                                    <span class="blog-card__read-time">
                                        {{ __('lang.Blogs min read', ['count' => blogReadTime($blog->content)]) }}
                                    </span>
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
                                @if(empty($hideExcerpt))
                                <p class="blog-card__excerpt" style="text-align: {{ $textDirection }} !important;">
                                    {{ blogExcerpt($blog->content, 110) }}
                                </p>
                                @endif
                            </div>
                            <div class="blog-two__meta-box comment-sec">
                                <ul class="blog-two__meta list-unstyled post-interactions">
                                    <li class="like-btn" data-url="{{ route('localized.blog.like', [app()->getLocale(), $blog->id]) }}">
                                        @if(in_array($blog->id, $likedBlogIds))
                                            <i class="heart-icon fa-solid fa-heart"></i>
                                        @else
                                            <i class="heart-icon fa-regular fa-heart"></i>
                                        @endif
                                        <span class="like">{{ __('lang.Like') }} </span>
                                        <span class="like-count">{{ $blog->likes_count }}</span>
                                    </li>
                                    <li>
                                        <a href="#" data-bs-toggle="modal" class="comment-a" data-bs-target="#editModal{{ $blog->id }}">
                                            <i class="far fa-comments mx-1"></i>
                                            <span class="comment">{{ __('lang.Comments') }}</span>
                                            <span class="comment-count">({{ $blog->comments_count }})</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="share-btn"
                                           data-bs-toggle="modal"
                                           data-bs-target="#shareModalTest{{ $blog->id }}"
                                           aria-label="{{ __('lang.Share') }}">
                                            <i class="far fa-share-square mx-1" aria-hidden="true"></i>
                                            <span class="share">{{ __('lang.Share') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Comment Modal -->
                    <div class="modal fade comment-modal" id="editModal{{ $blog->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered comment-modal__dialog">
                            <form id="comment-form-{{ $blog->id }}" class="ajax-comment-form comment-modal__form" method="POST" action="{{ route('localized.blog.comment', ['lang' => app()->getLocale(), $blog->id]) }}">
                                @csrf
                                <div class="modal-content comment-modal__content">
                                    <div class="comment-modal__header">
                                        <div class="comment-modal__header-text">
                                            <h5 class="comment-modal__title">{{ __('lang.Comments') }}</h5>
                                            <span class="comment-modal__count" id="comment-count-{{ $blog->id }}" data-count="{{ $blog->comments_count }}">
                                                @if($blog->comments_count === 0)
                                                    {{ __('lang.No comments yet') }}
                                                @elseif($blog->comments_count === 1)
                                                    1 {{ __('lang.Comment') }}
                                                @else
                                                    {{ $blog->comments_count }} {{ __('lang.Comments') }}
                                                @endif
                                            </span>
                                        </div>
                                        <button type="button" class="comment-modal__close" data-bs-dismiss="modal" aria-label="{{ __('lang.Close') }}">
                                            <i class="fas fa-times" aria-hidden="true"></i>
                                        </button>
                                    </div>

                                    <a href="{{ route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug]) }}" class="comment-modal__context">
                                        <div class="comment-modal__context-thumb">
                                            @include('site.partials.blog-thumb', ['blog' => $blog, 'class' => 'img-fluid'])
                                        </div>
                                        <div class="comment-modal__context-body">
                                            <span class="comment-modal__context-title">{{ Str::limit(html_entity_decode(strip_tags($blog->title)), 60) }}</span>
                                            <span class="comment-modal__context-meta">
                                                {{ $blog->creater->name ?? __('lang.unknown') }} · {{ $blog->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </a>

                                    <div class="comment-modal__body">
                                        <div class="comments-list comment-modal__list" id="show-comments-{{ $blog->id }}">
                                            @if($blog->comments_count < 1)
                                                <div class="no-comments comment-modal__empty">
                                                    <i class="far fa-comment-dots" aria-hidden="true"></i>
                                                    <p>{{ __('lang.Be the first to comment!') }}</p>
                                                </div>
                                            @else
                                                @foreach($blog->comments->sortByDesc('created_at') as $comment)
                                                    @php $commentUser = $comment->user; @endphp
                                                    <div class="comment-card">
                                                        @include('site.partials.comment-avatar', ['user' => $commentUser, 'comment' => $comment])
                                                        <div class="comment-content">
                                                            <div class="comment-meta">
                                                                <span class="username">{{ $comment->name }}</span>
                                                                <span class="timestamp">{{ $comment->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            <div class="comment-text">{{ $comment->comment }}</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="comment-modal__composer">
                                        @php
                                            $user = auth()->check() ? auth()->user() : null;
                                        @endphp

                                        @if((!isset($user) || !$user) && (!Cookie::get('visiter_token') || !\App\Models\Comment::where('visiter_token', Cookie::get('visiter_token'))->exists()))
                                            <div class="comment-modal__name-field">
                                                <label for="title{{ $blog->id }}" class="comment-modal__label">{{ __('lang.Your Name') }}</label>
                                                <input type="text" class="comment-modal__input" id="title{{ $blog->id }}" name="name" value="{{ old('name') }}" required>
                                            </div>
                                        @endif

                                        <div class="comment-modal__composer-box">
                                            <textarea class="comment-modal__textarea comment-textarea" name="comment" id="comment-textarea-{{ $blog->id }}" rows="2" placeholder="{{ __('lang.Add a comment') }}" required>{{ old('comment') }}</textarea>
                                            <div class="comment-modal__toolbar">
                                                @include('site.partials.comment-emoji-picker')
                                                <button type="submit" class="comment-btn-inside">
                                                    {{ __('lang.Comment') }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="ajax-comment-error comment-modal__error"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
