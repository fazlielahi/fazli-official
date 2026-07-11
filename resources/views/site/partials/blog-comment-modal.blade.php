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
