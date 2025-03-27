<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Estatistica.php';



require_once __DIR__ . '/../../lib/fpdf.php';

class ExportController {
    private $estatisticaModel;
    private $conn; // ✅ Corrigido aqui

    public function __construct($conn) {
        $this->conn = $conn;
        $this->estatisticaModel = new Estatistica($conn);
    }

    public function exportarCSV() {
        header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="estatisticas.csv"');

    // Adiciona BOM para acentuação correta no Excel
    echo "\xEF\xBB\xBF";
    $output = fopen('php://output', 'w');

    // Cabeçalhos
    fputcsv($output, [
        'Partida',
        'Jogador',
        'Gols',
        'Assistências',
        'Passes Completos',
        'Finalizações',
        'Faltas',
        'Cartões Amarelos',
        'Cartões Vermelhos',
        'Minutos Jogados',
        'Substituições'
    ], ';');

    // Verifica se veio um jogador_id
    $jogadorId = isset($_GET['jogador_id']) ? intval($_GET['jogador_id']) : null;

    $dados = $jogadorId
        ? $this->estatisticaModel->listarPorJogador($jogadorId)
        : $this->estatisticaModel->listarTodos();

    foreach ($dados as $linha) {
        fputcsv($output, [
            $linha['partida_id'] ?? '',
            $linha['jogador_nome'] ?? '',
            $linha['gols'] ?? '',
            $linha['assistencias'] ?? '',
            $linha['passes_completos'] ?? '',
            $linha['finalizacoes'] ?? '',
            $linha['faltas_cometidas'] ?? '',
            $linha['cartoes_amarelos'] ?? '',
            $linha['cartoes_vermelhos'] ?? '',
            $linha['minutos_jogados'] ?? '',
            $linha['substituicoes'] ?? ''
        ], ';');
    }

    fclose($output);
    exit();
    }

    public function exportarPDF($jogadorId = null) {
        $pdf = new FPDF();
        $pdf->AddPage();

        // Título com nome do jogador
        $titulo = 'Relatório de Estatísticas';
        if ($jogadorId) {
            $stmt = $this->conn->prepare("SELECT nome FROM jogadores WHERE id = ?");
            $stmt->bind_param("i", $jogadorId);
            $stmt->execute();

            $nomeJogador = ''; // evita erro
            $stmt->bind_result($nomeJogador);
            $stmt->fetch();
            $titulo = "Estatísticas do Jogador " . $nomeJogador;
            $stmt->close();
        }

        $pdf->SetFont('Helvetica', 'B', 14);
        $pdf->Cell(190, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $titulo), 1, 1, 'C');

        // Cabeçalho
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->Cell(18, 10, 'Partida', 1);
        $pdf->Cell(38, 10, 'Jogador', 1);
        $pdf->Cell(12, 10, 'Gols', 1);
        $pdf->Cell(12, 10, 'Assist.', 1);
        $pdf->Cell(18, 10, 'Passes', 1);
        $pdf->Cell(16, 10, 'Finaliz.', 1);
        $pdf->Cell(12, 10, 'Faltas', 1);
        $pdf->Cell(12, 10, 'Amar.', 1);
        $pdf->Cell(12, 10, 'Verm.', 1);
        $pdf->Cell(20, 10, 'Min. J.', 1);
        $pdf->Cell(20, 10, 'Subst.', 1);
        $pdf->Ln();

        $dados = $jogadorId
            ? $this->estatisticaModel->listarPorJogador($jogadorId)
            : $this->estatisticaModel->listarTodos();

        $pdf->SetFont('Helvetica', '', 10);
        foreach ($dados as $linha) {
            $pdf->Cell(18, 10, $linha['partida_id'] ?? '', 1);
            $pdf->Cell(38, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $linha['jogador_nome'] ?? ''), 1);
            $pdf->Cell(12, 10, $linha['gols'] ?? '', 1);
            $pdf->Cell(12, 10, $linha['assistencias'] ?? '', 1);
            $pdf->Cell(18, 10, $linha['passes_completos'] ?? '', 1);
            $pdf->Cell(16, 10, $linha['finalizacoes'] ?? '', 1);
            $pdf->Cell(12, 10, $linha['faltas_cometidas'] ?? '', 1);
            $pdf->Cell(12, 10, $linha['cartoes_amarelos'] ?? '', 1);
            $pdf->Cell(12, 10, $linha['cartoes_vermelhos'] ?? '', 1);
            $pdf->Cell(20, 10, $linha['minutos_jogados'] ?? '', 1);
            $pdf->Cell(20, 10, $linha['substituicoes'] ?? '', 1);
            $pdf->Ln();
        }

        $pdf->Output('D', 'estatisticas.pdf');
        exit();
    }
}