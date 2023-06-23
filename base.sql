CREATE DATABASE requerimentos;
USE requerimentos;

CREATE TABLE usuario (
    id BIGINT(12) UNSIGNED PRIMARY KEY,
    nome CHAR(255) NOT NULL,
    email CHAR(255) NOT NULL,
    fone BIGINT(11) UNSIGNED,
    curso INT(1) NOT NULL,
    turma INT(1),
    superuser BOOLEAN DEFAULT 0,
    psswd char(255) NOT NULL
);

CREATE TABLE requerimento (
    id INT PRIMARY KEY AUTO_INCREMENT,
    objeto INT(1) NOT NULL,
    inicio DATE NOT NULL,
    termino DATE NOT NULL,
    registro DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    anexo LONGBLOB NOT NULL,
    obs CHAR(255),
    situacao INT(1) NOT NULL,
    usuario_id BIGINT(12) UNSIGNED,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

CREATE TABLE docente (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome CHAR(255) NOT NULL
);

CREATE TABLE falta (
    faltas INT(1),
    requerimento_id INT,
    docente_id INT,
    FOREIGN KEY (requerimento_id) REFERENCES requerimento(id),
    FOREIGN KEY (docente_id) REFERENCES docente(id)
);
