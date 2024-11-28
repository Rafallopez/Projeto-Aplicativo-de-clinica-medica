<?php
class ChatModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getMensagens($userId1, $userId2) {
        $query = "SELECT m.*, u.nome as nome_remetente 
                 FROM mensagens m 
                 JOIN usuarios u ON m.remetente_id = u.id 
                 WHERE (remetente_id = ? AND destinatario_id = ?) 
                 OR (remetente_id = ? AND destinatario_id = ?) 
                 ORDER BY data_envio ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId1, $userId2, $userId2, $userId1]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function enviarMensagem($remetenteId, $destinatarioId, $mensagem) {
        $query = "INSERT INTO mensagens (remetente_id, destinatario_id, mensagem) 
                 VALUES (?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$remetenteId, $destinatarioId, $mensagem]);
    }
}
