<?php
    require_once('../../conf/Conexao.php');
    require_once('livro.class.php');

    $acao = "";
    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':  $acao = isset($_GET['acao']) ? $_GET['acao'] : ""; break;
        case 'POST': $acao = isset($_POST['acao']) ? $_POST['acao'] : ""; break;
    }

    $livro = new livro();
    var_dump($_POST);
    if (isset($acao)) {
        switch ($acao) {
            case 'adicionar':
                    echo "Cadastrar";
                    $autor = isset($_POST['autor']) ? $_POST['autor'] : '';
                    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
                    if (!empty($autor) && !empty($titulo)) {
                        $livro->inserir($autor, $titulo);
                    }
                break;
            case 'editar':
                    echo "Editar";
                    $id = isset($_POST['id']) ? $_POST['id'] : 0;
                    $autor = isset($_POST['autor']) ? $_POST['autor'] : '';
                    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
                    if (!empty($id) && !empty($autor) && !empty($titulo)) {
                        $livro->editar($id, array('autor' => $autor, 'titulo' => $titulo));
                    }
                break;
            case 'excluir':
                    $id = isset($_GET['id']) ? $_GET['id'] : 0;
                    if (!empty($id)) {
                        if ($livro->deletar($id)) {
                            header("Location: index.php");
                            exit;
                        } else {
                            echo "Erro ao excluir registro.";
                        }
                    }
                    break;                             
            default:
                break;
        }
        header("Location: index.php");
        exit;
    }
?>