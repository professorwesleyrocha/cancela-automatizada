import serial
from datetime import datetime
from urllib.request import urlopen
from urllib.parse import quote

PORTA = "COM4"
BAUDRATE = 9600

URL_PHP = "http://localhost/cancela/registrar_evento.php"

print("===================================")
print("   MONITOR DA CANCELA")
print("===================================")
print("Aguardando mensagens do Arduino...")
print("Pressione Ctrl+C para sair.")
print()

arduino = serial.Serial(PORTA, BAUDRATE, timeout=1)

while True:

    mensagem = arduino.readline().decode("utf-8", errors="ignore").strip()

    if mensagem:

        agora = datetime.now().strftime("%d/%m/%Y %H:%M:%S")

        print(f"[{agora}] {mensagem}")

        # Envia somente os eventos da cancela
        if mensagem == "CANCELA_ABRIU" or mensagem == "CANCELA_FECHOU":

            evento = quote(mensagem)

            url = f"{URL_PHP}?evento={evento}"

            try:
                resposta = urlopen(url, timeout=5)
                retorno = resposta.read().decode("utf-8", errors="ignore")

                print("  → PHP:", retorno)

            except Exception as erro:
                print("  → Erro ao enviar para o PHP:", erro)