<style>
    .dashboard-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        flex-wrap: wrap;
        margin-top: 1rem;
        padding-top: .75rem;
        border-top: 1px solid rgba(148, 163, 184, .15);
        color: #94a3b8;
        font-size: .75rem;
    }
    .dashboard-pagination__pages {
        display: flex;
        align-items: center;
        gap: .25rem;
    }
    .dashboard-pagination button {
        min-width: 2rem;
        height: 2rem;
        padding: 0 .55rem;
        border: 1px solid rgba(148, 163, 184, .25);
        border-radius: .5rem;
        background: rgba(51, 65, 85, .65);
        color: #cbd5e1;
        font-size: .75rem;
        transition: background-color .15s, border-color .15s, color .15s;
    }
    .dashboard-pagination button:hover:not(:disabled) {
        border-color: rgba(129, 140, 248, .75);
        background: rgba(79, 70, 229, .55);
        color: #fff;
    }
    .dashboard-pagination button.is-active {
        border-color: rgba(129, 140, 248, .9);
        background: #4f46e5;
        color: #fff;
    }
    .dashboard-pagination button:disabled {
        cursor: not-allowed;
        opacity: .4;
    }
    @media (max-width: 480px) {
        .dashboard-pagination {
            justify-content: center;
            width: 100%;
        }
        .dashboard-pagination__summary { width: 100%; text-align: center; }
        .dashboard-pagination__pages {
            max-width: 100%;
            flex-wrap: wrap;
            justify-content: center;
        }
        .dashboard-pagination__page:not(.is-active):not(.is-nearby) {
            display: none;
        }
    }
