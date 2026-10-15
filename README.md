# Cancela Automatizada

## Sobre o projeto

Sistema de controle de acesso desenvolvido para automatizar a abertura e o fechamento de uma cancela, com identificação e autorização de professores.

O projeto integra hardware e software, utilizando Arduino, Python, PHP e MySQL.

## Tecnologias utilizadas

- **Arduino:** controle dos componentes eletrônicos e acionamento da cancela.
- **Python:** comunicação serial com o Arduino e processamento da autorização.
- **PHP:** interface web para gerenciamento de professores e consulta de acessos.
- **MySQL:** armazenamento dos professores e registros de eventos.
- **XAMPP:** ambiente local para execução do PHP e do MySQL.

## Componentes eletrônicos

- Arduino Uno
- Sensor ultrassônico
- Servo motor
- LEDs de sinalização
- Buzzer
- Cabos e alimentação elétrica

## Funcionalidades

- Cadastro e gerenciamento de professores.
- Ativação e desativação de professores.
- Verificação de autorização de acesso.
- Acionamento da cancela pelo Arduino.
- Registro e consulta de eventos de acesso.
- Testes de identificação por voz em desenvolvimento.

## Estrutura do projeto

- `arduino/` — código do Arduino.
- `python/` — programas de comunicação e controle.
- `php/` — interface web e integração com o banco de dados.
- `banco_de_dados/` — arquivo SQL para preparar o banco de dados.

## Requisitos

- Arduino IDE.
- Python 3.
- XAMPP com Apache e MySQL.
- Bibliotecas Python necessárias para os módulos utilizados.
- Arduino conectado ao computador por USB.

## Instalação

1. Importe o arquivo SQL da pasta `banco_de_dados/` pelo phpMyAdmin.
2. Configure a conexão com o banco de dados nos arquivos PHP.
3. Coloque os arquivos PHP na pasta apropriada do servidor local.
4. Instale as dependências Python necessárias.
5. Confira a porta serial utilizada pelo Arduino.
6. Carregue o programa `.ino` no Arduino.
7. Inicie os serviços e teste a comunicação entre os componentes.

## Objetivo educacional

Este projeto demonstra a integração entre eletrônica, programação, banco de dados e desenvolvimento web, aplicando conceitos de automação e controle de acesso.

## Autor

Wesley Rocha da Silva

Projeto desenvolvido para fins educacionais e de portfólio.