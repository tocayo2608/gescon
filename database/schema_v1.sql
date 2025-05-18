
DROP  DATABASE IF EXISTS gescon;
CREATE DATABASE gescon
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE gescon;


CREATE TABLE Usuario (
                         id_usuario      INT AUTO_INCREMENT PRIMARY KEY,
                         nombre          VARCHAR(100)  NOT NULL,
                         email           VARCHAR(255)  NOT NULL UNIQUE,
                         password_hash   CHAR(60)      NOT NULL,   -- bcrypt
                         fecha_registro  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         activo          BOOLEAN       NOT NULL DEFAULT TRUE
) ENGINE = InnoDB;


CREATE TABLE Rol (
                     id_rol INT AUTO_INCREMENT PRIMARY KEY,
                     nombre VARCHAR(20) NOT NULL UNIQUE
) ENGINE = InnoDB;


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


CREATE TABLE Autor (
                       id_usuario INT PRIMARY KEY,
                       afiliacion VARCHAR(255),
                       orcid      VARCHAR(19),
                       FOREIGN KEY (id_usuario)
                           REFERENCES Usuario(id_usuario)
                           ON DELETE CASCADE
) ENGINE = InnoDB;


CREATE TABLE Revisor (
                         id_usuario        INT PRIMARY KEY,
                         institucion       VARCHAR(255),
                         fecha_designacion DATETIME,
                         FOREIGN KEY (id_usuario)
                             REFERENCES Usuario(id_usuario)
                             ON DELETE CASCADE
) ENGINE = InnoDB;


CREATE INDEX idx_usuario_email ON Usuario(email);
