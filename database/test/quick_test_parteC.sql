USE gescon;

/*--------------------------------------------------------------
  1. Crear dos revisores extra (si no existen)
--------------------------------------------------------------*/
INSERT IGNORE INTO Usuario (nombre,email,password_hash)
VALUES ('Revisor Extra 1','revx1@example.com',REPEAT('v',60));
SET @rExtra1 := LAST_INSERT_ID();
INSERT IGNORE INTO Revisor (id_usuario,institucion,fecha_designacion)
VALUES (@rExtra1,'Demo Univ',CURDATE());

INSERT IGNORE INTO Usuario (nombre,email,password_hash)
VALUES ('Revisor Extra 2','revx2@example.com',REPEAT('w',60));
SET @rExtra2 := LAST_INSERT_ID();
INSERT IGNORE INTO Revisor (id_usuario,institucion,fecha_designacion)
VALUES (@rExtra2,'Demo Univ',CURDATE());

/*--------------------------------------------------------------
  2. Crear nuevo artículo de prueba
--------------------------------------------------------------*/
INSERT INTO Articulo
(titulo, fecha_envio, resumen, topicos, autor_contacto, fecha_limite_envio)
VALUES
    ('Artículo Parte C 2 2', CURDATE(), 'Texto', 'SQL', 1, DATE_ADD(CURDATE(), INTERVAL 25 DAY));
SET @idArt := LAST_INSERT_ID();

/*--------------------------------------------------------------
  3. Ejecutar SP para asignar revisores
--------------------------------------------------------------*/
CALL sp_asignar_revisores(@idArt);

/*--------------------------------------------------------------
  4. Cambiar estado a “En revisión” (id_estado = 2)
--------------------------------------------------------------*/
UPDATE Articulo SET id_estado = 2 WHERE id_articulo = @idArt;

/*--------------------------------------------------------------
  5. Marcar UNA reseña como entregada con puntaje
--------------------------------------------------------------*/
UPDATE Reseña
SET fecha_envio = CURDATE(), puntaje = 5
WHERE id_articulo = @idArt
LIMIT 1;

/*--------------------------------------------------------------
  6. Consultas de verificación
--------------------------------------------------------------*/
SELECT '== View ==' AS _;            -- separador visual
SELECT * FROM vw_articulo_resumen WHERE id_articulo = @idArt;

SELECT '== HistEstado ==' AS _;
SELECT * FROM HistEstado WHERE id_articulo = @idArt ORDER BY fecha;

SELECT '== Promedio == ' AS _;
SELECT fn_promedio_puntaje_articulo(@idArt) AS promedio_puntaje;
