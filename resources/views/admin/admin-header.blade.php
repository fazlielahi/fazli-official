<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="{{route('localized.admin.blog', ['lang' => app()->getLocale()])}}" class="btn btn-secondary mx-1">{{ __('lang.All Blogs') }}</a> 
 
    {{-- language switcher --}}
                                                @php 
                                                    // Get current locale
                                                    $locale = App::getLocale();
                                                @endphp  

                                                @if ($locale === 'en') 
                                                    <a href="{{ route('lang.switch', 'ar') }}" class="btn btn-warning" >العربية</a>
                                                @else
                                                    <a href="{{ route('lang.switch', 'en') }}" class="btn btn-warning">English</a>
                                                    
                                                @endif


</nav>