USE gescon;
DELIMITER $$

/* --------------------------------------------------------------
   SP: sp_asignar_revisores
   Asigna hasta 3 revisores con baja carga a un artículo dado.
   Parámetros:
     IN p_id_articulo INT
   -------------------------------------------------------------- */
DROP PROCEDURE IF EXISTS sp_asignar_revisores $$
CREATE PROCEDURE sp_asignar_revisores (IN p_id_articulo INT)
BEGIN
    DECLARE v_revisores_asignados INT DEFAULT 0;

    /* 1. Verificar que el artículo exista */
    IF (SELECT COUNT(*) FROM Articulo WHERE id_articulo = p_id_articulo) = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Artículo no existe';
    END IF;

    /* 2. Asignar revisores con menos de 5 reseñas pendientes */
    INSERT INTO Reseña (id_articulo, id_revisor, fecha_asignacion, decision)
    SELECT
        p_id_articulo,
        r.id_usuario,
        CURDATE(),
        NULL
    FROM Revisor r
             LEFT JOIN (
        SELECT id_revisor, COUNT(*) AS abiertas
        FROM Reseña
        WHERE fecha_envio IS NULL
        GROUP BY id_revisor
    ) p ON p.id_revisor = r.id_usuario
    WHERE COALESCE(p.abiertas, 0) < 5
      AND r.id_usuario NOT IN (
        SELECT id_revisor
        FROM Reseña
        WHERE id_articulo = p_id_articulo
    )
    ORDER BY COALESCE(p.abiertas, 0) ASC
    LIMIT 3;

    /* 3. Contar cuántos quedaron asignados */
    SELECT ROW_COUNT() INTO v_revisores_asignados;

    /* 4. Opcional: retornar el valor */
    SELECT v_revisores_asignados AS revisores_nuevos;
END $$

DELIMITER ;
