<?php

class AuthController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login($email, $senha) {
        error_log("Login attempt - Email: " . $email);
        
        $query = "SELECT id, nome, email, senha, tipo FROM usuarios WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        error_log("User found: " . ($usuario ? 'Yes' : 'No'));
        
        if ($usuario && $senha === $usuario['senha']) {
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_role'] = $usuario['tipo'];
            $_SESSION['user_name'] = $usuario['nome'];
            
            error_log("Login successful - Role: " . $usuario['tipo']);
            
            if ($usuario['tipo'] === 'doutor') {
                header('Location: index.php?action=painel_doutor');
                exit();
            } else {
                header('Location: index.php?action=painel_paciente');
                exit();
            }
        }
        
        error_log("Login failed - Invalid credentials");
        return "Email ou senha inválidos";
    }}
?>