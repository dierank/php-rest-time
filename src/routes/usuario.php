<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Selecionar todos os usuários
$app->get('/api/usuarios', function (Request $request, Response $response) {
    $query = "SELECT * FROM usuarios";

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

// Selecionar 1 usuário
$app->get('/api/usuario/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $query = "SELECT * FROM usuarios WHERE id = $id";

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

// Adicionar usuário
$app->post('/api/usuario/adicionar', function (Request $request, Response $response) {
    $nome = $request->getParam('nome');
    $email = $request->getParam('email');
    $usuario = $request->getParam('usuario');
    $senha = $request->getParam('senha');
    $telefone = $request->getParam('telefone');

    $query = "INSERT INTO usuarios (nome, email, usuario, senha, telefone)
    VALUES(:nome, :email, :usuario, :senha, :telefone)";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->prepare($query);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':telefone', $telefone);

        $stmt->execute();

        echo '{"aviso": {"mensagem": "Usuário adicionado."}}';
    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}}';
    }
});

// Atualizar
$app->put('/api/usuario/atualizar/{id}', function (Request $request, Response $response) {
    $id       = $request->getAttribute('id');
    $nome     = $request->getParam('nome');
    $email    = $request->getParam('email');
    $usuario  = $request->getParam('usuario');
    $senha    = $request->getParam('senha');
    $telefone = $request->getParam('telefone');

    $query = "UPDATE usuarios SET
                nome     = :nome,
                email    = :email,
                usuario  = :usuario,
                senha    = :senha,
                telefone = :telefone
            WHERE id = $id";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->prepare($query);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':telefone', $telefone);

        $stmt->execute();

        echo '{"aviso": {"mensagem": "Usuário atualizado."}}';
    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}}';
    }
});

// Deletar usuário
$app->delete('/api/usuario/deletar/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $query = "DELETE FROM usuarios WHERE id = $id";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->prepare($query);
        $stmt->execute();
        $bd = null;

        echo '{"aviso": {"mensagem": "Usuário deletado."}}';
    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}';
    }
});
?>
