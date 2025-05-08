<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Patrocinador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card p-4 shadow">
        <h3 class="mb-4">Cadastrar Dados da Empresa Patrocinadora</h3>

        <form action="/campeonato_esportivo/routes/patrocinador/cadastrar_patrocinador.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nome da Empresa</label>
                <input type="text" name="nome_empresa" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Contrato</label>
                <input type="text" name="contrato" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Telefone</label>
                <input type="text" name="telefone" class="form-control" placeholder="(XX) XXXXX-XXXX" required>
            </div>

            <div class="mb-3">
                <label>Logo da Empresa (opcional)</label>
                <input type="file" name="logo" class="form-control">
            </div>

            <div class="alert alert-info text-center">
                O valor a ser investido será informado na hora de vincular a um time.
            </div>

            <button type="submit" class="btn btn-success">Cadastrar Empresa</button>
        </form>
    </div>
</div>
</body>
</html>
