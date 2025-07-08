# Theme System Documentation

## Overview
This website now includes a comprehensive light/dark mode theme system that allows users to switch between themes with a toggle button in the top-right corner of the navigation bar.

## Features

### 🎨 Theme Toggle
- **Location**: Top-right corner of the navigation bar
- **Functionality**: Click to switch between light and dark modes
- **Persistence**: Theme preference is saved in localStorage
- **Keyboard Shortcut**: Ctrl/Cmd + T to toggle themes
- **Responsive**: Adapts to different screen sizes

### 🌙 Dark Mode (Default)
- Dark background colors
- Light text colors
- High contrast for better readability
- Maintains the original dark theme aesthetic

### ☀️ Light Mode
- Light background colors
- Dark text colors
- Clean, modern appearance
- Optimized for daytime viewing

## Technical Implementation

### Files Created/Modified

1. **`public/styles/theme.css`** - Main theme stylesheet
   - CSS variables for both themes
   - Theme-specific styling rules
   - Responsive design considerations

2. **`public/js/theme.js`** - Theme management JavaScript
   - Theme switching logic
   - localStorage persistence
   - Event handling

3. **`resources/views/site/inc/header.blade.php`** - Updated header
   - Added theme toggle button
   - Responsive layout adjustments

4. **`resources/views/site/layout.blade.php`** - Updated layout
   - Included theme CSS and JS files

5. **Language Files** - Added translations
   - `resources/lang/en/lang.php` - English "Theme" translation
   - `resources/lang/ar/lang.php` - Arabic "المظهر" translation

### CSS Variables System

The theme system uses CSS custom properties (variables) to manage colors:

```css
:root {
  /* Light Mode Variables */
  --light-bg-primary: #ffffff;
  --light-text-primary: #212529;
  /* ... more variables */
  
  /* Dark Mode Variables */
  --dark-bg-primary: #0c0c0c;
  --dark-text-primary: #ffffff;
  /* ... more variables */
}
```

### JavaScript Class

The `ThemeManager` class handles all theme-related functionality:

```javascript
class ThemeManager {
  constructor() {
    this.currentTheme = localStorage.getItem('theme') || 'dark';
    this.init();
  }
  
  setTheme(theme) { /* ... */ }
  toggleTheme() { /* ... */ }
  // ... more methods
}
```

## Usage

### For Users
1. Click the theme toggle button in the top-right corner
2. Use keyboard shortcut Ctrl/Cmd + T
3. Theme preference is automatically saved

### For Developers

#### Adding Theme Support to New Components

1. **Use CSS Variables**: Instead of hardcoded colors, use theme variables:
   ```css
   .my-component {
     background-color: var(--bg-primary);
     color: var(--text-primary);
     border: 1px solid var(--border);
   }
   ```

2. **Add Theme-Specific Styles**: For complex components, add specific light mode overrides:
   ```css
   body[data-theme="light"] .my-component {
     background-color: var(--light-bg-secondary);
   }
   ```

3. **Listen for Theme Changes**: JavaScript can listen for theme changes:
   ```javascript
   document.addEventListener('themeChanged', (e) => {
     console.log('Theme changed to:', e.detail.theme);
     // Update component accordingly
   });
   ```

#### Extending the Theme System

1. **Add New Variables**: Add new color variables to both light and dark themes in `theme.css`
2. **Update Components**: Apply the new variables to components
3. **Test Both Themes**: Ensure components look good in both light and dark modes

## Browser Support

- Modern browsers with CSS custom properties support
- Graceful degradation for older browsers
- localStorage for theme persistence

## Accessibility

- High contrast ratios maintained in both themes
- Keyboard navigation support
- Screen reader friendly
- Respects user's system preferences (can be extended)

## Future Enhancements

- System theme detection (prefers-color-scheme media query)
- Additional theme options (high contrast, sepia, etc.)
- Animated theme transitions
- Theme-specific images and icons
- Server-side theme preference storage

## Troubleshooting

### Theme Not Switching
1. Check if `theme.js` is loaded
2. Verify localStorage is enabled
3. Check browser console for errors

### Styles Not Applying
1. Ensure `theme.css` is included
2. Check CSS specificity
3. Verify CSS variables are defined

### Responsive Issues
1. Test on different screen sizes
2. Check media queries in `theme.css`
3. Verify Bootstrap classes are properly applied 