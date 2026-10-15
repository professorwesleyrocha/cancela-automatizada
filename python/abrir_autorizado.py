import serial
import time

PORTA = "COM4"
BAUDRATE = 9600

arduino = serial.Serial(PORTA, BAUDRATE, timeout=2)

time.sleep(3)

print("Enviando autorização para o Arduino...")

arduino.write(b"ABRIR_AUTORIZADO\n")

time.sleep(1)

while arduino.in_waiting:
    resposta = arduino.readline().decode("utf-8", errors="ignore").strip()

    if resposta:
        print("Arduino:", resposta)

arduino.close()