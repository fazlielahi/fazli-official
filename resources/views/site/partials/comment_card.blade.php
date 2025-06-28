<div class="comment-card">
    <img
        src="{{ $user && $user->photo ? asset('images/' . $user->photo) : asset('assets/img/user-image.png') }}"
        alt="img" class="user-image">
    <div class="comment-content">
        <span class="username">{{ $comment->name }}</span>
        <span class="timestamp">{{ $comment->created_at->diffForHumans() }}</span>
        <div class="comment-text">{{ $comment->comment }}</div>
    </div>
</div> 