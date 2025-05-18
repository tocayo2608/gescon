USE gescon;

INSERT INTO Estado (nombre, descripcion, orden_visual) VALUES
                                                           ('Enviado',        'Artículo recibido y pendiente de asignación',           1),
                                                           ('En revisión',    'Asignado a revisores, esperando informes',              2),
                                                           ('Revisión menor', 'Aceptado con cambios menores requeridos',               3),
                                                           ('Revisión mayor', 'Aceptado con cambios mayores requeridos',               4),
                                                           ('Aceptado',       'Artículo aprobado para publicación',                    5),
                                                           ('Rechazado',      'Artículo no aceptado',                                  6);
