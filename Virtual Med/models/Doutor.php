<?php

class Doutor {
    private $db;
    private $table = 'doutores';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDadosDoutor($usuarioId) {
        $query = "SELECT d.*, u.nome, u.email 
                 FROM " . $this->table . " d
                 INNER JOIN usuarios u ON d.usuario_id = u.id 
                 WHERE d.usuario_id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$usuarioId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarDados($id, $dados) {
        $query = "UPDATE " . $this->table . " 
                 SET especialidade = ?, crm = ? 
                 WHERE id = ?";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$dados['especialidade'], $dados['crm'], $id]);
    }
}
