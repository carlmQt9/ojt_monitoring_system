{{-- Shared action loader --}}
<style>
    #pixelLoader, #pixelSuccess { font-family: system-ui, sans-serif; }
    .action-loader-spinner { width: 2.75rem; height: 2.75rem; border: 3px solid rgba(148,163,184,.3); border-top-color: #60a5fa; border-radius: 999px; animation: actionLoaderSpin .8s linear infinite; }
    @keyframes actionLoaderSpin { to { transform: rotate(360deg); } }
</style>

<div id="pixelLoader" class="hidden fixed inset-0 z-[300] flex items-center justify-center bg-slate-950/75 backdrop-blur-sm p-4">
    <div class="bg-slate-900 border border-slate-700 rounded-xl px-8 py-6 flex flex-col items-center gap-4 shadow-2xl">
        <div class="action-loader-spinner" aria-hidden="true"></div>
        <div class="text-gray-200 text-sm font-semibold" id="pixelLoaderLabel">Loading...</div>
    </div>
</div>

<div id="pixelSuccess" class="hidden fixed inset-0 z-[300] flex items-center justify-center bg-slate-950/75 backdrop-blur-sm p-4">
    <div class="bg-slate-900 border border-green-500/50 rounded-xl px-8 py-6 text-green-300 text-sm font-semibold shadow-2xl" id="pixelSuccessMsg">Completed</div>
</div>

<script>
    let _pixelInterval = null;

    function showPixelLoader(label) {
        label = label || 'LOADING';
        document.getElementById('pixelLoaderLabel').textContent = label;
        document.getElementById('pixelLoader').classList.remove('hidden');
    }

    function hidePixelLoader() {
        clearInterval(_pixelInterval);
        document.getElementById('pixelLoader').classList.add('hidden');
    }

    function showPixelSuccess(msg, duration) {
        msg = msg || 'SUCCESS!';
        duration = duration || 800;
        const el = document.getElementById('pixelSuccess');
        document.getElementById('pixelSuccessMsg').textContent = msg;
        el.classList.remove('hidden');
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
                else if (btnText.includes('REMOV') || btnText.includes('DELET') || btnText.includes('FOREVER')) label = 'DELETING';
                else if (btnText.includes('ARCHIVE')) label = 'ARCHIVING';
                else if (btnText.includes('RESTOR')) label = 'RESTORING';
                else if (btnText.includes('SUBMIT') || btnText.includes('UPLOAD')) label = 'UPLOADING';
                else if (btnText.includes('ADD') || btnText.includes('CREATE')) label = 'SAVING';
                else if (btnText.includes('SAVE') || btnText.includes('CHANGES') || btnText.includes('UPDATE')) label = 'SAVING';
                else if (btnText.includes('SIGN') || btnText.includes('LOGOUT')) label = 'SIGNING OUT';
                showPixelLoader(label);
                // Auto-hide after 8s as fallback (page will reload anyway)
                setTimeout(hidePixelLoader, 8000);
            });
        });
    });
</script>
