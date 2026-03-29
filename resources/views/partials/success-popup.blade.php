{{-- Partial for displaying a centralized success popup. --}}
{{-- Usage: include this at the top of the <body> on any view that may show a success message. --}}

<!-- markup (kept hidden by default) -->
<div id="successPopup" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 popup-container">
    <div class="popup-content bg-slate-800 border border-green-500 rounded-xl p-8 max-w-sm mx-auto backdrop-blur">
        <div class="flex items-center justify-center w-12 h-12 bg-green-500/20 rounded-full mx-auto mb-4">
            <svg class="w-6 h-6 checkmark-svg" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12" class="text-green-400" stroke="currentColor"></polyline>
            </svg>
        </div>
        <h3 class="success-title text-xl font-bold text-white text-center mb-2">Success!</h3>
        <p class="success-message text-gray-300 text-center mb-6"></p>
        <button onclick="closeSuccessPopup()" class="success-button w-full px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 active:scale-95">
            Got it
        </button>
    </div>
</div>

<!-- styles for animation and appearance -->
<style>
    @keyframes popupSlideIn {
        from {
            opacity: 0;
            transform: scale(0.8) translateY(20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    @keyframes checkmarkDraw {
        0% {
            stroke-dashoffset: 60;
            opacity: 0;
        }
        50% {
            opacity: 1;
        }
        100% {
            stroke-dashoffset: 0;
            opacity: 1;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes backgroundFadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .popup-container {
        animation: backgroundFadeIn 0.4s ease-in-out;
    }

    .popup-content {
        animation: popupSlideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .checkmark-svg {
        stroke-dasharray: 60;
        stroke-dashoffset: 60;
        animation: checkmarkDraw 1s ease-in-out 0.3s forwards;
    }

    .success-title {
        animation: fadeInUp 0.6s ease-out 0.8s both;
    }

    .success-message {
        animation: fadeInUp 0.6s ease-out 1s both;
    }

    .success-button {
        animation: fadeInUp 0.6s ease-out 1.2s both;
    }
</style>

<!-- behaviour script -->
<script>
    let _successReload = false;

    function showSuccess(message, redirectUrl = null, reloadOnClose = false) {
        const popup = document.getElementById('successPopup');
        if (!popup) return;
        popup.querySelector('.success-message').textContent = message;
        popup.classList.remove('hidden');
        popup.style.animation = 'backgroundFadeIn 0.4s ease-in-out';
        _successReload = reloadOnClose;

        // auto close after 3s then reload if needed
        setTimeout(closeSuccessPopup, 3000);

        if (redirectUrl) {
            setTimeout(() => { window.location.href = redirectUrl; }, 400);
        }
    }

    function closeSuccessPopup() {
        const popup = document.getElementById('successPopup');
        if (!popup) return;
        popup.style.animation = 'backgroundFadeIn 0.4s ease-in-out reverse';
        setTimeout(() => {
            popup.classList.add('hidden');
            if (_successReload) {
                _successReload = false;
                if (typeof _allowLeave !== 'undefined') _allowLeave = true;
                window.location.reload();
            }
        }, 400);
    }

    // close when clicking on backdrop
    document.addEventListener('click', function(e) {
        const popup = document.getElementById('successPopup');
        if (popup && e.target === popup) {
            closeSuccessPopup();
        }
    });

    // show server-side message if present
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            showSuccess("{{ addslashes(session('success')) }}");
        @endif
    });
</script>
