@foreach ($services as $service)
    <div class="item">
        <div class="blogs-one__single service-card-home">
            <div class="blogs-one__img-box">
                <div class="blogs-one__img">
                    <img src="{{ asset('assets/images/resources/' . $service['image']) }}" alt="{{ __('lang.' . $service['title']) }} | TFC - The Fazli Community">
                </div>
            </div>
            <div class="blogs-one__content">
                <h3 class="blogs-one__title">
                    <a href="{{ route('localized.services', ['lang' => $locale]) }}">{{ __('lang.' . $service['title']) }}</a>
                </h3>
                <div class="blogs-one__ratting-and-heart-box">
                    <div class="blogs-one__ratting-box">
                        <ul class="blogs-one__ratting list-unstyled">
                            @for ($i = 0; $i < 5; $i++)
                                <li><span class="icon-star"></span></li>
                            @endfor
                        </ul>
                        <p class="blogs-one__ratting-text">{{ __('lang.' . $service['reviews']) }}</p>
                    </div>
                    <div class="blogs-one__heart">
                        <button type="button" class="blogs-one__heart-btn" aria-label="{{ __('lang.Like') }}"><span class="icon-heart"></span></button>
                    </div>
                </div>
                <div class="blogs-one__btn-and-doller-box">
                    <div class="blogs-one__btn-box">
                        <a href="{{ $service['contact_url'] }}" class="blogs-one__btn thm-btn">
                            <span class="icon-angles-right"></span>{{ __('lang.Request a Quote') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
