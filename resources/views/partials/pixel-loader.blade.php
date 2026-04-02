{{-- Pixel Loader & Success Overlay --}}
<style>
    @font-face {
        font-family: 'Press Start 2P';
        src: url('https://fonts.gstatic.com/s/pressstart2p/v15/e3t4euO8T-267oIAQAu6jDQyK3nVivM.woff2') format('woff2');
    }
    #pixelLoader, #pixelSuccess { font-family: 'Press Start 2P', monospace; }
    .pixel-bar-wrap { display:flex; gap:4px; align-items:center; }
    .pixel-cell { width:28px; height:28px; border:3px solid #1a1a1a; image-rendering:pixelated; transition:background .1s; }
    .pixel-cell.filled { background:#4ade80; box-shadow:inset -4px -4px 0 #16a34a, inset 4px 4px 0 #86efac; }
    .pixel-cell.empty  { background:#d1d5db; box-shadow:inset -4px -4px 0 #9ca3af, inset 4px 4px 0 #f3f4f6; }
    .pixel-cell.cap-l  { border-radius:6px 0 0 6px; }
    .pixel-cell.cap-r  { border-radius:0 6px 6px 0; }
    @keyframes pixelDots { 0%{content:'.'} 25%{content:'..'} 50%{content:'...'} 75%{content:'....'} 100%{content:'.'} }
    #pixelDots::after { content:'.'; animation:pixelDots 1s steps(1) infinite; }
    @keyframes popIn { 0%{transform:scale(0) rotate(-20deg);opacity:0} 70%{transform:scale(1.2) rotate(5deg)} 100%{transform:scale(1) rotate(0);opacity:1} }
    @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    .pixel-check { image-rendering:pixelated; font-size:3rem; animation:popIn .5s cubic-bezier(.36,.07,.19,.97) forwards; }
    .pixel-success-text { animation:fadeUp .4s .3s ease forwards; opacity:0; }
</style>

<div id="pixelLoader" class="hidden fixed inset-0 z-[300] flex flex-col items-center justify-center bg-black/80">
    <div class="bg-slate-900 border-4 border-slate-600 rounded-2xl px-10 py-8 flex flex-col items-center gap-5" style="box-shadow:0 0 40px rgba(74,222,128,0.3)">
        <div class="pixel-bar-wrap" id="pixelBarCells"></div>
        <div class="text-green-400 text-sm tracking-widest" id="pixelLoaderLabel">LOADING<span id="pixelDots"></span></div>
    </div>
</div>

<div id="pixelSuccess" class="hidden fixed inset-0 z-[300] flex flex-col items-center justify-center bg-black/80">
    <div class="bg-slate-900 border-4 border-green-500 rounded-2xl px-12 py-8 flex flex-col items-center gap-4" style="box-shadow:0 0 40px rgba(74,222,128,0.4)">
        <div class="pixel-check">✅</div>
        <div class="pixel-success-text text-green-400 text-sm tracking-widest text-center" id="pixelSuccessMsg">SUCCESS!</div>
    </div>
</div>

<script>
    const PIXEL_TOTAL = 8;
    let _pixelInterval = null;

    function showPixelLoader(label) {
        label = label || 'LOADING';
        const wrap = document.getElementById('pixelBarCells');
        document.getElementById('pixelLoaderLabel').firstChild.textContent = label;
        wrap.innerHTML = '';
        for (let i = 0; i < PIXEL_TOTAL; i++) {
            const d = document.createElement('div');
            d.className = 'pixel-cell empty' + (i===0?' cap-l':'') + (i===PIXEL_TOTAL-1?' cap-r':'');
            wrap.appendChild(d);
        }
        document.getElementById('pixelLoader').classList.remove('hidden');
        let filled = 0;
        _pixelInterval = setInterval(() => {
            const cells = wrap.querySelectorAll('.pixel-cell');
            if (filled < PIXEL_TOTAL) { cells[filled].classList.replace('empty','filled'); filled++; }
            else { cells.forEach(c => c.classList.replace('filled','empty')); filled = 0; }
        }, 120);
    }

    function hidePixelLoader() {
        clearInterval(_pixelInterval);
        document.getElementById('pixelLoader').classList.add('hidden');
    }

    function showPixelSuccess(msg, duration) {
        msg = msg || 'SUCCESS!';
        duration = duration || 1400;
        const el = document.getElementById('pixelSuccess');
        document.getElementById('pixelSuccessMsg').textContent = msg;
        const check = el.querySelector('.pixel-check');
        const txt = el.querySelector('.pixel-success-text');
        check.style.animation = 'none'; txt.style.animation = 'none';
        el.classList.remove('hidden');
        requestAnimationFrame(() => { check.style.animation = ''; txt.style.animation = ''; });
        setTimeout(() => el.classList.add('hidden'), duration);
    }

    function pixelAction(label, action, successMsg) {
        showPixelLoader(label);
        return Promise.resolve(action()).then(result => {
            hidePixelLoader();
            if (successMsg) showPixelSuccess(successMsg);
            return result;
        }).catch(err => {
            hidePixelLoader();
            throw err;
        });
    }

    // Auto-attach pixel loader to all form submits in this page
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form').forEach(function (form) {
            form.addEventListener('submit', function () {
                // Determine label from submit button text or form action
                const btn = form.querySelector('[type="submit"]');
                const btnText = (btn ? btn.textContent : '').trim().toUpperCase();
                let label = 'SAVING';
                if (btnText.includes('DENY') || btnText.includes('REJECT')) label = 'DENYING';
                else if (btnText.includes('APPROV')) label = 'APPROVING';
                else if (btnText.includes('REMOV') || btnText.includes('DELET')) label = 'DELETING';
                else if (btnText.includes('SUBMIT') || btnText.includes('UPLOAD')) label = 'UPLOADING';
                else if (btnText.includes('EVALUAT')) label = 'SAVING';
                showPixelLoader(label);
                // Auto-hide after 8s as fallback (page will reload anyway)
                setTimeout(hidePixelLoader, 8000);
            });
        });
    });
</script>
