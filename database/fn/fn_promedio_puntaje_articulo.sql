USE gescon;
DELIMITER $$

/* --------------------------------------------------------------
   FUNCTION: fn_promedio_puntaje_articulo
   Retorna el promedio (DECIMAL 4,2) de puntajes para un artículo.
   NULL si no hay reseñas entregadas (fecha_envio IS NULL).
---------------------------------------------------------------*/
DROP FUNCTION IF EXISTS fn_promedio_puntaje_articulo $$
CREATE FUNCTION fn_promedio_puntaje_articulo (p_id_articulo INT)
    RETURNS DECIMAL(4,2)
    DETERMINISTIC
    READS SQL DATA
BEGIN
    DECLARE v_prom DECIMAL(4,2);

    SELECT AVG(puntaje)
    INTO v_prom
    FROM Reseña
    WHERE id_articulo = p_id_articulo
      AND fecha_envio IS NOT NULL;

    RETURN v_prom;   -- será NULL si no encontró filas
END $$

DELIMITER ;
