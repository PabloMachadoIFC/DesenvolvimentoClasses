<?php

class Livro {
    /***
    Atributos
    */
    public $id;
    public $autor;
    public $titulo;

    /***
    Métodos
    */
    public function imprimirLivro() {
        $str = 'Id: ' . $this->id .
        ', Autor: ' . $this->autor .
        ', Título: ' . $this->titulo;

        return $str;
    }

    public function listar($tipo = 0, $info) {
        include_once("../../conf/conf.inc.php"); // incluir configuração do banco

        $conexao = Conexao::getInstance(); // criar conexão

        // montar consulta
        $sql = "SELECT * FROM Livro";
        switch ($tipo) {
            case 1:
                $sql .= ' WHERE id = :info';
                break;
            case 2:
                $sql .= ' WHERE autor LIKE :info';
                break;
            default:
                break;
        }

        $comando = $conexao->prepare($sql); // preparar comando
        // vincular os parâmetros
        if ($tipo > 0) {
            //$comando->bindParam('info', $info, PDO::PARAM_INT);
            $comando->bindValue(':info', $info);
        }
        // executar
        if ($comando->execute()) {
            return $comando->fetchAll();
        }
    }

    public function inserir($autor, $titulo) {
        include_once("../../conf/conf.inc.php"); // incluir configuração do banco
    
        $conexao = Conexao::getInstance(); // criar conexão
    
        $sql = "INSERT INTO Livro (autor, titulo) VALUES (:autor, :titulo)";
        $comando = $conexao->prepare($sql); // preparar comando
        $comando->bindValue(':autor', $autor);
        $comando->bindValue(':titulo', $titulo);
        // executar
        if ($comando->execute()) {
            $this->id = $conexao->lastInsertId();
            $this->autor = $autor;
            $this->titulo = $titulo;
            return true;
        } else {
            return false;
        }
    }
    
    
    

    public function deletar($id) {
        include_once("../../conf/conf.inc.php");
        $conn = Conexao::getInstance();
        $stmt = $conn->prepare("DELETE FROM livro WHERE id = :id");
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }
    

    public function editar($id, $dados) {
        include_once("../../conf/conf.inc.php"); // incluir configuração do banco

        $conexao = Conexao::getInstance(); // criar conexão

        // montar consulta
        $sql = "UPDATE Livro SET";
        $params = [];
        foreach ($dados as $campo => $valor) {
            $sql .= " $campo = :$campo,";
            $params[":$campo"] = $valor;
        }
        $sql = rtrim($sql, ','); // remove a última vírgula
        $sql .= " WHERE id = :id";
        $params[':id'] = $id;

        $comando = $conexao->prepare($sql);
        foreach ($params as $chave => $valor) {
            $comando->bindValue($chave, $valor);
        }
        if ($comando->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
}

?>