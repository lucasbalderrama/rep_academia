<?php 
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM aluno WHERE aluno_cod = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header('Location: aluno.php');
        exit();
    } else {
        echo "Erro ao excluir o aluno.";
    }

    $stmt->close();
}
?>
