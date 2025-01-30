<?php
include 'conexao.php';
session_start();

$sql = "
    SELECT 
        instrutor.instrutor_cod,
        instrutor.instrutor_nome,
        instrutor.instrutor_especialidade
    FROM instrutor
";

$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/vitalis-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/instrutor.css">
    <title>Vitalis - Página do instrutor</title>
</head>
<body>
<header>
        <nav>
            <ul>
                <li><a id="inicio" href="index.php">Início</a></li>
                <li><a href="aluno.php">Página do aluno</a></li>
                <li><a href="instrutor.php">Página do instrutor </a></li>
                <li><a href="aula.php">Aulas</a></li>
            </ul>
        </nav>        
    </header>

    <div class="exibir-instrutor">
        <div class="img-instrutor-page"></div>
        <div class="tabela">
            <h2>Instrutores:</h2>
            <?php if ($resultado->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nome do instrutor</th>
                            <th>Especialidade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['instrutor_nome']; ?></td>
                                <td><?php echo $row['instrutor_especialidade']; ?></td>
                                <td>
                                    <a class="editar" href="editar_aluno.php">Editar</a>
                                    <a class="excluir" href="excluir_aluno.php">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>