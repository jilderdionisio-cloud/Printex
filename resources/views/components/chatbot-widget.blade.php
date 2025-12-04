<style>
    /* Contenedor base */
    #printex-chatbot {
        position: fixed;
        bottom: 22px;
        right: 22px;
        z-index: 2090;
        font-family: 'Space Grotesk', 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
    }

    /* Boton flotante */
    #printex-chat-toggle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: none;
        background: linear-gradient(145deg, #16a34a 0%, #22c55e 45%, #0ea5e9 100%);
        color: #fff;
        display: grid;
        place-items: center;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.18);
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        animation: printex-pop 0.35s ease;
    }
    #printex-chat-toggle:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 32px rgba(0, 0, 0, 0.22);
    }
    #printex-chat-toggle .printex-icon {
        font-size: 22px;
    }

    /* Ventana */
    #printex-chat-window {
        position: absolute;
        bottom: 76px;
        right: 0;
        width: min(380px, 90vw);
        max-height: 74vh;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 20px 46px rgba(0, 0, 0, 0.22);
        display: none;
        flex-direction: column;
        overflow: hidden;
        animation: printex-fade 0.25s ease;
    }
    #printex-chat-window.open { display: flex; }

    .printex-chat-header {
        background: linear-gradient(135deg, #0ea5e9, #22c55e);
        color: #fff;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 700;
    }
    .printex-chat-close {
        background: transparent;
        border: none;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
    }

    #printex-chat-messages {
        padding: 12px;
        background: #f7f9fc;
        display: flex;
        flex-direction: column;
        gap: 10px;
        overflow-y: auto;
        max-height: 52vh;
    }

    .printex-bubble {
        padding: 10px 12px;
        border-radius: 14px;
        max-width: 78%;
        width: fit-content;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        font-size: 14px;
        line-height: 1.35;
        white-space: pre-line;
    }
    .printex-bubble.user {
        background: #e3f2fd;
        color: #0d47a1;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }
    .printex-bubble.bot {
        background: #eceff1;
        color: #37474f;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
    }
    .printex-bubble.typing {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .printex-dot {
        width: 6px; height: 6px;
        background: #90a4ae;
        border-radius: 50%;
        animation: printex-bounce 1s infinite ease-in-out;
    }
    .printex-dot:nth-child(2) { animation-delay: 0.1s; }
    .printex-dot:nth-child(3) { animation-delay: 0.2s; }

    .printex-chat-footer {
        padding: 12px;
        border-top: 1px solid #e5e7eb;
        background: #fff;
        display: flex;
        gap: 8px;
    }
    #printex-chat-input {
        flex: 1;
        border: 1px solid #cfd8dc;
        border-radius: 12px;
        padding: 10px 12px;
        font-size: 14px;
        outline: none;
        transition: border 0.15s ease, box-shadow 0.15s ease;
    }
    #printex-chat-input:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.16);
    }
    #printex-chat-send {
        border: none;
        border-radius: 12px;
        background: #0ea5e9;
        color: #fff;
        font-weight: 700;
        padding: 10px 14px;
        cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    #printex-chat-send:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(14, 165, 233, 0.28);
    }

    @keyframes printex-pop {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    @keyframes printex-fade {
        from { transform: translateY(10px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    @keyframes printex-bounce {
        0%, 80%, 100% { transform: scale(0.9); opacity: 0.6; }
        40% { transform: scale(1.2); opacity: 1; }
    }

    @media (max-width: 640px) {
        #printex-chatbot { right: 16px; bottom: 16px; }
        #printex-chat-window { width: calc(100vw - 24px); right: -2px; }
    }
</style>

<div id="printex-chatbot" aria-live="polite">
    <button id="printex-chat-toggle" aria-label="Abrir chat">
        <span class="printex-icon">&#128172;</span>
    </button>

    <div id="printex-chat-window" aria-hidden="true">
        <header class="printex-chat-header">
            <span>Asistente IA - Printex</span>
            <button class="printex-chat-close" id="printex-chat-close" aria-label="Cerrar">&times;</button>
        </header>

        <div id="printex-chat-messages">
            <div class="printex-bubble bot">Hola, soy tu asistente IA. Pregunta por productos o recomendaciones.</div>
        </div>

        <form class="printex-chat-footer" id="printex-chat-form">
            <input type="text" id="printex-chat-input" placeholder="Escribe tu mensaje..." autocomplete="off" required>
            <button type="submit" id="printex-chat-send">Enviar</button>
        </form>
    </div>
</div>

<script>
    (() => {
        const toggle = document.getElementById('printex-chat-toggle');
        const windowEl = document.getElementById('printex-chat-window');
        const closeBtn = document.getElementById('printex-chat-close');
        const form = document.getElementById('printex-chat-form');
        const input = document.getElementById('printex-chat-input');
        const messages = document.getElementById('printex-chat-messages');
        const sendBtn = document.getElementById('printex-chat-send');

        const csrfToken =
            document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            window.csrfToken || '';

        const appendMessage = (role, text, isTyping = false) => {
            const bubble = document.createElement('div');
            bubble.className = `printex-bubble ${role}` + (isTyping ? ' typing' : '');
            if (isTyping) {
                bubble.id = 'printex-typing';
                bubble.innerHTML = '<span class="printex-dot"></span><span class="printex-dot"></span><span class="printex-dot"></span>';
            } else {
                bubble.textContent = text;
            }
            messages.appendChild(bubble);
            messages.scrollTop = messages.scrollHeight;
            return bubble;
        };

        const removeTyping = () => {
            const typing = document.getElementById('printex-typing');
            if (typing) typing.remove();
        };

        const setLoading = (state) => {
            sendBtn.disabled = state;
            input.disabled = state;
            sendBtn.textContent = state ? '...' : 'Enviar';
        };

        const toggleWindow = (force) => {
            const isOpen = windowEl.classList.contains('open');
            const shouldOpen = force !== undefined ? force : !isOpen;
            windowEl.classList.toggle('open', shouldOpen);
            windowEl.setAttribute('aria-hidden', shouldOpen ? 'false' : 'true');
            if (shouldOpen) setTimeout(() => input.focus(), 100);
        };

        toggle.addEventListener('click', () => toggleWindow(true));
        closeBtn.addEventListener('click', () => toggleWindow(false));

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const text = input.value.trim();
            if (!text) return;

            appendMessage('user', text);
            input.value = '';
            setLoading(true);
            appendMessage('bot', '', true);

            try {
                const baseUrl = document.querySelector('meta[name="app-url"]')?.content || window.location.origin || '';
                const response = await fetch(`${baseUrl.replace(/\/$/, '')}/api/chatbot`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: text })
                });

                const data = await response.json();
                removeTyping();

                if (!response.ok) throw new Error(data.error || 'Error del servidor.');
                const reply = data.reply || data.message || 'No se obtuvo respuesta.';
                appendMessage('bot', reply);
            } catch (err) {
                removeTyping();
                appendMessage('bot', 'No pude responder ahora. Intenta de nuevo en un momento.');
                console.warn('Chatbot error', err);
            } finally {
                setLoading(false);
                input.focus();
            }
        });
    })();
</script>
