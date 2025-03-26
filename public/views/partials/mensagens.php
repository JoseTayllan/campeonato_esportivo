<?php 
if (isset($_SESSION['mensagem_erro'])): ?>
    <div class="alert alert-danger">
        <?php echo $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['mensagem_sucesso'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['erro'])): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($_GET['erro']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success">
        <?php echo htmlspecialchars($_GET['sucesso']); ?>
    </div>
<?php endif; ?>
