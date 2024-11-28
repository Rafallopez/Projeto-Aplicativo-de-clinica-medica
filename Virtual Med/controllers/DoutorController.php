<?php

class DoutorController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getConsultas($doutorId) {
        $query = "SELECT c.*, u.nome as nome_paciente, p.plano_saude 
                 FROM consultas c 
                 INNER JOIN pacientes p ON c.paciente_id = p.id 
                 INNER JOIN usuarios u ON p.usuario_id = u.id 
                 WHERE c.doutor_id = ? 
                 ORDER BY c.data_hora ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$doutorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizarStatusConsulta($consultaId, $status) {
        $query = "UPDATE consultas SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$status, $consultaId]);
    }

    public function getProntuarios($pacienteId) {
        $query = "SELECT * FROM prontuarios WHERE paciente_id = ? ORDER BY data_registro DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$pacienteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarProntuario($pacienteId, $descricao, $prescricao) {
        $query = "INSERT INTO prontuarios (paciente_id, descricao, prescricao) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$pacienteId, $descricao, $prescricao]);
    }

    public function visualizarBancoDados() {
        $query = "SELECT u.nome, u.email, p.data_nascimento, p.plano_saude,
                  GROUP_CONCAT(DISTINCT c.data_hora) as consultas_anteriores,
                  GROUP_CONCAT(DISTINCT m.mensagem) as historico_mensagens
                  FROM usuarios u
                  JOIN pacientes p ON u.id = p.usuario_id
                  LEFT JOIN consultas c ON u.id = c.paciente_id
                  LEFT JOIN mensagens m ON u.id = m.remetente_id OR u.id = m.destinatario_id
                  WHERE u.tipo = 'paciente'
                  GROUP BY u.id";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'views/doutor/banco_dados_pacientes.php';
    }
            public function perfil() {
$query = "SELECT u.*, d.crm, d.especialidade 
          FROM usuarios u 
          LEFT JOIN doutores d ON d.usuario_id = u.id 
          WHERE u.id = ? AND u.tipo = 'doutor'";
    
$stmt = $this->db->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$doutor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$doutor) {
    header('Location: index.php?action=painel_doutor');
    exit();
}
    
require_once 'views/doutor/perfil.php';
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
     
}

