// Theme Management JavaScript
class ThemeManager {
    constructor() {
        const lockTheme = document.body ? document.body.getAttribute('data-theme-lock') : null;
        this.lockTheme = lockTheme && String(lockTheme).trim() ? String(lockTheme).trim() : null;
        this.currentTheme = this.lockTheme || localStorage.getItem('theme') || 'light';
        this.init();
    }

    init() {
        // Set initial theme
        this.setTheme(this.currentTheme);
        
        // If theme is locked (e.g. CV pages), disable toggling
        if (!this.lockTheme) {
            this.addEventListeners();
        } else {
            this.disableToggleUi();
        }
        
        // Update toggle button state
        this.updateToggleButton();
    }

    setTheme(theme) {
        // Set body data attribute
        document.body.setAttribute('data-theme', theme);
        
        // Update toggle button
        const toggle = document.querySelector('.theme-toggle');
        if (toggle) {
            toggle.setAttribute('data-theme', theme);
        }
        
        // Save to localStorage
        localStorage.setItem('theme', theme);
        
        // Update current theme
        this.currentTheme = theme;
        
        // Dispatch custom event for other scripts
        document.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme } }));
    }

    toggleTheme() {
        const newTheme = this.currentTheme === 'dark' ? 'light' : 'dark';
        this.setTheme(newTheme);
    }

    updateToggleButton() {
        const toggle = document.querySelector('.theme-toggle');
        if (toggle) {
            toggle.setAttribute('data-theme', this.currentTheme);
        }
    }

    addEventListeners() {
        // Theme toggle button click
        document.addEventListener('click', (e) => {
            if (e.target.closest('.theme-toggle')) {
                this.toggleTheme();
            }
        });

        // Keyboard shortcut (Ctrl/Cmd + T)
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 't') {
                e.preventDefault();
                this.toggleTheme();
            }
        });
    }

    disableToggleUi() {
        const toggle = document.querySelector('.theme-toggle');
        if (!toggle) return;
        toggle.setAttribute('aria-disabled', 'true');
        toggle.setAttribute('title', "Theme toggle isn't available in Resume tool.");
        toggle.style.pointerEvents = 'none';
        toggle.style.opacity = '0.65';
        toggle.style.cursor = 'not-allowed';

        const container = toggle.closest('.theme-toggle-container');
        if (container) {
            container.setAttribute('title', "Theme toggle isn't available in Resume tool.");
            container.style.cursor = 'not-allowed';
        }
    }

    // Get current theme
    getCurrentTheme() {
        return this.currentTheme;
    }

    // Check if theme is dark
    isDark() {
        return this.currentTheme === 'dark';
    }

    // Check if theme is light
    isLight() {
        return this.currentTheme === 'light';
    }
}

// Initialize theme manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.themeManager = new ThemeManager();
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ThemeManager;
} 