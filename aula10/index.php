<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_professor'])) {
    $nome = $_POST['nome'];
    $sql = "INSERT INTO Professor (nome) VALUES ('$nome')";
    if ($conn->query($sql) === TRUE) {
        echo "Professor adicionado com sucesso!<br>";
    } else {
        echo "Erro: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_aula'])) {
    $sala = $_POST['sala'];
    $nome_professor = $_POST['nome_professor'];
    $sql = "SELECT id_professor FROM Professor WHERE nome = '$nome_professor'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_professor = $row['id_professor'];
        $sql = "INSERT INTO Aula (sala, id_professor) VALUES ('$sala', $id_professor)";
        if ($conn->query($sql) === TRUE) {
            echo "Aula adicionada com sucesso!<br>";
        } else {
            echo "Erro: " . $conn->error;
        }
    } else {
        echo "Professor não encontrado.<br>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $sql = $tipo == 'professor' ? "DELETE FROM Professor WHERE id_professor = $id" : "DELETE FROM Aula WHERE id_aula = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Registro deletado com sucesso!<br>";
    } else {
        echo "Erro: " . $conn->error;
    }
}

$aulas = $conn->query("SELECT Aula.id_aula, Aula.sala, Professor.nome FROM Aula JOIN Professor ON Aula.id_professor = Professor.id_professor");
$professores = $conn->query("SELECT * FROM Professor");
$professores_nomes = $conn->query("SELECT * FROM Professor");
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Professor e Aula</title>
    <script>
        function confirmarDelecao() {
            return confirm("Tem certeza que deseja deletar este registro?");
        }
    </script>
</head>
<body>

<h2>Adicionar Professor</h2>
<form method="post" action="">
    <label for="nome">Nome do Professor:</label>
    <input type="text" id="nome" name="nome" required>
    <button type="submit" name="add_professor">Adicionar Professor</button>
</form>

<h2>Adicionar Aula</h2>
<form method="post" action="">
    <label for="nome_professor">Nome do Professor:</label>
    <select id="nome_professor" name="nome_professor" required>
        <?php while ($row = $professores->fetch_assoc()): ?>
            <option value="<?= $row['nome'] ?>"><?= $row['nome'] ?></option>
        <?php endwhile; ?>
    </select>
    <label for="sala">Sala:</label>
    <input type="text" id="sala" name="sala" required>
    <button type="submit" name="add_aula">Adicionar Aula</button>
</form>

<h2>Professores Cadastrados</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Ações</th>
    </tr>
    <?php while ($row = $professores_nomes->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_professor'] ?></td>
        <td><?= $row['nome'] ?></td>
        <td>
            <form method="post" action="" style="display:inline;" onsubmit="return confirmarDelecao();">
                <input type="hidden" name="id" value="<?= $row['id_professor'] ?>">
                <input type="hidden" name="tipo" value="professor">
                <button type="submit" name="delete">Deletar</button>
            </form>
            <form method="get" action="editar_professor.php" style="display:inline;">
                <input type="hidden" name="id" value="<?= $row['id_professor'] ?>">
                <button type="submit">Editar</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<h2>Aulas Cadastradas</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Sala</th>
        <th>Professor</th>
        <th>Ações</th>
    </tr>
    <?php while ($row = $aulas->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_aula'] ?></td>
        <td><?= $row['sala'] ?></td>
        <td><?= $row['nome'] ?></td>
        <td>
            <form method="post" action="" style="display:inline;" onsubmit="return confirmarDelecao();">
                <input type="hidden" name="id" value="<?= $row['id_aula'] ?>">
                <input type="hidden" name="tipo" value="aula">
                <button type="submit" name="delete">Deletar</button>
            </form>
            <form method="get" action="editar_aula.php" style="display:inline;">
                <input type="hidden" name="id" value="<?= $row['id_aula'] ?>">
                <button type="submit">Editar</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
