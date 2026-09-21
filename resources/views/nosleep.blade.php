<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>NoSleep</title>

        <style>
            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #f4f5f7;
                color: #181b20;
                font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                -webkit-font-smoothing: antialiased;
            }

            .card {
                width: min(360px, calc(100% - 48px));
                background-color: #ffffff;
                border-radius: 16px;
                padding: 44px 28px 32px;
                text-align: center;
                box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05), 0 12px 32px rgba(15, 23, 42, 0.08);
            }

            h1 {
                margin: 0;
                font-size: 1.9rem;
                font-weight: 700;
                letter-spacing: -0.02em;
            }

            .status {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                margin: 18px 0 20px;
                padding: 6px 14px;
                border-radius: 999px;
                background-color: #f1f2f4;
                color: #6b7280;
                font-size: 0.78rem;
                font-weight: 600;
                letter-spacing: 0.08em;
            }

            .status .dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background-color: #9ca3af;
            }

            .status.active {
                background-color: #e7f8ee;
                color: #166534;
            }

            .status.active .dot {
                background-color: #22c55e;
                animation: pulse 2s ease-in-out infinite;
            }

            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.35; }
            }

            .description {
                margin: 0 auto 24px;
                max-width: 26ch;
                font-size: 0.95rem;
                line-height: 1.55;
                color: #4b5563;
            }

            .timer {
                margin: -8px auto 24px;
                font-size: 0.95rem;
                font-variant-numeric: tabular-nums;
                color: #374151;
            }

            #toggle-button {
                width: 100%;
                padding: 13px 16px;
                border: none;
                border-radius: 12px;
                background-color: #181b20;
                color: #ffffff;
                font-size: 0.95rem;
                font-weight: 600;
                cursor: pointer;
                transition: background-color 0.15s ease;
            }

            #toggle-button:hover:not(:disabled) {
                background-color: #343a46;
            }

            #toggle-button:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            .message {
                margin: 16px 0 0;
                padding: 10px 12px;
                border: 1px solid #fecaca;
                border-radius: 10px;
                background-color: #fef2f2;
                color: #b91c1c;
                font-size: 0.85rem;
                line-height: 1.45;
            }
        </style>
    </head>
    <body>
        <main class="card">
            <h1>NoSleep</h1>

            <p id="status" class="status"><span class="dot"></span><span id="status-label">INACTIVE</span></p>

            <p id="description" class="description">Keep your screen awake.</p>

            <p id="timer" class="timer" hidden>Running for: 00:00:00</p>

            <button id="toggle-button" type="button">Start NoSleep</button>

            <p id="message" class="message" role="alert" hidden></p>
        </main>

        <script>
            (() => {
                'use strict';

                const statusEl = document.getElementById('status');
                const labelEl = document.getElementById('status-label');
                const descriptionEl = document.getElementById('description');
                const timerEl = document.getElementById('timer');
                const buttonEl = document.getElementById('toggle-button');
                const messageEl = document.getElementById('message');

                let active = false;
                let sentinel = null;
                let startedAt = 0;
                let intervalId = null;
                let requesting = false;

                if (!('wakeLock' in navigator)) {
                    buttonEl.disabled = true;
                    showMessage('Your browser does not support Screen Wake Lock.');
                    return;
                }

                const pad = (value) => String(value).padStart(2, '0');

                function formatElapsed(ms) {
                    const total = Math.max(0, Math.floor(ms / 1000));
                    return [Math.floor(total / 3600), Math.floor((total % 3600) / 60), total % 60]
                        .map(pad)
                        .join(':');
                }

                function updateTimer() {
                    timerEl.textContent = `Running for: ${formatElapsed(Date.now() - startedAt)}`;
                }

                function showMessage(text) {
                    messageEl.hidden = false;
                    messageEl.textContent = text;
                }

                function hideMessage() {
                    messageEl.hidden = true;
                }

                async function acquireLock() {
                    if (requesting) return null;
                    requesting = true;
                    try {
                        const lock = await navigator.wakeLock.request('screen');
                        sentinel = lock;
                        lock.addEventListener('release', () => handleRelease(lock));
                        hideMessage();
                        return lock;
                    } catch {
                        showMessage('Could not acquire the screen wake lock.');
                        return null;
                    } finally {
                        requesting = false;
                    }
                }

                function activate() {
                    active = true;
                    startedAt = Date.now();
                    intervalId = setInterval(updateTimer, 1000);
                    updateTimer();
                    statusEl.classList.add('active');
                    labelEl.textContent = 'ACTIVE';
                    descriptionEl.textContent = 'Your screen will stay awake while NoSleep is running.';
                    timerEl.hidden = false;
                    buttonEl.textContent = 'Stop NoSleep';
                }

                function stop(message) {
                    active = false;
                    if (intervalId !== null) {
                        clearInterval(intervalId);
                        intervalId = null;
                    }
                    const lock = sentinel;
                    sentinel = null;
                    if (lock) {
                        lock.release().catch(() => {});
                    }
                    statusEl.classList.remove('active');
                    labelEl.textContent = 'INACTIVE';
                    descriptionEl.textContent = 'Keep your screen awake.';
                    timerEl.hidden = true;
                    buttonEl.textContent = 'Start NoSleep';
                    if (message) {
                        showMessage(message);
                    } else {
                        hideMessage();
                    }
                }

                function start() {
                    hideMessage();
                    acquireLock().then((lock) => {
                        if (lock !== null && !active) activate();
                    });
                }

                function reacquire() {
                    acquireLock().then((lock) => {
                        if (lock === null && active) stop('Could not reacquire the screen wake lock.');
                    });
                }

                function handleRelease(released) {
                    if (sentinel !== released) return;
                    sentinel = null;
                    if (!active || document.visibilityState !== 'visible') return;
                    reacquire();
                }

                buttonEl.addEventListener('click', () => {
                    if (active) stop();
                    else start();
                });

                document.addEventListener('visibilitychange', () => {
                    if (document.visibilityState !== 'visible' || !active) return;
                    updateTimer();
                    if (!sentinel) reacquire();
                });
            })();
        </script>
    </body>
</html>
