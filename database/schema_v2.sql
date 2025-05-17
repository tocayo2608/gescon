-- ------------------------------------------------------------------
-- GESCON – Fase A: Diseño de autenticación y roles
-- Archivo : schema_v1.sql
-- ------------------------------------------------------------------

/* 1. (Re)crear la base de datos */
DROP  DATABASE IF EXISTS gescon;
CREATE DATABASE gescon
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE gescon;

/* 2. Tabla base de usuarios */
CREATE TABLE Usuario (
                         id_usuario      INT AUTO_INCREMENT PRIMARY KEY,
                         nombre          VARCHAR(100)  NOT NULL,
                         email           VARCHAR(255)  NOT NULL UNIQUE,
                         password_hash   CHAR(60)      NOT NULL,   -- bcrypt
                         fecha_registro  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         activo          BOOLEAN       NOT NULL DEFAULT TRUE
) ENGINE = InnoDB;

/* 3. Catálogo de roles */
CREATE TABLE Rol (
                     id_rol INT AUTO_INCREMENT PRIMARY KEY,
                     nombre VARCHAR(20) NOT NULL UNIQUE
) ENGINE = InnoDB;

/* 4. Asociación N-a-N usuario–rol */
CREATE TABLE UsuarioRol (
                            id_usuario INT NOT NULL,
                            id_rol     INT NOT NULL,
                            PRIMARY KEY (id_usuario, id_rol),
                            FOREIGN KEY (id_usuario)
                                REFERENCES Usuario(id_usuario)
                                ON DELETE CASCADE,
                            FOREIGN KEY (id_rol)
                                REFERENCES Rol(id_rol)
                                ON DELETE CASCADE
) ENGINE = InnoDB;

/* 5. Rol específico: Autor */
CREATE TABLE Autor (
                       id_usuario INT PRIMARY KEY,
                       afiliacion VARCHAR(255),
                       orcid      VARCHAR(19),
                       FOREIGN KEY (id_usuario)
                           REFERENCES Usuario(id_usuario)
                           ON DELETE CASCADE
) ENGINE = InnoDB;

/* 6. Rol específico: Revisor */
CREATE TABLE Revisor (
                         id_usuario        INT PRIMARY KEY,
                         institucion       VARCHAR(255),
                         fecha_designacion DATETIME,
                         FOREIGN KEY (id_usuario)
                             REFERENCES Usuario(id_usuario)
                             ON DELETE CASCADE
) ENGINE = InnoDB;
/* 7. Tabla Articulo -------------------------------------------- */
CREATE TABLE Articulo (
                          id_articulo       INT AUTO_INCREMENT PRIMARY KEY,
                          titulo            VARCHAR(300)  NOT NULL,
                          fecha_envio       DATE          NOT NULL,
                          resumen           TEXT          NOT NULL,
                          topicos           VARCHAR(255),         -- por normalizar más adelante
                          autor_contacto    INT           NOT NULL,            -- FK a Usuario
                          fecha_limite_envio DATE         NOT NULL,
                          CONSTRAINT fk_articulo_autor_contacto
                              FOREIGN KEY (autor_contacto)
                                  REFERENCES Usuario(id_usuario)
                                  ON DELETE RESTRICT,
                          UNIQUE (titulo, autor_contacto)          -- evita títulos duplicados por mismo autor
) ENGINE = InnoDB;

/* 8. Tabla AutorArt (relación N-a-N artículo–autor) ------------- */
CREATE TABLE AutorArt (
                          id_articulo INT NOT NULL,
                          id_usuario  INT NOT NULL,
                          orden_autor SMALLINT NOT NULL,
                          afiliacion_local   VARCHAR(255),
                          email_secundario   VARCHAR(255),
                          PRIMARY KEY (id_articulo, id_usuario),
                          CONSTRAINT fk_autorart_articulo
                              FOREIGN KEY (id_articulo)
                                  REFERENCES Articulo(id_articulo)
                                  ON DELETE CASCADE,
                          CONSTRAINT fk_autorart_usuario
                              FOREIGN KEY (id_usuario)
                                  REFERENCES Usuario(id_usuario)
                                  ON DELETE CASCADE
) ENGINE = InnoDB;
/* 9. Tabla Reseña ------------------------------------------------- */
CREATE TABLE Reseña (
                        id_reseña        INT AUTO_INCREMENT PRIMARY KEY,
                        id_articulo      INT  NOT NULL,
                        id_revisor       INT  NOT NULL,
                        fecha_asignacion DATE NOT NULL,
                        fecha_envio      DATE,
                        decision         VARCHAR(30),
                        comentario       TEXT,
                        puntaje          TINYINT,

                        CONSTRAINT fk_reseña_articulo
                            FOREIGN KEY (id_articulo)
                                REFERENCES Articulo(id_articulo)
                                ON DELETE CASCADE,

                        CONSTRAINT fk_reseña_revisor
                            FOREIGN KEY (id_revisor)
                                REFERENCES Revisor(id_usuario)
                                ON DELETE CASCADE
) ENGINE = InnoDB;
/* 10. Tabla Estado (catálogo) ------------------------------------ */
CREATE TABLE Estado (
                        id_estado      INT AUTO_INCREMENT PRIMARY KEY,
                        nombre         VARCHAR(40)  NOT NULL UNIQUE,
                        descripcion    VARCHAR(255),
                        orden_visual   SMALLINT     NOT NULL
) ENGINE = InnoDB;

/* 11. Tabla HistEstado (historial de estados) -------------------- */
CREATE TABLE HistEstado (
                            id_articulo INT      NOT NULL,
                            fecha       DATETIME NOT NULL,
                            id_estado   INT      NOT NULL,
                            observacion VARCHAR(255),

                            PRIMARY KEY (id_articulo, fecha),

                            CONSTRAINT fk_hist_estado_articulo
                                FOREIGN KEY (id_articulo)
                                    REFERENCES Articulo(id_articulo)
                                    ON DELETE CASCADE,

                            CONSTRAINT fk_hist_estado_estado
                                FOREIGN KEY (id_estado)
                                    REFERENCES Estado(id_estado)
                                    ON DELETE RESTRICT
) ENGINE = InnoDB;

/* 7. Índices recomendados */
CREATE INDEX idx_usuario_email ON Usuario(email);
