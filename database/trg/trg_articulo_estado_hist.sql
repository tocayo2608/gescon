USE gescon;
DELIMITER $$

/* ------------------------------------------------------------------
   Paso previo: añadir columna id_estado a Articulo (si no existe)
-------------------------------------------------------------------*/
ALTER TABLE Articulo
    ADD COLUMN id_estado INT NOT NULL DEFAULT 1 AFTER topicos,
    ADD CONSTRAINT fk_articulo_estado
        FOREIGN KEY (id_estado)
            REFERENCES Estado(id_estado)
            ON DELETE RESTRICT;

/* Actualizar artículos existentes al estado 'Enviado' (id 1) */
UPDATE Articulo SET id_estado = 1
WHERE id_estado IS NULL;

/* Insertar en HistEstado para artículos que aún no tengan registro */
INSERT IGNORE INTO HistEstado (id_articulo, fecha, id_estado, observacion)
SELECT a.id_articulo, NOW(), a.id_estado, 'Carga inicial'
FROM Articulo a;

/* ------------------------------------------------------------------
   Trigger BEFORE INSERT   – asigna estado 'Enviado' a nuevos artículos
-------------------------------------------------------------------*/
DROP TRIGGER IF EXISTS trg_articulo_before_insert $$
CREATE TRIGGER trg_articulo_before_insert
    BEFORE INSERT ON Articulo
    FOR EACH ROW
BEGIN
    /* obligamos a guardar estado 1 si el autor no envía uno */
    IF NEW.id_estado IS NULL THEN
        SET NEW.id_estado = 1;  -- 1 = Enviado
    END IF;
END $$

/* ------------------------------------------------------------------
   Trigger AFTER INSERT    – registra estado inicial en HistEstado
-------------------------------------------------------------------*/
DROP TRIGGER IF EXISTS trg_articulo_after_insert $$
CREATE TRIGGER trg_articulo_after_insert
    AFTER INSERT ON Articulo
    FOR EACH ROW
BEGIN
    INSERT INTO HistEstado (id_articulo, fecha, id_estado, observacion)
    VALUES (NEW.id_articulo, NOW(), NEW.id_estado, 'Creación de artículo');
END $$

/* ------------------------------------------------------------------
   Trigger AFTER UPDATE    – cada cambio de id_estado ⇒ HistEstado
-------------------------------------------------------------------*/
DROP TRIGGER IF EXISTS trg_articulo_after_update $$
CREATE TRIGGER trg_articulo_after_update
    AFTER UPDATE ON Articulo
    FOR EACH ROW
BEGIN
    IF NEW.id_estado <> OLD.id_estado THEN
        INSERT INTO HistEstado (id_articulo, fecha, id_estado, observacion)
        VALUES (NEW.id_articulo, NOW(), NEW.id_estado, 'Cambio automático');
    END IF;
END $$

DELIMITER ;
