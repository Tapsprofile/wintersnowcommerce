/**
 * Dark/Light Mode Toggle
 * Handles theme switching with local storage persistence
 */

(function() {
    'use strict';

    // Check for saved theme preference or default to system preference
    const currentTheme = localStorage.getItem('theme') || 
                        (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    
    // Apply theme on page load
    document.documentElement.setAttribute('data-theme', currentTheme);
    
    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        // Create theme toggle button if it doesn't exist
        createThemeToggle();
        
        // Add event listener to toggle button
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', toggleTheme);
        }
        
        // Update toggle icon on load
        updateToggleIcon(currentTheme);
    });
    
    /**
     * Create theme toggle button in header
     */
    function createThemeToggle() {
        // Check if button already exists
        if (document.getElementById('theme-toggle')) {
            return;
        }
        
        // Find header or create toggle container
        const header = document.querySelector('.site-header') || 
                      document.querySelector('header') ||
                      document.body;
        
        // Create toggle button
        const toggleButton = document.createElement('button');
        toggleButton.id = 'theme-toggle';
        toggleButton.className = 'theme-toggle';
        toggleButton.setAttribute('aria-label', 'Toggle dark/light mode');
        toggleButton.innerHTML = getSunIcon();
        
        // Insert into header
        if (header.classList.contains('site-header')) {
            const container = header.querySelector('.container') || header;
            container.appendChild(toggleButton);
        } else {
            header.insertBefore(toggleButton, header.firstChild);
        }
    }
    
    /**
     * Toggle between dark and light themes
     */
    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        // Update theme
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        
        // Update icon
        updateToggleIcon(newTheme);
        
        // Trigger custom event for other scripts
        const event = new CustomEvent('themeChanged', { detail: { theme: newTheme } });
        document.dispatchEvent(event);
    }
    
    /**
     * Update toggle button icon based on current theme
     */
    function updateToggleIcon(theme) {
        const toggleButton = document.getElementById('theme-toggle');
        if (!toggleButton) return;
        
        if (theme === 'dark') {
            toggleButton.innerHTML = getMoonIcon();
            toggleButton.setAttribute('aria-label', 'Switch to light mode');
        } else {
            toggleButton.innerHTML = getSunIcon();
            toggleButton.setAttribute('aria-label', 'Switch to dark mode');
        }
    }
    
    /**
     * Get sun icon SVG
     */
    function getSunIcon() {
        return `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z" />
            </svg>
        `;
    }
    
    /**
     * Get moon icon SVG
     */
    function getMoonIcon() {
        return `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z" clip-rule="evenodd" />
            </svg>
        `;
    }
    
})();
