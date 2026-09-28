<script>
(() => {
    const storageKey = `dashboard-action-state:${window.location.pathname}`;

    const saveDashboardState = () => {
        const activeSection = document.querySelector('.dash-section:not(.hidden)')?.id || null;
        const expandedCards = [...document.querySelectorAll('.student-card.expanded')]
            .map(card => card.dataset.studentId)
            .filter(Boolean);
        const activeTabs = [...document.querySelectorAll('button[data-tab]')]
            .filter(button => !button.classList.contains('border-transparent'))
            .map(button => button.dataset.tab)
            .filter(Boolean);
        const filterValues = Object.fromEntries(
            [...document.querySelectorAll('input[type="search"][id], input[data-preserve-filter][id], select[data-preserve-filter][id]')]
                .map(field => [field.id, field.value])
        );

        sessionStorage.setItem(storageKey, JSON.stringify({
            activeSection,
            expandedCards,
            activeTabs,
            filterValues,
            scrollY: window.scrollY,
        }));
    };

    // Capture the current context before every ordinary form action refreshes data.
    document.addEventListener('submit', saveDashboardState, true);

    document.addEventListener('DOMContentLoaded', () => {
        let state;
        try { state = JSON.parse(sessionStorage.getItem(storageKey) || 'null'); } catch (_) { state = null; }
        if (!state) return;
        sessionStorage.removeItem(storageKey);

        setTimeout(() => {
            const section = state.activeSection?.replace('section-', '');
            if (section && typeof window.showSection === 'function') window.showSection(section);

            (state.expandedCards || []).forEach(studentId => {
                const card = document.querySelector(`.student-card[data-student-id="${studentId}"]`);
                if (card) card.classList.add('expanded');
            });

            (state.activeTabs || []).forEach(tabId => {
                const tab = document.querySelector(`button[data-tab="${tabId}"]`);
                if (tab) tab.click();
            });

            Object.entries(state.filterValues || {}).forEach(([id, value]) => {
                const field = document.getElementById(id);
                if (!field) return;
                field.value = value;
                field.dispatchEvent(new Event(field.tagName === 'SELECT' ? 'change' : 'input', { bubbles: true }));
            });

            window.scrollTo({ top: state.scrollY || 0, behavior: 'auto' });
        }, 150);
    });
})();
</script>
