@extends('site.layout')

@section('body_class', 'page-login')

@section('title', __('lang.Login'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        .footer{
            display: none !important;
        }
    </style>
@endsection
 
@section('head')
    <!-- Preload critical CSS -->
    <link rel="preload" href="{{ asset('assets/css/style.css') }}" as="style" />
    <link rel="preload" href="{{ asset('assets/css/responsive.css') }}" as="style" />

    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" /> <!-- main heading css -->
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet" />

    <!-- Third-party CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-all.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jarallax.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}" />

    <!-- Module CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/banner.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/sliding-text.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/category.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/about.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/services.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/why-choose.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/live-class.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/video-one.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/blog.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/counter.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/team.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/newsletter.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/testimonial.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/contact.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/process.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/page-header.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/become-a-teacher.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/shop.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/faq.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/error.css') }}" />

    <!-- Template styles -->
    <link rel="stylesheet" href="{{ asset('styles/login-register.css') }}" />
    @if(in_array(app()->getLocale(), ['ar', 'ur']))
        <link rel="stylesheet" href="{{ asset('styles/login-register-rtl.css') }}" />
    @endif
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />
@endsection

@section('content')

<div class="auth-shell">
    <div class="auth-card">
        <aside class="auth-media" aria-hidden="true">
            <img class="auth-media__bg" src="{{ asset('images/login-image.jpg') }}" alt="" />

            <div class="auth-media-inner">
                <div class="brand">
                    <img
                        class="brand-logo"
                        src="{{ asset('images/tfc.png') }}"
                        alt=""
                        width="80"
                        height="24"
                    />
                    <span class="brand-text">{{ __('lang.MADE_BY') }}</span>
                </div>

                <div class="media-quote">
                    <p>{{ __('lang.AUTH_QUOTE') }}</p>
                    <div class="meta">
                        <strong></strong><br />
                        <span>{{ __('lang.AUTH_SUPPORT') }}</span>
                    </div>
                </div>
            </div>
        </aside>

        <main class="auth-main">
            <header class="auth-heading">
                <h1>{{ __('lang.AUTH_WELCOME_BACK_TFC') }}</h1>
                <p>{{ __('lang.AUTH_LOGIN_DESC') }}</p>
            </header>

            @if(session('success'))
                <div class="auth-success">{{ session('success') }}</div>
            @endif

            @if (session('status'))
                <div class="auth-success">{{ session('status') }}</div>
            @endif

            @if (session('auth_required'))
                <div class="auth-info">{{ session('auth_required') }}</div>
            @endif

            {{-- Rate limit: show countdown box (restored) --}}
            @if(session('throttle_seconds'))
                <div id="rateLimitError" class="auth-errors">
                    <div style="display:flex; gap:6px; align-items:baseline; flex-wrap:wrap;">
                        <strong>{{ $errors->first() }}</strong>
                        <span id="countdown" style="font-weight: 800;"></span>
                    </div>
                </div>
            @endif

            {{-- Field-level errors (no generic global box) --}}

            <form id="loginForm" class="auth-form" method="post" action="{{ route('localized.login', ['lang' => app()->getlocale()]) }}">
                @csrf
                @if(!empty($next))
                    <input type="hidden" name="next" value="{{ $next }}" />
                @endif

                <div class="auth-field auth-field--float @error('email') is-error @enderror">
                    <div class="auth-input-wrap">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                        />
                        <label for="email">{{ __('lang.Email') }}</label>
                    </div>
                    @error('email')
                        <div class="auth-field-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field auth-field--float @error('password') is-error @enderror">
                    <div class="auth-input-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            autocomplete="current-password"
                        />
                        <label for="password">{{ __('lang.Password') }}</label>
                    </div>
                    @error('password')
                        <div class="auth-field-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-row">
                    <a class="auth-link" href="{{ route('localized.password.request', ['lang' => app()->getLocale()]) }}">
                        {{ __('lang.AUTH_FORGOT_PASSWORD_SHORT') }}
                    </a>

                    <label class="switch" for="remember">
                        <span>{{ __('lang.AUTH_REMEMBER_DETAILS') }}</span>
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                        <span class="switch-ui" aria-hidden="true"></span>
                    </label>
                </div>

                <button type="submit" id="loginButton" class="auth-submit">{{ __('lang.Login') }}</button>

                <div class="auth-divider" role="separator"><span class="auth-divider__text">{{ __('lang.AUTH_OR') }}</span></div>

                <a
                    href="{{ route('auth.google.redirect') }}{{ !empty($next) ? ('?next=' . urlencode($next)) : '' }}"
                    class="auth-oauth"
                    aria-label="Continue with Google"
                >
                    <span class="gmark" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="17" height="17">
                            <path fill="#EA4335" d="M12 10.2v3.9h5.5c-.2 1.3-1.6 3.9-5.5 3.9-3.3 0-6-2.7-6-6s2.7-6 6-6c1.9 0 3.1.8 3.8 1.4l2.6-2.5C17.8 3.4 15.2 2 12 2 6.5 2 2 6.5 2 12s4.5 10 10 10c5.8 0 9.6-4.1 9.6-9.8 0-.7-.1-1.2-.2-1.7H12z"/>
                            <path fill="#34A853" d="M3.6 7.3l3.2 2.3C7.7 7.8 9.7 6 12 6c1.9 0 3.1.8 3.8 1.4l2.6-2.5C17.8 3.4 15.2 2 12 2 8.2 2 4.9 4.1 3.6 7.3z"/>
                            <path fill="#FBBC05" d="M12 22c3.1 0 5.7-1 7.6-2.8l-3.5-2.7c-.9.6-2.1 1-4.1 1-3.3 0-6-2.7-6-6 0-.5.1-1 .2-1.5l-3.2-2.3C2.3 9 2 10.5 2 12c0 5.5 4.5 10 10 10z"/>
                            <path fill="#4285F4" d="M21.6 12.2c0-.7-.1-1.2-.2-1.7H12v3.9h5.5c-.3 1.6-1.3 3-2.8 3.8l3.5 2.7c2.1-1.9 3.4-4.8 3.4-8.7z"/>
                        </svg>
                    </span>
                    <span>{{ __('lang.AUTH_CONTINUE_WITH_GOOGLE') }}</span>
                </a>

                <div class="auth-foot">
                    {{ __('lang.AUTH_DONT_HAVE_ACCOUNT') }}
                    <a href="{{ route('localized.register', ['lang' => app()->getlocale()]) }}{{ !empty($next) ? ('?next=' . urlencode($next)) : '' }}">{{ __('lang.Sign Up') }}</a>
                </div>
            </form>
        </main>
    </div>
</div>

@endsection

@section('script')
    {{-- Core JS --}}
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Plugins --}}
    <script src="{{ asset('assets/js/jarallax.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/odometer.min.js') }}"></script>
    <script src="{{ asset('assets/js/wNumb.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/marquee.min.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>

    {{-- GSAP --}}
    <script src="{{ asset('assets/js/gsap/gsap.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/ScrollTrigger.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/SplitText.js') }}"></script>

    {{-- Custom Template JS --}}
    <script src="{{ asset('assets/js/script.js') }}"></script>

    {{-- Heart Icon Toggle Script --}}
    <script>
        $(document).ready(function() {
            // Heart icon toggle functionality
            $('.blogs-one__heart a').on('click', function(e) {
                e.preventDefault();
                var $heartIcon = $(this).find('.icon-heart');

                // Toggle the active class
                $heartIcon.toggleClass('active');

                // Optional: Add animation effect
                if ($heartIcon.hasClass('active')) {
                    $heartIcon.addClass('heart-beat');
                    setTimeout(function() {
                        $heartIcon.removeClass('heart-beat');
                    }, 300);
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const I18N = {
                emailRequired: @json(__('lang.AUTH_EMAIL_REQUIRED')),
                emailInvalid: @json(__('lang.AUTH_EMAIL_INVALID')),
                passwordRequired: @json(__('lang.AUTH_PASSWORD_REQUIRED')),
                throttleFallback: @json(__('lang.AUTH_TOO_MANY_ATTEMPTS')),
                wait: @json(__('lang.Wait')),
            };

            const remember = document.getElementById('remember');
            const switchUi = document.querySelector('.switch-ui');
            if (remember && switchUi) {
                switchUi.addEventListener('click', (e) => {
                    e.preventDefault();
                    remember.checked = !remember.checked;
                    remember.dispatchEvent(new Event('change', { bubbles: true }));
                });
            }

            function inputLooksFilled(input) {
                if (input.value && String(input.value).trim().length > 0) {
                    return true;
                }
                try {
                    if (input.matches(':-webkit-autofill')) {
                        return true;
                    }
                } catch (e) { /* unsupported selector */ }
                try {
                    if (input.matches(':-moz-autofill')) {
                        return true;
                    }
                } catch (e) { /* unsupported selector */ }
                return false;
            }

            function refreshAuthFloat(input) {
                const field = input.closest('.auth-field--float');
                if (!field) return;
                const has = inputLooksFilled(input);
                const focused = document.activeElement === input;
                field.classList.toggle('is-float', has || focused);
            }

            function refreshAllAuthFloats() {
                document.querySelectorAll('.auth-field--float input').forEach(refreshAuthFloat);
            }

            document.querySelectorAll('.auth-field--float input').forEach((input) => {
                refreshAuthFloat(input);
                ['focus', 'blur', 'input', 'change'].forEach((evt) => {
                    input.addEventListener(evt, () => refreshAuthFloat(input));
                });
                input.addEventListener('animationstart', (e) => {
                    if (e.animationName === 'auth-autofill-detect') {
                        refreshAuthFloat(input);
                    }
                });
            });

            /* Autofill runs after DOMContentLoaded; re-check on load + short delays */
            function scheduleAutofillFloatSync() {
                refreshAllAuthFloats();
                [50, 150, 400, 800, 1600].forEach((ms) => setTimeout(refreshAllAuthFloats, ms));
            }
            if (document.readyState === 'complete') {
                scheduleAutofillFloatSync();
            } else {
                window.addEventListener('load', scheduleAutofillFloatSync);
            }
            window.addEventListener('pageshow', (ev) => {
                if (ev.persisted) {
                    refreshAllAuthFloats();
                }
            });

            const form = document.getElementById('loginForm');
            if (!form) return;

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            function getOrCreateRateLimitBox() {
                let box = document.getElementById('rateLimitError');
                if (box) return box;

                box = document.createElement('div');
                box.id = 'rateLimitError';
                box.className = 'auth-errors';
                box.style.display = 'none';
                box.innerHTML = `
                    <div style="display:flex; gap:6px; align-items:baseline; flex-wrap:wrap;">
                        <strong id="rateLimitMsg"></strong>
                        <span id="countdown" style="font-weight: 800;"></span>
                    </div>
                `;
                form.insertAdjacentElement('beforebegin', box);
                return box;
            }

            function hideRateLimitBox() {
                const box = document.getElementById('rateLimitError');
                if (box) box.style.display = 'none';
            }

            function showRateLimitBox(message, seconds) {
                const box = getOrCreateRateLimitBox();
                const msgEl = box.querySelector('#rateLimitMsg') || box.querySelector('strong');
                const countdown = box.querySelector('#countdown');
                const btn = document.getElementById('loginButton');

                box.style.display = '';
                if (msgEl) msgEl.textContent = message || I18N.throttleFallback;

                if (!seconds || !countdown || !btn) return;

                const originalText = btn.textContent.trim();
                let remaining = Number(seconds) || 0;

                btn.disabled = true;
                btn.style.opacity = '0.6';
                btn.style.cursor = 'not-allowed';
                btn.textContent = originalText + ' (' + I18N.wait + ')';

                function tick() {
                    if (remaining > 0) {
                        const minutes = Math.floor(remaining / 60);
                        const secs = remaining % 60;
                        const timeString = minutes > 0
                            ? minutes + ':' + (secs < 10 ? '0' : '') + secs
                            : secs + 's';
                        countdown.textContent = ' (' + timeString + ')';
                        remaining--;
                        setTimeout(tick, 1000);
                    } else {
                        countdown.textContent = '';
                        btn.disabled = false;
                        btn.style.opacity = '1';
                        btn.style.cursor = 'pointer';
                        btn.textContent = originalText;
                        box.style.display = 'none';
                    }
                }
                tick();
            }

            function clearLoginClientErrors() {
                form.querySelectorAll('.auth-field-msg[data-login-client-msg]').forEach((n) => n.remove());
                form.querySelectorAll('.auth-field.is-error').forEach((w) => w.classList.remove('is-error'));
            }

            function setLoginFieldError(fieldKey, message) {
                if (!message) return;
                const inputId = fieldKey === 'email' ? 'email' : 'password';
                const input = document.getElementById(inputId);
                const wrap = input ? input.closest('.auth-field') : null;
                if (!wrap) return;

                wrap.classList.add('is-error');

                let msg = wrap.querySelector('.auth-field-msg[data-login-client-msg]');
                if (!msg) {
                    msg = document.createElement('div');
                    msg.className = 'auth-field-msg';
                    msg.setAttribute('data-login-client-msg', '1');
                    const inner = wrap.querySelector('.auth-input-wrap');
                    if (inner && inner.parentNode) {
                        inner.insertAdjacentElement('afterend', msg);
                    } else {
                        wrap.appendChild(msg);
                    }
                }
                msg.textContent = message;
            }

            function clearLoginFieldUI(wrap) {
                if (!wrap) return;
                wrap.classList.remove('is-error');
                wrap.querySelectorAll('.auth-field-msg').forEach((n) => n.remove());
            }

            function validateSingleLoginField(inputId) {
                const el = document.getElementById(inputId);
                const wrap = el ? el.closest('.auth-field') : null;
                if (!wrap) return;

                const email = (form.querySelector('#email')?.value || '').trim();
                const password = form.querySelector('#password')?.value || '';

                let ok = true;
                if (inputId === 'email') {
                    ok = email.length > 0 && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
                } else if (inputId === 'password') {
                    ok = password.length > 0;
                }

                if (ok) {
                    clearLoginFieldUI(wrap);
                }
            }

            ['input', 'change'].forEach((evt) => {
                ['email', 'password'].forEach((id) => {
                    form.querySelector('#' + id)?.addEventListener(evt, () => {
                        validateSingleLoginField(id);
                        hideRateLimitBox();
                    });
                });
            });

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                hideRateLimitBox();
                clearLoginClientErrors();

                const email = (form.querySelector('#email')?.value || '').trim();
                const password = form.querySelector('#password')?.value || '';

                let invalid = false;
                if (!email) {
                    setLoginFieldError('email', I18N.emailRequired);
                    invalid = true;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    setLoginFieldError('email', I18N.emailInvalid);
                    invalid = true;
                }
                if (!password) {
                    setLoginFieldError('password', I18N.passwordRequired);
                    invalid = true;
                }
                if (invalid) return;

                const btn = document.getElementById('loginButton');
                if (btn) btn.disabled = true;

                try {
                    const fd = new FormData(form);
                    const res = await fetch(form.action, {
                        method: 'POST',
                        body: fd,
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                        },
                    });

                    if (res.status === 422) {
                        const data = await res.json().catch(() => ({}));
                        const errors = data.errors || {};
                        Object.keys(errors).forEach((k) => {
                            const msg = Array.isArray(errors[k]) ? errors[k][0] : String(errors[k]);
                            setLoginFieldError(k, msg);
                        });
                        if (btn) btn.disabled = false;
                        return;
                    }

                    if (res.status === 429) {
                        const data = await res.json().catch(() => ({}));
                        const msg = data.message || (data.errors?.email?.[0]) || I18N.throttleFallback;
                        showRateLimitBox(msg, data.throttle_seconds || 0);
                        if (btn) btn.disabled = false;
                        return;
                    }

                    if (res.redirected || res.ok) {
                        window.location.href = res.url;
                        return;
                    }

                    if (btn) btn.disabled = false;
                } catch (err) {
                    if (btn) btn.disabled = false;
                }
            });
        });
    </script>

    {{-- Rate Limit Countdown Script (restored) --}}
    @if(session('throttle_seconds'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const throttleSeconds = {{ session('throttle_seconds', 0) }};
            const countdownElement = document.getElementById('countdown');
            const loginButton = document.getElementById('loginButton');
            const rateLimitError = document.getElementById('rateLimitError');

            if (throttleSeconds > 0 && countdownElement && loginButton) {
                const originalButtonText = loginButton.textContent.trim();
                let remainingSeconds = throttleSeconds;

                loginButton.disabled = true;
                loginButton.style.opacity = '0.6';
                loginButton.style.cursor = 'not-allowed';
                loginButton.textContent = originalButtonText + ' ({{ __("lang.Wait") }})';

                function updateCountdown() {
                    if (remainingSeconds > 0) {
                        const minutes = Math.floor(remainingSeconds / 60);
                        const seconds = remainingSeconds % 60;
                        const timeString = minutes > 0
                            ? minutes + ':' + (seconds < 10 ? '0' : '') + seconds
                            : seconds + 's';

                        countdownElement.textContent = ' (' + timeString + ')';
                        remainingSeconds--;
                        setTimeout(updateCountdown, 1000);
                    } else {
                        countdownElement.textContent = '';
                        loginButton.disabled = false;
                        loginButton.style.opacity = '1';
                        loginButton.style.cursor = 'pointer';
                        loginButton.textContent = originalButtonText;

                        if (rateLimitError) {
                            rateLimitError.style.display = 'none';
                        }
                    }
                }

                updateCountdown();
            }
        });
    </script>
    @endif

@endsection