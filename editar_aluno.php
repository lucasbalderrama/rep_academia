<?php
include 'conexao.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conexao->prepare("SELECT * FROM aluno WHERE aluno_cod = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $aluno = $result->fetch_assoc();

    if (!$aluno) {
        die("Aluno não encontrado.");
    }
    
} else {
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
</head>
<body>
    <h2>Editar Aluno</h2>
    <form action="" method="post">
        <input type="hidden" name="aluno_cod" value="<?php echo htmlspecialchars($aluno['aluno_cod']); ?>">

        <label for="aluno_nome">Nome:</label>
        <input type="text" id="aluno_nome" name="aluno_nome" value="<?php echo htmlspecialchars($aluno['aluno_nome']); ?>" required>
        
        <label for="aluno_cpf">CPF:</label>
        <input type="text" id="aluno_cpf" name="aluno_cpf" value="<?php echo htmlspecialchars($aluno['aluno_cpf']); ?>" required>
        
        <label for="aluno_telefone">Telefone:</label>
        <input type="text" id="aluno_telefone" name="aluno_telefone" value="<?php echo htmlspecialchars($aluno['aluno_telefone']); ?>" required>
        
        <label for="aluno_endereco">Endereço:</label>
        <input type="text" id="aluno_endereco" name="aluno_endereco" value="<?php echo htmlspecialchars($aluno['aluno_endereco']); ?>" required>
        
        <input type="submit" value="Salvar">
    </form>
</body>
</html>

