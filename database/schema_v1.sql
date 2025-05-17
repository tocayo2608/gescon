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

/* 7. Índices recomendados */
CREATE INDEX idx_usuario_email ON Usuario(email);
