<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $sala = $_POST['sala'];
   

   

    $sql = "UPDATE Aula SET sala='$sala'  WHERE id_aula=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Aula atualizada com sucesso!<br>";
    } else {
        echo "Erro: " . $conn->error;
    }
}

$id_aula = $_GET['id'];
$aula_result = $conn->query("SELECT * FROM Aula WHERE id_aula = $id_aula");
$aula = $aula_result->fetch_assoc();
$professores = $conn->query("SELECT * FROM Professor");
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aula</title>
</head>
<body>

<h2>Editar Aula</h2>

<form method="post" action="">
    <input type="hidden" name="id" value="<?= $aula['id_aula'] ?>">
    
    </select>
    <label for="sala">Sala:</label>
    <input type="text" id="sala" name="sala" value="<?= $aula['sala'] ?>" required>
    <button type="submit">Atualizar Aula</button>
</form>
<a href="index.php">Voltar</a>

</body>
</html>
