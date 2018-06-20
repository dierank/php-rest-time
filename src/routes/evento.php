<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Selecionar todos as eventos
$app->get('/api/eventos', function (Request $request, Response $response) {
    $query = "SELECT * FROM eventos";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->query($query);

        $eventos = $stmt->fetchAll(PDO::FETCH_OBJ);
        $bd = null;
        echo json_encode($eventos);

    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}}';
    }
});

// Selecionar as eventos de um usuario
$app->get('/api/usuario/{id}/eventos', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $query = "SELECT * FROM eventos WHERE id_usuario = $id";

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

// Adicionar evento do usuario
$app->post('/api/evento/adicionar', function (Request $request, Response $response) {
    $id_usuario = $request->getParam('id_usuario');
    $nome       = $request->getParam('nome');

    $query = "INSERT INTO eventos (id_usuario,nome)
    VALUES(:id_usuario,:nome)";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->prepare($query);

        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':nome', $nome);

        $stmt->execute();

        echo '{"aviso": {"mensagem": "evento adicionada."}}';
    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}}';
    }
});

// Atualizar
$app->put('/api/evento/atualizar/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $nome = $request->getParam('nome');

    $query = "UPDATE eventos set
                nome     = :nome,
            WHERE id = $id";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->prepare($query);

        $stmt->bindParam(':nome', $nome);

        $stmt->execute();

        echo '{"aviso": {"mensagem": "evento atualizada."}}';
    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}}';
    }
});

// Deletar evento
$app->delete('/api/evento/deletar/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $query = "DELETE FROM eventos WHERE id = $id";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->prepare($query);
        $stmt->execute();
        $bd = null;

        echo '{"aviso": {"mensagem": "evento deletada."}}';
    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}';
    }
});


?>
