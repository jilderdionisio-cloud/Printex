<style>
.printbot-fab {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1100;
    width: 72px;
    height: 72px;
    border-radius: 50%;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0033A0, #0a1f52);
    box-shadow: 0 14px 30px rgba(0,0,0,0.2);
    color: #FFD700;
    font-size: 32px;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.printbot-fab:hover {
    transform: translateY(-2px);
    box-shadow: 0 18px 34px rgba(0,0,0,0.24);
}
.printbot-window {
    position: fixed;
    bottom: 102px;
    right: 20px;
    width: 320px;
    max-width: 90vw;
    background: #f5f7fb;
    border-radius: 16px;
    box-shadow: 0 18px 40px rgba(0,0,0,0.22);
    overflow: hidden;
    z-index: 1100;
    opacity: 0;
    pointer-events: none;
    transform: translateY(12px);
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
}
.printbot-window.open { opacity: 1; pointer-events: auto; transform: translateY(0); }
.printbot-header {
    background: linear-gradient(135deg, #0033A0, #0a1f52);
    color: #fff;
    padding: 12px 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.printbot-header .bot-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: #FFD700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #8A0000;
    font-weight: 900;
    font-size: 18px;
}
.printbot-header h6 { margin: 0; font-weight: 800; letter-spacing: 0.02em; }
.printbot-body {
    padding: 12px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 360px;
    overflow-y: auto;
}
.printbot-msg {
    padding: 10px 12px;
    border-radius: 12px;
    font-size: 14px;
    line-height: 1.4;
    white-space: pre-line;
    max-width: 90%;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}
.printbot-msg.bot { background: #E0E0E0; color: #0a0a0a; align-self: flex-start; }
.printbot-msg.user { background: #0033A0; color: #fff; align-self: flex-end; }
.printbot-quick { display: flex; flex-wrap: wrap; gap: 8px; }
.printbot-quick button {
    background: #FFD700;
    color: #0033A0;
    border: none;
    border-radius: 999px;
    padding: 8px 12px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    box-shadow: 0 8px 16px rgba(0,0,0,0.12);
}
.printbot-input {
    display: flex;
    padding: 10px;
    gap: 8px;
    border-top: 1px solid #e5e7eb;
    background: #fff;
}
.printbot-input input {
    flex: 1;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    padding: 10px 12px;
    font-size: 14px;
}
.printbot-input button {
    background: #0033A0;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 14px;
    font-weight: 700;
    cursor: pointer;
}
@media (max-width: 576px) {
    .printbot-window {
        right: 10px;
        bottom: 80px;
        width: calc(100vw - 20px);
    }
}
</style>

<button class="printbot-fab" id="printbotToggle" aria-label="Abrir chat PrintBot">🤖</button>

<div class="printbot-window" id="printbotWindow">
    <div class="printbot-header">
        <div class="bot-icon">🤖</div>
        <div>
            <h6 class="mb-0">PrintBot</h6>
            <small>Asistente Virtual</small>
        </div>
    </div>
    <div class="printbot-body" id="printbotBody">
        <div class="printbot-msg bot">
            Hola, soy PrintBot. ¿En qué puedo ayudarte?
        </div>
        <div class="printbot-quick">
            <button data-quick="Ver productos">Ver productos</button>
            <button data-quick="Ver cursos">Ver cursos</button>
            <button data-quick="Métodos de pago">Métodos de pago</button>
            <button data-quick="Seguimiento de pedido">Seguimiento de pedido</button>
            <button data-quick="Contacto">Contacto</button>
        </div>
    </div>
    <div class="printbot-input">
        <input type="text" id="printbotInput" placeholder="Escribe tu mensaje...">
        <button type="button" id="printbotSend">Enviar</button>
    </div>
</div>

<script>
(function() {
    const toggle = document.getElementById('printbotToggle');
    const windowBox = document.getElementById('printbotWindow');
    const bodyBox = document.getElementById('printbotBody');
    const input = document.getElementById('printbotInput');
    const sendBtn = document.getElementById('printbotSend');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // Quitar mensaje inicial si existe
    const initialBot = bodyBox.querySelector('.printbot-msg.bot');
    if (initialBot) {
        initialBot.remove();
    }

    function openClose() { windowBox.classList.toggle('open'); }

    function appendMessage(text, from = 'bot') {
        const msg = document.createElement('div');
        msg.className = 'printbot-msg ' + from;
        msg.textContent = text;
        bodyBox.appendChild(msg);
        bodyBox.scrollTop = bodyBox.scrollHeight;
    }

    async function sendMessage() {
        const text = input.value.trim();
        if (!text) return;
        appendMessage(text, 'user');
        input.value = '';

        const thinking = document.createElement('div');
        thinking.className = 'printbot-msg bot';
        thinking.textContent = 'PrintBot está pensando...';
        bodyBox.appendChild(thinking);
        bodyBox.scrollTop = bodyBox.scrollHeight;

        try {
            const res = await fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({ message: text }),
            });
            if (!res.ok) {
                throw new Error('Respuesta no válida');
            }
            const data = await res.json();
            thinking.remove();
            appendMessage(data.reply || '¿Te ayudo con productos, cursos, pagos o pedidos?', 'bot');
        } catch (err) {
            thinking.remove();
            appendMessage('¿Te ayudo con productos, cursos, pagos o pedidos?', 'bot');
        }
    }

    toggle.addEventListener('click', openClose);
    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });
    document.querySelectorAll('.printbot-quick button').forEach(btn => {
        btn.addEventListener('click', () => {
            input.value = btn.dataset.quick;
            sendMessage();
        });
    });
})();
</script>
