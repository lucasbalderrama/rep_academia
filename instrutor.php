<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
    if ($_POST['action'] === 'edit' && isset($_POST['id_instrutor'])) {
        $id = $_POST['id_instrutor'];
        $nome_edit = $_POST['nome_edit'];
        $cpf_edit = $_POST['cpf_edit'];
        $telefone_edit = $_POST['telefone_edit'];
        $endereco_edit = $_POST['endereco_edit'];
        
        $query1 = "UPDATE instrutor SET instrutor_nome = ? WHERE instrutor_cod = ?";
        $stmt1 = $conexao->prepare($query1);
        $stmt1->bind_param("si", $nome_edit, $id);
        $stmt1->execute();
        $stmt1->close();
        
        $query2 = "UPDATE instrutor SET instrutor_endereco = ? WHERE instrutor_cod = ?";
        $stmt2 = $conexao->prepare($query2);
        $stmt2->bind_param("si", $endereco_edit, $id);
        $stmt2->execute();
        $stmt2->close();
        
        $query3 = "UPDATE instrutor SET instrutor_especialidade = ?, instrutor_telefone = ? WHERE instrutor_cod = ?";
        $stmt3 = $conexao->prepare($query3);
        $stmt3->bind_param("ssi", $cpf_edit, $telefone_edit, $id);
        
        if ($stmt3->execute()) {
            $stmt3->close();
            header("Location: instrutor.php");
            exit();
        } else {
            echo "Erro ao editar linha: " . $conexao->error;
        }
        
        $stmt3->close();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/vitalis-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/aluno.css">
    <title>Vitalis - instrutor</title>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a id="inicio" href="index.php">Início</a></li>
            <li><a href="aluno.php">Página do aluno</a></li>
            <li><a href="instrutor.php">Página do instrutor </a></li>
            <li><a href="aula.php">instrutor</a></li>
        </ul>
    </nav>        
</header>
<main>
    <?php
    $sql_mostrar = "SELECT instrutor.instrutor_cod, instrutor.instrutor_nome, instrutor.instrutor_especialidade FROM instrutor";
    $mostrar = $conexao->query($sql_mostrar);
    ?>
    <div class='exibir'>
        <?php
        while($row = $mostrar->fetch_assoc()){
            echo "
            <form action='' method='POST' class='info_instrutor'>
                <input type='hidden' name='action' value='edit'>
                <input type='hidden' name='id_instrutor' value='".$row['instrutor_cod']."'>
                <div class='cont-atual'>
                    <p>Nome do instrutor: ".$row['instrutor_nome']."</p>
                    <p>Especialidade do instrutor: ".$row['instrutor_especialidade']."</p>
                </div>
                <div class='edicao'>
                    <input id='n-nome' name='nome_edit' type='text' value='".$row['instrutor_nome']."' required>
                    <input id='n-tipo' name='cpf_edit' type='text' value='".$row['instrutor_especialidade']."' required>
                </div>
                <button id='salv' type='submit'>Salvar</button>
                <button id='canc' type='button'>Cancelar</button>
                <button id='edi' type='button'>Editar</button>
                <button id='exc' type='submit' name='action' value='delete'>Excluir</button>
            </form>";
        }
        ?>
    </div>
</main>
<script>
    let butEdit = document.querySelectorAll('#edi');
    let edicao = document.querySelectorAll('.edicao');
    let conteudo = document.querySelectorAll('.cont-atual');
    let butExc = document.querySelectorAll('#exc');
    let butCanc = document.querySelectorAll('#canc');
    let butSalv = document.querySelectorAll('#salv');

    butCanc.forEach((botao, index) => {
        botao.addEventListener('click', () => {
            edicao[index].classList.toggle('esconder');
            conteudo[index].classList.toggle('mostrar');
            butEdit[index].classList.toggle('mostrar');
            butExc[index].classList.toggle('mostrar');
            butSalv[index].classList.toggle('esconder');
            butCanc[index].classList.toggle('esconder');
        });
    });

    butEdit.forEach((botao, index) => {
        botao.addEventListener('click', () => {
            edicao[index].classList.toggle('mostrar');
            conteudo[index].classList.toggle('esconder');
            butEdit[index].classList.toggle('esconder');
            butExc[index].classList.toggle('esconder');
            butSalv[index].classList.toggle('mostrar');
            butCanc[index].classList.toggle('mostrar');
        });
    });
</script>
</body>
</html>
