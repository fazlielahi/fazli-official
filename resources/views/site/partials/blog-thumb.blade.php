@php
    $thumb = blogThumbMeta($blog);
    $imgClass = trim('blog-two__thumb ' . ($class ?? '') . ($thumb['is_default'] ? ' blog-two__img--default' : ''));
@endphp

<img src="{{ $thumb['url'] }}"
     onerror="this.onerror=null;this.src='{{ $thumb['default'] }}';"
     alt="{{ $blog->title ?? 'Blog post image' }}"
     loading="lazy"
     class="{{ $imgClass }}">
