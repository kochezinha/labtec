<?php include("header.php"); ?>

<div class="container text-center mt-3 mb-5">

    <!-- Alerta para informar a quantidade de incidentes -->
    <?php
    include("conexaoBD.php");

    // Contar total de incidentes
    $resultado = mysqli_query($conn, "SELECT COUNT(*) as total FROM incidente");
    $row = mysqli_fetch_assoc($resultado);
    $totalIncidentes = $row['total'];
    ?>
    <div class="alert alert-info text-center" style="width:50%; margin:auto;">
        Há <strong><?php echo $totalIncidentes; ?></strong> incidentes cadastrados em nosso sistema!
    </div>
    <br>

    <!-- Formulário para aplicar filtros aos incidentes -->
    <form name="formFiltro" action="index.php" method="GET" style="width:50%; margin:auto;">
        <select class="form-select" name="filtroLaboratorio" required>
            <option value="todos">Visualizar todos os Laboratórios</option>
            <option value="Lab 1">Lab 1</option>
            <option value="Lab 2">Lab 2</option>
            <option value="Lab 3">Lab 3</option>
            <option value="Lab 4">Lab 4</option>
            <option value="Lab 5">Lab 5</option>
        </select><br>
        <button type="submit" class="btn btn-primary" style="float:right">
            Filtrar Incidentes
        </button>
    </form>

    <!-- Início da exibição dos incidentes -->
    <div class="row mt-5">
        <?php
        // Verifica se o filtro foi aplicado
        $filtroLaboratorio = isset($_GET['filtroLaboratorio']) ? $_GET['filtroLaboratorio'] : 'todos';

        // Cria a consulta com base no filtro selecionado
        if ($filtroLaboratorio == 'todos') {
            $query = "SELECT * FROM incidente";
        } else {
            $query = "SELECT * FROM incidente WHERE laboratorio = '$filtroLaboratorio'";
        }

        $resultado = mysqli_query($conn, $query);

        // Exibe os incidentes
        while ($incidente = mysqli_fetch_assoc($resultado)) {
            ?>
        <div class="col-sm-3">
    <div class="card" style="width:100%; height:100%;">
        <?php
        // Verifica se a imagem existe
        $fotoIncidente = $incidente['fotoIncidente'];
        if (file_exists($fotoIncidente) && !empty($fotoIncidente)) {
            echo "<img class='card-img-top' src='$fotoIncidente' alt='Imagem do Incidente'>";
        } else {
            echo "<img class='card-img-top' src='img/default-image.jpg' alt='Imagem Padrão'>"; // Caminho para a imagem padrão
        }
        ?>
        <div class="card-body">
            <p class="card-text">Descrição: <?php echo $incidente['descricao']; ?></p>
            <p class="card-text">Laboratório: <?php echo $incidente['laboratorio']; ?></p>
            <p class="card-text">Número do Computador: <?php echo $incidente['numeroComputador']; ?></p>
            <p class="card-text">Status: <?php echo $incidente['status']; ?></p>
            <a href="#" class="btn btn-primary">Ver Detalhes</a>
        </div>
    </div>
</div>

            <?php
        }
        ?>
    </div>

</div>

<?php include("footer.php"); ?>
