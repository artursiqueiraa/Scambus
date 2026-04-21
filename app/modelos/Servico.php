<?php

require_once "../configuracao/banco.php";

class Servico {

    private $conexao;

    public function __construct() {

        // cria conexão com banco
        $banco = new Banco();
        $this->conexao = $banco->conectar();

    }

    // ✅ NOVO: expõe a conexão para uso externo (necessário para lastInsertId no controlador)
    public function getConexao(){
        return $this->conexao;
    }

    
    public function listar() {

        /*
        Buscamos serviços + usuário + foto
        */

        $sql = "SELECT 
            servicos.*,
            usuarios.nome,
            usuarios.id as usuario_id,
            categorias.nome as categoria,

            (SELECT AVG(nota)
             FROM avaliacoes
             WHERE avaliado_id = usuarios.id) as avaliacao_media,

            servico_fotos.caminho_foto

        FROM servicos

        JOIN usuarios 
        ON usuarios.id = servicos.usuario_id

        LEFT JOIN categorias
        ON categorias.id = servicos.categoria_id

        LEFT JOIN servico_fotos 
        ON servico_fotos.servico_id = servicos.id

        WHERE servicos.status = 'ATIVO'

        GROUP BY servicos.id

        ORDER BY servicos.data_criacao DESC

        LIMIT 6";
        

        $stmt = $this->conexao->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    
public function criar($usuario_id,$categoria,$titulo,$oferece,$aceita,$foto){

$sql = "INSERT INTO servicos
        (usuario_id,categoria_id,titulo,descricao_oferece,descricao_aceita,status)
        VALUES
        (:usuario_id,:categoria,:titulo,:oferece,:aceita,'ATIVO')";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":usuario_id",$usuario_id);
$stmt->bindParam(":categoria",$categoria);
$stmt->bindParam(":titulo",$titulo);
$stmt->bindParam(":oferece",$oferece);
$stmt->bindParam(":aceita",$aceita);

$stmt->execute();

$servico_id = $this->conexao->lastInsertId();

/*
salvando foto
*/

if($foto){

    $sqlFoto = "INSERT INTO servico_fotos
                (servico_id,caminho_foto)
                VALUES
                (:servico_id,:foto)";

    $stmtFoto = $this->conexao->prepare($sqlFoto);

    $stmtFoto->bindParam(":servico_id",$servico_id);
    $stmtFoto->bindParam(":foto",$foto);

    $stmtFoto->execute();
}

}



    public function buscarPorId($id){

        $sql = "SELECT 
                    servicos.*,
                    usuarios.nome,
                    usuarios.id as usuario_id,
                    servico_fotos.caminho_foto
                FROM servicos

                JOIN usuarios 
                ON usuarios.id = servicos.usuario_id

                LEFT JOIN servico_fotos 
                ON servico_fotos.servico_id = servicos.id

                WHERE servicos.id = :id

                LIMIT 1";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindParam(":id",$id);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarPorUsuario($usuario_id){

$sql = "SELECT 
servicos.*,
servico_fotos.caminho_foto

FROM servicos

LEFT JOIN servico_fotos
ON servico_fotos.servico_id = servicos.id

WHERE servicos.usuario_id = :usuario

GROUP BY servicos.id";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":usuario",$usuario_id);

$stmt->execute();

return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

public function buscar($termo){

$sql = "SELECT 
servicos.*,
usuarios.nome,
servico_fotos.caminho_foto,

(SELECT AVG(nota)
FROM avaliacoes
WHERE avaliado_id = usuarios.id) as avaliacao_media

FROM servicos

JOIN usuarios
ON usuarios.id = servicos.usuario_id

LEFT JOIN servico_fotos
ON servico_fotos.servico_id = servicos.id

WHERE servicos.status = 'ATIVO'
AND servicos.titulo LIKE :termo

GROUP BY servicos.id
ORDER BY servicos.data_criacao DESC";

$stmt = $this->conexao->prepare($sql);

$busca = "%".$termo."%";

$stmt->bindParam(":termo",$busca);

$stmt->execute();

return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


public function listarPorCategoria($categoria_id){

$sql = "SELECT 
servicos.*,
usuarios.nome,
usuarios.id as usuario_id,
categorias.nome as categoria,

(SELECT AVG(nota)
FROM avaliacoes
WHERE avaliado_id = usuarios.id) as avaliacao_media,

servico_fotos.caminho_foto


FROM servicos

JOIN usuarios
ON usuarios.id = servicos.usuario_id

LEFT JOIN categorias
ON categorias.id = servicos.categoria_id

LEFT JOIN servico_fotos
ON servico_fotos.servico_id = servicos.id

WHERE servicos.status = 'ATIVO'
AND servicos.categoria_id = :categoria

GROUP BY servicos.id
ORDER BY servicos.data_criacao DESC";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":categoria",$categoria_id);

$stmt->execute();

return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


public function atualizar($id,$categoria,$titulo,$oferece,$aceita,$foto){

$sql = "UPDATE servicos SET
categoria_id = :categoria,
titulo = :titulo,
descricao_oferece = :oferece,
descricao_aceita = :aceita
WHERE id = :id";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":categoria",$categoria);
$stmt->bindParam(":titulo",$titulo);
$stmt->bindParam(":oferece",$oferece);
$stmt->bindParam(":aceita",$aceita);
$stmt->bindParam(":id",$id);

$stmt->execute();

/*
se enviou nova foto
*/

if($foto){

/*
verifica se já existe foto
*/

$sqlVerifica = "SELECT id FROM servico_fotos WHERE servico_id = :id";

$stmtVerifica = $this->conexao->prepare($sqlVerifica);

$stmtVerifica->bindParam(":id",$id);

$stmtVerifica->execute();

$existe = $stmtVerifica->fetch();

if($existe){

$sqlFoto = "UPDATE servico_fotos
SET caminho_foto = :foto
WHERE servico_id = :id";

}else{

$sqlFoto = "INSERT INTO servico_fotos
(servico_id,caminho_foto)
VALUES
(:id,:foto)";

}

$stmtFoto = $this->conexao->prepare($sqlFoto);

$stmtFoto->bindParam(":foto",$foto);
$stmtFoto->bindParam(":id",$id);

$stmtFoto->execute();

}


}

public function alterarStatus($id,$status){

$sql = "UPDATE servicos
SET status = :status
WHERE id = :id";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":status",$status);
$stmt->bindParam(":id",$id);

$stmt->execute();

}

public function excluir($id){

$sql = "DELETE FROM servicos
WHERE id = :id";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":id",$id);

$stmt->execute();

}

public function contarServicos(){

$sql = "SELECT COUNT(*) as total FROM servicos";

$stmt = $this->conexao->prepare($sql);

$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

return $result['total'];

}

public function favoritar($usuario,$servico){

$sql = "INSERT INTO favoritos
(usuario_id,servico_id)
VALUES
(:usuario,:servico)";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":usuario",$usuario);
$stmt->bindParam(":servico",$servico);

$stmt->execute();

}

public function desfavoritar($usuario,$servico){

$sql = "DELETE FROM favoritos
WHERE usuario_id = :usuario
AND servico_id = :servico";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":usuario",$usuario);
$stmt->bindParam(":servico",$servico);

$stmt->execute();

}

public function favoritosDoUsuario($usuario_id){

$sql = "SELECT 
servicos.*,
servico_fotos.caminho_foto

FROM favoritos

JOIN servicos
ON servicos.id = favoritos.servico_id

LEFT JOIN servico_fotos
ON servico_fotos.servico_id = servicos.id

WHERE favoritos.usuario_id = :usuario

GROUP BY servicos.id";

$stmt = $this->conexao->prepare($sql);

$stmt->bindParam(":usuario",$usuario_id);

$stmt->execute();

return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

public function listarTodos(){

$sql = "SELECT 
    servicos.*,
    usuarios.nome,
    usuarios.id as usuario_id,
    categorias.nome as categoria,

    (SELECT AVG(nota)
     FROM avaliacoes
     WHERE avaliado_id = usuarios.id) as avaliacao_media,

    servico_fotos.caminho_foto

FROM servicos

JOIN usuarios 
ON usuarios.id = servicos.usuario_id

LEFT JOIN categorias
ON categorias.id = servicos.categoria_id

LEFT JOIN servico_fotos 
ON servico_fotos.servico_id = servicos.id

WHERE servicos.status = 'ATIVO'

GROUP BY servicos.id

ORDER BY servicos.data_criacao DESC";

$stmt = $this->conexao->prepare($sql);

$stmt->execute();

return $stmt->fetchAll(PDO::FETCH_ASSOC);

}



public function buscarFotos($servico_id)
{
    $sql = "SELECT * FROM servico_fotos WHERE servico_id = :id";

    $stmt = $this->conexao->prepare($sql);
    $stmt->bindParam(":id", $servico_id);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    




}