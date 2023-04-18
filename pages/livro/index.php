<?php
require_once('../../conf/Conexao.php');
require_once('livro.class.php');

$livro = new livro();

$livros = $livro->listar($tipo = 0, $info = '');

$modo = 'adicionar';
$id_editar = '';
$autor_editar = '';
$titulo_editar = '';

if (isset($_GET['acao']) && $_GET['acao'] == 'editar' && isset($_GET['id'])) {
    $modo = 'editar';
    $id_editar = $_GET['id'];
    foreach ($livros as $l) {
        if ($l['id'] == $id_editar) {
            $autor_editar = $l['autor'];
            $titulo_editar = $l['titulo'];
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Livros</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-center">Livros</h1>
                <form method="POST" action="acao.php">
                    <input type="hidden" name="acao" value="<?= $modo ?>">
                    
                    <div class="mb-3">
                        <label for="autor" class="form-label">ID</label>
                        <input type="text" class="form-control" name="id" value="<?= $id_editar ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="autor" class="form-label">Autor</label>
                        <input type="text" class="form-control" id="autor" name="autor" value="<?= $autor_editar ?>">
                    </div>
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $titulo_editar ?>">
                    </div>
                    <button type="submit" class="btn btn-primary"><?= $modo == 'adicionar' ? 'Adicionar' : 'Salvar' ?></button>
                </form>
                <hr>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Autor</th>
                            <th>Título</th>
                            <th>Modificar</th>
                            <th>Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($livros as $livro): ?>
                            <tr>
                                <td><?= $livro['id'] ?></td>
                                <td><?= $livro['autor'] ?></td>
                                <td><?= $livro['titulo'] ?></td>
                                <td><a class='btn btn-warning' href='index.php?acao=editar&id=<?= $livro['id'] ?>'>Editar</a></td>
                                <td><a class='btn btn-danger'  href='acao.php?acao=excluir&id=<?= $livro['id'] ?>'>Excluir</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </body>
</html>
