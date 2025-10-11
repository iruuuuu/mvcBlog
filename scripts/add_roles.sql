-- Script para agregar roles al sistema
USE blog;

-- Agregar columna role a la tabla user
ALTER TABLE user ADD COLUMN role ENUM('admin', 'user') DEFAULT 'user' NOT NULL;

-- Actualizar usuarios existentes
-- El primer usuario (admin) será administrador
UPDATE user SET role = 'admin' WHERE username = 'admin';

-- Los demás usuarios serán usuarios normales
UPDATE user SET role = 'user' WHERE username != 'admin';
