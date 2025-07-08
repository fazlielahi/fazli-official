@extends('site.layout')

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
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />

@endsection

@section('content')

<div class="page-wrapper">

<!--Page Header Start-->
<section class="page-header">
    <div class="page-header__bg" style="background-image: url(assets/images/shapes/page-header-bg-shape.png);">
    </div>
    <div class="page-header__shape-4">
        <img src="assets/images/shapes/page-header-shape-4.png" alt="">
    </div>
    <div class="page-header__shape-5">
        <img src="assets/images/shapes/page-header-shape-5.png" alt="">
    </div>
    <div class="page-header__social">
        <a href="#">Facebook</a>
        <span>//</span>
        <a href="#">Instagram</a>
        <span>//</span>
        <a href="#">LinkedIn</a>
        <span>//</span>
        <a href="#">Twitter</a>
    </div>
    <div class="container">
        <div class="page-header__inner">
            <div class="page-header__img">
                <img src="assets/images/resources/page-header-img-1.png" alt="">
                <div class="page-header__shape-1">
                    <img src="assets/images/shapes/page-header-shape-1.png" alt="">
                </div>
                <div class="page-header__shape-2">
                    <img src="assets/images/shapes/page-header-shape-2.png" alt="">
                </div>
                <div class="page-header__shape-3">
                    <img src="assets/images/shapes/page-header-shape-3.png" alt="">
                </div>
            </div>
            <h2>Blog Details</h2>
            <div class="thm-breadcrumb__box">
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="index.html">Home</a></li>
                    <li><span>//</span></li>
                    <li>Blog Details</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--Page Header End-->

