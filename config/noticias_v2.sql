SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS auditoria, usuario_rol, noticias, roles, usuarios, parametros;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL
);
INSERT INTO roles (id, nombre_rol) VALUES (1, 'Editor'), (2, 'Validador');

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE usuario_rol (
    usuario_id INT,
    rol_id INT,
    PRIMARY KEY (usuario_id, rol_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (rol_id) REFERENCES roles(id) ON DELETE CASCADE
);

CREATE TABLE noticias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    resumen VARCHAR(200),
    descripcion TEXT NOT NULL,
    imagen VARCHAR(255) DEFAULT NULL,
    estado ENUM('Borrador', 'Lista para Validación', 'Para Corrección', 'Publicada', 'Expirada', 'Anulada') DEFAULT 'Borrador',
    autor_id INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_publicacion DATETIME DEFAULT NULL,
    fecha_expiracion DATETIME DEFAULT NULL,
    FOREIGN KEY (autor_id) REFERENCES usuarios(id)
);

CREATE TABLE auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    noticia_id INT,
    usuario_id INT,
    estado_anterior VARCHAR(50),
    estado_nuevo VARCHAR(50),
    observacion TEXT,
    fecha_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (noticia_id) REFERENCES noticias(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE parametros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_parametro VARCHAR(50),
    valor VARCHAR(10)
);
INSERT INTO parametros (nombre_parametro, valor) VALUES ('dias_expiracion', '30'), ('max_file_size', '2048');