<?php
require_once __DIR__ . '/../../Models/patrocinador/Patrocinador.php';

class AtualizarBannerController {
    private $model;

    public function __construct($conn) {
        $this->model = new Patrocinador($conn);
    }

    public function atualizarLogo($usuario_id, $arquivo) {
        if (empty($arquivo['name'])) return false;

        $upload_dir = __DIR__ . '/../../../public/img/patrocinadores/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $nome_limpo = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', pathinfo($arquivo['name'], PATHINFO_FILENAME));
        $logo_nome = uniqid() . '_' . $nome_limpo . '.' . $extensao;
        $destino = $upload_dir . $logo_nome;

        if (!move_uploaded_file($arquivo['tmp_name'], $destino)) return false;

        $logo_path = 'public/img/patrocinadores/' . $logo_nome;
        return $this->model->atualizarLogoPorUsuario($usuario_id, $logo_path);
    }
}
