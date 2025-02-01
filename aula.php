<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/vitalis-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/aula.css">
    <title>Vitalis - Aulas</title>
</head>
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

        $sql_mostrar = "SELECT aula.aula_cod, aluno.aluno_nome AS aluno_nome, aula.aula_tipo, aula.aula_data, instrutor.instrutor_nome AS instrutor_nome
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    
                        <?php
                        while($row = $mostrar->fetch_assoc()){
                            echo "
                            <form action='' method='POST'>
                                <input type='hidden' name='action' value='edit'>
                                <input type='hidden' name='id_aula' value='".$row['aula_cod']."'>
                                <tr>
                                    <td class='cont-atual'>".$row['aluno_nome']."<input class='edicao' id='n-nome' name='novo_nome' type='text' value='".$row['aluno_nome']."' required></td>
                                    <td class='cont-atual'>".$row['aula_tipo']."<input class='edicao' id='n-tipo' name='novo_tipo' type='text' value='".$row['aula_tipo']."' required></td>
                                    <td class='cont-atual'>".$row['aula_data']."<input class='edicao' id='n-data' name='nova_data' type='date' value='".$row['aula_data']."' required></td>
                                    <td class='cont-atual'>".$row['instrutor_nome']."<input class='edicao' id='n-inst' name='novo_inst' type='text' value='".$row['instrutor_nome']."' required></td>
                                    <td>
                                        <button id='salv' type='submit'>Salvar</button>
                                        <button id='canc' type='button'>Cancelar</button>
                                        <button id='edi' type='button'>Editar</button>
                                        <button id='exc' type='submit' name='action' value='delete'>Excluir</button>
                                    </td>
                                </tr>";
                        }

                        if ($_SERVER["REQUEST_METHOD"] === "POST") {
                            if (isset($_POST['action'])) {
                                if ($_POST['action'] === 'delete' && isset($_POST['id_aula'])) {
                                    $id = $_POST['id_aula'];
                                    $query = "DELETE FROM aula WHERE aula_cod = ?"; 
                                    $stmt = $conexao->prepare($query);
                                    $stmt->bind_param("i", $id);
                        
                                    if ($stmt->execute()) {
                                        echo "<script>
                                        Swal.fire({
                                            title: 'Linha excluída com sucesso!',
                                            icon: 'success',
                                            confirmButtonColor: '#438e4b',
                                        }).then(function() {
                                            location.href = 'aula.php';
                                        });
                                        </script>";
                                    } else {
                                        echo "Erro ao excluir linha: ".$conexao->error;
                                    }
                        
                                    $stmt->close();
                                }
                        
                                if ($_POST['action'] === 'edit' && isset($_POST['id_aula'])) {
                                    $id = $_POST['id_aula'];
                                    $novo_aluno = $_POST['novo_aluno'];
                                    $novo_tipo = $_POST['novo_tipo'];
                                    $nova_data = $_POST['nova_data'];
                                    $nova_inst = $_POST['nova_inst'];
                        
                                    $query = "UPDATE aula SET aluno_nome = ?, aula_tipo = ?, aula_data = ?, instrutor_nome = ? WHERE aula_cod = ?";
                                    $stmt = $conexao->prepare($query);
                                    $stmt->bind_param("ssdsi", $novo_aluno, $novo_tipo, $nova_data, $novo_inst, $id);
                        
                                    if ($stmt->execute()) {
                                        echo "<script>
                                        Swal.fire({
                                            title: 'Linha atualizada com sucesso!',
                                            icon: 'success',
                                            confirmButtonColor: '#438e4b',
                                        }).then(function() {
                                            location.href = 'aula.php';
                                        });
                                        </script>";
                                    } else {
                                        echo "Erro ao editar linha: ".$conexao->error;
                                    }
                        
                                    $stmt->close();
                                }
                            }
                        }
                        ?>
                    </form>
                    <script>
                        let butEdit = document.querySelectorAll('#edi')
                        let edicao = document.querySelectorAll('.edicao')
                        let conteudo = document.querySelectorAll('.cont-atual')
                        let butExc = document.querySelectorAll('#exc')
                        let butCanc = document.querySelectorAll('#canc')
                        let butSalv = document.querySelectorAll('#salv')

                        butCanc.forEach((botao, index) => {
                            botao.addEventListener('click', () => {
                                edicao[index].classList.toggle('esconder');
                                conteudo[index].classList.toggle('mostrar');
                                butEdit[index].classList.toggle('mostrar');
                                butExc[index].classList.toggle('mostrar');
                                butSalv[index].classList.toggle('esconder');
                                butCanc[index].classList.toggle('esconder');
                            })
                        })

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
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>