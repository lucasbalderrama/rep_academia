<?php
include 'conexao.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete' && isset($_POST['id_aluno'])) {
            $id = $_POST['id_aluno'];
            $query = "DELETE FROM aluno WHERE aluno_cod = ?";
            $stmt = $conexao->prepare($query);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                echo "<script>
                alert('Aluno excluído com sucesso!');
                location.href = 'aluno.php';
                </script>";
            } else {
                echo "Erro ao excluir: " . $conexao->error;
            }

            $stmt->close();
        }

        if ($_POST['action'] === 'edit' && isset($_POST['id_aluno'])) {
            $id = $_POST['id_aluno'];
            $novo_nome = $_POST['novo_nome'];
            $novo_cpf = $_POST['novo_cpf'];
            $novo_telefone = $_POST['novo_telefone'];
            $novo_endereco = $_POST['novo_endereco'];

            $query = "UPDATE aluno SET aluno_nome = ?, aluno_cpf = ?, aluno_telefone = ?, aluno_endereco = ? WHERE aluno_cod = ?";
            $stmt = $conexao->prepare($query);
            $stmt->bind_param("ssssi", $novo_nome, $novo_cpf, $novo_telefone, $novo_endereco, $id);

            if ($stmt->execute()) {
                echo "<script>
                alert('Dados do aluno atualizados com sucesso!');
                location.href = 'aluno.php';
                </script>";
            } else {
                echo "Erro ao editar: " . $conexao->error;
            }

            $stmt->close();
        }
    }
}

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
                            <form method="POST" action="">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id_aluno" value="<?php echo $row['aluno_cod']; ?>">
                                <tr>
                                    <td class="cont-atual"><?php echo $row['aluno_cod']; ?></td>
                                    <td class="cont-atual"><?php echo $row['aluno_nome']; ?>
                                        <input class="edicao esconder" name="novo_nome" type="text" value="<?php echo $row['aluno_nome']; ?>" required>
                                    </td>
                                    <td class="cont-atual"><?php echo $row['aluno_cpf']; ?>
                                        <input class="edicao esconder" name="novo_cpf" type="text" value="<?php echo $row['aluno_cpf']; ?>" required>
                                    </td>
                                    <td class="cont-atual"><?php echo $row['aluno_telefone']; ?>
                                        <input class="edicao esconder" name="novo_telefone" type="text" value="<?php echo $row['aluno_telefone']; ?>" required>
                                    </td>
                                    <td class="cont-atual"><?php echo $row['aluno_endereco']; ?>
                                        <input class="edicao esconder" name="novo_endereco" type="text" value="<?php echo $row['aluno_endereco']; ?>" required>
                                    </td>
                                    <td>
                                        <button class="salvar esconder" type="submit">Salvar</button>
                                        <button class="cancelar esconder" type="button">Cancelar</button>
                                        <button class="editar" type="button">Editar</button>
                                        <button class="excluir" type="submit" name="action" value="delete">Excluir</button>
                                    </td>
                                </tr>
                            </form>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <script>
        document.querySelectorAll(".editar").forEach((botao, index) => {
        botao.addEventListener("click", () => {
            let row = botao.closest("tr");
            row.querySelectorAll(".edicao").forEach(input => input.classList.toggle("mostrar"));
            row.querySelectorAll(".cont-atual").forEach(span => span.classList.toggle("esconder"));
            row.querySelector(".salvar").classList.toggle("mostrar");
            row.querySelector(".cancelar").classList.toggle("mostrar");
            botao.classList.toggle("esconder");
            row.querySelector(".excluir").classList.toggle("esconder");
        });
    });

    document.querySelectorAll(".cancelar").forEach((botao, index) => {
        botao.addEventListener("click", () => {
            let row = botao.closest("tr");
            row.querySelectorAll(".edicao").forEach(input => input.classList.toggle("esconder"));
            row.querySelectorAll(".cont-atual").forEach(span => span.classList.toggle("mostrar"));
            row.querySelector(".salvar").classList.toggle("esconder");
            row.querySelector(".cancelar").classList.toggle("esconder");
            row.querySelector(".editar").classList.toggle("mostrar");
            row.querySelector(".excluir").classList.toggle("mostrar");
        });
    });
    </script>
</body>
</html>