@php
    $resolveCustomSections = function ($data) {
        if (!empty($data['custom_sections']) && is_array($data['custom_sections'])) {
            return $data['custom_sections'];
        }
        if (!empty($data['custom']) && is_array($data['custom'])) {
            return [[
                'id' => 'legacy',
                'heading' => trim($data['custom_heading'] ?? '') ?: 'Custom',
                'items' => $data['custom'],
            ]];
        }
        return [];
    };

    $customSections = isset($customSection)
        ? [$customSection]
        : $resolveCustomSections($data ?? []);
@endphp

@foreach($customSections as $customSection)
    @php
        $customId = $customSection['id'] ?? ('cs_' . $loop->index);
        $layoutKey = 'custom__' . $customId;
        $customHeading = trim($customSection['heading'] ?? '') ?: 'Custom';
        $customItems = $customSection['items'] ?? [];
        $customStyle = '';
        if (isset($sectionStyle) && is_callable($sectionStyle)) {
            $customStyle = $sectionStyle($layoutKey);
        }
        $customLayoutColumn = isset($layoutColumn) && is_callable($layoutColumn) ? $layoutColumn($layoutKey) : null;
    @endphp
    @if(is_array($customItems) && count($customItems) > 0)
        <section class="custom"
            data-custom-id="{{ $customId }}"
            data-layout-key="{{ $layoutKey }}"
            @if($customStyle !== '') style="{{ $customStyle }}" @endif
            @if($customLayoutColumn) data-layout-column="{{ $customLayoutColumn }}" @endif
        >
            <h2 class="section-title">{{ mb_strtoupper($customHeading) }}</h2>
            <div class="section-content">
                <div class="custom-items">
                @foreach($customItems as $item)
                    @if(isset($item['is_hidden']) && (string) $item['is_hidden'] === '1')
                        @continue
                    @endif
                    @php
                        $hasTitle = !empty($item['title']);
                        $hasContent = !empty($item['content']);
                    @endphp
                    @if($hasTitle || $hasContent)
                        <div class="custom-item">
                            @if($hasTitle)
                                <h3 class="item-title">{{ $item['title'] }}</h3>
                            @endif
                            @if($hasContent)
                                <div class="item-description">{!! $item['content'] !!}</div>
                            @endif
                        </div>
                    @endif
                @endforeach
                </div>
            </div>
        </section>
    @endif
@endforeach
