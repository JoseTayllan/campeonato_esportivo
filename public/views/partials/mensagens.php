<?php if(isset($_SESSION['mensagem_erro'])): ?>
    <div class="alert alert-danger">
        <?php echo $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?>
    </div>
<?php endif; ?>

<?php if(isset($_SESSION['mensagem_sucesso'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?>
    </div>
<?php endif; ?>
