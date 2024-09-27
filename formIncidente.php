<?php include("header.php") ?>

<div class="container-fluid text-center">
    <h2>Registro de Incidente:</h2>

    <div class="d-flex justify-content-center mb-3">
        <div class="row">
            <div class="col-sm-12">
                <form action="actionIncidente.php" class="was-validated" method="POST" enctype="multipart/form-data">
                    
                    <div class="form-floating mb-3 mt-3">
                        <input type="date" class="form-control" id="dataIncidente" name="dataIncidente" required>
                        <label for="dataIncidente" class="form-label">Data do Incidente:</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <input type="file" class="form-control" id="fotoIncidente" name="fotoIncidente" required>
                        <label for="fotoIncidente" class="form-label">Foto:</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <textarea class="form-control" id="descricaoIncidente" placeholder="Informe uma descrição do Incidente" name="descricaoIncidente" required></textarea>
                        <label for="descricaoIncidente" class="form-label">Descrição do Incidente:</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select" id="categoriaIncidente" name="categoriaIncidente" required>
                            <option value="hardware">Hardware</option>
                            <option value="software">Software</option>
                            <option value="rede">Rede</option>
                            <option value="outros">Outros</option>
                        </select>
                        <label for="categoriaIncidente" class="form-label">Categoria:</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select" id="laboratorioIncidente" name="laboratorioIncidente" required>
                            <option value="Lab 1">Lab 1</option>
                            <option value="Lab 2">Lab 2</option>
                            <option value="Lab 3">Lab 3</option>
                            <option value="Lab 4">Lab 4</option>
                            <option value="Lab 5">Lab 5</option>
                        </select>
                        <label for="laboratorioIncidente" class="form-label">Laboratório do Incidente:</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <input type="number" class="form-control" id="numeroComputador" placeholder="Número do computador" name="numeroComputador" required min="1">
                        <label for="numeroComputador" class="form-label">Número do Computador:</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>


                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select" id="statusIncidente" name="statusIncidente" required>
                            <option value="pendente">Pendente</option>
                            <option value="resolvido">Resolvido</option>
                            <option value="em progresso">Em Progresso</option>
                        </select>
                        <label for="statusIncidente" class="form-label">Status do Incidente:</label>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
    <br>
    <br>
</div>

<?php include("footer.php") ?>
