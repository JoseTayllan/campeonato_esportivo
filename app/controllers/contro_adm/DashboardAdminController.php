<?php
require_once __DIR__ . '/../../Models/model_adm/Admin.php';

class DashboardAdminController {
    public function carregarDashboard($admin_id) {
        return [
            'estatisticas' => Admin::obterResumoPorUsuario($admin_id),
            'campeonatos'  => Admin::listarCampeonatosPorUsuario($admin_id),
        ];
    }
}

