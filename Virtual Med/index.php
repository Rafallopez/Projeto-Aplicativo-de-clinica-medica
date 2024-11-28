<?php
session_start();

include_once 'config/Database.php';
include_once 'controllers/AuthController.php';
include_once 'controllers/DoutorController.php';
include_once 'controllers/PacienteController.php';
include_once 'controllers/ConsultaController.php';
include_once 'controllers/ChatController.php';

// Arquivo principal que gerencia todas as rotas e ações do sistema
// Inicia a sessão e inclui os arquivos necessários
// Controla o fluxo da aplicação baseado na ação requisitada (action)


$database = new Database();
$db = $database->getConnection();

function verificarAuth() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?action=login');
        exit();
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : 'login';

switch ($action) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController = new AuthController($db);
            $mensagem = $authController->login($_POST['email'], $_POST['senha']);
            if ($mensagem) {
                $_SESSION['erro'] = $mensagem;
                header('Location: index.php?action=login');
                exit();
            }
        } else {
            include 'views/auth/login.php';
        }
        break;

    case 'painel_doutor':
        verificarAuth();
        if ($_SESSION['user_role'] !== 'doutor') {
            header('Location: index.php?action=login');
            exit();
        }
        $doutorController = new DoutorController($db);
        $consultas = $doutorController->getConsultas($_SESSION['user_id']);
        include 'views/doutor/painel.php';
        break;

    case 'painel_paciente':
        verificarAuth();
        if ($_SESSION['user_role'] !== 'paciente') {
            header('Location: index.php?action=login');
            exit();
        }
        $pacienteController = new PacienteController($db);
        $consultas = $pacienteController->getConsultas($_SESSION['user_id']);
        include 'views/paciente/painel.php';
        break;

    case 'sair':
        session_destroy();
        header('Location: index.php?action=login');
        break;

    case 'agendar_consulta':
        verificarAuth();
        $consultaController = new ConsultaController($db);
        
        if ($_SESSION['user_role'] === 'doutor') {
            $pacientes = $consultaController->getPacientes();
            include 'views/consulta/create.php';
        } else {
            $doutores = $consultaController->getDoutores();
            include 'views/paciente/agendar_consulta.php';
        }
        break;

    case 'salvar_consulta':
        verificarAuth();
        $consultaController = new ConsultaController($db);
        $data = [
            'doutor_id' => $_POST['doutor_id'],
            'paciente_id' => $_SESSION['user_id'],
            'data' => $_POST['data'],
            'hora' => $_POST['hora'],
            'detalhes' => $_POST['detalhes']
        ];
        if($consultaController->salvarConsulta()) {
            header('Location: index.php?action=visualizar_consultas');
        }        break;

    case 'visualizar_consultas':
        verificarAuth();
        $consultaController = new ConsultaController($db);
        $consultas = $consultaController->buscarTodasConsultas($_SESSION['user_id']);
        
        if ($_SESSION['user_role'] === 'doutor') {
            include 'views/doutor/visualizar_consultas.php';
        } else {
            include 'views/paciente/minhas_consultas.php';
        }
        break;

    case 'concluir_consulta':
        verificarAuth();
        if ($_SESSION['user_role'] === 'doutor') {
            $consultaController = new ConsultaController($db);
            $consultaController->concluirConsulta($_GET['id']);
            header('Location: index.php?action=visualizar_consultas');
        }
        break;

    case 'editar_consulta':
        verificarAuth();
        $consultaController = new ConsultaController($db);
        $id = $_GET['id'];
        $consultaController->editar($id);
        break;

    case 'atualizar_consulta':
        verificarAuth();
        $consultaController = new ConsultaController($db);
        $consultaController->atualizar($_POST);
        break;
        
    case 'excluir_consulta':
        verificarAuth();
        $consultaController = new ConsultaController($db);
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $consultaController->excluir($id);
        break;
     
    case 'chat':
        verificarAuth();
        $chatController = new ChatController($db);
        $chatController->index($_SESSION['user_id']);
        break;

    case 'chat_conversa':
        verificarAuth();
        $chatController = new ChatController($db);
        $chatController->conversa($_GET['id']);
        break;

    case 'enviar_mensagem':
        verificarAuth();
        $chatController = new ChatController($db);
        $chatController->enviarMensagem();
        break;

    case 'banco_dados_pacientes':
        verificarAuth();
        if ($_SESSION['user_role'] === 'doutor') {
            $doutorController = new DoutorController($db);
            $doutorController->visualizarBancoDados();
        }
        break;

    case 'resumo_consultas':
        verificarAuth();
        $consultaController = new ConsultaController($db);
        $consultaController->resumoDiario();
        break;
                
    case 'perfil':
        verificarAuth();
            if ($_SESSION['user_role'] === 'doutor') {
                $doutorController = new DoutorController($db);
                $doutorController->perfil();
            } else {
                $pacienteController = new PacienteController($db);
                $pacienteController->perfil();
            }
        break;
            
    case 'atualizar_perfil':
        verificarAuth();
        $doutorController = new DoutorController($db);
        $doutorController->atualizarPerfil($_POST);
        break;
    case 'salvar_info_emergencia':
        verificarAuth();
        if ($_SESSION['user_role'] === 'paciente') {
            $pacienteController = new PacienteController($db);
            $pacienteController->salvarInfoEmergencia($_POST);
        }
        break;
    
    case 'info_emergencia':
            verificarAuth();
            if ($_SESSION['user_role'] === 'paciente') {
                $pacienteController = new PacienteController($db);
                $pacienteController->verInfoEmergencia();
            }
    break;
        
    case 'editar_info_emergencia':
            verificarAuth();
            if ($_SESSION['user_role'] === 'paciente') {
                $pacienteController = new PacienteController($db);
                $pacienteController->editarInfoEmergencia();
            }    
    break;   
    case 'cancelar_consulta':
    verificarAuth();
    $consultaController = new ConsultaController($db);
    if ($_SESSION['user_role'] === 'doutor') {
        $consultaController->cancelarConsultaDoutor($_GET['id']);
    } else {
        $consultaController->cancelarConsulta($_GET['id']);
    }
    header('Location: index.php?action=visualizar_consultas');
    break;
                    
        
    default:
        header('Location: index.php?action=login');
        break;
}



