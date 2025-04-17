<?php 
session_start();
include 'views/cabecalho/header_index.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Campeonatos</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card-custom {
            transition: 0.3s;
            border-radius: 10px;
            cursor: pointer;
        }

        .card-custom:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>



<!-- Placar em Tempo Real -->
<div class="container my-5">
    <h3 class="text-center mb-4">Placar ao Vivo</h3>
    <div class="row justify-content-center" id="placarTempoReal">
        <!-- Exemplo de Partida (item dinâmico futuro) -->
        <div class="col-md-6 mb-4 text-center">
            <div class="d-flex align-items-center justify-content-around border rounded p-3 bg-white shadow-sm">
                <img src="assets/logos/time1.png" alt="Time 1" class="logo-time" style="width: 60px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalTime1">
                <strong class="fs-4 mx-3">2 x 1</strong>
                <img src="assets/logos/time2.png" alt="Time 2" class="logo-time" style="width: 60px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalTime2">
            </div>
        </div>
    </div>
</div>

<!-- Modal Escalação Time 1 -->
<div class="modal fade" id="modalTime1" tabindex="-1" aria-labelledby="modalTime1Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Escalação - Time 1</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Lista dinâmica futura -->
                <ul>
                    <li>Goleiro: João</li>
                    <li>Zagueiro: Marcos</li>
                    <li>Meia: Lucas</li>
                    <!-- ... -->
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal Escalação Time 2 -->
<div class="modal fade" id="modalTime2" tabindex="-1" aria-labelledby="modalTime2Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Escalação - Time 2</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Lista dinâmica futura -->
                <ul>
                    <li>Goleiro: Pedro</li>
                    <li>Zagueiro: Vinícius</li>
                    <li>Atacante: Felipe</li>
                    <!-- ... -->
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Resultados de Jogos Passados - Design com Cards -->
<div class="container my-5">
    <h3 class="text-center mb-4">Resultados Anteriores</h3>
    <div class="row justify-content-center" id="resultadosPassados">

        <!-- Exemplo de Card de Resultado -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center bg-light rounded">
                    <p class="text-muted mb-1">15/04/2025</p>
                    <div class="d-flex justify-content-around align-items-center mb-2">
                        <div class="text-center">
                            <img src="assets/logos/time1.png" alt="Time 1" style="width: 40px;">
                            <p class="mb-0 fw-semibold">Time A</p>
                        </div>
                        <div class="fs-4 fw-bold">2 x 0</div>
                        <div class="text-center">
                            <img src="assets/logos/time2.png" alt="Time 2" style="width: 40px;">
                            <p class="mb-0 fw-semibold">Time B</p>
                        </div>
                    </div>
                    <span class="badge bg-secondary">Finalizado</span>
                </div>
            </div>
        </div>

        <!-- Exemplo de Card de Resultado -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center bg-light rounded">
                    <p class="text-muted mb-1">15/04/2025</p>
                    <div class="d-flex justify-content-around align-items-center mb-2">
                        <div class="text-center">
                            <img src="assets/logos/time1.png" alt="Time 1" style="width: 40px;">
                            <p class="mb-0 fw-semibold">Time A</p>
                        </div>
                        <div class="fs-4 fw-bold">2 x 0</div>
                        <div class="text-center">
                            <img src="assets/logos/time2.png" alt="Time 2" style="width: 40px;">
                            <p class="mb-0 fw-semibold">Time B</p>
                        </div>
                    </div>
                    <span class="badge bg-secondary">Finalizado</span>
                </div>
            </div>
        </div>

        <!-- Exemplo de Card de Resultado -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center bg-light rounded">
                    <p class="text-muted mb-1">15/04/2025</p>
                    <div class="d-flex justify-content-around align-items-center mb-2">
                        <div class="text-center">
                            <img src="assets/logos/time1.png" alt="Time 1" style="width: 40px;">
                            <p class="mb-0 fw-semibold">Time A</p>
                        </div>
                        <div class="fs-4 fw-bold">2 x 0</div>
                        <div class="text-center">
                            <img src="assets/logos/time2.png" alt="Time 2" style="width: 40px;">
                            <p class="mb-0 fw-semibold">Time B</p>
                        </div>
                    </div>
                    <span class="badge bg-secondary">Finalizado</span>
                </div>
            </div>
        </div>

        <!-- Adicione mais cards aqui dinamicamente via PHP/JS -->

    </div>
</div>


<?php include 'views/cabecalho/footer.php'; ?>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
