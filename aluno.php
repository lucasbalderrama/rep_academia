<?php
include 'conexao.php';
session_start();

$sql = "
    SELECT 
        aluno.aluno_cod,
        aluno.aluno_nome,
        aluno.aluno_cpf, 
        aluno.aluno_telefone,
        aluno.aluno_endereco  
    FROM aluno
";

$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/vitalis-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/aluno.css">
    <title>Vitalis - Página do aluno</title>
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

    <div class="exibir-alunos">
        <div class="img-alunos-page"></div>
        <div class="tabela">
            <h2>Alunos:</h2>
            <?php if ($resultado->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID do aluno</th>  
                            <th>Nome do aluno</th>
                            <th>CPF do aluno</th>
                            <th>Telefone do aluno</th>
                            <th>Endereço do aluno</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['aluno_cod']; ?></td>
                                <td><?php echo $row['aluno_nome']; ?></td>
                                <td><?php echo $row['aluno_cpf']; ?></td>
                                <td><?php echo $row['aluno_telefone']; ?></td>
                                <td><?php echo $row['aluno_endereco']; ?></td>
                                <td>
                                    <a class="editar" href="editar_aluno.php?id=<?php echo $row['aluno_cod']; ?>">Editar</a>
                                    <a class="excluir" href="excluir_aluno.php?id=<?php echo $row['aluno_cod']; ?>">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <form method="POST" action=""></form>

</body>
</html>