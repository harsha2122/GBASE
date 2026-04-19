// Page Search Functionality
(function () {
    let searchOverlay, searchInput, searchResults, closeBtn;
    let searchBtn;

    // Initialize search components
    function initSearch() {
        searchBtn = document.getElementById('gbase-search-btn');
        searchOverlay = document.getElementById('gbase-search-overlay');
        searchInput = document.getElementById('gbase-search-input');
        searchResults = document.getElementById('gbase-search-results');
        closeBtn = document.getElementById('gbase-search-close');

        if (!searchBtn || !searchOverlay) return;

        // Event listeners
        searchBtn.addEventListener('click', openSearch);
        closeBtn.addEventListener('click', closeSearch);
        searchOverlay.addEventListener('click', function (e) {
            if (e.target === searchOverlay) closeSearch();
        });

        // Search on input
        searchInput.addEventListener('input', debounce(performSearch, 300));

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
                closeSearch();
            }
        });
    }

    function openSearch() {
        searchOverlay.classList.add('active');
        searchInput.focus();
        document.body.style.overflow = 'hidden';
    }

    function closeSearch() {
        searchOverlay.classList.remove('active');
        searchInput.value = '';
        searchResults.innerHTML = '';
        document.body.style.overflow = '';
    }

    function performSearch() {
        const query = searchInput.value.trim();

        if (query.length < 2) {
            searchResults.innerHTML = '<div class="search-empty">Type at least 2 characters to search...</div>';
            return;
        }

        // Get all searchable content
        const searchableElements = document.querySelectorAll('h1, h2, h3, h4, h5, h6, p, li, td, th, span, a, div');

        const results = [];
        const queryLower = query.toLowerCase();
        const seenTexts = new Set();

        searchableElements.forEach(element => {
            // Skip header, footer, and search elements
            if (element.closest('header') ||
                element.closest('footer') ||
                element.closest('#gbase-search-overlay') ||
                element.closest('script') ||
                element.closest('style')) {
                return;
            }

            const text = element.textContent.trim();
            const textLower = text.toLowerCase();

            // Skip empty, duplicates, or too long texts
            if (!text || seenTexts.has(text) || text.length > 200) return;

            if (textLower.includes(queryLower)) {
                seenTexts.add(text);

                // Get context
                const index = textLower.indexOf(queryLower);
                const start = Math.max(0, index - 50);
                const end = Math.min(text.length, index + query.length + 50);
                let snippet = text.substring(start, end);

                if (start > 0) snippet = '...' + snippet;
                if (end < text.length) snippet = snippet + '...';

                // Highlight the match
                const regex = new RegExp(`(${escapeRegExp(query)})`, 'gi');
                snippet = snippet.replace(regex, '<mark>$1</mark>');

                results.push({
                    text: text.substring(0, 100) + (text.length > 100 ? '...' : ''),
                    snippet: snippet,
                    element: element
                });
            }
        });

        displayResults(results, query);
    }

    function displayResults(results, query) {
        if (results.length === 0) {
            searchResults.innerHTML = `<div class="search-empty">No results found for "${escapeHtml(query)}"</div>`;
            return;
        }

        const html = results.slice(0, 20).map((result, index) => `
      <div class="search-result-item" data-index="${index}">
        <div class="search-result-snippet">${result.snippet}</div>
      </div>
    `).join('');

        searchResults.innerHTML = `
      <div class="search-count">${results.length} result${results.length !== 1 ? 's' : ''} found</div>
      ${html}
    `;

        // Add click handlers to scroll to results
        document.querySelectorAll('.search-result-item').forEach((item, index) => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                const targetElement = results[index].element;

                console.log('Scrolling to:', targetElement); // Debug

                // Close overlay immediately
                searchOverlay.classList.remove('active');
                document.body.style.overflow = '';

                // Wait for overlay to close
                setTimeout(() => {
                    searchInput.value = '';
                    searchResults.innerHTML = '';

                    // Scroll to element with fallback
                    if ('scrollBehavior' in document.documentElement.style) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center',
                            inline: 'nearest'
                        });
                    } else {
                        // Fallback for browsers without smooth scroll
                        const rect = targetElement.getBoundingClientRect();
                        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                        const targetY = rect.top + scrollTop - (window.innerHeight / 2);

                        window.scrollTo({
                            top: targetY,
                            behavior: 'smooth'
                        });
                    }

                    // Highlight after scrolling starts
                    setTimeout(() => {
                        targetElement.classList.add('search-highlight-flash');
                        setTimeout(() => {
                            targetElement.classList.remove('search-highlight-flash');
                        }, 3000);
                    }, 400);
                }, 400);
            });
        });
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSearch);
    } else {
        initSearch();
    }
})();
