@php
    $shareUrl = route('localized.blog-details', ['lang' => app()->getLocale(), 'slug' => $blog->slug]);
    $shareTitle = html_entity_decode(strip_tags((string) $blog->title), ENT_QUOTES | ENT_HTML5, 'UTF-8');
@endphp

<div class="modal fade share-blog-modal" id="shareModalTest{{ $blog->id }}" tabindex="-1" aria-labelledby="shareModalLabel{{ $blog->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered share-model">
        <div class="modal-content share-modal">
            <div class="modal-header share-modal__header">
                <h5 class="modal-title" id="shareModalLabel{{ $blog->id }}">{{ __('lang.Share this blog') }}</h5>
                <button type="button" class="btn-close share-modal__close" data-bs-dismiss="modal" aria-label="{{ __('lang.Cancel') }}"></button>
            </div>
            <div id="copyMessage{{ $blog->id }}" class="share-modal__copied" role="status" aria-live="polite">
                {{ __('lang.Link copied!') }}
            </div>
            <div class="modal-body share-icons-row">
                <a href="#"
                   class="share-action"
                   data-share-action="copy"
                   data-share-url="{{ $shareUrl }}"
                   data-message-id="copyMessage{{ $blog->id }}"
                   title="{{ __('lang.Copy Link') }}"
                   aria-label="{{ __('lang.Copy Link') }}">
                    <i class="fa-regular fa-copy share-icon share-icon--copy" aria-hidden="true"></i>
                </a>
                <a href="https://wa.me/?text={{ rawurlencode($shareUrl) }}"
                   class="share-action"
                   data-share-action="whatsapp"
                   data-share-url="{{ $shareUrl }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   title="{{ __('lang.Share on WhatsApp') }}"
                   aria-label="{{ __('lang.Share on WhatsApp') }}">
                    <i class="fa-brands fa-whatsapp share-icon share-icon--whatsapp" aria-hidden="true"></i>
                </a>
                <a href="#"
                   class="share-action"
                   data-share-action="facebook"
                   data-share-url="{{ $shareUrl }}"
                   title="{{ __('lang.Share on Facebook') }}"
                   aria-label="{{ __('lang.Share on Facebook') }}">
                    <i class="fa-brands fa-facebook share-icon share-icon--facebook" aria-hidden="true"></i>
                </a>
                <a href="#"
                   class="share-action"
                   data-share-action="linkedin"
                   data-share-url="{{ $shareUrl }}"
                   data-share-title="{{ e($shareTitle) }}"
                   title="{{ __('lang.Share on LinkedIn') }}"
                   aria-label="{{ __('lang.Share on LinkedIn') }}">
                    <i class="fa-brands fa-linkedin share-icon share-icon--linkedin" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</div>
