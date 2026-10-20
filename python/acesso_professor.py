
import serial
import time
import mysql.connector

# ===============================
# CONFIGURAÇÕES
# ===============================

PORTA = "COM4"
BAUDRATE = 9600

# ===============================
# IDENTIFICAÇÃO
# ===============================

print("===================================")
print("       CONTROLE DE ACESSO")
print("===================================")

codigo = input("Digite seu código: ")

# ===============================
# CONECTA AO MYSQL
# ===============================

conexao = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="cancela"
)

cursor = conexao.cursor()

# ===============================
# PROCURA PROFESSOR
# ===============================

sql = """
SELECT id, nome
FROM professores
WHERE codigo = %s
AND ativo = 1
"""

cursor.execute(sql, (codigo,))
resultado = cursor.fetchone()

# ===============================
# ACESSO NEGADO
# ===============================

if not resultado:
    print()
    print("❌ ACESSO NEGADO!")
    print("Código inválido.")

    cursor.close()
    conexao.close()
    exit()

# ===============================
# PROFESSOR ENCONTRADO
# ===============================

professor_id = resultado[0]
nome = resultado[1]

print()
print("✅ ACESSO AUTORIZADO!")
print("Professor:", nome)

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
# REGISTRA O ACESSO
# ===============================

sql = """
INSERT INTO acessos
(professor_id, data_acesso, hora_acesso, evento)
VALUES (%s, CURDATE(), CURTIME(), %s)
"""

cursor.execute(
    sql,
    (professor_id, "CANCELA_ABRIU")
)

conexao.commit()

# ===============================
# ENVIA AUTORIZAÇÃO AO ARDUINO
# ===============================

arduino.write(b"ABRIR_AUTORIZADO\n")

# ===============================
# AGUARDA RESPOSTA
# ===============================

time.sleep(1)

while arduino.in_waiting:
    resposta = arduino.readline().decode(
        "utf-8",
        errors="ignore"
    ).strip()

    if resposta:
        print("Arduino:", resposta)

# ===============================
# FECHA COMUNICAÇÃO
# ===============================

arduino.close()
cursor.close()
conexao.close()

print()
print("Acesso concluído.")

