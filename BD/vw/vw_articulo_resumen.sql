USE gescon;

DROP VIEW IF EXISTS vw_articulo_resumen;
CREATE VIEW vw_articulo_resumen AS
SELECT
    a.id_articulo,
    a.titulo,
    e.nombre        AS estado_actual,
    a.fecha_envio,
    u.nombre        AS autor_contacto,
    COUNT(r.id_reseña)               AS n_reseñas_total,
    SUM(CASE WHEN r.fecha_envio IS NOT NULL THEN 1 ELSE 0 END) AS n_reseñas_entregadas
FROM Articulo a
         JOIN Usuario   u ON u.id_usuario = a.autor_contacto
         JOIN Estado    e ON e.id_estado  = a.id_estado
         LEFT JOIN Reseña r ON r.id_articulo = a.id_articulo
GROUP BY
    a.id_articulo, a.titulo, e.nombre, a.fecha_envio, u.nombre
ORDER BY a.id_articulo;
