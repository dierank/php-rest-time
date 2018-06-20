<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
// Selecionar todos as categorias

include '../phpqrcode/qrlib.php';

$app->post('/api/qrcode', function (Request $request, Response $response) {







    QRcode::png('localhost/APIRest/usuarios', 'test.png', 'L', 4, 2);









    echo '{"aviso": {"mensagem": "QR Code criado."}}';
});


$app->get('/api/categorias', function (Request $request, Response $response) {
    $query = "SELECT * FROM categorias";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->query($query);

        $categorias = $stmt->fetchAll(PDO::FETCH_OBJ);
        $bd = null;
        echo json_encode($categorias);

    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}}';
    }
});

// Selecionar as categorias de um usuario
$app->get('/api/usuario/{id}/categorias', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $query = "SELECT * FROM categorias WHERE id_usuario = $id";

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

// Adicionar categoria do usuario
$app->post('/api/categoria/adicionar', function (Request $request, Response $response) {
    $id_usuario = $request->getParam('id_usuario');
    $nome       = $request->getParam('nome');

    $query = "INSERT INTO categorias (id_usuario,nome)
    VALUES(:id_usuario,:nome)";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->prepare($query);

        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':nome', $nome);

        $stmt->execute();

        echo '{"aviso": {"mensagem": "Categoria adicionada."}}';
    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}}';
    }
});

// Atualizar
$app->put('/api/categoria/atualizar/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $nome = $request->getParam('nome');

    $query = "UPDATE categorias set
                nome     = :nome,
            WHERE id = $id";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->prepare($query);

        $stmt->bindParam(':nome', $nome);

        $stmt->execute();

        echo '{"aviso": {"mensagem": "Categoria atualizada."}}';
    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}}';
    }
});

// Deletar categoria
$app->delete('/api/categoria/deletar/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $query = "DELETE FROM categorias WHERE id = $id";

    try {
        $bd = new Banco();
        $bd = $bd->getConexao();

        $stmt = $bd->prepare($query);
        $stmt->execute();
        $bd = null;

        echo '{"aviso": {"mensagem": "Categoria deletada."}}';
    } catch(PDOException $e) {
        echo '{"erro": {"mensagem": '. $e->getMessage().'}';
    }
});
?>
