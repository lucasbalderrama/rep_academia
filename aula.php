<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/vitalis-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/aula.css">
    <title>Vitalis - Aulas</title>
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
    <main>
        <?php
        include 'conexao.php';

        $sql_mostrar = "SELECT aluno.aluno_nome AS aluno_nome, aula.aula_tipo, aula.aula_data, instrutor.instrutor_nome AS instrutor_nome
                FROM aula
                JOIN aluno ON aula.fk_aluno_cod = aluno.aluno_cod
                JOIN instrutor ON aula.fk_instrutor_cod = instrutor.instrutor_cod";
        $mostrar = $conexao->query($sql_mostrar);
        ?>
        <div class='exibir'>
            <table>
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>Aula</th>
                        <th>Data</th>
                        <th>Instrutor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($row = $mostrar->fetch_assoc()){
                            echo "<tr>";
                            echo "<td>".$row['aluno_nome']."</td>";
                            echo "<td>".$row['aula_tipo']."</td>";
                            echo "<td>".$row['aula_data']."</td>";
                            echo "<td>".$row['instrutor_nome']."</td>";
                            echo "</tr>";
                        }
                        ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>