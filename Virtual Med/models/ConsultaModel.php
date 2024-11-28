<?php
class ConsultaModel {
    private $conn;
    private $table_name = "consultas";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT c.id, c.data, c.hora, u.name as nome_paciente 
                 FROM " . $this->table_name . " c
                 JOIN users u ON c.paciente_id = u.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create($data, $hora, $paciente_id) {
        $query = "INSERT INTO " . $this->table_name . " (data, hora, paciente_id) 
                 VALUES (:data, :hora, :paciente_id)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":data", $data);
        $stmt->bindParam(":hora", $hora);
        $stmt->bindParam(":paciente_id", $paciente_id);

        return $stmt->execute();
    }

    public function buscarPorId($id) {
        $query = "SELECT * FROM consultas WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($dados) {
        $query = "UPDATE consultas 
                  SET paciente_id = ?, data_hora = ?, detalhes = ? 
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $dados['paciente_id'],
            $dados['data_hora'],
            $dados['detalhes'],
            $dados['id']
        ]);
    }

    public function excluir($id) {
        $query = "DELETE FROM consultas WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

public function buscarTodasConsultas($userId) {
    $query = "SELECT c.id, c.data_hora as data,
              u.nome as nome_paciente,
              d.especialidade,
              c.detalhes as detalhes
              FROM consultas c
              JOIN usuarios u ON c.paciente_id = u.id
              LEFT JOIN doutores d ON c.doutor_id = d.usuario_id
              WHERE c.doutor_id = ? OR c.paciente_id = ?
              ORDER BY c.data_hora DESC";

    $stmt = $this->conn->prepare($query);
    $stmt->execute([$userId, $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}

