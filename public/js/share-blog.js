function copyToClipboard(evt, text, messageId) {
    if (evt) {
        evt.preventDefault();
    }

    function showMessage() {
        const copyMessage = document.getElementById(messageId);
        if (!copyMessage) {
            console.warn(`copyToClipboard: element #${messageId} not found`);
            return;
        }
        copyMessage.style.display = 'block';
        setTimeout(() => {
            copyMessage.style.display = 'none';
        }, 2000);
    }

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text)
            .then(showMessage)
            .catch(function (err) {
                console.error('Copy failed:', err);
                fallbackCopy(text, showMessage);
            });
    } else {
        fallbackCopy(text, showMessage);
    }
}

function fallbackCopy(text, onSuccess) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'absolute';
    textarea.style.left = '-9999px';
    document.body.appendChild(textarea);
    textarea.select();

    try {
        document.execCommand('copy');
        onSuccess();
    } catch (err) {
        console.error('Fallback copy failed:', err);
    }

    document.body.removeChild(textarea);
}

document.addEventListener('click', function (evt) {
    const link = evt.target.closest('.share-action[data-share-action]');
    if (!link) {
        return;
    }

    const action = link.dataset.shareAction;
    const url = link.dataset.shareUrl || '';
    const title = link.dataset.shareTitle || '';

    if (action === 'copy') {
        copyToClipboard(evt, url, link.dataset.messageId);
        return;
    }

    if (action === 'facebook') {
        evt.preventDefault();
        const facebookUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url);
        window.open(facebookUrl, '_blank', 'noopener,noreferrer,width=600,height=600');
        return;
    }

    if (action === 'linkedin') {
        evt.preventDefault();
        const linkedinUrl = 'https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(url);
        window.open(linkedinUrl, '_blank', 'noopener,noreferrer,width=600,height=600');
        return;
    }

    // WhatsApp uses a real href; let the browser handle it.
});