<!--Blog Details Start-->
<section class="blog-details">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="blog-details__left">
                    <div class="blog-details__img-box">
                        <div class="blog-details__img">
                            <img src="assets/images/blog/blog-details-img-1.jpg" alt="">
                        </div>
                    </div>
                    <div class="blog-details__content">
                        <h3 class="blog-details__title-1">The Future of Education: Why Online Learning is Here
                            to Stay</h3>
                        <div class="blog-details__client-and-meta">
                            <div class="blog-details__client-box">
                                <div class="blog-details__client-img">
                                    <img src="assets/images/blog/blog-details-client-img-1.jpg" alt="">
                                </div>
                                <div class="blog-details__client-content">
                                    <p>Published By</p>
                                    <h4>Jordan Walk</h4>
                                </div>
                            </div>
                            <ul class="blog-details__client-meta list-unstyled">
                                <li>
                                    <div class="icon">
                                        <span class="icon-calendar"></span>
                                    </div>
                                    <p>Nov 02, 2025</p>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-tags"></span>
                                    </div>
                                    <p>Marketing</p>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-comments"></span>
                                    </div>
                                    <p>(Comments)</p>
                                </li>
                            </ul>
                        </div>
                        <p class="blog-details__text-1">The digital era has radically transformed nearly
                            every industry, and education is no exception. What began as an alternative to
                            traditional classroom settings has now solidified into an essential component of
                            modern education. The flexibility, accessibility, and evolving technology of
                            online learning make it more than just a trend; it’s a pivotal shift that’s here
                            to stay. In this post, we’ll explore the reasons why online learning has not
                            only become a staple of modern education but also why it holds the key to the
                            future.</p>
                        <h4 class="blog-details__title-2">Flexibility and Accessibility</h4>
                        <p class="blog-details__text-2">One of the most significant advantages of online
                            learning is the flexibility it offers. Students are no longer bound by
                            geographic location or rigid schedules. Online courses allow learners to access
                            materials at their own pace and fit study time into their busy lives. </p>
                        <p class="blog-details__text-3">With online learning, education is accessible from
                            anywhere with an internet connection. This accessibility helps bridge the gap
                            for students in remote areas, making education more inclusive and far-reaching
                            than ever before. </p>
                        <div class="blog-details__points-box">
                            <h4 class="blog-details__points-title">A Personalized Learning Experience</h4>
                            <ul class="blog-details__points list-unstyled">
                                <li>
                                    <div class="icon">
                                        <span class="icon-angles-right"></span>
                                    </div>
                                    <p>Online learning platforms have evolved to offer a highly personalized
                                        experience tailored to each student's needs. </p>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-angles-right"></span>
                                    </div>
                                    <p>Universities, colleges, and independent platforms offer courses in fields
                                        ranging from AI and data science to psychology, art history, and
                                        business.</p>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-angles-right"></span>
                                    </div>
                                    <p>For instance, some students benefit from visual aids, while others learn
                                        best through hands-on activities or text-based resources.</p>
                                </li>
                            </ul>
                        </div>
                        <div class="blog-details__quote-box">
                            <div class="blog-details__quote-icon-1">
                                <span class="icon-quote"></span>
                            </div>
                            <div class="blog-details__quote-icon-2">
                                <span class="icon-quote"></span>
                            </div>
                            <p class="blog-details__quote-text">Education in the modern world transcends
                                classrooms and rigid schedules; it is a lifelong journey accessible to anyone,
                                anywhere, with a drive to learn and grow. </p>
                            <div class="blog-details__client-box-2">
                                <div class="blog-details__client-img-2">
                                    <img src="assets/images/blog/blog-details-client-img-2.jpg" alt="">
                                </div>
                                <div class="blog-details__client-content-2">
                                    <p>Web Designer</p>
                                    <h4>Johnson Taylor</h4>
                                </div>
                            </div>
                        </div>
                        <h4 class="blog-details__title-3">Lifelong Learning and Skill Development</h4>
                        <p class="blog-details__text-4">Lifelong learning is becoming essential for
                            professionals who want to stay relevant in their careers, and online learning caters
                            to this need by offering short courses, workshops, and certifications that focus on
                            specific skills.</p>
                        <div class="blog-details__img-box-2">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="blog-details__img-box-img">
                                        <img src="assets/images/blog/blog-details-img-box-img-1.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="blog-details__img-box-img">
                                        <img src="assets/images/blog/blog-details-img-box-img-2.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="blog-details__text-5">As we move forward, the role of online learning in
                            education will only expand. By embracing these changes, institutions and individuals
                            alike can benefit from an education that meets the needs of a rapidly evolving
                            world. Online learning is not just a passing phase – it’s the future of education.
                        </p>
                        <div class="blog-details__tag-and-share">
                            <div class="blog-details__tag">
                                <span>Tags:</span>
                                <a href="#">Education</a>
                                <a href="#">Development</a>
                                <a href="#">Design</a>
                            </div>
                            <div class="blog-details__share">
                                <span>Share</span>
                                <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                            </div>
                        </div>
                        <div class="comment-one">
                            <h3 class="comment-one__title">Total Reviews (165)</h3>
                            <ul class="comment-one__single-list list-unstyled">
                                <li>
                                    <div class="comment-one__single">
                                        <div class="comment-one__image-box">
                                            <div class="comment-one__image">
                                                <img src="assets/images/blog/comment-1-1.jpg" alt="">
                                            </div>
                                        </div>
                                        <div class="comment-one__content">
                                            <div class="comment-one__name-box">
                                                <h4>Alisa Manama <span>Product Designer</span></h4>
                                            </div>
                                            <p>This article really resonates with me! As a working parent,
                                                online
                                                learning has been a game-changer. I’m able to continue my
                                                education
                                                without sacrificing family time. I genuinely believe that this
                                                is
                                                the
                                                future of education.</p>
                                            <div class="comment-one__btn-box">
                                                <a href="blog-details.html" class="comment-one__btn">Reply</a>
                                                <span>18 July, 2025</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="comment-one__single">
                                        <div class="comment-one__image-box">
                                            <div class="comment-one__image">
                                                <img src="assets/images/blog/comment-1-2.jpg" alt="">
                                            </div>
                                        </div>
                                        <div class="comment-one__content">
                                            <div class="comment-one__name-box">
                                                <h4>Jordan Walk <span>By Author</span></h4>
                                            </div>
                                            <p>Absolutely! It’s amazing how online learning adapts to our lives,
                                                isn’t it? Being able to balance work, family, and education is
                                                such a huge advantage. Glad it’s working so well for you!</p>
                                            <div class="comment-one__btn-box">
                                                <a href="blog-details.html" class="comment-one__btn">Reply</a>
                                                <span>18 July, 2025</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <ul class="comment-one__single-list comment-one__single-list-2 list-unstyled">
                                <li>
                                    <div class="comment-one__single">
                                        <div class="comment-one__image-box">
                                            <div class="comment-one__image">
                                                <img src="assets/images/blog/comment-1-3.jpg" alt="">
                                            </div>
                                        </div>
                                        <div class="comment-one__content">
                                            <div class="comment-one__name-box">
                                                <h4>Lisa Oliva <span>Fashion Designer</span></h4>
                                            </div>
                                            <p>This article really resonates with me! As a working parent,
                                                online learning has been a game-changer. I’m able to continue my
                                                education without sacrificing family time. I genuinely believe
                                                that this is the future of education.</p>
                                            <div class="comment-one__btn-box">
                                                <a href="blog-details.html" class="comment-one__btn">Reply</a>
                                                <span>18 July, 2025</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="comment-form">
                            <h3 class="comment-form__title">Submit Your Reviews</h3>
                            <div class="comment-form__text-and-ratting">
                                <p class="comment-form__text">Your Ratings </p>
                                <ul class="comment-form__ratting list-unstyled">
                                    <li>
                                        <span class="icon-star"></span>
                                    </li>
                                    <li>
                                        <span class="icon-star"></span>
                                    </li>
                                    <li>
                                        <span class="icon-star"></span>
                                    </li>
                                    <li>
                                        <span class="icon-star"></span>
                                    </li>
                                    <li>
                                        <span class="icon-star"></span>
                                    </li>
                                </ul>
                            </div>
                            <form action="assets/inc/sendemail.php"
                                class="comment-form__form contact-form-validated" novalidate="novalidate">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="comment-form__input-box">
                                            <input type="text" placeholder="Full Name" name="name">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="comment-form__input-box">
                                            <input type="email" placeholder="Email Address" name="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="comment-form__input-box text-message-box">
                                            <textarea name="message" placeholder="Write Review"></textarea>
                                        </div>
                                        <div class="comment-form__btn-box">
                                            <button type="submit" class="comment-form__btn"><span
                                                    class="icon-arrow-circle"></span>Submit
                                                Review</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="result"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="sidebar">

                    <div class="sidebar__single sidebar__category">
                        <div class="sidebar__title-box">
                            <div class="sidebar__title-icon">
                                <img src="assets/images/icon/sidebar-title-icon.png" alt="">
                            </div>
                            <h3 class="sidebar__title">Category </h3>
                        </div>
                        <ul class="sidebar__category-list list-unstyled">
                            <li>
                                <a href="blog-details.html">Digital Marketing - (45)<span
                                        class="fas fa-arrow-right"></span></a>
                            </li>
                            <li>
                                <a href="blog-details.html">Health & Fitness - (12)<span
                                        class="fas fa-arrow-right"></span></a>
                            </li>
                            <li class="active">
                                <a href="blog-details.html">Programming & Tech - (78)<span
                                        class="fas fa-arrow-right"></span></a>
                            </li>
                            <li>
                                <a href="blog-details.html">Product Design - (45)<span
                                        class="fas fa-arrow-right"></span></a>
                            </li>
                            <li>
                                <a href="blog-details.html">Online Chef - (12)<span
                                        class="fas fa-arrow-right"></span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="sidebar__single sidebar__post">
                        <div class="sidebar__title-box">
                            <div class="sidebar__title-icon">
                                <img src="assets/images/icon/sidebar-title-icon.png" alt="">
                            </div>
                            <h3 class="sidebar__title">Latest Post </h3>
                        </div>
                        <ul class="sidebar__post-list list-unstyled">
                            <li>
                                <div class="sidebar__post-image">
                                    <img src="assets/images/blog/blog-lp-1.jpg" alt="">
                                </div>
                                <div class="sidebar__post-content">
                                    <ul class="sidebar__post-meta list-unstyled">
                                        <li>
                                            <p><span class="icon-tags"></span>Development</p>
                                        </li>
                                        <li>
                                            <p><span class="icon-clock"></span>10 Min Read</p>
                                        </li>
                                    </ul>
                                    <h3 class="sidebar__post-title"><a href="blog-details.html">Creating a
                                            Productive Study Space for Online Learning</a></h3>
                                </div>
                            </li>
                            <li>
                                <div class="sidebar__post-image">
                                    <img src="assets/images/blog/blog-lp-2.jpg" alt="">
                                </div>
                                <div class="sidebar__post-content">
                                    <ul class="sidebar__post-meta list-unstyled">
                                        <li>
                                            <p><span class="icon-tags"></span>Development</p>
                                        </li>
                                        <li>
                                            <p><span class="icon-clock"></span>10 Min Read</p>
                                        </li>
                                    </ul>
                                    <h3 class="sidebar__post-title"><a href="blog-details.html">Universities,
                                            colleges, and independent platforms</a></h3>
                                </div>
                            </li>
                            <li>
                                <div class="sidebar__post-image">
                                    <img src="assets/images/blog/blog-lp-3.jpg" alt="">
                                </div>
                                <div class="sidebar__post-content">
                                    <ul class="sidebar__post-meta list-unstyled">
                                        <li>
                                            <p><span class="icon-tags"></span>Development</p>
                                        </li>
                                        <li>
                                            <p><span class="icon-clock"></span>10 Min Read</p>
                                        </li>
                                    </ul>
                                    <h3 class="sidebar__post-title"><a href="blog-details.html">How to Succeed
                                            in Online Learning: Tips for Students</a></h3>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="sidebar__single sidebar__tag">
                        <div class="sidebar__title-box">
                            <div class="sidebar__title-icon">
                                <img src="assets/images/icon/sidebar-title-icon.png" alt="">
                            </div>
                            <h3 class="sidebar__title">Keywords</h3>
                        </div>
                        <div class="sidebar__tag-list">
                            <a href="blog-details.html">Business</a>
                            <a href="blog-details.html">Design</a>
                            <a href="blog-details.html">Development</a>
                            <a href="blog-details.html">Technology</a>
                            <a href="blog-details.html">Fitness</a>
                            <a href="blog-details.html">Cooking</a>
                            <a href="blog-details.html">Health Care</a>
                        </div>
                    </div>
                    <div class="sidebar__single sidebar__newsletter">
                        <div class="sidebar__title-box">
                            <div class="sidebar__title-icon">
                                <img src="assets/images/icon/sidebar-title-icon.png" alt="">
                            </div>
                            <h3 class="sidebar__title">Newsletter </h3>
                        </div>
                        <p class="sidebar__newsletter-text">Subscribe our newsletter to get every update </p>
                        <form action="#" class="sidebar__newsletter-form">
                            <input type="search" placeholder="Search Blogs">
                            <button type="submit">Subscribe<i class="icon-circle-left"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Blog Details End-->


<!--Newsletter Two Start -->
<section class="newsletter-two">
</section>
<!--Newsletter Two End -->

</div><!-- /.page-wrapper -->


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


@endsection
