/**
 * PPMHA Application JavaScript
 * Main interactive functionality and utilities
 */

// ========== DOM Ready Setup ==========
function initializeApp() {
    setupHamburger();
    setupDeleteButtons();
    setupAlerts();
    setupTableSearch();
    setupDarkModeToggle();
    setupClickableRows();
}

// ========== Clickable Table Rows ==========
function setupClickableRows() {
    const rows = document.querySelectorAll('tr[data-href]');
    rows.forEach(row => {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function(e) {
            // Don't trigger if clicking a button, link or checkbox inside the row
            if (e.target.closest('button') || e.target.closest('a') || e.target.closest('input')) {
                return;
            }
            window.location.href = this.getAttribute('data-href');
        });
    });
}

if(document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeApp);
} else {
    initializeApp();
}

// ========== Hamburger Menu ==========
function setupHamburger() {
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('navMenu');

    if(hamburger && navMenu) {
        hamburger.addEventListener('click', function(e) {
            e.preventDefault();
            navMenu.classList.toggle('active');
            hamburger.classList.toggle('active');
        });
    }
}

// ========== Delete Confirmation ==========
function confirmDelete(message = 'Apakah Anda yakin ingin menghapus?') {
    return confirm(message);
}

function setupDeleteButtons() {
    const deleteButtons = document.querySelectorAll('[data-action="delete"]');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            if(!confirmDelete(this.getAttribute('data-confirm') || 'Apakah Anda yakin ingin menghapus item ini?')) {
                return;
            }

            const form = this.closest('form');
            if(form) {
                const btn = this;
                btn.disabled = true;
                btn.classList.add('btn-loading');
                form.submit();
            }
        });
    });
}

// ========== Form Utilities ==========
function validateForm(form) {
    if(!form) return false;
    
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;

    inputs.forEach(input => {
        const isEmpty = !input.value.trim();
        input.classList.toggle('is-invalid', isEmpty);
        
        if(isEmpty) {
            isValid = false;
        }
    });

    return isValid;
}

function setupFormValidation() {
    const forms = document.querySelectorAll('form[data-validate="true"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if(!validateForm(this)) {
                e.preventDefault();
                return false;
            }
        });
    });
}

if(document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupFormValidation);
} else {
    setupFormValidation();
}

// ========== Alert Auto-dismiss ==========
function setupAlerts() {
    const alerts = document.querySelectorAll('.alert:not([data-persist])');
    
    alerts.forEach(alert => {
        const duration = parseInt(alert.getAttribute('data-dismiss') || '5000');
        
        setTimeout(() => {
            fadeOut(alert, 300, () => {
                alert.remove();
            });
        }, duration);
    });
}

function fadeOut(element, duration = 300, callback) {
    element.style.transition = `opacity ${duration}ms ease`;
    element.style.opacity = '0';
    
    setTimeout(() => {
        if(callback) callback();
    }, duration);
}

// ========== Table Search ==========
function setupTableSearch() {
    const searchInputs = document.querySelectorAll('[data-table-search]');
    
    searchInputs.forEach(input => {
        input.addEventListener('keyup', function() {
            const tableId = this.getAttribute('data-table-search');
            const table = document.getElementById(tableId);
            
            if(!table) return;
            
            const filter = this.value.toUpperCase();
            const rows = table.querySelectorAll('tbody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const text = row.textContent.toUpperCase();
                const isVisible = text.includes(filter);
                
                row.style.display = isVisible ? '' : 'none';
                if(isVisible) visibleCount++;
            });

            // Show empty message if no results
            const noResults = table.querySelector('.no-results');
            if(noResults) {
                noResults.style.display = visibleCount === 0 ? '' : 'none';
            }
        });
    });
}

