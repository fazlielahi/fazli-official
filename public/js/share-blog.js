function copyToClipboard(evt, text, messageId) {
    evt.preventDefault();
  
    // Try modern Clipboard API
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(text)
        .then(showMessage)
        .catch(err => console.error('Copy failed:', err));
    } else {
      // Fallback for older browsers
      const textarea = document.createElement('textarea');
      textarea.value = text;
      textarea.style.position = 'absolute';
      textarea.style.left = '-9999px';
      document.body.appendChild(textarea);
  
      textarea.select();
      try {
        document.execCommand('copy');
        showMessage();
      } catch (err) {
        console.error('Fallback copy failed:', err);
      }
      document.body.removeChild(textarea);
    }
  
    function showMessage() {
      const copyMessage = document.getElementById(messageId);
      if (!copyMessage) {
        console.warn(`copyToClipboard: element #${messageId} not found`);
        return;
      }
      copyMessage.style.display = 'block';
      copyMessage.style.zIndex   = '1060';  // above default Bootstrap modal z-index (1050)
      setTimeout(() => {
        copyMessage.style.display = 'none';
      }, 2000);
    }
  }
  