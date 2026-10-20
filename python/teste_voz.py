
from http.server import HTTPServer, BaseHTTPRequestHandler
from urllib.parse import parse_qs
import json

HTML = """
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teste de Voz - Cancela</title>
</head>

<body style="font-family: Arial; text-align: center; padding: 25px">

    <h2>Teste de Voz</h2>

    <p>Fale ou digite a matrícula do professor.</p>

    <input
        id="matricula"
        type="text"
        placeholder="Matrícula do professor"
        autocomplete="off"
        style="font-size:20px; padding:12px; width:90%; box-sizing:border-box"
    >

    <br><br>

    <button
        onclick="ditar()"
        style="font-size:18px; padding:12px"
    >
        🎤 Ditar matrícula
    </button>

    <br><br>

    <button
        onclick="enviar()"
        style="font-size:18px; padding:12px"
    >
        Enviar texto
    </button>

    <p id="resultado">Aguardando...</p>

    <script>
        function ditar() {
            const campo = document.getElementById("matricula");
            campo.focus();

            document.getElementById("resultado").textContent =
                "Toque no microfone do teclado do celular e dite a matrícula.";
        }

        async function enviar() {
            const campo = document.getElementById("matricula");
            const matricula = campo.value.trim();
            const resultado = document.getElementById("resultado");

            if (!matricula) {
                resultado.textContent = "Digite ou dite uma matrícula primeiro.";
                campo.focus();
                return;
            }

            resultado.textContent = "Enviando ao computador...";

            try {
                const resposta = await fetch("/enviar", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded;charset=UTF-8"
                    },
                    body: "matricula=" + encodeURIComponent(matricula)
                });

                const dados = await resposta.json();
                resultado.textContent = dados.mensagem;
            } catch (erro) {
                resultado.textContent =
                    "Não foi possível enviar. Verifique se o servidor Python está ativo.";
            }
        }
    </script>

</body>
</html>
"""


class TesteVoz(BaseHTTPRequestHandler):

    def do_GET(self):
        self.send_response(200)
        self.send_header("Content-Type", "text/html; charset=utf-8")
        self.end_headers()
        self.wfile.write(HTML.encode("utf-8"))

    def do_POST(self):
        if self.path != "/enviar":
            self.send_error(404)
            return

        tamanho = int(self.headers.get("Content-Length", 0))
        corpo = self.rfile.read(tamanho).decode("utf-8")
        dados = parse_qs(corpo)

        matricula = dados.get("matricula", [""])[0].strip()

        if matricula:
            print(f"Matrícula recebida para teste: {matricula}")
            resposta = {
                "ok": True,
                "mensagem": f"Texto recebido pelo computador: {matricula}"
            }
        else:
            resposta = {
                "ok": False,
                "mensagem": "Matrícula vazia."
            }

        conteudo = json.dumps(resposta, ensure_ascii=False).encode("utf-8")

        self.send_response(200)
        self.send_header("Content-Type", "application/json; charset=utf-8")
        self.send_header("Content-Length", str(len(conteudo)))
        self.end_headers()
        self.wfile.write(conteudo)

    def log_message(self, formato, *args):
        pass


server = HTTPServer(("0.0.0.0", 8000), TesteVoz)

print("Teste de voz disponível na porta 8000.")
print("Aguardando matrículas enviadas pelo celular.")
print("Para encerrar, pressione Ctrl+C.")

try:
    server.serve_forever()
except KeyboardInterrupt:
    print("\\nServidor de teste encerrado.")
    server.server_close()
