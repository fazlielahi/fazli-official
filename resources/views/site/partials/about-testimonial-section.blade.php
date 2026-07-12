<section class="testimonial-one about-testimonial" id="testimonials-section">
    <div class="container">
        <div class="section-title text-center sec-title-animation animation-style2">
            <div class="section-title__tagline-box">
                <div class="section-title__tagline-shape"></div>
                <span class="section-title__tagline">{{ __('lang.Testimonial') }}</span>
            </div>
            <h2 class="section-title__title">
                {{ __('lang.Explore Genuine Feedback') }}<br>
                {!! __('lang.from Happy Clients') !!}
            </h2>
        </div>
        <div class="testimonial-one__inner">
            <div class="testimonial-one__carousel owl-theme owl-carousel">
                @foreach ($testimonialItems as $testimonial)
                    @php
                        $defaultAvatar = $testimonialDefaultImage ?? asset('images/default.svg');
                        $avatarPath = $testimonial['image'] ?? '';
                        $avatarSrc = ($avatarPath && file_exists(public_path($avatarPath)))
                            ? asset($avatarPath)
                            : $defaultAvatar;
                    @endphp
                    <div class="item">
                        <article class="testimonial-one__single about-testimonial-card">
                            <blockquote class="about-testimonial-card__quote">
                                <p class="testimonial-one__text">{{ __('lang.' . $testimonial['text_key']) }}</p>
                            </blockquote>
                            <div class="about-testimonial-card__author">
                                <img
                                    src="{{ $avatarSrc }}"
                                    alt="{{ __('lang.' . $testimonial['name_key']) }}"
                                    class="about-testimonial-card__avatar"
                                    width="56"
                                    height="56"
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='{{ $defaultAvatar }}';"
                                >
                                <div class="about-testimonial-card__meta">
                                    <h3 class="testimonial-one__client-name">{{ __('lang.' . $testimonial['name_key']) }}</h3>
                                    <p class="testimonial-one__client-sub-title">{{ __('lang.' . $testimonial['title_key']) }}</p>
                                </div>
                            </div>
                            <div class="testimonial-one__ratting-and-social">
                                <ul class="testimonial-one__ratting list-unstyled" aria-label="{{ __('lang.Testimonial') }}">
                                    @for ($i = 0; $i < 5; $i++)
                                        <li><span class="icon-star" aria-hidden="true"></span></li>
                                    @endfor
                                </ul>
                                @if (!empty($testimonial['linkedin']))
                                    <div class="testimonial-one__social">
                                        <a href="{{ $testimonial['linkedin'] }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                            <span class="fab fa-linkedin-in" aria-hidden="true"></span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
