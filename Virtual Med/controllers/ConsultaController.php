<?php

include_once 'models/ConsultaModel.php';



class ConsultaController {
    private $db;
    private $consulta;

    public function __construct($db) {
        $this->db = $db;
        $this->consulta = new ConsultaModel($db);
    }

    public function index() {
        $consultas = $this->consulta->read();
        include 'views/consulta/index.php';
    }

    public function salvarConsulta() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paciente_id = $_SESSION['user_role'] === 'paciente' ? $_SESSION['user_id'] : $_POST['paciente_id'];
            $doutor_id = $_SESSION['user_role'] === 'doutor' ? $_SESSION['user_id'] : $_POST['doutor_id'];
            $data = $_POST['data'];
            $hora = $_POST['hora'];
            $detalhes = $_POST['detalhes'];
        
            $data_hora = $data . ' ' . $hora;
        
            $sql = "INSERT INTO consultas (paciente_id, doutor_id, data_hora, detalhes) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$paciente_id, $doutor_id, $data_hora, $detalhes]);
        
            if ($result) {
                header('Location: index.php?action=visualizar_consultas');
                return true;
            }
        }
        return false;
    }

    public function getPacientes() {
        $query = "SELECT id, nome FROM usuarios WHERE tipo = 'paciente'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function visualizar($id) {
        $consultas = $this->consulta->buscarTodasConsultas($_SESSION['user_id']);
        require_once 'views/consulta/visualizar.php';
    }
      public function editar($id) {
          $consulta = $this->consulta->buscarPorId($id);
          $pacientes = $this->getPacientes();
          require_once 'views/consulta/editar.php';
      }

      public function atualizar($dados) {
          $dataHora = $dados['data'] . ' ' . $dados['hora'];
          $dadosAtualizados = [
              'id' => $dados['id'],
              'paciente_id' => $dados['paciente_id'],
              'data_hora' => $dataHora,
              'detalhes' => $dados['detalhes']
          ];
        
          if($this->consulta->atualizar($dadosAtualizados)) {
              header('Location: index.php?action=visualizar_consultas');
              exit();
          }
      }
    public function excluir($id) {
        if($this->consulta->excluir($id)) {
            header('Location: index.php?action=visualizar_consultas');
            exit();
        }
    }

    public function resumoDiario() {
        $hoje = date('Y-m-d');
        $query = "SELECT c.*, u.nome as nome_paciente, 
                  TIME(c.data_hora) as hora
                  FROM consultas c
                  JOIN usuarios u ON c.paciente_id = u.id
                  WHERE DATE(c.data_hora) = ?
                  AND c.doutor_id = ?
                  ORDER BY c.data_hora ASC";
                  
        $stmt = $this->db->prepare($query);
        $stmt->execute([$hoje, $_SESSION['user_id']]);
        $consultas_dia = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'views/consulta/resumo.php';
    }

    public function getDoutores() {
        $query = "SELECT d.id, u.nome, d.especialidade 
                  FROM doutores d 
                  JOIN usuarios u ON d.usuario_id = u.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function agendarConsulta() {
        $doutores = $this->getDoutores();
        require_once 'views/paciente/agendar_consulta.php';
    }
    
    public function getConsultasPaciente($pacienteId) {
        $query = "SELECT c.id, c.data_hora as data,
        u.nome as nome_paciente,
        d.especialidade,
        c.detalhes as detalhes
        FROM consultas c
        JOIN usuarios u ON c.paciente_id = u.id
        LEFT JOIN doutores d ON c.doutor_id = d.usuario_id
        WHERE c.doutor_id = ? OR c.paciente_id = ?
        ORDER BY c.data_hora DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$pacienteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function cancelarConsulta($id) {
        $query = "UPDATE consultas SET status = 'cancelada' WHERE id = ? AND paciente_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id, $_SESSION['user_id']]);
    }
    
    public function getConsultasDoutor($doutorId) {
        $query = "SELECT c.*, u.nome as nome_paciente 
                  FROM consultas c 
                  JOIN usuarios u ON c.paciente_id = u.id 
                  WHERE c.doutor_id = ? 
                  ORDER BY c.data_hora ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$doutorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function concluirConsulta($id) {
        $query = "UPDATE consultas SET status = 'concluida' WHERE id = ? AND doutor_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id, $_SESSION['user_id']]);
    }
    
    public function buscarTodasConsultas($userId) {
        if ($_SESSION['user_role'] === 'doutor') {
            $query = "SELECT c.*, u.nome as nome_paciente 
                    FROM consultas c 
                    JOIN usuarios u ON c.paciente_id = u.id 
                    WHERE c.doutor_id = ? 
                    ORDER BY c.data_hora ASC";
        } else {
            $query = "SELECT c.*, u.nome as nome_doutor, d.especialidade 
                    FROM consultas c 
                    JOIN usuarios u ON c.doutor_id = u.id 
                    JOIN doutores d ON u.id = d.usuario_id 
                    WHERE c.paciente_id = ? 
                    ORDER BY c.data_hora ASC";
        }
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function cancelarConsultaDoutor($id) {
        $query = "UPDATE consultas SET status = 'cancelada' WHERE id = ? AND doutor_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id, $_SESSION['user_id']]);
    }

    public function salvarConsultaPaciente() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $doutor_id = $_POST['doutor_id'];
            $data = $_POST['data'];
            $hora = $_POST['hora'];
            $detalhes = $_POST['detalhes'];
            
            // Combine date and time
            $data_hora = $data . ' ' . $hora;
            
            // Check for existing appointments
            $sql = "SELECT * FROM consultas WHERE doutor_id = ? AND data_hora = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$doutor_id, $data_hora]);
            
            if ($stmt->rowCount() > 0) {
                $_SESSION['erro'] = "Horário já ocupado para este médico.";
                header('Location: index.php?action=agendar_consulta');
                exit;
            }
            
            // Insert the appointment
            $sql = "INSERT INTO consultas (paciente_id, doutor_id, data_hora, detalhes) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$_SESSION['user_id'], $doutor_id, $data_hora, $detalhes]);
            
            header('Location: index.php?action=visualizar_consultas');
            exit;
        }
    }
    
    
}
?>
