<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Selecionar todos as atividades
$app->get('/api/atividades', function (Request $request, Response $response) {
    $query = "SELECT * FROM atividades";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->query($query);

        $atividades = $stmt->fetchAll(PDO::FETCH_OBJ);
        $bd = null;
        echo json_encode($atividades);

    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}}';
    }
});

// Selecionar as atividades de um usuario
$app->get('/api/usuario/{id}/atividades', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $query = "SELECT * FROM atividades WHERE id_usuario = $id";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->query($query);

        $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);
        $bd = null;
        echo json_encode($usuarios);

    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}';
    }
});

// Adicionar atividade do usuario
$app->post('/api/atividade/adicionar', function (Request $request, Response $response) {
    $id_usuario = $request->getParam('id_usuario');
    $nome       = $request->getParam('nome');

    $query = "INSERT INTO atividades (id_usuario,nome)
    VALUES(:id_usuario,:nome)";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->prepare($query);

        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':nome', $nome);

        $stmt->execute();

        echo '{"aviso": {"mensagem": "atividade adicionada."}}';
    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}}';
    }
});

// Atualizar
$app->put('/api/atividade/atualizar/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $nome = $request->getParam('nome');

    $query = "UPDATE atividades set
                nome     = :nome,
            WHERE id = $id";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->prepare($query);

        $stmt->bindParam(':nome', $nome);

        $stmt->execute();

        echo '{"aviso": {"mensagem": "atividade atualizada."}}';
    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}}';
    }
});

// Deletar atividade
$app->delete('/api/atividade/deletar/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $query = "DELETE FROM atividades WHERE id = $id";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->prepare($query);
        $stmt->execute();
        $bd = null;

        echo '{"aviso": {"mensagem": "atividade deletada."}}';
    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}';
    }
});


?>
