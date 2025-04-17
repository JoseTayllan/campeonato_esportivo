<?php 
session_start();
require_once __DIR__ . '/../../../config/database.php';
?>

<?php include '../cabecalho/header.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>

        body {
            background: linear-gradient(to bottom, #0d0d0d, #f8f9fa);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        body {
            background-color: #f8f9fa;
        }

        .card-cadastro {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            background-color: #0d0d0d;
            color: #fff;
        }

        .btn-login-voltar {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
        }

        .form-label {
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container mt-5 mb-5"> <!-- mb-5 aqui evita que cole no footer -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-cadastro shadow">
                <div class="card-header text-center">
                    <h4><i class="bi bi-person-plus-fill me-2"></i>Cadastro de Usuário</h4>
                </div>
                <div class="card-body bg-white">
                    
                    <?php include '../partials/mensagens.php'; ?>

                    <form action="../../../routes/users.php" method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" name="nome" placeholder="Ex: Ana Pereira" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" name="email" placeholder="Ex: ana@email.com" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" name="senha" placeholder="Crie uma senha segura" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Usuário</label>
                            <select class="form-control" name="tipo" required>
                                <option value="">Selecione um tipo</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Organizador">Organizador</option>
                                <option value="Treinador">Treinador</option>
                                <option value="Jogador">Jogador</option>
                                <option value="Olheiro">Olheiro</option>
                                <option value="Patrocinador">Patrocinador</option>
                            </select>
                        </div>

                        <!-- Botão de cadastrar -->
                        <button type="submit" class="btn btn-dark w-100 mb-2">
                            <i class="bi bi-save me-1"></i> Cadastrar
                        </button>

                        <!-- Botão de login abaixo -->
                        <a href="../login/login.php" class="btn btn-outline-dark w-100">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Já tem conta? Fazer login
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