</style>
<script>
(function () {
    let paginationId = 0;

    function getPaginationItems(list) {
        return Array.from(list.querySelectorAll(':scope > [data-pagination-item], :scope > tr, :scope > div, :scope > li'))
            .filter(item => item.textContent.trim() !== 'Loading...' && item.style.display !== 'none');
    }

    function paginateList(list) {
        if (list.dataset.paginationReady === 'true') return;

        const oldControlsId = list.dataset.paginationControls;
        if (oldControlsId) document.getElementById(oldControlsId)?.remove();
        delete list.dataset.paginationControls;

        const items = getPaginationItems(list);
        const pageSize = Number(list.dataset.pageSize || 10);

        const groups = [];
        const groupIndexes = new Map();
        items.forEach((item, index) => {
            const key = item.dataset.paginationGroup || `item-${index}`;
            if (!groupIndexes.has(key)) {
                groupIndexes.set(key, groups.length);
                groups.push([]);
            }
            groups[groupIndexes.get(key)].push(item);
        });

        if (groups.length <= pageSize) {
            list._dashboardPagination = {
                setFilter(nextFilter) {
                    const activeFilter = typeof nextFilter === 'function' ? nextFilter : null;
                    groups.forEach(group => {
                        const matches = !activeFilter || activeFilter(group);
                        group[0]?.classList.toggle('hidden', !matches);
                        group.slice(1).forEach(item => {
                            if (matches) item.classList.add('hidden');
                            else item.classList.add('hidden');
                        });
                    });
                }
            };
            return;
        }
        list.dataset.paginationReady = 'true';

        const totalPages = Math.ceil(groups.length / pageSize);
        let currentPage = 1;
        let filter = null;
        const controls = document.createElement('div');
        controls.className = 'dashboard-pagination';
        controls.id = `dashboard-pagination-${++paginationId}`;
        list.dataset.paginationControls = controls.id;
        if (list.tagName === 'TBODY') {
            const table = list.closest('table');
            table.nextElementSibling?.matches('.dashboard-pagination') && table.nextElementSibling.remove();
            table.insertAdjacentElement('afterend', controls);
        } else {
            list.querySelectorAll(':scope > .dashboard-pagination').forEach(existing => existing.remove());
            list.appendChild(controls);
        }

        function render() {
            const visibleGroups = filter ? groups.filter(filter) : groups;
            const visiblePageCount = Math.max(1, Math.ceil(visibleGroups.length / pageSize));
            currentPage = Math.min(currentPage, visiblePageCount);
            const first = (currentPage - 1) * pageSize;
            groups.forEach(group => {
                const index = visibleGroups.indexOf(group);
                group.forEach(item => item.classList.toggle('hidden', index < first || index >= first + pageSize));
            });

            controls.innerHTML = '';
            const summary = document.createElement('span');
            summary.className = 'dashboard-pagination__summary';
            summary.textContent = visibleGroups.length
                ? `Showing ${first + 1}-${Math.min(first + pageSize, visibleGroups.length)} of ${visibleGroups.length}`
                : 'No matching items';
            controls.appendChild(summary);

            const pages = document.createElement('div');
            pages.className = 'dashboard-pagination__pages';
            const previous = document.createElement('button');
            previous.type = 'button';
            previous.textContent = 'Prev';
            previous.disabled = currentPage === 1;
            previous.addEventListener('click', () => { currentPage--; render(); });
            pages.appendChild(previous);

            const visiblePages = new Set([1, visiblePageCount, currentPage - 1, currentPage, currentPage + 1]);
            [...visiblePages].sort((a, b) => a - b).forEach(page => {
                if (page < 1 || page > visiblePageCount) return;
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'dashboard-pagination__page';
                button.textContent = page;
                button.setAttribute('aria-label', `Page ${page}`);
                button.classList.toggle('is-active', page === currentPage);
                button.classList.toggle('is-nearby', Math.abs(page - currentPage) === 1);
                button.addEventListener('click', () => { currentPage = page; render(); });
                pages.appendChild(button);
            });

            const next = document.createElement('button');
            next.type = 'button';
            next.textContent = 'Next';
            next.disabled = currentPage === visiblePageCount;
            next.addEventListener('click', () => { currentPage++; render(); });
            pages.appendChild(next);
            controls.appendChild(pages);
        }

        list._dashboardPagination = {
            setFilter(nextFilter) {
                filter = typeof nextFilter === 'function' ? nextFilter : null;
                currentPage = 1;
                render();
            }
        };
        render();
    }

    function resetPaginationList(list) {
        const controlsId = list.dataset.paginationControls;
        if (controlsId) document.getElementById(controlsId)?.remove();
        delete list.dataset.paginationReady;
        delete list.dataset.paginationControls;
        delete list._dashboardPagination;
        paginateList(list);
    }

    function initDashboardPagination() {
        document.querySelectorAll('[data-pagination-list]').forEach(paginateList);
    }

    window.refreshDashboardPagination = function (selector) {
        const list = typeof selector === 'string' ? document.querySelector(selector) : selector;
        if (list?.matches('[data-pagination-list]')) resetPaginationList(list);
    };

    window.filterDashboardPagination = function (selector, filter) {
        const list = typeof selector === 'string' ? document.querySelector(selector) : selector;
        list?._dashboardPagination?.setFilter(filter);
    };

    function startDashboardPagination() {
        initDashboardPagination();
        const paginationObserver = new MutationObserver(records => {
            const changedLists = new Set();
            records.forEach(record => {
                const target = record.target instanceof Element ? record.target : null;
                if (target?.closest('.dashboard-pagination')) return;
                const paginationOnly = [...record.addedNodes, ...record.removedNodes].length > 0
                    && [...record.addedNodes, ...record.removedNodes].every(node =>
                        node instanceof Element && node.classList.contains('dashboard-pagination'));
                if (paginationOnly) return;
                const list = target?.matches('[data-pagination-list]')
                    ? target
                    : target?.closest('[data-pagination-list]');
                if (list) changedLists.add(list);
                record.addedNodes.forEach(node => {
                    if (!(node instanceof Element)) return;
                    if (node.matches('[data-pagination-list]')) changedLists.add(node);
                    node.querySelectorAll('[data-pagination-list]').forEach(nestedList => changedLists.add(nestedList));
                });
            });
            changedLists.forEach(resetPaginationList);
        });
        paginationObserver.observe(document.body, { childList: true, subtree: true });

    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startDashboardPagination);
    } else {
        startDashboardPagination();
    }
})();
</script>
