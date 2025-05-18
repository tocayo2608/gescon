# 🧾 GESCON 
Hector Jerez Fantini 202373544-2 \
Martín González Asenjo 202373587-6\
Repositorio oficial: [github.com/tocayo2608/gescon](https://github.com/tocayo2608/gescon)

---

## 📦 Requisitos

- PHP 8.1+ (usado con PHPStorm 2025.1.1 + XAMPP 8.2.x)
- MySql
- Google Chrome
- Python 3.13 (para poblamiento utilizando la librería Faker)

---

## 🚀 Instalación local (modo XAMPP + PHPStorm)

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

## 🧪 Poblamiento con Python

Desde el directorio `scripts/` o donde esté ubicado `populate.py`, ejecuta:

```
python populate.py
```

Esto inserta automáticamente:

- Usuarios, autores y revisores
- Artículos con autores múltiples
- Reseñas simuladas
- Cambios de estado con trigger
- Roles básicos: autor, revisor, jefe_comite

---

## 📦 Dependencias Python

Instala las siguientes dependencias:

```
pip install mysql-connector-python Faker
```

> También puedes usar un entorno virtual:



---

## 👤 Accesos de prueba

| Rol     | Usuario           | Contraseña |
|---------|-------------------|------------|
| Autor   | autor1@example.com | xxxxxxxxxx |
| Revisor | rev1@example.com   | yyyyyyyyyy |

Usa el formulario de registro para crear más autores.

---

## 📁 Estructura del proyecto

```
gescon/
├── README.md
├── database/           # scripts SQL
├── scripts/            # populate.py
├── src/
│   ├── auth/           # login, registro
│   ├── middleware/     # protección por sesión
│   ├── config/         # db.php
│   ├── router.php      # rutas centralizadas
│   ├── layout.php      # plantilla base
│   ├── dashboard.php
│   ├── articulos_*.php
│   └── ...
```

---
