<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];

    $sql = "UPDATE Professor SET nome='$nome' WHERE id_professor=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Professor atualizado com sucesso!<br>";
    } else {
        echo "Erro: " . $conn->error;
    }
}

$id_professor = $_GET['id'];
$professor_result = $conn->query("SELECT * FROM Professor WHERE id_professor = $id_professor");
$professor = $professor_result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Professor</title>
</head>
<body>

<h2>Editar Professor</h2>

<form method="post" action="">
    <input type="hidden" name="id" value="<?= $professor['id_professor'] ?>">
    <label for="nome">Nome do Professor:</label>
    <input type="text" id="nome" name="nome" value="<?= $professor['nome'] ?>" required>
    <button type="submit">Atualizar Professor</button>
</form>
<a href="index.php">Voltar</a>

</body>
</html>
