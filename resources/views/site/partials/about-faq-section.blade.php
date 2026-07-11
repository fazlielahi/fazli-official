<section id="faq" class="faq-section py-5">
    <div class="container">
        <h2 class="mb-4">{{ __('lang.faq_title') }}</h2>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h3 class="accordion-header" id="heading1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        {{ __('lang.faq_what_services') }}
                    </button>
                </h3>
                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">{{ __('lang.faq_what_services_ans') }}</div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header" id="heading2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        {{ __('lang.faq_why_seo_important') }}
                    </button>
                </h3>
                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">{{ __('lang.faq_why_seo_important_ans') }}</div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header" id="heading3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        {{ __('lang.faq_responsive_websites') }}
                    </button>
                </h3>
                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">{{ __('lang.faq_responsive_websites_ans') }}</div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header" id="heading4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                        {{ __('lang.faq_website_time') }}
                    </button>
                </h3>
                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">{{ __('lang.faq_website_time_ans') }}</div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header" id="heading5">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                        {{ __('lang.faq_manage_content') }}
                    </button>
                </h3>
                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">{{ __('lang.faq_manage_content_ans') }}</div>
                </div>
            </div>
            <div class="accordion-item">
                <h3 class="accordion-header" id="heading6">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                        {{ __('lang.faq_maintenance') }}
                    </button>
                </h3>
                <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">{{ __('lang.faq_maintenance_ans') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>
