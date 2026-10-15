#include <Servo.h>

Servo cancela;

// HC-SR04
const int trigPin = 5;
const int echoPin = 6;

// Servo
const int servoPin = 4;

// LEDs
const int ledVermelho = 7;
const int ledAmarelo = 8;
const int ledVerde = 9;

long duracao;
int distancia;

void setup() {

  cancela.attach(servoPin);

  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);

  pinMode(ledVermelho, OUTPUT);
  pinMode(ledAmarelo, OUTPUT);
  pinMode(ledVerde, OUTPUT);

  // Cancela começa fechada
  cancela.write(100);

  // Vermelho aceso
  digitalWrite(ledVermelho, HIGH);
  digitalWrite(ledAmarelo, LOW);
  digitalWrite(ledVerde, LOW);

  Serial.begin(9600);
}

void loop() {

  // Mede a distância
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);

  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);

  duracao = pulseIn(echoPin, HIGH);

  distancia = duracao * 0.034 / 2;

  Serial.print("Distancia: ");
  Serial.print(distancia);
  Serial.println(" cm");

  // Veículo detectado
  if (distancia > 0 && distancia <= 15) {

    Serial.println("Veiculo detectado!");

    // Amarelo
    digitalWrite(ledVermelho, LOW);
    digitalWrite(ledAmarelo, HIGH);
    delay(1000);

    // Verde
    digitalWrite(ledAmarelo, LOW);
    digitalWrite(ledVerde, HIGH);

    // Abre a cancela
    cancela.write(150);

    delay(3000);

    // Amarelo novamente
    digitalWrite(ledVerde, LOW);
    digitalWrite(ledAmarelo, HIGH);
    delay(1000);

    // Vermelho
    digitalWrite(ledAmarelo, LOW);
    digitalWrite(ledVermelho, HIGH);

    // Fecha a cancela
    cancela.write(100);

    delay(1000);
  }

  delay(100);
}