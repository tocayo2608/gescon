# TAREA 2 INF239 
Hector Jerez Fantini 202373544-2 \
Martín González Asenjo 202373587-6\
Repositorio: [github.com/tocayo2608/gescon](https://github.com/tocayo2608/gescon)

---

##  Recursos utilizados

- PHP 8.1 (usado con PHPStorm 2025.1.1 + XAMPP 8.2)
- MySql
- Google Chrome
- Python 3.13 

---

## Instalación Local

1. Clonar este repositorio:
   ```
   git clone https://github.com/tocayo2608/gescon.git
   ```

2. Abre el proyecto en **PHPStorm**.

3. Copia la carpeta `gescon/` dentro de:
   ```
   C:\xampp\htdocs\
   ```

4. Crea la base de datos `gescon` en **MySQL** (PhpMyAdmin o CLI):
   - Ejecuta todos los scripts de creación y artefactos desde `/database/`
   - Luego ejecuta el script de poblamiento desde Python

---
## Dependencias Python para el poblado de la Base de Datos

```
pip install mysql-connector-python Faker
```
## Poblamiento con Python

Desde el directorio `scripts/` o donde esté ubicado `populate.py`, ejecuta:

```
python populate.py
```

---




---
