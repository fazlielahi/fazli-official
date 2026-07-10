<img
    src="{{ userPhotoUrl($user ?? null, $comment->photo ?? null) }}"
    class="user-image{{ !empty($class) ? ' ' . $class : '' }}"
    alt=""
    loading="lazy"
    onerror="this.onerror=null;this.src='{{ asset('images/default.svg') }}';">
