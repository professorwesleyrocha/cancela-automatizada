import serial
import time
from http.server import BaseHTTPRequestHandler, HTTPServer

# ===============================
# CONFIGURAÇÕES
# ===============================

PORTA = "COM4"
BAUDRATE = 9600

HOST = "localhost"
PORTA_SERVIDOR = 5000


# ===============================
# CONECTA AO ARDUINO
# ===============================

arduino = serial.Serial(
    PORTA,
    BAUDRATE,
    timeout=2
)

time.sleep(3)


# ===============================
# SERVIDOR
# ===============================

class ServidorCancela(BaseHTTPRequestHandler):

    def do_GET(self):

        if self.path == "/abrir":

            print()
            print("Autorização recebida do sistema.")
            print("Enviando comando para o Arduino...")

            arduino.write(b"ABRIR_AUTORIZADO\n")

            time.sleep(1)

            resposta = ""

            while arduino.in_waiting:

                mensagem = arduino.readline().decode(
                    "utf-8",
                    errors="ignore"
                ).strip()

                if mensagem:
                    resposta = mensagem

                    if mensagem == "CANCELA_ABRIU":
                        print("===================================")
                        print("          CANCELA ABERTA")
                        print("===================================")

                    elif mensagem == "CANCELA_FECHOU":
                        print("===================================")
                        print("          CANCELA FECHADA")
                        print("===================================")

                    else:
                        print("Arduino:", mensagem)

            # Resposta para o PHP
            self.send_response(200)
            self.send_header(
                "Content-type",
                "text/plain; charset=utf-8"
            )
            self.end_headers()

            self.wfile.write(b"OK")

        else:

            self.send_response(404)
            self.end_headers()


# ===============================
# INICIA SERVIDOR
# ===============================

servidor = HTTPServer(
    (HOST, PORTA_SERVIDOR),
    ServidorCancela
)

print("===================================")
print("      SERVIDOR DA CANCELA")
print("===================================")
print("Arduino conectado na", PORTA)
print("Servidor ativo em:")
print("http://localhost:5000")
print()
print("Aguardando autorização...")
print("Pressione CTRL+C para encerrar.")
print()

try:

    servidor.serve_forever()

except KeyboardInterrupt:

    print()
    print("Servidor encerrado.")

finally:

    arduino.close()
    servidor.server_close()