const STORAGE_KEY = 'tubipure-theme';

function getSavedTheme() {
    try {
        return window.localStorage.getItem(STORAGE_KEY) === 'dark' ? 'dark' : 'light';
    } catch {
        return 'light';
    }
}

function applyTheme(theme) {
    const normalizedTheme = theme === 'dark' ? 'dark' : 'light';
    document.documentElement.dataset.theme = normalizedTheme;

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        const nextTheme = normalizedTheme === 'dark' ? 'light' : 'dark';
        const label = `Switch to ${nextTheme} mode`;
        button.setAttribute('aria-label', label);
        button.setAttribute('title', label);
        button.setAttribute('aria-pressed', String(normalizedTheme === 'dark'));
    });

    document.dispatchEvent(new CustomEvent('tubipure-theme-change', { detail: { theme: normalizedTheme } }));
}

applyTheme(getSavedTheme());

document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const nextTheme = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';

        try {
            window.localStorage.setItem(STORAGE_KEY, nextTheme);
        } catch {
            // The current page still switches even when browser storage is unavailable.
        }

        applyTheme(nextTheme);
    });
});
