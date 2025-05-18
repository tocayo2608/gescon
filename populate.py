
import random
import datetime
from time import sleep
from typing import List, Tuple

import mysql.connector  # pip install mysql-connector-python
from faker import Faker  # pip install Faker

N_AUTORES = 10
N_REVISORES = 5
N_ARTICULOS = 12
RESEÑAS_POR_ART = 3

DB_CONFIG = {
    "host": "127.0.0.1",
    "user": "root",
    "password": "",
    "database": "gescon",
    "auth_plugin": "mysql_native_password",
}

faker = Faker("es_CL")
random.seed(42)


def get_conn():
    return mysql.connector.connect(**DB_CONFIG)


def insert_many(cur, sql: str, seq: List[Tuple]):
    if seq:
        cur.executemany(sql, seq)


def poblar_roles(cur):
    insert_many(
        cur,
        "INSERT IGNORE INTO Rol (nombre) VALUES (%s)",
        [("autor",), ("revisor",), ("jefe_comite",)]
    )


def poblar_autores(cur) -> List[int]:
    datos_usuario = [
        (faker.name(), faker.unique.email(), "x" * 60) for _ in range(N_AUTORES)
    ]
    insert_many(
        cur,
        "INSERT INTO Usuario (nombre, email, password_hash) VALUES (%s,%s,%s)",
        datos_usuario,
    )
    cur.execute(
        "SELECT id_usuario FROM Usuario ORDER BY id_usuario DESC LIMIT %s",
        (N_AUTORES,),
    )
    ids = [row[0] for row in cur.fetchall()][::-1]

    insert_many(
        cur,
        "INSERT IGNORE INTO Autor (id_usuario, afiliacion, orcid) VALUES (%s,%s,NULL)",
        [(uid, faker.company()) for uid in ids],
    )

    cur.execute("SELECT id_rol FROM Rol WHERE nombre = 'autor'")
    id_rol_autor = cur.fetchone()[0]

    insert_many(
        cur,
        "INSERT IGNORE INTO UsuarioRol (id_usuario, id_rol) VALUES (%s, %s)",
        [(uid, id_rol_autor) for uid in ids],
    )

    return ids


def poblar_revisores(cur) -> List[int]:
    datos_usuario = [
        (faker.name(), faker.unique.email(), "y" * 60) for _ in range(N_REVISORES)
    ]
    insert_many(
        cur,
        "INSERT INTO Usuario (nombre, email, password_hash) VALUES (%s,%s,%s)",
        datos_usuario,
    )
    cur.execute(
        "SELECT id_usuario FROM Usuario ORDER BY id_usuario DESC LIMIT %s",
        (N_REVISORES,),
    )
    ids = [row[0] for row in cur.fetchall()][::-1]

    insert_many(
        cur,
        "INSERT IGNORE INTO Revisor (id_usuario, institucion, fecha_designacion) VALUES (%s,%s,CURDATE())",
        [(uid, faker.company()) for uid in ids],
    )

    cur.execute("SELECT id_rol FROM Rol WHERE nombre = 'revisor'")
    id_rol_revisor = cur.fetchone()[0]

    insert_many(
        cur,
        "INSERT IGNORE INTO UsuarioRol (id_usuario, id_rol) VALUES (%s, %s)",
        [(uid, id_rol_revisor) for uid in ids],
    )

    return ids


def poblar_articulos(cur, autor_ids: List[int]) -> List[int]:
    datos_art = []
    for i in range(N_ARTICULOS):
        titulo = f"Paper Demo {i + 1} - {faker.unique.uuid4()[:8]}"
        fecha_envio = faker.date_between(start_date="-30d", end_date="today")
        resumen = faker.text(max_nb_chars=200)
        topicos = random.choice(["BD", "SQL", "AI", "ML", "DW"])
        autor_contacto = random.choice(autor_ids)
        fecha_limite = fecha_envio + datetime.timedelta(days=30)
        datos_art.append(
            (
                titulo,
                fecha_envio,
                resumen,
                topicos,
                autor_contacto,
                fecha_limite,
            )
        )

    insert_many(
        cur,
        """
        INSERT INTO Articulo (titulo, fecha_envio, resumen, topicos, autor_contacto, fecha_limite_envio)
        VALUES (%s, %s, %s, %s, %s, %s)
        """,
        datos_art,
    )
    cur.execute(
        "SELECT id_articulo FROM Articulo ORDER BY id_articulo DESC LIMIT %s",
        (N_ARTICULOS,),
    )
    ids = [row[0] for row in cur.fetchall()][::-1]

    datos_autorart = []
    for art_id in ids:
        autores = random.sample(autor_ids, k=random.randint(2, 3))
        for orden, uid in enumerate(autores, start=1):
            datos_autorart.append((art_id, uid, orden))

    insert_many(
        cur,
        "INSERT INTO AutorArt (id_articulo, id_usuario, orden_autor) VALUES (%s,%s,%s)",
        datos_autorart,
    )
    return ids


def poblar_reseñas(cur, art_ids: List[int], rev_ids: List[int]):
    datos_reseña = []
    for art_id in art_ids:
        revisores = random.sample(rev_ids, k=RESEÑAS_POR_ART)
        for rev_id in revisores:
            fecha_asig = faker.date_between(start_date="-20d", end_date="-5d")
            if random.random() < 0.6:
                fecha_envio = fecha_asig + datetime.timedelta(days=random.randint(1, 10))
                decision = random.choice(["Revisión menor", "Revisión mayor", "Aceptado"])
                comentario = faker.sentence()
                puntaje = random.randint(3, 5)
            else:
                fecha_envio = None
                decision = None
                comentario = None
                puntaje = None
            datos_reseña.append(
                (
                    art_id,
                    rev_id,
                    fecha_asig,
                    fecha_envio,
                    decision,
                    comentario,
                    puntaje,
                )
            )
    insert_many(
        cur,
        """
        INSERT INTO Reseña (id_articulo, id_revisor, fecha_asignacion, fecha_envio, decision, comentario, puntaje)
        VALUES (%s,%s,%s,%s,%s,%s,%s)
        """,
        datos_reseña,
    )


def avanzar_estados(cur, art_ids: List[int]):
    for art_id in art_ids:
        nuevo_estado = random.choice([2, 3, 4, 5, 6])
        sleep(1)
        cur.execute("UPDATE Articulo SET id_estado = %s WHERE id_articulo = %s", (nuevo_estado, art_id))

# --------------------------- MAIN --------------------------- #

def main():
    print("Conectando a la BD …")
    with get_conn() as conn:
        cur = conn.cursor()

        print("→ Insertando roles base …")
        poblar_roles(cur)

        print("→ Insertando autores …")
        autores = poblar_autores(cur)
        print(f"   {len(autores)} autores")

        print("→ Insertando revisores …")
        revisores = poblar_revisores(cur)
        print(f"   {len(revisores)} revisores")

        print("→ Insertando artículos …")
        articulos = poblar_articulos(cur, autores)
        print(f"   {len(articulos)} artículos")

        print("→ Insertando reseñas …")
        poblar_reseñas(cur, articulos, revisores)

        print("→ Avanzando estados …")
        avanzar_estados(cur, articulos)

        conn.commit()
        print("Poblamiento completo ✓")

if __name__ == "__main__":
    main()