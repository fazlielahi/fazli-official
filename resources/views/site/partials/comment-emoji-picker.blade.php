<div class="emoji-picker-container">
    <button type="button" class="emoji-toggle-btn" aria-label="{{ __('lang.Add a comment') }}">
        <i class="far fa-face-smile" aria-hidden="true"></i>
    </button>
    <div class="emoji-panel">
        <div class="emoji-grid">
            @foreach(['😊','😂','😍','😎','🤔','👍','👎','❤️','🔥','💯','✨','🎉','👏','🙏','😭','😡','😱','😴','🤗','😇','🤩','😋','🤪','😝','🤓','😤','😪','🤐','😷','🤒','🤕','🤢','🤮','🤧','😈','👿','👹','👺','💀','☠️','👻','👽','🤖','💩','😺','😸','😹','😻','😼','😽','🙀','😿','😾'] as $emoji)
                <button type="button" class="emoji-btn" data-emoji="{{ $emoji }}">{{ $emoji }}</button>
            @endforeach
        </div>
    </div>
</div>
