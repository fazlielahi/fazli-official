<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => [
        [
            '@type' => 'Question',
            'name' => __('lang.faq_what_services'),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => __('lang.faq_what_services_ans'),
            ],
        ],
        [
            '@type' => 'Question',
            'name' => __('lang.faq_why_seo_important'),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => __('lang.faq_why_seo_important_ans'),
            ],
        ],
        [
            '@type' => 'Question',
            'name' => __('lang.faq_responsive_websites'),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => __('lang.faq_responsive_websites_ans'),
            ],
        ],
        [
            '@type' => 'Question',
            'name' => __('lang.faq_website_time'),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => __('lang.faq_website_time_ans'),
            ],
        ],
        [
            '@type' => 'Question',
            'name' => __('lang.faq_manage_content'),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => __('lang.faq_manage_content_ans'),
            ],
        ],
        [
            '@type' => 'Question',
            'name' => __('lang.faq_maintenance'),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => __('lang.faq_maintenance_ans'),
            ],
        ],
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
