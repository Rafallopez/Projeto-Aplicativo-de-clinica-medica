<?php

class PacienteController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getConsultas($pacienteId) {
        $query = "SELECT c.*, u.nome as nome_doutor, d.especialidade 
                 FROM consultas c 
                 INNER JOIN doutores d ON c.doutor_id = d.id 
                 INNER JOIN usuarios u ON d.usuario_id = u.id 
                 WHERE c.paciente_id = ? 
                 ORDER BY c.data_hora ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$pacienteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agendarConsulta($pacienteId, $doutorId, $dataHora) {
        $query = "INSERT INTO consultas (paciente_id, doutor_id, data_hora) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        
        if ($stmt->execute([$pacienteId, $doutorId, $dataHora])) {
            return "Consulta agendada com sucesso!";
        }
        return "Erro ao agendar consulta.";
    }

    public function getDoutoresDisponiveis() {
        $query = "SELECT d.id, u.nome, d.especialidade 
                 FROM doutores d 
                 INNER JOIN usuarios u ON d.usuario_id = u.id";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cancelarConsulta($consultaId) {
        $query = "UPDATE consultas SET status = 'cancelada' WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$consultaId]);
    }

    public function perfil() {
        $query = "SELECT u.*, p.data_nascimento, p.plano_saude 
                  FROM usuarios u 
                  LEFT JOIN pacientes p ON p.usuario_id = u.id 
                  WHERE u.id = ? AND u.tipo = 'paciente'";
            
        $stmt = $this->db->prepare($query);
        $stmt->execute([$_SESSION['user_id']]);
        $paciente = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$paciente) {
            header('Location: index.php?action=painel_paciente');
            exit();
        }
            
        require_once 'views/paciente/perfil.php';
    }
    
    public function atualizarPerfil($dados) {
        if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro'] = "Email inválido";
            header('Location: index.php?action=perfil');
            return;
        }
    
        $query = "UPDATE usuarios SET email = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$dados['email'], $_SESSION['user_id']]);
    
        if (!empty($dados['nova_senha'])) {
            $query = "UPDATE usuarios SET senha = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$dados['nova_senha'], $_SESSION['user_id']]);
        }
    
        $_SESSION['sucesso'] = "Perfil atualizado com sucesso!";
        header('Location: index.php?action=perfil');
    }
    
    public function infoEmergencia() {
        $query = "SELECT * FROM info_emergencia WHERE paciente_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$_SESSION['user_id']]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);
        
        require_once 'views/paciente/info_emergencia.php';
    }
    
    public function salvarInfoEmergencia($dados) {
        $query = "INSERT INTO info_emergencia 
                  (paciente_id, tipo_sanguineo, alergias, medicamentos, condicoes_medicas, 
                   contato_emergencia_1_nome, contato_emergencia_1_telefone,
                   contato_emergencia_2_nome, contato_emergencia_2_telefone, 
                   observacoes) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                  ON DUPLICATE KEY UPDATE 
                  tipo_sanguineo = VALUES(tipo_sanguineo),
                  alergias = VALUES(alergias),
                  medicamentos = VALUES(medicamentos),
                  condicoes_medicas = VALUES(condicoes_medicas),
                  contato_emergencia_1_nome = VALUES(contato_emergencia_1_nome),
                  contato_emergencia_1_telefone = VALUES(contato_emergencia_1_telefone),
                  contato_emergencia_2_nome = VALUES(contato_emergencia_2_nome),
                  contato_emergencia_2_telefone = VALUES(contato_emergencia_2_telefone),
                  observacoes = VALUES(observacoes)";
    
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute([
            $_SESSION['user_id'],
            $dados['tipo_sanguineo'],
            $dados['alergias'],
            $dados['medicamentos'],
            $dados['condicoes_medicas'],
            $dados['contato_emergencia_1_nome'],
            $dados['contato_emergencia_1_telefone'],
            $dados['contato_emergencia_2_nome'],
            $dados['contato_emergencia_2_telefone'],
            $dados['observacoes']
        ]);
    
        if ($result) {
            $_SESSION['sucesso'] = "Informações de emergência atualizadas com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao atualizar informações de emergência.";
        }
        
        header('Location: index.php?action=info_emergencia');
    }
    
    public function verInfoEmergencia() {
        $query = "SELECT * FROM info_emergencia WHERE paciente_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$_SESSION['user_id']]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);
        
        require_once 'views/paciente/info_emergencia_view.php';
    }
    
    public function editarInfoEmergencia() {
        $query = "SELECT * FROM info_emergencia WHERE paciente_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$_SESSION['user_id']]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);
        
        require_once 'views/paciente/info_emergencia_edit.php';
    }
    
}
