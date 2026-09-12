{{-- Adds a show/hide eye button to every password input on the page. --}}
<style>
    .pw-wrap {
        position: relative;
        display: block;
    }

    .pw-wrap > input {
        padding-right: 44px;
    }

    .pw-toggle {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        z-index: 60;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4px;
        border: 0;
        background: none;
        color: #6c757d;
        cursor: pointer;
        line-height: 0;
    }

    .pw-toggle:hover {
        color: #0e1776;
    }

    .pw-toggle svg {
        width: 20px;
        height: 20px;
    }

    .pw-toggle .pw-icon-hide {
        display: none;
    }

    .pw-toggle.is-shown .pw-icon-show {
        display: none;
    }

    .pw-toggle.is-shown .pw-icon-hide {
        display: block;
    }
</style>

<script>
    (function () {
        var EYE =
            '<svg class="pw-icon-show" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
            '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>' +
            '<svg class="pw-icon-hide" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
            '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>' +
            '<line x1="1" y1="1" x2="23" y2="23"/></svg>';

        function attach(input) {
            if (input.dataset.pwToggle) {
                return;
            }
            input.dataset.pwToggle = '1';

            var wrap = document.createElement('span');
            wrap.className = 'pw-wrap';
            input.parentNode.insertBefore(wrap, input);
            wrap.appendChild(input);

            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'pw-toggle';
            btn.setAttribute('aria-label', 'Show password');
            btn.innerHTML = EYE;

            btn.addEventListener('click', function () {
                var shown = input.type === 'text';
                input.type = shown ? 'password' : 'text';
                btn.classList.toggle('is-shown', !shown);
                btn.setAttribute('aria-label', shown ? 'Show password' : 'Hide password');
                input.focus();
            });

            wrap.appendChild(btn);
        }

        function init() {
            document.querySelectorAll('input[type="password"]').forEach(attach);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
</script>
