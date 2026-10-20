import serial
import time

PORTA = "COM4"
BAUDRATE = 9600

arduino = serial.Serial(PORTA, BAUDRATE, timeout=2)

time.sleep(3)

print("Enviando comando para o Arduino...")

arduino.write(b"TESTE\n")

time.sleep(1)

resposta = arduino.readline().decode("utf-8", errors="ignore").strip()

print("Arduino respondeu:", resposta)

arduino.close()