<?php include("header.php"); ?>

<?php
// Bloco para declaração das variáveis
$fotoincidente = $nomeIncidente = $descricaoIncidente = $categoriaIncidente = $laboratorioIncidente = "";
$numeroComputador = $statusIncidente = "";
$dataCadastroIncidente = date('Y-m-d'); // Data no formato AAAA-MM-DD
$horaCadastroIncidente = date('H:i:s'); // Horas no formato HH:MM:SS
$erroPreenchimento = false; // Controle de erros

// Verifica o método de envio do FORM
if ($_SERVER["REQUEST_METHOD"] == "POST") {



    // Validação do campo descricaoIncidente
    if (empty($_POST["descricaoIncidente"])) {
        echo "<div class='alert alert-warning text-center'>O campo <strong>DESCRIÇÃO</strong> é obrigatório!</div>";
        $erroPreenchimento = true;
    } else {
        $descricaoIncidente = filtrar_entrada($_POST["descricaoIncidente"]);
    }

      // Validação do campo dataIncidente
      if (empty($_POST["dataIncidente"])) {
        echo "<div class='alert alert-warning text-center'>O campo <strong>DATA DO INCIDENTE</strong> é obrigatório!</div>";
        $erroPreenchimento = true;
    } else {
        $dataIncidente = filtrar_entrada($_POST["dataIncidente"]);
    }

    // Validação do campo categoriaIncidente
    if (empty($_POST["categoriaIncidente"])) {
        echo "<div class='alert alert-warning text-center'>O campo <strong>CATEGORIA</strong> é obrigatório!</div>";
        $erroPreenchimento = true;
    } else {
        $categoriaIncidente = filtrar_entrada($_POST["categoriaIncidente"]);
    }

    // Validação do campo laboratorioIncidente
    if (empty($_POST["laboratorioIncidente"])) {
        echo "<div class='alert alert-warning text-center'>O campo <strong>LABORATÓRIO</strong> é obrigatório!</div>";
        $erroPreenchimento = true;
    } else {
        $laboratorioIncidente = filtrar_entrada($_POST["laboratorioIncidente"]);
    }

    // Validação do campo numeroComputador
    if (empty($_POST["numeroComputador"])) {
        echo "<div class='alert alert-warning text-center'>O campo <strong>NÚMERO DO COMPUTADOR</strong> é obrigatório!</div>";
        $erroPreenchimento = true;
    } else {
        $numeroComputador = filtrar_entrada($_POST["numeroComputador"]);
    }

    // Validação do campo statusIncidente
    if (empty($_POST["statusIncidente"])) {
        echo "<div class='alert alert-warning text-center'>O campo <strong>STATUS</strong> é obrigatório!</div>";
        $erroPreenchimento = true;
    } else {
        $statusIncidente = filtrar_entrada($_POST["statusIncidente"]);
    }

    // Início da validação da Foto do Usuário
    $diretorio = "img/"; // Diretório para as imagens
    $fotoIncidente = $diretorio . basename($_FILES["fotoIncidente"]["name"]); // img/ana.jpg
    $erroUpload = false; // Controle de erro de upload
    $tipoDaImagem = strtolower(pathinfo($fotoIncidente, PATHINFO_EXTENSION)); // Tipo do arquivo

    // Verifica se o tamanho da imagem é maior do que ZERO
    if ($_FILES["fotoIncidente"]["size"] != 0) {
        if ($_FILES["fotoIncidente"]["size"] > 5000000) { // Limite de 5MB
            echo "<div class='alert alert-warning text-center'>A foto não pode ser <strong>maior</strong> do que 5MB!</div>";
            $erroUpload = true;
        }

        // Tipos de imagem aceitos
        if ($tipoDaImagem != "jpg" && $tipoDaImagem != "jpeg" && $tipoDaImagem != "png" && $tipoDaImagem != "webp") {
            echo "<div class='alert alert-warning text-center'>A foto precisa estar nos formatos <strong>JPG, JPEG, PNG ou WEBP</strong>!</div>";
            $erroUpload = true;
        }

        if (!$erroUpload) {
            // Mover o arquivo para o diretório definido
            if (!move_uploaded_file($_FILES["fotoIncidente"]["tmp_name"], $fotoIncidente)) {
                echo "<div class='alert alert-warning text-center'>Erro ao tentar<strong>MOVER O ARQUIVO para o diretório $diretorio</strong>!</div>";
                $erroUpload = true;
            }
        }
    } else {
        echo "<div class='alert alert-warning text-center'>Erro ao tentar fazer o <strong>UPLOAD DA FOTO</strong>!</div>";
        $erroUpload = true;
    }

    // Se não houver erro de preenchimento ou upload
    if (!$erroPreenchimento && !$erroUpload) {
        // Cria a Query para inserção na tabela Incidentes
        $inserirIncidente = "INSERT INTO incidente (fotoincidente, numeroComputador, laboratorio, categoria, descricao, dataIncidente, status, idUsuario)
                             VALUES ('$fotoIncidente', '$numeroComputador', '$laboratorioIncidente', '$categoriaIncidente', '$descricaoIncidente', '$dataCadastroIncidente', '$statusIncidente', 3)"; 

        // Inclui o arquivo para conexão com o Banco de Dados
        include("conexaoBD.php");

        // Executa a QUERY no Banco de Dados
        if (mysqli_query($conn, $inserirIncidente)) {
            echo "
                       <div class='alert alert-success text-center'>Incidente cadastrado com sucesso!</div>
                <div class='container mt-3'>
                    <div class='container mt-3 text-center'>
                        <img src='$fotoIncidente' style='width: 150px;'>
                    </div>
                    <div class='table-responsive'>
                        <table class='table'>
                            <tr>
                                <th>NOME</th>
                                <td>$nomeIncidente</td>
                            </tr>
                            <tr>
                                <th>DESCRIÇÃO</th>
                                <td>$descricaoIncidente</td>
                            </tr>
                            <tr>
                                <th>DATA DO INCIDENTE</th>
                                <td>$dataIncidente</td>
                            </tr>
                            <tr>
                                <th>NÚMERO DO COMPUTADOR</th>
                                <td>$numeroComputador</td>
                            </tr>
                            <tr>
                                <th>LABORATÓRIO</th>
                                <td>$laboratorioIncidente</td>
                            </tr>
                            <tr>
                                <th>CATEGORIA</th>
                                <td>$categoriaIncidente</td>
                            </tr>
                            <tr>
                                <th>STATUS</th>
                                <td>$statusIncidente</td>
                            </tr>
                        </table>
                    </div>
                </div>
            ";
        } else {
            echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar Incidente!</div>" . mysqli_error($conn);
            echo "<p>$inserirIncidente</p>";
        }
    }
}

// Função para filtrar as entradas de dados do formulário para evitar SQL Injection
function filtrar_entrada($dado) {
    $dado = trim($dado); // Remove espaços desnecessários
    $dado = stripslashes($dado); // Remove as barras invertidas
    $dado = htmlspecialchars($dado); // Converte caracteres especiais em entidades HTML

    return $dado; // Retorna o dado filtrado
}
?>

<?php include("footer.php"); ?>
