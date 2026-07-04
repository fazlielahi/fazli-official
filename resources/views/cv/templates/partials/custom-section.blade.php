@php
    $customHeading = trim($data['custom_heading'] ?? '') ?: 'Custom';
    $customStyle = isset($sectionStyle) && is_callable($sectionStyle) ? $sectionStyle('custom') : '';
    $customLayoutColumn = isset($layoutColumn) && is_callable($layoutColumn) ? $layoutColumn('custom') : null;
@endphp
@if(isset($data['custom']) && count($data['custom']) > 0)
    <section class="custom"
        @if($customStyle !== '') style="{{ $customStyle }}" @endif
        @if($customLayoutColumn) data-layout-column="{{ $customLayoutColumn }}" @endif
    >
        <h2 class="section-title">{{ mb_strtoupper($customHeading) }}</h2>
        <div class="section-content">
            <div class="custom-items">
            @foreach($data['custom'] as $item)
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
