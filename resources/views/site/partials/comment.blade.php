<div class="comment-card comment-item" style="border-bottom: 1px solid #767676; margin-bottom: 20px; padding-bottom: 4px; align-items: flex-start;">
    <img
        src="{{ $user && $user->photo ? asset('images/' . $user->photo) : ($comment && $comment->photo ? asset('images/' . $comment->photo) : asset('images/default.png')) }}"
        class="user-image" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 12px;">
    <div class="comment-content comment-detail">
    <div class="comment-creater">
        <span class="username" style="font-weight: bold;">{{ $comment->name }}</span>
        <span class="timestamp" style="color: #888; font-size: 0.9em; margin-left: 8px;">{{ $comment->created_at->diffForHumans() }}</span>
    <div class="comment-creater">
        <div class="comment-text" style="margin-top: 4px;">{{ $comment->comment }}</div>
    </div>
</div> 