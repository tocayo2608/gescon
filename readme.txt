
Hector Jerez Fantini 202373544-2
Martín González Asenjo 202373587-6


Recursos utilizados

- PHP 8.2.12 (usado con PHPStorm 2025.1.1 + XAMPP 8.2)
- MySql
- Google Chrome
- Python 3.13

Instalación Local

1. Clonar este repositorio:

   git clone https://github.com/tocayo2608/gescon.git


2. Abrir el proyecto en **PHPStorm**.

3. Copiar la carpeta `gescon/` dentro de:

   C:\xampp\htdocs\

4. Crear la base de datos `gescon` en **MySQL** (PhpMyAdmin):
   - Ejecuta todos los scripts de creación y artefactos desde `/database/`
   - Luego ejecuta el script de poblamiento desde Python


Dependencias Python para el poblado de la Base de Datos. Ejecutar desde una terminal:
    pip install mysql-connector-python Faker

Poblamiento de la Base de Datos

Desde el directorio `scripts/` o donde esté ubicado `populate.py`, ejecuta:

    python populate.py

Levantamiento de XAMPP

-En el Control Panel, pulsa Start junto a Apache y MySQL.
-ConfirmaR que ambos quedan en verde y muestran “Running”.


Acceso y credenciales

Entrar en http://localhost/gescon/login con el mail y la contraseña asignados como Revisor.

Si aún no tiene cuenta: usar /register, elegir “Revisor” en el selector de rol y completar datos.

