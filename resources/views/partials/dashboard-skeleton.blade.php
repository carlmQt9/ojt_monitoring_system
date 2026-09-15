<style>
    #dashboardSkeleton {
        --skeleton-base: rgba(51, 65, 85, 0.72);
        --skeleton-highlight: rgba(148, 163, 184, 0.18);
        position: fixed;
        inset: 0;
        z-index: 500;
        display: flex;
        background: #0f172a;
        color: #e2e8f0;
        opacity: 1;
        visibility: visible;
           will-change: opacity, visibility;
           transition: opacity 0.45s cubic-bezier(0.22, 1, 0.36, 1), visibility 0s linear 0.45s;
    }

    #dashboardSkeleton.is-ready {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    .skeleton-shimmer {
        position: relative;
        overflow: hidden;
           will-change: background;
        background: var(--skeleton-base);
        border-radius: 0.55rem;
    }

    .skeleton-shimmer::after {
        position: absolute;
        inset: 0;
        content: '';
           animation: skeletonSweep 1.6s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        background: linear-gradient(90deg, transparent, var(--skeleton-highlight), transparent);
        animation: skeletonSweep 1.45s ease-in-out infinite;
    }

    .dashboard-skeleton-sidebar {
           animation: skeletonContentIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) both;
        display: none;
        width: 16rem;
        flex: 0 0 16rem;
        padding: 1.25rem 1rem;
        border-right: 1px solid rgba(148, 163, 184, 0.16);
    }

        .dashboard-skeleton-nav-item:nth-child(2) { animation-delay: 0.06s; }
        .dashboard-skeleton-nav-item:nth-child(3) { animation-delay: 0.12s; }
        .dashboard-skeleton-nav-item:nth-child(4) { animation-delay: 0.18s; }
        .dashboard-skeleton-nav-item:nth-child(5) { animation-delay: 0.24s; }

    .dashboard-skeleton-brand {
        display: flex;
        align-items: center;
        gap: 0.75rem;

        .dashboard-skeleton-card:nth-child(2) { animation-delay: 0.08s; }
        .dashboard-skeleton-card:nth-child(3) { animation-delay: 0.16s; }
        .dashboard-skeleton-card:nth-child(4) { animation-delay: 0.24s; }
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.16);
    }


        @keyframes skeletonContentIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
    .dashboard-skeleton-nav {
        display: grid;
        gap: 0.75rem;
        margin-top: 1.5rem;
           .dashboard-skeleton-main { animation: none; }
    }

    .dashboard-skeleton-nav-item {
        height: 2.65rem;
        border-radius: 0.65rem;
    }


            function scheduleHide() {
                requestAnimationFrame(() => requestAnimationFrame(hideDashboardSkeleton));
            }
    .dashboard-skeleton-main {
        width: 100%;
               document.addEventListener('DOMContentLoaded', scheduleHide, { once: true });
    }
               scheduleHide();
    .dashboard-skeleton-topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 3.5rem;
        margin-bottom: 2rem;
    }

    .dashboard-skeleton-heading {
        width: min(22rem, 65%);
        height: 2.25rem;
    }

    .dashboard-skeleton-avatar {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 999px;
    }

    .dashboard-skeleton-cards {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.85rem;
    }

    .dashboard-skeleton-card {
        height: 7rem;
        padding: 1rem;
    }

    .dashboard-skeleton-card::before,
    .dashboard-skeleton-card::after {
        display: block;
        width: 45%;
        height: 0.75rem;
        margin-bottom: 1.15rem;
        content: '';
        border-radius: 0.35rem;
        background: var(--skeleton-highlight);
    }

    .dashboard-skeleton-card::after {
        width: 62%;
        height: 1.5rem;
        margin-bottom: 0;
        background: var(--skeleton-base);
    }

    .dashboard-skeleton-panel {
        height: 13rem;
        margin-top: 1rem;
        padding: 1rem;
    }

    .dashboard-skeleton-lines {
        display: grid;
        gap: 0.8rem;
        margin-top: 1.5rem;
    }

    .dashboard-skeleton-line {
        height: 0.8rem;
    }

    .dashboard-skeleton-line:nth-child(2) { width: 82%; }
    .dashboard-skeleton-line:nth-child(3) { width: 67%; }

    @keyframes skeletonSweep {
        100% { transform: translateX(100%); }
    }

    @media (min-width: 768px) {
        .dashboard-skeleton-main { padding: 1.5rem 2rem; }
        .dashboard-skeleton-cards { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    }

    @media (min-width: 1024px) {
        .dashboard-skeleton-sidebar { display: block; }
        .dashboard-skeleton-main { padding: 1.5rem 2.5rem; }
    }

    @media (prefers-reduced-motion: reduce) {
        #dashboardSkeleton { transition: none; }
        .skeleton-shimmer::after { animation: none; }
    }
</style>

<div id="dashboardSkeleton" aria-hidden="true">
    <aside class="dashboard-skeleton-sidebar">
        <div class="dashboard-skeleton-brand">
            <div class="skeleton-shimmer dashboard-skeleton-avatar"></div>
            <div class="skeleton-shimmer" style="width: 9rem; height: 0.85rem"></div>
        </div>
        <div class="dashboard-skeleton-nav">
            <div class="skeleton-shimmer dashboard-skeleton-nav-item"></div>
            <div class="skeleton-shimmer dashboard-skeleton-nav-item"></div>
            <div class="skeleton-shimmer dashboard-skeleton-nav-item"></div>
            <div class="skeleton-shimmer dashboard-skeleton-nav-item"></div>
            <div class="skeleton-shimmer dashboard-skeleton-nav-item"></div>
        </div>
    </aside>
    <main class="dashboard-skeleton-main">
        <div class="dashboard-skeleton-topbar">
            <div class="skeleton-shimmer dashboard-skeleton-heading"></div>
            <div class="skeleton-shimmer dashboard-skeleton-avatar"></div>
        </div>
        <div class="dashboard-skeleton-cards">
            <div class="skeleton-shimmer dashboard-skeleton-card"></div>
            <div class="skeleton-shimmer dashboard-skeleton-card"></div>
            <div class="skeleton-shimmer dashboard-skeleton-card"></div>
            <div class="skeleton-shimmer dashboard-skeleton-card"></div>
        </div>
        <div class="skeleton-shimmer dashboard-skeleton-panel">
            <div class="skeleton-shimmer" style="width: 35%; height: 1rem"></div>
            <div class="dashboard-skeleton-lines">
                <div class="skeleton-shimmer dashboard-skeleton-line"></div>
                <div class="skeleton-shimmer dashboard-skeleton-line"></div>
                <div class="skeleton-shimmer dashboard-skeleton-line"></div>
            </div>
        </div>
    </main>
</div>

<script>
    (function () {
        function hideDashboardSkeleton() {
            const skeleton = document.getElementById('dashboardSkeleton');
            if (skeleton) skeleton.classList.add('is-ready');
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', hideDashboardSkeleton, { once: true });
        } else {
            hideDashboardSkeleton();
        }
    })();
</script>