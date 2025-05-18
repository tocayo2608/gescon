# GESCON – Inventario de entidades (Parte B)

| Entidad   | Atributos clave (bosquejo)                          | Fuente enunciado |
|-----------|-----------------------------------------------------|---------------|
| Articulo | id_articulo (PK), titulo, fecha_envio, resumen, topicos, autor_contacto (FK → Usuario), fecha_limite_envio | pág. 3        |
| AutorArt | id_articulo (PK, FK → Articulo), id_usuario (PK, FK → Usuario), orden_autor, afiliacion_local, email_secundario | pág. 3        |
| Revisor | id_usuario (PK, FK → Usuario), institucion, fecha_designacion, area_experiencia | Fase A (schema_v1.sql) |
| Reseña | id_reseña (PK), id_articulo (FK → Articulo), id_revisor (FK → Revisor), fecha_asignacion, fecha_envio, decision, comentario, puntaje |pág. 4|
| Estado | id_estado (PK), nombre, descripcion, orden_visual |pág. 4|
| HistEstado | id_articulo (PK, FK → Articulo), fecha (PK), id_estado (FK → Estado), observacion |pág. 4 |
| Comité | id_comite (PK), nombre, año, fecha_creacion, activo |pág. 5|
| Miembro | id_usuario (PK, FK → Usuario), id_comite (PK, FK → Comité), rol, fecha_inicio, fecha_fin |pág. 5|
