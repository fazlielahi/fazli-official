<div class="comment-card comment-item">
    @include('site.partials.comment-avatar', ['user' => $user ?? null, 'comment' => $comment])
    <div class="comment-content">
        <div class="comment-meta">
            <span class="username">{{ $comment->name }}</span>
            <span class="timestamp">{{ $comment->created_at->diffForHumans() }}</span>
        </div>
        <div class="comment-text">{{ $comment->comment }}</div>
    </div>
</div>
