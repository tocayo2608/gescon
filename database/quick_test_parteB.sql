USE gescon;


INSERT IGNORE INTO Usuario (nombre, email, password_hash)
VALUES ('Autor Demo', 'autor.demo@example.com', REPEAT('x',60));
SET @idAutor := LAST_INSERT_ID();


INSERT INTO Articulo
(titulo, fecha_envio, resumen, topicos, autor_contacto, fecha_limite_envio)
VALUES
    ('Paper de prueba', CURDATE(), 'Resumen brevísimo', 'BD,SQL', @idAutor, DATE_ADD(CURDATE(), INTERVAL 30 DAY));
SET @idArt := LAST_INSERT_ID();


INSERT INTO AutorArt (id_articulo, id_usuario, orden_autor)
VALUES (@idArt, @idAutor, 1);

INSERT IGNORE INTO Usuario (nombre, email, password_hash)
VALUES ('Revisor Demo', 'revisor.demo@example.com', REPEAT('y',60));
SET @idRevisorUsr := LAST_INSERT_ID();
INSERT IGNORE INTO Revisor (id_usuario, institucion, fecha_designacion)
VALUES (@idRevisorUsr, 'Demo University', CURDATE());


INSERT INTO Reseña
(id_articulo, id_revisor, fecha_asignacion, fecha_envio, decision, comentario, puntaje)
VALUES (@idArt, @idRevisorUsr, CURDATE(), CURDATE(), 'Revisión menor', 'Buen trabajo', 4);


INSERT INTO HistEstado (id_articulo, fecha, id_estado, observacion)
VALUES (@idArt, NOW(), 2, 'Asignado a revisión');
