<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrintBot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Chat con PrintBot</h5>
                    </div>
                    <div class="card-body">
                        <div id="chat" class="mb-3" style="min-height: 200px;"></div>
                        <div class="input-group">
                            <input id="msg" type="text" class="form-control" placeholder="Escribe algo...">
                            <button class="btn btn-primary" onclick="sendMsg()">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    async function sendMsg() {
        const input = document.getElementById('msg');
        const message = input.value.trim();
        if (!message) return;

        const chatBox = document.getElementById('chat');
        chatBox.innerHTML += `<p><strong>Tú:</strong> ${message}</p>`;

        const req = await fetch("/chatbot", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ message })
        });

        const res = await req.json();
        chatBox.innerHTML += `<p><strong>PrintBot:</strong> ${res.reply}</p>`;
        input.value = "";
    }
    </script>
</body>
</html>
