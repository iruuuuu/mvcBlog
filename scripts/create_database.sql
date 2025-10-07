-- SQL script to create the blog database and tables

CREATE DATABASE IF NOT EXISTS blog;
USE blog;

-- User table
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Post table
-- Renamed 'date' column to 'created_at' to avoid MySQL reserved keyword issues
CREATE TABLE IF NOT EXISTS post (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    text TEXT NOT NULL,
    author VARCHAR(50) NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

-- Insert sample users for testing
-- Password for all users is 'admin123' (hashed with MD5: 0192023a7bbd73250516f069df18b500)
INSERT INTO user (username, password) VALUES 
('admin', '0192023a7bbd73250516f069df18b500'),
('usuario1', '0192023a7bbd73250516f069df18b500'),
('juan', '0192023a7bbd73250516f069df18b500');

-- Insert sample posts for testing
INSERT INTO post (title, created_at, text, author, user_id) VALUES 
('Mi primer post', NOW(), 'Este es mi primer post en el blog. ¡Bienvenidos a todos!', 'admin', 1),
('Aprendiendo PHP', NOW(), 'Hoy estoy aprendiendo PHP y MVC. Es muy interesante cómo se estructura el código.', 'usuario1', 2),
('Blog funcional', NOW(), 'El blog ya está funcionando correctamente. Ahora puedo publicar posts fácilmente.', 'admin', 1);

-- Comentario table
CREATE TABLE comentarios (
    id INT NOT NULL AUTO_INCREMENT,
    texto TEXT NOT NULL, -- Agregamos un campo para el contenido del comentario
    post_id INT NOT NULL, -- Clave foránea para la tabla 'post'
    user_id INT NOT NULL, -- Clave foránea para la tabla 'user' (el autor del comentario)
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Opcional: para saber cuándo se hizo el comentario

    PRIMARY KEY (id),

    -- Define la clave foránea para el post
    FOREIGN KEY (post_id) REFERENCES post(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    -- Define la clave foránea para el usuario (autor del comentario)
    FOREIGN KEY (user_id) REFERENCES user(id)
        ON DELETE RESTRICT -- Recomendado: no permitir eliminar un usuario si tiene comentarios
        ON UPDATE CASCADE
);


-- Insertar comentarios de ejemplo
INSERT INTO comentarios (texto, post_id, user_id, fecha_creacion) VALUES
-- Comentarios para el Post 1 ('Mi primer post')
('¡Felicidades por tu primer post! Se ve muy bien el blog.', 1, 2, NOW()), -- Comentario de 'usuario1'
('Me parece un excelente inicio, espero ver más contenido pronto.', 1, 3, NOW()), -- Comentario de 'juan'

-- Comentarios para el Post 2 ('Aprendiendo PHP')
('El enfoque MVC es el camino correcto. ¡Sigue así con PHP!', 2, 1, NOW()), -- Comentario de 'admin'

-- Comentarios para el Post 3 ('Blog funcional')
('Es genial que ya esté todo operativo. ¡A publicar!', 3, 2, NOW()); -- Comentario de 'usuario1'