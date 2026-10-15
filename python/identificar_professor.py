import mysql.connector

print("===================================")
print("     IDENTIFICAÇÃO DO PROFESSOR")
print("===================================")

codigo = input("Digite seu código: ")

conexao = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="cancela"
)

cursor = conexao.cursor()

sql = """
SELECT id, nome
FROM professores
WHERE codigo = %s
AND ativo = 1
"""

cursor.execute(sql, (codigo,))

resultado = cursor.fetchone()

if resultado:

    professor_id = resultado[0]
    nome = resultado[1]

    print()
    print("ACESSO AUTORIZADO!")
    print("Professor:", nome)
    print("ID:", professor_id)

else:

    print()
    print("ACESSO NEGADO!")
    print("Código inválido.")

cursor.close()
conexao.close()