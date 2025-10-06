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
