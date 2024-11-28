CREATE DATABASE IF NOT EXISTS VirtualMed;
USE VirtualMed;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('paciente', 'doutor') NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE doutores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    crm VARCHAR(20) NOT NULL,
    especialidade VARCHAR(100) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    data_nascimento DATE NOT NULL,
    plano_saude VARCHAR(100),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doutor_id INT NOT NULL,
    paciente_id INT NOT NULL,
    data_hora DATETIME NOT NULL,
    status ENUM('agendada', 'concluida', 'cancelada') DEFAULT 'agendada',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (doutor_id) REFERENCES usuarios(id),
    FOREIGN KEY (paciente_id) REFERENCES usuarios(id)
);

ALTER TABLE consultas ADD COLUMN detalhes TEXT AFTER data_hora;



drop table consultas;

-- Inserindo usuários (doutores)
INSERT INTO usuarios (nome, email, senha, tipo) VALUES
('Dr. Carlos Silva', 'carlos.silva@virtualmed.com', '$2y$10$abcdefghijklmnopqrstuv', 'doutor'),
('Dra. Maria Santos', 'maria.santos@virtualmed.com', '$2y$10$abcdefghijklmnopqrstuv', 'doutor'),
('Dr. João Oliveira', 'joao.oliveira@virtualmed.com', '$2y$10$abcdefghijklmnopqrstuv', 'doutor');

-- Inserindo doutores
INSERT INTO doutores (usuario_id, crm, especialidade) VALUES
(1, '123456-SP', 'Cardiologia'),
(2, '234567-SP', 'Dermatologia'),
(3, '345678-SP', 'Ortopedia');

-- Inserindo usuários (pacientes)
INSERT INTO usuarios (nome, email, senha, tipo) VALUES
('Ana Pereira', 'ana.pereira@email.com', '123', 'paciente'),
('Pedro Costa', 'pedro.costa@email.com', '123', 'paciente'),
('Lucia Mendes', 'lucia.mendes@email.com', '123', 'paciente'),
('Roberto Alves', 'roberto.alves@email.com', '123', 'paciente');

drop table usuarios;

-- Inserindo pacientes
INSERT INTO pacientes (usuario_id, data_nascimento, plano_saude) VALUES
(4, '1990-05-15', 'Unimed'),
(5, '1985-08-22', 'Bradesco Saúde'),
(6, '1995-03-10', 'SulAmérica'),
(7, '1978-12-01', 'Amil');

-- Inserindo algumas consultas
INSERT INTO consultas (paciente_id, doutor_id, data_hora, status) VALUES
(1, 1, '2024-01-20 14:30:00', 'agendada'),
(2, 2, '2024-01-21 10:00:00', 'agendada'),
(3, 3, '2024-01-22 15:45:00', 'agendada'),
(4, 1, '2024-01-23 09:15:00', 'agendada');



-- Insert test user (password: 123456)
INSERT INTO usuarios (nome, email, senha, tipo) VALUES 
('Test Doctor', 'doctor@test.com', '123456', 'doutor'),
('Test Patient', 'patient@test.com', '123456', 'paciente');

CREATE TABLE mensagens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    remetente_id INT,
    destinatario_id INT,
    mensagem TEXT,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    lida BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (remetente_id) REFERENCES usuarios(id),
    FOREIGN KEY (destinatario_id) REFERENCES usuarios(id)
);

CREATE TABLE info_emergencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT,
    tipo_sanguineo VARCHAR(5),
    alergias TEXT,
    medicamentos TEXT,
    condicoes_medicas TEXT,
    contato_emergencia_1_nome VARCHAR(100),
    contato_emergencia_1_telefone VARCHAR(20),
    contato_emergencia_2_nome VARCHAR(100),
    contato_emergencia_2_telefone VARCHAR(20),
    observacoes TEXT,
    FOREIGN KEY (paciente_id) REFERENCES usuarios(id)
);
