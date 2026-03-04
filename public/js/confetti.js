// Simple Confetti Effect for Create CV Button
(function() {
    'use strict';
    
    // Green color variations
    const colors = ['#1da370', '#0d8a5a', '#25cb8c', '#21cf8c', '#2ecc71', '#27ae60'];
    
    function createConfetti(button) {
        const rect = button.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        
        // Create 20 confetti dots
        for (let i = 0; i < 20; i++) {
            const dot = document.createElement('div');
            dot.className = 'confetti-dot';
            dot.style.background = colors[Math.floor(Math.random() * colors.length)];
            dot.style.left = centerX + 'px';
            dot.style.top = centerY + 'px';
            
            // Random direction and distance
            const angle = (Math.PI * 2 * i) / 20;
            const distance = Math.random() * 60 + 30;
            const endX = centerX + Math.cos(angle) * distance;
            const endY = centerY + Math.sin(angle) * distance;
            
            document.body.appendChild(dot);
            
            // Animate
            dot.animate([
                { transform: 'translate(0, 0) scale(1)', opacity: 1 },
                { transform: `translate(${endX - centerX}px, ${endY - centerY}px) scale(0)`, opacity: 0 }
            ], {
                duration: 1000 + Math.random() * 500,
                easing: 'ease-out'
            }).onfinish = () => dot.remove();
        }
    }
    
    // Initialize - Auto confetti
    function init() {
        const btn = document.getElementById('createCvBtn');
        if (!btn) return;
        
        // Trigger confetti immediately on load
        createConfetti(btn);
        
        // Auto-trigger confetti every 3 seconds
        setInterval(function() {
            createConfetti(btn);
        }, 1000);
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

