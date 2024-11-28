<?php
include_once 'models/ChatModel.php';

class ChatController {
    private $db;
    private $chatModel;

    public function __construct($db) {
        $this->db = $db;
        $this->chatModel = new ChatModel($db);
    }

    public function index($userId) {
        $query = "SELECT u.id, u.nome, u.tipo 
                 FROM usuarios u 
                 WHERE u.tipo != ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$_SESSION['user_role']]);
        $contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'views/chat/index.php';
    }

    public function conversa($destinatarioId) {
        $mensagens = $this->chatModel->getMensagens($_SESSION['user_id'], $destinatarioId);
        require_once 'views/chat/conversa.php';
    }

    public function enviarMensagem() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $remetenteId = $_SESSION['user_id'];
            $destinatarioId = $_POST['destinatario_id'];
            $mensagem = $_POST['mensagem'];
            
            $this->chatModel->enviarMensagem($remetenteId, $destinatarioId, $mensagem);
            header("Location: index.php?action=chat_conversa&id=$destinatarioId");
        }
    }
}
