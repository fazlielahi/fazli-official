@extends('site.layout')

@section('body_class', 'page-cv-projects')

@section('title', 'Projects - ' . __('lang.DEFAULT_TITLE'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}"> 
    <link rel="stylesheet" href="{{ asset('styles/theme.css') }}" />

    <!-- Template base styles (needed for consistent header layout) -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />

    <!-- Shared CV layout styles (same as templates page) -->
    <link rel="stylesheet" href="{{ asset('cv/css/cv-templates.css') }}" />
    <link rel="stylesheet" href="{{ asset('cv/css/cv-side-menu.css') }}" />
    <link rel="stylesheet" href="{{ asset('cv/css/cv-projects.css') }}" />
@endsection

@section('content')
    <div class="cv-gallery">
        <div class="container">
            <div class="cv-gallery__layout">
                <aside class="cv-side-menu" aria-label="Quick menu">
                    <a class="cv-side-menu__item" href="{{ route('localized.cv.gallery', ['lang' => app()->getLocale()]) }}">
                        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'plus'])</span>
                        <span class="cv-side-menu__label">Create</span>
                    </a>
                    <a class="cv-side-menu__item" href="{{ route('localized.home', ['lang' => app()->getLocale()]) }}">
                        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'home'])</span>
                        <span class="cv-side-menu__label">Home</span>
                    </a>
                    <a class="cv-side-menu__item is-active" href="{{ route('localized.cv.projects', ['lang' => app()->getLocale()]) }}" aria-current="page">
                        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'folder'])</span>
                        <span class="cv-side-menu__label">Projects</span>
                    </a>
                    <a class="cv-side-menu__item" href="{{ route('localized.cv.gallery', ['lang' => app()->getLocale()]) }}">
                        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'layers'])</span>
                        <span class="cv-side-menu__label">Templates</span>
                    </a>
                    <a class="cv-side-menu__item" href="{{ route('localized.cv.trash', ['lang' => app()->getLocale()]) }}">
                        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'trash'])</span>
                        <span class="cv-side-menu__label">Trash</span>
                    </a>
                </aside>

                <div class="templates-showcase cv-projects-showcase">
                    <section class="cv-projects-panel" aria-label="Projects">
                        <div class="cv-projects-panel__tabs" role="tablist" aria-label="Project filters">
                            <button type="button" class="cv-projects-tab is-active" data-tab="all" role="tab" aria-selected="true">
                                @include('cv.partials.svg-icon', ['name' => 'grid'])
                                <span>All</span>
                            </button>
                            <button type="button" class="cv-projects-tab" data-tab="resumes" role="tab" aria-selected="false">
                                @include('cv.partials.svg-icon', ['name' => 'document'])
                                <span>Resumes</span>
                            </button>
                            <button type="button" class="cv-projects-tab cv-projects-tab--soon" data-tab="cover" role="tab" aria-selected="false" data-tooltip="Coming soon">
                                @include('cv.partials.svg-icon', ['name' => 'envelope'])
                                <span>Cover letters</span>
                            </button>
                            <button type="button" class="cv-projects-tab cv-projects-tab--soon" data-tab="more" role="tab" aria-selected="false" data-tooltip="Coming soon">
                                @include('cv.partials.svg-icon', ['name' => 'ellipsis-horizontal'])
                                <span>More</span>
                            </button>
                        </div>

                        <div class="cv-projects-panel__body">
                            <div class="cv-projects-pane" data-pane="all">
                                <div class="cv-projects-grid">
                                    @forelse($cvs as $cv)
                                        @include('cv.partials.project-card', ['cv' => $cv])
                                    @empty
                                        <div class="cv-projects-empty">
                                            <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="No projects yet" loading="lazy">
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="cv-projects-pane" data-pane="resumes" hidden>
                                <div class="cv-projects-grid">
                                    @forelse($cvs as $cv)
                                        @include('cv.partials.project-card', ['cv' => $cv])
                                    @empty
                                        <div class="cv-projects-empty">
                                            <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="No resumes yet" loading="lazy">
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="cv-projects-pane" data-pane="cover" hidden>
                                <div class="cv-projects-empty">
                                    <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="Coming soon" loading="lazy">
                                </div>
                            </div>

                            <div class="cv-projects-pane" data-pane="more" hidden>
                                <div class="cv-projects-empty">
                                    <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="Coming soon" loading="lazy">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <div class="cv-delete-choice-modal" id="cv-delete-choice-modal" hidden aria-hidden="true">
        <div class="cv-delete-choice-modal__backdrop" data-cv-delete-dismiss tabindex="-1"></div>
        <div class="cv-delete-choice-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="cv-delete-choice-title">
            <div class="cv-delete-choice-modal__header">
                <h2 class="cv-delete-choice-modal__title" id="cv-delete-choice-title">Remove resume</h2>
                <button type="button" class="cv-delete-choice-modal__close" data-cv-delete-dismiss aria-label="Close">
                    @include('cv.partials.svg-icon', ['name' => 'x-mark', 'class' => 'cv-svg-icon cv-delete-choice-modal__close-icon'])
                </button>
            </div>
            <p class="cv-delete-choice-modal__lead">Remove from projects or wipe it entirely.</p>
            <div class="cv-delete-choice-modal__options">
                <div class="cv-delete-choice-modal__soft-row">
                    <button type="button" class="cv-delete-choice-modal__btn-soft" id="cv-delete-choice-soft">
                        <span class="cv-delete-choice-modal__btn-icon" aria-hidden="true">@include('cv.partials.svg-icon', ['name' => 'archive-box-arrow-down', 'class' => 'cv-svg-icon'])</span>
                        <span>Move to Trash</span>
                    </button>
                    <span class="cv-delete-choice-modal__soft-hint">
                        Recover from Trash anytime. Automatically deleted after {{ $trashRetentionDays }} days.
                    </span>
                </div>
                <div class="cv-delete-choice-modal__danger-zone">
                    <label class="cv-delete-choice-modal__check">
                        <input type="checkbox" id="cv-delete-permanent-confirm" autocomplete="off" />
                        <span>I understand this will be <strong>permanent</strong>.</span>
                    </label>
                    <button type="button" class="cv-delete-choice-modal__danger" id="cv-delete-choice-permanent" disabled>
                        <span class="cv-delete-choice-modal__btn-icon" aria-hidden="true">@include('cv.partials.svg-icon', ['name' => 'fire', 'class' => 'cv-svg-icon'])</span>
                        <span>Delete permanently</span>
                    </button>
                </div>
            </div>
            <div class="cv-delete-choice-modal__footer">
                <button type="button" class="cv-delete-choice-modal__cancel" data-cv-delete-dismiss>Cancel</button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        (function () {
            const tabs = document.querySelectorAll('.cv-projects-tab');
            const panes = document.querySelectorAll('.cv-projects-pane');

            function setActive(tabKey) {
                tabs.forEach(t => {
                    const isActive = t.dataset.tab === tabKey;
                    t.classList.toggle('is-active', isActive);
                    t.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });
                panes.forEach(p => {
                    const show = p.dataset.pane === tabKey;
                    p.hidden = !show;
                });
            }

            tabs.forEach(t => {
                t.addEventListener('click', () => {
                    if (t.classList.contains('cv-projects-tab--soon')) return;
                    setActive(t.dataset.tab);
                });
            });

            // simple tooltip for coming soon tabs
            let ttTimer = null;
            tabs.forEach(t => {
                if (!t.classList.contains('cv-projects-tab--soon')) return;
                t.addEventListener('click', () => {
                    t.classList.add('is-tooltip-open');
                    clearTimeout(ttTimer);
                    ttTimer = setTimeout(() => t.classList.remove('is-tooltip-open'), 1400);
                });
                t.addEventListener('mouseleave', () => t.classList.remove('is-tooltip-open'));
            });

            // Card menus
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            const locale = @json(app()->getLocale());
            const duplicateUrlTpl = @json(route('localized.cv.duplicate', ['lang' => app()->getLocale(), 'id' => 'CV_ID']));
            const updateTitleUrlTpl = @json(route('localized.cv.updateTitle', ['lang' => app()->getLocale(), 'id' => 'CV_ID']));
            const previewUrlTpl = @json(route('localized.cv.preview', ['lang' => app()->getLocale(), 'id' => 'CV_ID']));
            const pdfUrlTpl = @json(route('localized.cv.export.pdf', ['lang' => app()->getLocale(), 'id' => 'CV_ID']));
            const permanentDeleteUrlTpl = @json(route('localized.cv.permanent', ['lang' => app()->getLocale(), 'id' => 'CV_ID']));

            const deleteChoiceModal = document.getElementById('cv-delete-choice-modal');
            const deletePermanentCheck = document.getElementById('cv-delete-permanent-confirm');
            const deletePermanentBtn = document.getElementById('cv-delete-choice-permanent');
            const deleteSoftBtn = document.getElementById('cv-delete-choice-soft');
            let pendingDeleteCard = null;

            const renamePop = { el: null, card: null, anchor: null, outsidePtr: null };

            function closeRenamePopover() {
                if (renamePop.outsidePtr) {
                    document.removeEventListener('pointerdown', renamePop.outsidePtr, true);
                    renamePop.outsidePtr = null;
                }
                renamePop.card = null;
                renamePop.anchor = null;
                if (renamePop.el) {
                    renamePop.el.hidden = true;
                    renamePop.el.classList.remove('cv-project-rename-popover--on-card');
                    ['left', 'top', 'width'].forEach((prop) => renamePop.el.style.removeProperty(prop));
                }
            }

            function ensureRenamePopoverEl() {
                if (renamePop.el) return renamePop.el;
                const wrap = document.createElement('div');
                wrap.className = 'cv-project-rename-popover';
                wrap.setAttribute('role', 'dialog');
                wrap.setAttribute('aria-label', 'Edit title');
                wrap.hidden = true;
                wrap.innerHTML = ''
                    + '<div class="cv-project-rename-popover__title">Edit title</div>'
                    + '<div class="cv-project-rename-popover__row">'
                    + '<input type="text" class="cv-project-rename-popover__input" maxlength="255" autocomplete="off" />'
                    + '<button type="button" class="cv-project-rename-popover__submit" aria-label="Save title">'
                    + '<svg class="cv-svg-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>'
                    + '</button></div>';
                document.body.appendChild(wrap);
                renamePop.el = wrap;
                const input = wrap.querySelector('.cv-project-rename-popover__input');
                const submitBtn = wrap.querySelector('.cv-project-rename-popover__submit');
                submitBtn.addEventListener('click', (ev) => {
                    ev.preventDefault();
                    ev.stopPropagation();
                    submitRenamePopover();
                });
                input.addEventListener('keydown', (ev) => {
                    if (ev.key === 'Enter') {
                        ev.preventDefault();
                        submitRenamePopover();
                    }
                });
                return wrap;
            }

            function positionRenamePopover() {
                const wrap = renamePop.el;
                const anchor = renamePop.anchor;
                if (!wrap || wrap.hidden || !anchor || !anchor.isConnected) return;
                const pad = 8;
                const inset = 10;
                const ar = anchor.getBoundingClientRect();
                const place = () => {
                    let left = ar.left + inset;
                    let width = ar.width - inset * 2;
                    width = Math.max(136, Math.min(width, window.innerWidth - pad * 2));
                    left = Math.max(pad, Math.min(left, window.innerWidth - pad - width));
                    let top = ar.top + inset;
                    const estH = wrap.offsetHeight || 120;
                    if (top + estH > window.innerHeight - pad) {
                        top = Math.max(pad, window.innerHeight - pad - estH);
                    }
                    wrap.style.position = 'fixed';
                    wrap.style.left = left + 'px';
                    wrap.style.top = top + 'px';
                    wrap.style.width = width + 'px';
                };
                requestAnimationFrame(() => {
                    place();
                    requestAnimationFrame(place);
                });
            }

            function openRenamePopover(card) {
                closeRenamePopover();
                const wrap = ensureRenamePopoverEl();
                renamePop.card = card;
                renamePop.anchor = card.querySelector('.cv-project-card__footer') || card;
                const input = wrap.querySelector('.cv-project-rename-popover__input');
                input.value = (card.getAttribute('data-cv-title') || '').trim();
                wrap.classList.add('cv-project-rename-popover--on-card');
                wrap.hidden = false;
                positionRenamePopover();
                input.focus();
                input.select();

                const outsidePtr = (ev) => {
                    if (!renamePop.el || renamePop.el.hidden) return;
                    if (ev.target.closest('.cv-project-rename-popover')) return;
                    closeRenamePopover();
                };
                renamePop.outsidePtr = outsidePtr;
                setTimeout(() => document.addEventListener('pointerdown', outsidePtr, true), 0);
            }

            async function submitRenamePopover() {
                const wrap = renamePop.el;
                const card = renamePop.card;
                if (!wrap || wrap.hidden || !card) return;
                const input = wrap.querySelector('.cv-project-rename-popover__input');
                const trimmed = String(input.value || '').trim();
                const current = (card.getAttribute('data-cv-title') || '').trim();
                if (trimmed === '' || trimmed === current) {
                    closeRenamePopover();
                    return;
                }
                const id = card.getAttribute('data-cv-id');
                const tipRect = wrap.getBoundingClientRect();
                const url = String(updateTitleUrlTpl).replace('CV_ID', encodeURIComponent(String(id)));
                const res = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                    },
                    body: new URLSearchParams({ _token: csrf, title: trimmed }).toString(),
                }).catch(() => null);

                if (!res || !res.ok) {
                    showProjectCopyToast('Could not rename', tipRect);
                    return;
                }
                let data = null;
                try {
                    data = await res.json();
                } catch (err) {
                    showProjectCopyToast('Could not rename', tipRect);
                    return;
                }
                const newTitle = (data && data.cv && data.cv.title) ? String(data.cv.title) : trimmed;
                document.querySelectorAll('.cv-project-card[data-cv-id="' + CSS.escape(String(id)) + '"]').forEach((el) => {
                    el.setAttribute('data-cv-title', newTitle);
                    const titleEl = el.querySelector('.cv-project-card__title');
                    if (titleEl) titleEl.textContent = newTitle;
                    const frame = el.querySelector('.cv-project-card__frame');
                    if (frame) frame.setAttribute('title', 'Preview ' + newTitle);
                    const previewLink = el.querySelector('.cv-project-card__preview-link');
                    if (previewLink) previewLink.setAttribute('aria-label', 'Open ' + newTitle);
                });
                closeRenamePopover();
                closeAllMenus();
                showProjectCopyToast('Renamed', tipRect);
            }

            function portalMenuToBody(menu, moreBtn) {
                if (menu.dataset.cvMenuPortaled === '1') return;
                menu._cvMenuCard = moreBtn.closest('.cv-project-card');
                menu._cvMenuAnchorParent = moreBtn.parentElement;
                menu._cvMenuAnchorBtn = moreBtn;
                document.body.appendChild(menu);
                menu.dataset.cvMenuPortaled = '1';
            }

            function restoreMenuFromPortal(menu) {
                if (menu.dataset.cvMenuPortaled !== '1') return;
                const btn = menu._cvMenuAnchorBtn;
                const parent = menu._cvMenuAnchorParent;
                if (btn && btn.isConnected) {
                    btn.insertAdjacentElement('afterend', menu);
                } else if (parent && parent.isConnected) {
                    parent.appendChild(menu);
                }
                delete menu._cvMenuAnchorBtn;
                delete menu._cvMenuAnchorParent;
                delete menu._cvMenuCard;
                delete menu.dataset.cvMenuPortaled;
            }

            function resetMenuDock(menu) {
                restoreMenuFromPortal(menu);
                menu.classList.remove('cv-project-card__menu--fixed');
                ['position', 'left', 'top', 'width', 'right', 'bottom', 'max-height', 'overflow-y'].forEach((prop) => {
                    menu.style.removeProperty(prop);
                });
            }

            function findMenuForMoreBtn(moreBtn) {
                if (!moreBtn) return null;
                const inActions = moreBtn.parentElement?.querySelector('.cv-project-card__menu');
                if (inActions) return inActions;
                return Array.from(document.querySelectorAll('.cv-project-card__menu')).find((m) => m._cvMenuAnchorBtn === moreBtn) || null;
            }

            function closeAllMenus() {
                closeRenamePopover();
                document.querySelectorAll('.cv-project-card__menu').forEach((m) => {
                    m.hidden = true;
                    resetMenuDock(m);
                });
                document.querySelectorAll('.cv-project-card__more').forEach((b) => {
                    b.setAttribute('aria-expanded', 'false');
                    b.classList.remove('is-open');
                    b.setAttribute('aria-label', 'More options');
                });
                document.querySelectorAll('.cv-project-card.is-menu-open').forEach((c) => {
                    c.classList.remove('is-menu-open');
                });
            }

            /**
             * Fixed to the real viewport. Ancestors with backdrop-filter/transform create a
             * containing block for position:fixed, so we portal the menu to document.body first.
             */
            function positionProjectMenu(moreBtn, menu) {
                if (!moreBtn || !menu) return;
                portalMenuToBody(menu, moreBtn);
                const pad = 8;
                const gap = 6;
                const vw = window.innerWidth;
                const vh = window.innerHeight;
                const maxW = Math.min(288, vw - pad * 2);
                const rect = moreBtn.getBoundingClientRect();
                let left = rect.right - maxW;
                left = Math.max(pad, Math.min(left, vw - maxW - pad));
                let top = rect.bottom + gap;

                menu.classList.add('cv-project-card__menu--fixed');
                Object.assign(menu.style, {
                    position: 'fixed',
                    left: left + 'px',
                    top: top + 'px',
                    width: maxW + 'px',
                    right: 'auto',
                    bottom: 'auto',
                });

                const mh = menu.offsetHeight;
                if (top + mh > vh - pad) {
                    top = Math.max(pad, rect.top - mh - gap);
                    menu.style.top = top + 'px';
                }

                const maxH = vh - pad * 2;
                if (mh > maxH) {
                    menu.style.maxHeight = maxH + 'px';
                    menu.style.overflowY = 'auto';
                } else {
                    menu.style.maxHeight = '';
                    menu.style.overflowY = '';
                }
            }

            function repositionOpenProjectMenu() {
                const menu = document.querySelector('.cv-project-card__menu.cv-project-card__menu--fixed:not([hidden])');
                if (!menu || menu.hidden) return;
                const btn = menu._cvMenuAnchorBtn;
                if (!btn || !btn.isConnected) return;
                positionProjectMenu(btn, menu);
                positionRenamePopover();
            }

            const projectsPanelBody = document.querySelector('.cv-projects-panel__body');
            window.addEventListener('resize', repositionOpenProjectMenu);
            window.addEventListener('scroll', repositionOpenProjectMenu, true);
            if (projectsPanelBody) {
                projectsPanelBody.addEventListener('scroll', repositionOpenProjectMenu, { passive: true });
            }

            document.addEventListener('click', (e) => {
                const moreBtn = e.target.closest('.cv-project-card__more');
                if (moreBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    const card = moreBtn.closest('.cv-project-card');
                    const menu = findMenuForMoreBtn(moreBtn);
                    if (!menu) return;

                    const wasHidden = menu.hidden;
                    closeAllMenus();
                    menu.hidden = !wasHidden;
                    const isOpen = !menu.hidden;
                    moreBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    moreBtn.classList.toggle('is-open', isOpen);
                    moreBtn.setAttribute('aria-label', isOpen ? 'Close menu' : 'More options');

                    if (isOpen) {
                        card?.classList.add('is-menu-open');
                        requestAnimationFrame(() => {
                            requestAnimationFrame(() => positionProjectMenu(moreBtn, menu));
                        });
                    }
                    return;
                }

                if (e.target.closest('.cv-project-card__menu')) return;
                if (e.target.closest('.cv-project-rename-popover')) return;
                closeAllMenus();
            });

            document.addEventListener('keydown', (e) => {
                if (e.key !== 'Escape' && e.key !== 'Esc') return;
                if (renamePop.el && !renamePop.el.hidden) {
                    closeRenamePopover();
                    e.preventDefault();
                    return;
                }
                closeAllMenus();
            });

            async function copyToClipboard(text) {
                try {
                    await navigator.clipboard.writeText(text);
                    return true;
                } catch (err) {
                    try {
                        const ta = document.createElement('textarea');
                        ta.value = text;
                        ta.style.position = 'fixed';
                        ta.style.left = '-9999px';
                        document.body.appendChild(ta);
                        ta.select();
                        document.execCommand('copy');
                        ta.remove();
                        return true;
                    } catch (e2) {
                        return false;
                    }
                }
            }

            function showProjectCopyToast(message, anchorRect) {
                const tip = document.createElement('span');
                tip.className = 'cv-project-card__copy-toast';
                tip.setAttribute('role', 'status');
                tip.textContent = message;
                document.body.appendChild(tip);
                const pad = 8;
                const place = () => {
                    const tw = tip.offsetWidth;
                    const th = tip.offsetHeight;
                    let left = anchorRect.right + 10;
                    if (left + tw > window.innerWidth - pad) {
                        left = Math.max(pad, anchorRect.left - tw - 10);
                    }
                    let top = anchorRect.top + (anchorRect.height - th) / 2;
                    top = Math.max(pad, Math.min(top, window.innerHeight - pad - th));
                    tip.style.left = left + 'px';
                    tip.style.top = top + 'px';
                };
                requestAnimationFrame(() => {
                    place();
                    requestAnimationFrame(place);
                });
                setTimeout(() => {
                    tip.classList.add('is-out');
                    setTimeout(() => tip.remove(), 280);
                }, 2000);
            }

            async function downloadCvPdf(cardEl) {
                const id = cardEl?.getAttribute('data-cv-id');
                if (!id) return false;
                const url = String(pdfUrlTpl).replace('CV_ID', encodeURIComponent(String(id)));
                const res = await fetch(url, {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/pdf',
                    },
                }).catch(() => null);
                if (!res || !res.ok) return false;
                const blob = await res.blob();
                if (!blob || blob.size === 0) return false;
                let filename = 'resume.pdf';
                const cd = res.headers.get('Content-Disposition');
                if (cd) {
                    const m = cd.match(/filename\*=UTF-8''([^;]+)/i) || cd.match(/filename="([^"]+)"/) || cd.match(/filename=([^;]+)/i);
                    if (m) {
                        try {
                            filename = decodeURIComponent(m[1].replace(/['"]/g, '').trim());
                        } catch (err) {
                            filename = m[1].replace(/['"]/g, '').trim();
                        }
                    }
                }
                if (!/\.pdf$/i.test(filename)) {
                    const t = (cardEl.getAttribute('data-cv-title') || 'resume').replace(/[^\w\-. ]/g, '_').replace(/\s+/g, '_').slice(0, 80);
                    filename = t + '.pdf';
                }
                const objUrl = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = objUrl;
                a.download = filename;
                a.rel = 'noopener';
                document.body.appendChild(a);
                a.click();
                a.remove();
                setTimeout(() => URL.revokeObjectURL(objUrl), 5000);
                return true;
            }

            async function deleteCv(cardEl) {
                const id = cardEl?.getAttribute('data-cv-id');
                if (!id) return false;
                const urlTpl = @json(route('localized.cv.delete', ['lang' => app()->getLocale(), 'id' => 'CV_ID']));
                const url = String(urlTpl).replace('CV_ID', encodeURIComponent(String(id)));

                const res = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: new URLSearchParams({ _token: csrf, _method: 'DELETE' }).toString(),
                }).catch(() => null);

                if (!res || !res.ok) return false;

                document.querySelectorAll('.cv-project-card[data-cv-id="' + CSS.escape(String(id)) + '"]').forEach((el) => el.remove());
                return true;
            }

            async function permanentDeleteCv(cardEl) {
                const id = cardEl?.getAttribute('data-cv-id');
                if (!id) return false;
                const url = String(permanentDeleteUrlTpl).replace('CV_ID', encodeURIComponent(String(id)));
                const res = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                    },
                    body: new URLSearchParams({ _token: csrf, _method: 'DELETE' }).toString(),
                }).catch(() => null);

                if (!res || !res.ok) return false;

                document.querySelectorAll('.cv-project-card[data-cv-id="' + CSS.escape(String(id)) + '"]').forEach((el) => el.remove());
                return true;
            }

            function openDeleteChoiceModal(card) {
                pendingDeleteCard = card;
                if (deletePermanentCheck) deletePermanentCheck.checked = false;
                if (deletePermanentBtn) deletePermanentBtn.disabled = true;
                if (!deleteChoiceModal) return;
                deleteChoiceModal.hidden = false;
                deleteChoiceModal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('cv-delete-choice-modal-open');
                requestAnimationFrame(() => deleteSoftBtn?.focus());
            }

            function closeDeleteChoiceModal() {
                pendingDeleteCard = null;
                if (deleteChoiceModal) {
                    deleteChoiceModal.hidden = true;
                    deleteChoiceModal.setAttribute('aria-hidden', 'true');
                }
                document.body.classList.remove('cv-delete-choice-modal-open');
                if (deletePermanentCheck) deletePermanentCheck.checked = false;
                if (deletePermanentBtn) deletePermanentBtn.disabled = true;
            }

            deletePermanentCheck?.addEventListener('change', function () {
                if (deletePermanentBtn) deletePermanentBtn.disabled = !this.checked;
            });

            deleteSoftBtn?.addEventListener('click', async function () {
                const card = pendingDeleteCard;
                if (!card) return;
                const ok = await deleteCv(card);
                closeDeleteChoiceModal();
                showProjectTopToast(ok ? 'Moved to Trash' : 'Could not move to Trash');
            });

            deletePermanentBtn?.addEventListener('click', async function () {
                const card = pendingDeleteCard;
                if (!card || !deletePermanentCheck?.checked) return;
                const ok = await permanentDeleteCv(card);
                closeDeleteChoiceModal();
                showProjectTopToast(ok ? 'Permanently deleted' : 'Could not delete');
            });

            document.querySelectorAll('[data-cv-delete-dismiss]').forEach((el) => {
                el.addEventListener('click', function () {
                    closeDeleteChoiceModal();
                });
            });

            document.addEventListener('keydown', function (e) {
                if (e.key !== 'Escape') return;
                if (!deleteChoiceModal || deleteChoiceModal.hidden) return;
                closeDeleteChoiceModal();
            });

            function formatCvCardDate(iso) {
                if (!iso) return '';
                const d = new Date(iso);
                if (Number.isNaN(d.getTime())) return '';
                return d.toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' });
            }

            function hydrateClonedProjectCard(clone, cv) {
                const newId = String(cv.id);
                const title = (cv.title != null && String(cv.title).trim() !== '') ? String(cv.title) : 'Untitled resume';
                const slug = cv.template_slug;
                const openHref = '/' + locale + '/cv/create/' + encodeURIComponent(slug) + '?cv_id=' + encodeURIComponent(newId);
                const previewSrc = String(previewUrlTpl).replace('CV_ID', encodeURIComponent(newId)) + '?scale=0.28&crop=0.30';
                const sub = clone.querySelector('.cv-project-card__sub');

                clone.setAttribute('data-cv-id', newId);
                clone.setAttribute('data-open-href', openHref);
                clone.setAttribute('data-cv-title', title);
                clone.classList.remove('is-menu-open');

                const titleEl = clone.querySelector('.cv-project-card__title');
                if (titleEl) titleEl.textContent = title;
                if (sub) sub.textContent = 'Updated ' + formatCvCardDate(cv.updated_at);

                const frame = clone.querySelector('.cv-project-card__frame');
                if (frame) {
                    frame.setAttribute('title', 'Preview ' + title);
                    frame.setAttribute('src', previewSrc);
                }
                const plink = clone.querySelector('.cv-project-card__preview-link');
                if (plink) {
                    plink.href = openHref;
                    plink.setAttribute('aria-label', 'Open ' + title);
                }

                const menu = clone.querySelector('.cv-project-card__menu');
                if (menu) {
                    menu.hidden = true;
                    menu.classList.remove('cv-project-card__menu--fixed');
                    ['position', 'left', 'top', 'width', 'right', 'bottom', 'max-height', 'overflow-y'].forEach((prop) => {
                        menu.style.removeProperty(prop);
                    });
                    delete menu.dataset.cvMenuPortaled;
                    delete menu._cvMenuAnchorBtn;
                    delete menu._cvMenuAnchorParent;
                    delete menu._cvMenuCard;
                }
                const more = clone.querySelector('.cv-project-card__more');
                if (more) more.setAttribute('aria-expanded', 'false');

                clone.querySelectorAll('.cv-project-card__menu-body > a.cv-project-card__menu-item').forEach((a) => {
                    const lab = a.querySelector('.cv-project-card__menu-label')?.textContent?.trim() || '';
                    if (lab === 'Open') {
                        a.href = openHref;
                        a.removeAttribute('target');
                        a.removeAttribute('rel');
                    } else if (lab === 'Open in a new tab') {
                        a.href = openHref;
                        a.target = '_blank';
                        a.rel = 'noopener noreferrer';
                    }
                });
            }

            function insertDuplicatedCards(sourceCard, cv) {
                document.querySelectorAll('.cv-projects-grid').forEach((grid) => {
                    grid.querySelector('.cv-projects-empty')?.remove();
                    const clone = sourceCard.cloneNode(true);
                    hydrateClonedProjectCard(clone, cv);
                    grid.insertBefore(clone, grid.firstChild);
                });
            }

            async function duplicateCv(cardEl) {
                const id = cardEl?.getAttribute('data-cv-id');
                if (!id) return null;
                const url = String(duplicateUrlTpl).replace('CV_ID', encodeURIComponent(String(id)));
                const res = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                    },
                    body: new URLSearchParams({ _token: csrf }).toString(),
                }).catch(() => null);
                if (!res || !res.ok) return null;
                let data = null;
                try {
                    data = await res.json();
                } catch (err) {
                    return null;
                }
                if (!data || !data.success || !data.cv) return null;
                return data.cv;
            }

            function showProjectTopToast(message) {
                const el = document.createElement('div');
                el.className = 'cv-projects-top-toast';
                el.setAttribute('role', 'status');
                el.textContent = message;
                document.body.appendChild(el);
                requestAnimationFrame(() => el.classList.add('is-in'));
                setTimeout(() => {
                    el.classList.remove('is-in');
                    el.classList.add('is-out');
                    setTimeout(() => el.remove(), 320);
                }, 2600);
            }

            document.addEventListener('click', async (e) => {
                if (e.target.closest('.cv-project-card__menu a')) {
                    closeAllMenus();
                    return;
                }

                const item = e.target.closest('button.cv-project-card__menu-item');
                if (!item || item.disabled) return;
                e.preventDefault();
                e.stopPropagation();

                const menuEl = item.closest('.cv-project-card__menu');
                const card = menuEl?._cvMenuCard || item.closest('.cv-project-card');
                const action = item.getAttribute('data-action');
                const openHref = card?.getAttribute('data-open-href') || '';

                if (action === 'copy_link') {
                    const anchorRect = item.getBoundingClientRect();
                    const ok = await copyToClipboard(openHref);
                    showProjectCopyToast(ok ? 'Link copied' : 'Copy failed', anchorRect);
                    closeAllMenus();
                    return;
                }

                if (action === 'rename') {
                    closeAllMenus();
                    requestAnimationFrame(() => openRenamePopover(card));
                    return;
                }

                if (action === 'duplicate') {
                    closeAllMenus();
                    const newCv = await duplicateCv(card);
                    if (!newCv) {
                        showProjectTopToast('Could not copy');
                        return;
                    }
                    insertDuplicatedCards(card, newCv);
                    showProjectTopToast('Copy created');
                    return;
                }

                if (action === 'download') {
                    const labelEl = item.querySelector('.cv-project-card__menu-label');
                    const prevLabel = labelEl ? labelEl.textContent : 'Download';
                    item.classList.add('cv-project-card__menu-item--loading');
                    item.setAttribute('aria-busy', 'true');
                    if (labelEl) labelEl.textContent = 'Generating PDF…';
                    requestAnimationFrame(() => repositionOpenProjectMenu());

                    let ok = false;
                    try {
                        ok = await downloadCvPdf(card);
                    } finally {
                        item.classList.remove('cv-project-card__menu-item--loading');
                        item.removeAttribute('aria-busy');
                        if (labelEl) labelEl.textContent = prevLabel;
                        requestAnimationFrame(() => repositionOpenProjectMenu());
                    }
                    if (!ok) showProjectTopToast('Could not download');
                    return;
                }

                if (action === 'trash') {
                    closeAllMenus();
                    openDeleteChoiceModal(card);
                    return;
                }

                closeAllMenus();
            });
        })();
    </script>
@endsection

