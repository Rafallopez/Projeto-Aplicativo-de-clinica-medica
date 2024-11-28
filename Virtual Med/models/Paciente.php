<?php

class Paciente {
    private $db;
    private $table = 'pacientes';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDadosPaciente($usuarioId) {
        $query = "SELECT p.*, u.nome, u.email 
                 FROM " . $this->table . " p
                 INNER JOIN usuarios u ON p.usuario_id = u.id 
                 WHERE p.usuario_id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$usuarioId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarDados($id, $dados) {
        $query = "UPDATE " . $this->table . " 
                 SET data_nascimento = ?, plano_saude = ? 
                 WHERE id = ?";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$dados['data_nascimento'], $dados['plano_saude'], $id]);
    }

    public function getHistoricoConsultas($pacienteId) {
        $query = "SELECT c.*, u.nome as nome_doutor, d.especialidade 
                 FROM consultas c 
                 INNER JOIN doutores d ON c.doutor_id = d.id 
                 INNER JOIN usuarios u ON d.usuario_id = u.id 
                 WHERE c.paciente_id = ? 
                 ORDER BY c.data_hora DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$pacienteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