// ========== Manual Test Functions ==========
function testDarkMode() {
    console.log('Testing dark mode toggle...');
    const body = document.body;
    const isCurrentlyDark = body.classList.contains('dark-mode');
    
    console.log('Current state:', isCurrentlyDark);
    
    // Toggle the state
    body.classList.toggle('dark-mode');
    const newState = body.classList.contains('dark-mode');
    
    console.log('New state:', newState);
    
    // Update button
    updateToggleButton(newState);
    
    // Save preference
    localStorage.setItem('darkMode', newState ? 'enabled' : 'disabled');
    
    return newState;
}

// Make it globally available for testing
window.testDarkMode = testDarkMode;

// ========== Utility Functions ==========
function getCsrfToken() {
    const token = document.querySelector('meta[name="csrf-token"]');
    return token ? token.getAttribute('content') : '';
}

function showLoader(element) {
    if(!element) return;
    element.classList.add('btn-loading');
    element.disabled = true;
}

function hideLoader(element) {
    if(!element) return;
    element.classList.remove('btn-loading');
    element.disabled = false;
}

// ========== Dark Mode Toggle ==========
function setupDarkModeToggle() {
    // Create dark mode toggle button
    const toggleButton = document.createElement('button');
    toggleButton.className = 'dark-mode-toggle';
    toggleButton.id = 'darkModeToggle';
    toggleButton.setAttribute('aria-label', 'Toggle dark mode');
    toggleButton.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    `;
    
    // Add some debugging info
    console.log('Dark mode toggle initialized');
    
    document.body.appendChild(toggleButton);
    
    // Check for saved preference or system preference
    const savedMode = localStorage.getItem('darkMode');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    console.log('Saved mode:', savedMode);
    console.log('System prefers dark:', systemPrefersDark);
    
    // Apply dark mode if needed
    if(savedMode === 'enabled' || (!savedMode && systemPrefersDark)) {
        document.body.classList.add('dark-mode');
        console.log('Applied dark mode');
        updateToggleButton(true);
    } else {
        console.log('Light mode applied');
        updateToggleButton(false);
    }
    
    // Force reflow to ensure CSS takes effect
    document.body.offsetHeight;
    
    // Toggle event listener
    toggleButton.addEventListener('click', function() {
        console.log('Dark mode toggle clicked');
        const isDark = document.body.classList.contains('dark-mode');
        console.log('Current dark mode state:', isDark);
        
        document.body.classList.toggle('dark-mode');
        
        // Save preference
        const newState = document.body.classList.contains('dark-mode');
        console.log('New dark mode state:', newState);
        
        if(newState) {
            localStorage.setItem('darkMode', 'enabled');
            updateToggleButton(true);
        } else {
            localStorage.setItem('darkMode', 'disabled');
            updateToggleButton(false);
        }
        
        // Add visual feedback
        this.style.transform = 'scale(0.8)';
        this.style.boxShadow = '0 0 20px rgba(5, 150, 105, 0.8)';
        setTimeout(() => {
            this.style.transform = '';
            this.style.boxShadow = '';
        }, 300);
    });
    
    // Listen for system preference changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        const savedMode = localStorage.getItem('darkMode');
        if(!savedMode) {
            if(e.matches) {
                document.body.classList.add('dark-mode');
                updateToggleButton(true);
            } else {
                document.body.classList.remove('dark-mode');
                updateToggleButton(false);
            }
        }
    });
}

function updateToggleButton(isDark) {
    const toggleButton = document.querySelector('.dark-mode-toggle');
    if(!toggleButton) {
        console.error('Dark mode toggle button not found');
        return;
    }
    
    console.log('Updating toggle button to:', isDark ? 'dark' : 'light');
    
    const svg = toggleButton.querySelector('svg');
    if(isDark) {
        // Sun icon for dark mode
        svg.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        `;
        toggleButton.title = 'Switch to Light Mode';
    } else {
        // Moon icon for light mode (keeping green theme)
        svg.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        `;
        toggleButton.title = 'Switch to Dark Mode';
    }
    
    // Add green accent to the toggle button
    svg.style.color = '#ffffff';
    svg.style.stroke = '#ffffff';
    
    // Visual confirmation
    toggleButton.style.backgroundColor = isDark ? '#047857' : '#059669';
}
