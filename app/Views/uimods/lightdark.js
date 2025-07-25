// Function to set theme based on browser/system preference
function applyPreferredTheme() {
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    document.documentElement.setAttribute('data-bs-theme', prefersDark ? 'dark' : 'light');
}

// Apply theme on page load
applyPreferredTheme();

// Optionally, listen for changes in user preference
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', applyPreferredTheme);

const themeKey = 'preferred-theme';

function getPreferredTheme() {
const stored = localStorage.getItem(themeKey);
if (stored === 'light' || stored === 'dark') return stored;

// Fall back to system preference
return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

function setTheme(theme) {
document.documentElement.setAttribute('data-bs-theme', theme);
localStorage.setItem(themeKey, theme);
}

export const toggleTheme = () => {
const current = document.documentElement.getAttribute('data-bs-theme') || getPreferredTheme();
const newTheme = current === 'dark' ? 'light' : 'dark';
setTheme(newTheme);
}

// Set initial theme on load
setTheme(getPreferredTheme());
