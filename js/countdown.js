/**
 * Countdown Timer
 * Countdown to festive offers end date
 */

(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        initCountdownTimers();
    });
    
    /**
     * Initialize all countdown timers on the page
     */
    function initCountdownTimers() {
        const countdownElements = document.querySelectorAll('.countdown-timer');
        
        countdownElements.forEach(function(element) {
            const endDate = element.getAttribute('data-end-date');
            if (endDate) {
                startCountdown(element, new Date(endDate));
            } else {
                // Default: 7 days from now
                const defaultEndDate = new Date();
                defaultEndDate.setDate(defaultEndDate.getDate() + 7);
                startCountdown(element, defaultEndDate);
            }
        });
    }
    
    /**
     * Start countdown for a specific element
     */
    function startCountdown(element, endDate) {
        const displayElement = element.querySelector('.countdown-display');
        
        if (!displayElement) {
            createCountdownDisplay(element);
        }
        
        // Update immediately
        updateCountdown(element, endDate);
        
        // Update every second
        setInterval(function() {
            updateCountdown(element, endDate);
        }, 1000);
    }
    
    /**
     * Create countdown display HTML
     */
    function createCountdownDisplay(element) {
        const title = element.getAttribute('data-title') || 'Festive Sale Ends In:';
        
        const html = `
            <div class="countdown-title">${title}</div>
            <div class="countdown-display">
                <div class="countdown-unit">
                    <div class="countdown-value" id="days">00</div>
                    <div class="countdown-label">Days</div>
                </div>
                <div class="countdown-unit">
                    <div class="countdown-value" id="hours">00</div>
                    <div class="countdown-label">Hours</div>
                </div>
                <div class="countdown-unit">
                    <div class="countdown-value" id="minutes">00</div>
                    <div class="countdown-label">Minutes</div>
                </div>
                <div class="countdown-unit">
                    <div class="countdown-value" id="seconds">00</div>
                    <div class="countdown-label">Seconds</div>
                </div>
            </div>
        `;
        
        element.innerHTML = html;
    }
    
    /**
     * Update countdown display
     */
    function updateCountdown(element, endDate) {
        const now = new Date().getTime();
        const distance = endDate.getTime() - now;
        
        if (distance < 0) {
            element.querySelector('.countdown-display').innerHTML = '<p>Offer Expired</p>';
            return;
        }
        
        // Calculate time units
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Update display
        const daysElement = element.querySelector('#days');
        const hoursElement = element.querySelector('#hours');
        const minutesElement = element.querySelector('#minutes');
        const secondsElement = element.querySelector('#seconds');
        
        if (daysElement) daysElement.textContent = padZero(days);
        if (hoursElement) hoursElement.textContent = padZero(hours);
        if (minutesElement) minutesElement.textContent = padZero(minutes);
        if (secondsElement) secondsElement.textContent = padZero(seconds);
    }
    
    /**
     * Pad number with leading zero
     */
    function padZero(num) {
        return num < 10 ? '0' + num : num;
    }
    
})();
