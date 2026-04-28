@extends('site.layout')

@section('body_class', 'page-cv-trash')

@section('title', 'Trash - ' . __('lang.DEFAULT_TITLE'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />
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
                    <a class="cv-side-menu__item" href="{{ route('localized.cv.projects', ['lang' => app()->getLocale()]) }}">
                        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'folder'])</span>
                        <span class="cv-side-menu__label">Projects</span>
                    </a>
                    <a class="cv-side-menu__item" href="{{ route('localized.cv.gallery', ['lang' => app()->getLocale()]) }}">
                        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'layers'])</span>
                        <span class="cv-side-menu__label">Templates</span>
                    </a>
                    <a class="cv-side-menu__item is-active" href="{{ route('localized.cv.trash', ['lang' => app()->getLocale()]) }}" aria-current="page">
                        <span class="cv-side-menu__icon">@include('cv.partials.svg-icon', ['name' => 'trash'])</span>
                        <span class="cv-side-menu__label">Trash</span>
                    </a>
                </aside>

                <div class="templates-showcase cv-projects-showcase">
                    <section class="cv-projects-panel cv-trash-panel" aria-label="Trash">
                        <div class="cv-projects-panel__tabs cv-trash-panel__tabs" role="tablist" aria-label="Trash filters">
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

                            <div class="cv-trash-hint" role="presentation">
                                <button type="button" class="cv-trash-hint__btn" aria-label="Trash info">
                                    @include('cv.partials.svg-icon', ['name' => 'info-circle', 'class' => 'cv-svg-icon'])
                                </button>
                                <div class="cv-trash-hint__tooltip" role="tooltip">
                                    <div>Read-only previews. Restore a resume or delete it permanently.</div>
                                    <div>Items are permanently deleted from Trash after {{ $trashRetentionDays }} days.</div>
                                </div>
                            </div>
                        </div>

                        <div class="cv-projects-panel__body">
                            <div class="cv-projects-pane" data-pane="all">
                                <div class="cv-projects-grid cv-trash-grid">
                                    @forelse($cvs as $cv)
                                        @include('cv.partials.trash-cv-card', ['cv' => $cv, 'trashRetentionDays' => $trashRetentionDays])
                                    @empty
                                        <div class="cv-projects-empty cv-trash-empty">
                                            <img class="cv-trash-empty__img" src="{{ asset('images/trash.png') }}" alt="" loading="lazy">
                                            <h3 class="cv-trash-empty__title">Any files you trash will end up here</h3>
                                            <p class="cv-trash-empty__text">You’ll have {{ $trashRetentionDays }} days to restore them before they’re automatically deleted from Trash.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="cv-projects-pane" data-pane="resumes" hidden>
                                <div class="cv-projects-grid cv-trash-grid">
                                    @forelse($cvs as $cv)
                                        @include('cv.partials.trash-cv-card', ['cv' => $cv, 'trashRetentionDays' => $trashRetentionDays])
                                    @empty
                                        <div class="cv-projects-empty cv-trash-empty">
                                            <img class="cv-trash-empty__img" src="{{ asset('images/trash.png') }}" alt="" loading="lazy">
                                            <h3 class="cv-trash-empty__title">Any resumes you trash will end up here</h3>
                                            <p class="cv-trash-empty__text">You’ll have {{ $trashRetentionDays }} days to restore them before they’re automatically deleted from Trash.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="cv-projects-pane" data-pane="cover" hidden>
                                <div class="cv-projects-empty cv-trash-empty cv-trash-empty--placeholder">
                                    <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="" loading="lazy">
                                    <p class="cv-trash-empty__text">Cover letters in Trash will appear here.</p>
                                </div>
                            </div>

                            <div class="cv-projects-pane" data-pane="more" hidden>
                                <div class="cv-projects-empty cv-trash-empty cv-trash-empty--placeholder">
                                    <img src="{{ asset('cv-templates/images/cv-templates-placeholder.png') }}" alt="" loading="lazy">
                                    <p class="cv-trash-empty__text">More types coming soon.</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <div class="cv-trash-purge-modal" id="cv-trash-purge-modal" hidden aria-hidden="true">
        <div class="cv-trash-purge-modal__backdrop" data-trash-purge-dismiss tabindex="-1"></div>
        <div class="cv-trash-purge-modal__dialog" role="alertdialog" aria-modal="true" aria-labelledby="cv-trash-purge-title" aria-describedby="cv-trash-purge-desc">
            <div class="cv-trash-purge-modal__header">
                <h2 class="cv-trash-purge-modal__title" id="cv-trash-purge-title">Delete permanently?</h2>
                <button type="button" class="cv-trash-purge-modal__close" data-trash-purge-dismiss aria-label="Close">
                    @include('cv.partials.svg-icon', ['name' => 'x-mark', 'class' => 'cv-svg-icon cv-trash-purge-modal__close-icon'])
                </button>
            </div>
            <p class="cv-trash-purge-modal__lead" id="cv-trash-purge-desc">This resume will be removed from our servers. You won’t be able to restore it.</p>
            <label class="cv-trash-purge-modal__check">
                <input type="checkbox" id="cv-trash-purge-confirm" autocomplete="off" />
                <span>I understand this is <strong>permanent</strong> and cannot be undone.</span>
            </label>
            <div class="cv-trash-purge-modal__footer">
                <button type="button" class="cv-trash-purge-modal__btn cv-trash-purge-modal__btn--cancel" data-trash-purge-dismiss>Cancel</button>
                <button type="button" class="cv-trash-purge-modal__btn cv-trash-purge-modal__btn--danger" id="cv-trash-purge-submit" disabled>
                    @include('cv.partials.svg-icon', ['name' => 'trash', 'class' => 'cv-svg-icon'])
                    <span>Delete permanently</span>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        (function () {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            const restoreTpl = @json(route('localized.cv.trash.restore', ['lang' => app()->getLocale(), 'id' => 'CV_ID']));
            const purgeTpl = @json(route('localized.cv.trash.force', ['lang' => app()->getLocale(), 'id' => 'CV_ID']));

            const tabs = document.querySelectorAll('.cv-trash-panel__tabs .cv-projects-tab');
            const panes = document.querySelectorAll('.cv-trash-panel .cv-projects-pane');

            function setActiveTab(tabKey) {
                tabs.forEach(function (t) {
                    const isActive = t.dataset.tab === tabKey;
                    t.classList.toggle('is-active', isActive);
                    t.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });
                panes.forEach(function (p) {
                    p.hidden = p.dataset.pane !== tabKey;
                });
            }

            tabs.forEach(function (t) {
                t.addEventListener('click', function () {
                    if (t.classList.contains('cv-projects-tab--soon')) return;
                    setActiveTab(t.dataset.tab);
                });
            });

            let ttTimer = null;
            tabs.forEach(function (t) {
                if (!t.classList.contains('cv-projects-tab--soon')) return;
                t.addEventListener('click', function () {
                    t.classList.add('is-tooltip-open');
                    clearTimeout(ttTimer);
                    ttTimer = setTimeout(function () { t.classList.remove('is-tooltip-open'); }, 1400);
                });
                t.addEventListener('mouseleave', function () { t.classList.remove('is-tooltip-open'); });
            });

            // Info tooltip (mobile/touch): tap to toggle.
            const hintWrap = document.querySelector('.cv-trash-hint');
            const hintBtn = hintWrap ? hintWrap.querySelector('.cv-trash-hint__btn') : null;

            function closeHintTooltip() {
                if (!hintWrap) return;
                hintWrap.classList.remove('is-open');
                if (hintBtn) hintBtn.setAttribute('aria-expanded', 'false');
            }

            hintBtn?.setAttribute('aria-expanded', 'false');
            hintBtn?.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (!hintWrap) return;
                const willOpen = !hintWrap.classList.contains('is-open');
                document.querySelectorAll('.cv-trash-hint.is-open').forEach(function (el) {
                    el.classList.remove('is-open');
                });
                hintWrap.classList.toggle('is-open', willOpen);
                hintBtn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            });

            document.addEventListener('click', function (e) {
                if (!hintWrap || !hintWrap.classList.contains('is-open')) return;
                if (e.target && hintWrap.contains(e.target)) return;
                closeHintTooltip();
            });

            const trashRetentionDays = Number(@json($trashRetentionDays)) || 30;
            const trashEmptyImgSrc = @json(asset('images/trash.png'));

            function trashEmptyHtml(which) {
                var title = which === 'resumes'
                    ? 'Any resumes you trash will end up here'
                    : 'Any files you trash will end up here';

                var desc = 'You’ll have ' + trashRetentionDays + ' days to restore them before they’re automatically deleted from Trash.';

                return ''
                    + '<div class="cv-projects-empty cv-trash-empty">'
                    +   '<img class="cv-trash-empty__img" src="' + String(trashEmptyImgSrc) + '" alt="" loading="lazy">'
                    +   '<h3 class="cv-trash-empty__title">' + title + '</h3>'
                    +   '<p class="cv-trash-empty__text">' + desc + '</p>'
                    + '</div>';
            }

            function removeTrashCardsById(id) {
                document.querySelectorAll('.cv-trash-card[data-cv-id="' + CSS.escape(String(id)) + '"]').forEach(function (el) {
                    el.remove();
                });
                document.querySelectorAll('.cv-trash-grid').forEach(function (grid) {
                    if (!grid.querySelector('.cv-trash-card')) {
                        var pane = grid.closest('.cv-projects-pane');
                        var key = pane ? pane.getAttribute('data-pane') : 'all';
                        grid.innerHTML = trashEmptyHtml(key === 'resumes' ? 'resumes' : 'all');
                    }
                });
            }

            const purgeModal = document.getElementById('cv-trash-purge-modal');
            const purgeCheckbox = document.getElementById('cv-trash-purge-confirm');
            const purgeSubmitBtn = document.getElementById('cv-trash-purge-submit');
            let pendingPurgeId = null;
            let pendingPurgeBtn = null;

            function closeTrashPurgeModal() {
                pendingPurgeId = null;
                pendingPurgeBtn = null;
                if (purgeCheckbox) purgeCheckbox.checked = false;
                if (purgeSubmitBtn) purgeSubmitBtn.disabled = true;
                if (purgeModal) {
                    purgeModal.hidden = true;
                    purgeModal.setAttribute('aria-hidden', 'true');
                }
                document.body.classList.remove('cv-trash-purge-modal-open');
            }

            function openTrashPurgeModal(id, btn) {
                pendingPurgeId = id;
                pendingPurgeBtn = btn;
                if (purgeCheckbox) purgeCheckbox.checked = false;
                if (purgeSubmitBtn) purgeSubmitBtn.disabled = true;
                if (purgeModal) {
                    purgeModal.hidden = false;
                    purgeModal.setAttribute('aria-hidden', 'false');
                }
                document.body.classList.add('cv-trash-purge-modal-open');
                requestAnimationFrame(function () {
                    purgeCheckbox?.focus();
                });
            }

            function executeTrashPurge(id, btn) {
                btn.disabled = true;
                const url = String(purgeTpl).replace('CV_ID', encodeURIComponent(id));
                fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                    },
                    body: new URLSearchParams({ _token: csrf, _method: 'DELETE' }).toString(),
                })
                    .then(function (r) { return r.json().then(function (j) { return { ok: r.ok, j: j }; }); })
                    .then(function (res) {
                        if (res.ok && res.j && res.j.success) {
                            closeTrashPurgeModal();
                            removeTrashCardsById(id);
                        } else {
                            btn.disabled = false;
                            alert((res.j && res.j.message) || 'Could not delete.');
                        }
                    })
                    .catch(function () {
                        btn.disabled = false;
                        alert('Could not delete.');
                    });
            }

            purgeCheckbox?.addEventListener('change', function () {
                if (purgeSubmitBtn) purgeSubmitBtn.disabled = !this.checked;
            });

            purgeSubmitBtn?.addEventListener('click', function () {
                if (!pendingPurgeId || !pendingPurgeBtn || !purgeCheckbox?.checked) return;
                executeTrashPurge(pendingPurgeId, pendingPurgeBtn);
            });

            document.querySelectorAll('[data-trash-purge-dismiss]').forEach(function (el) {
                el.addEventListener('click', function () {
                    closeTrashPurgeModal();
                });
            });

            document.addEventListener('keydown', function (e) {
                if (e.key !== 'Escape') return;
                if (hintWrap && hintWrap.classList.contains('is-open')) closeHintTooltip();
                if (!purgeModal || purgeModal.hidden) return;
                closeTrashPurgeModal();
            });

            document.querySelector('.cv-trash-panel')?.addEventListener('click', function (ev) {
                const btn = ev.target.closest('[data-action="restore"], [data-action="purge"]');
                if (!btn) return;
                ev.preventDefault();
                ev.stopPropagation();
                const card = btn.closest('.cv-trash-card');
                const id = card?.getAttribute('data-cv-id');
                if (!id) return;

                const action = btn.getAttribute('data-action');

                if (action === 'restore') {
                    btn.disabled = true;
                    const url = String(restoreTpl).replace('CV_ID', encodeURIComponent(id));
                    fetch(url, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                        },
                        body: new URLSearchParams({ _token: csrf }).toString(),
                    })
                        .then(function (r) { return r.json().then(function (j) { return { ok: r.ok, j: j }; }); })
                        .then(function (res) {
                            if (res.ok && res.j && res.j.success) {
                                removeTrashCardsById(id);
                            } else {
                                btn.disabled = false;
                                alert((res.j && res.j.message) || 'Could not restore.');
                            }
                        })
                        .catch(function () {
                            btn.disabled = false;
                            alert('Could not restore.');
                        });
                    return;
                }

                if (action === 'purge') {
                    openTrashPurgeModal(id, btn);
                }
            });
        })();
    </script>
@endsection
