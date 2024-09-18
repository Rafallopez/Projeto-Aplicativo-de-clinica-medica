CREATE DATABASE clinica;

USE clinica;

-- Tabela de usuários (médicos e pacientes)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    role ENUM('medico', 'paciente') NOT NULL
);

-
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('medico', 'paciente') NOT NULL
);

CREATE TABLE IF NOT EXISTS consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medico_id INT NOT NULL,
    paciente_id INT NOT NULL,
    data DATE NOT NULL,
    hora TIME NOT NULL,
    detalhes_paciente TEXT,
    FOREIGN KEY (medico_id) REFERENCES usuarios(id),
    FOREIGN KEY (paciente_id) REFERENCES usuarios(id),
    UNIQUE KEY (medico_id, data, hora),
    UNIQUE KEY (paciente_id, data, hora)
);

drop table consultas;


-- Inserindo médicos
INSERT INTO usuarios (username, password, nome, email, telefone, role) VALUES
('medico1', MD5('senhaMedico1'), 'Dr. João Silva', 'joao@clinica.com', '1111-1111', 'medico'),
('medico2', MD5('senhaMedico2'), 'Dr. Maria Souza', 'maria@clinica.com', '2222-2222', 'medico'),
('medico3', MD5('senhaMedico3'), 'Dr. Carlos Oliveira', 'carlos@clinica.com', '3333-3333', 'medico');

-- Inserindo pacientes
INSERT INTO usuarios (username, password, nome, email, telefone, role) VALUES
('paciente1', MD5('senhaPaciente1'), 'Ana Pereira', 'ana@clinica.com', '4444-4444', 'paciente'),
('paciente2', MD5('senhaPaciente2'), 'José Costa', 'jose@clinica.com', '5555-5555', 'paciente'),
('paciente3', MD5('senhaPaciente3'), 'Mariana Lima', 'mariana@clinica.com', '6666-6666', 'paciente');

select * from usuarios;