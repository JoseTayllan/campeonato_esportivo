<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../lib/fpdf.php';

class ExportAvaliacaoController {

    public function exportarPDF() {
        global $conn;
    
        if (ob_get_length()) ob_end_clean();
    
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="avaliacoes.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
    
        $query = "SELECT a.forca, a.velocidade, a.drible, a.finalizacao, 
                         a.nota_geral, a.observacoes, j.nome AS jogador_nome, 
                         u.nome AS olheiro_nome
                  FROM avaliacoes a
                  JOIN jogadores j ON a.jogador_id = j.id
                  JOIN usuarios u ON a.olheiro_id = u.id";
    
        if (isset($_GET['jogador_id'])) {
            $jogador_id = intval($_GET['jogador_id']);
            $query .= " WHERE a.jogador_id = $jogador_id";
        }
    
        $query .= " ORDER BY a.nota_geral DESC";
    
        $result = $conn->query($query);
        if (!$result || $result->num_rows === 0) {
            die("Nenhuma avaliação encontrada.");
        }
    
        $pdf = new FPDF();
        $pdf->AddPage();
    
        // Título
        $pdf->SetFillColor(50, 50, 50);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(190, 10, 'Avaliacoes de Jogadores', 1, 1, 'C', true);
        $pdf->Ln(3);
    
        // Cabeçalho
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(40, 8, 'Jogador', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Olheiro', 1, 0, 'C', true);
        $pdf->Cell(15, 8, 'Forca', 1, 0, 'C', true);
        $pdf->Cell(20, 8, 'Veloc.', 1, 0, 'C', true);
        $pdf->Cell(15, 8, 'Drible', 1, 0, 'C', true);
        $pdf->Cell(20, 8, 'Final.', 1, 0, 'C', true);
        $pdf->Cell(15, 8, 'Nota', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Obs.', 1, 1, 'C', true);
    
        // Dados
        $pdf->SetFont('Arial', '', 9);
        $fill = false;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $pdf->SetFillColor($fill ? 245 : 255);
            $pdf->Cell(40, 7, mb_convert_encoding($row['jogador_nome'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', $fill);
            $pdf->Cell(40, 7, mb_convert_encoding($row['olheiro_nome'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', $fill);
            $pdf->Cell(15, 7, $row['forca'], 1, 0, 'C', $fill);
            $pdf->Cell(20, 7, $row['velocidade'], 1, 0, 'C', $fill);
            $pdf->Cell(15, 7, $row['drible'], 1, 0, 'C', $fill);
            $pdf->Cell(20, 7, $row['finalizacao'], 1, 0, 'C', $fill);
            $pdf->Cell(15, 7, $row['nota_geral'], 1, 0, 'C', $fill);
            $pdf->Cell(40, 7, mb_convert_encoding($row['observacoes'] ?? '', 'ISO-8859-1', 'UTF-8'), 1, 1, 'C', $fill);
            $fill = !$fill;
        }
    
        // Rodapé com data
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(190, 7, 'Exportado em: ' . date('d/m/Y H:i'), 0, 0, 'R');
    
        $pdf->Output('I', 'avaliacoes.pdf');
        exit;
    }
    

    public function exportarCSV() {
        global $conn;
    
        // Define cabeçalhos
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="avaliacoes.csv"');
    
        // Abre a saída padrão com UTF-8 BOM para acentos no Excel
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
    
        // Cabeçalho
        $cabecalho = ['Jogador', 'Olheiro', 'Força', 'Velocidade', 'Drible', 'Finalização', 'Nota Geral', 'Observações'];
        fputcsv($output, $cabecalho, ';');
    
        $query = "SELECT a.forca, a.velocidade, a.drible, a.finalizacao, 
                         a.nota_geral, a.observacoes, j.nome AS jogador_nome, 
                         u.nome AS olheiro_nome
                  FROM avaliacoes a
                  JOIN jogadores j ON a.jogador_id = j.id
                  JOIN usuarios u ON a.olheiro_id = u.id";
    
        if (isset($_GET['jogador_id'])) {
            $jogador_id = intval($_GET['jogador_id']);
            $query .= " WHERE a.jogador_id = $jogador_id";
        }
    
        $query .= " ORDER BY a.nota_geral DESC";
    
        $result = $conn->query($query);
    
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $linha = [
                $row['jogador_nome'] ?? '',
                $row['olheiro_nome'] ?? '',
                $row['forca'] ?? '',
                $row['velocidade'] ?? '',
                $row['drible'] ?? '',
                $row['finalizacao'] ?? '',
                $row['nota_geral'] ?? '',
                $row['observacoes'] ?? ''
            ];
            fputcsv($output, $linha, ';');
        }
    
        fclose($output);
        exit;
    }
    

    public function exportarEstatisticasPDF() {
        global $conn;
    
        if (ob_get_length()) ob_end_clean();
    
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="estatisticas.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
    
        $query = "SELECT e.partida_id, p.data AS data_partida, j.nome AS jogador_nome, 
                        e.gols, e.assistencias, e.passes_completos, e.finalizacoes, 
                        e.faltas_cometidas, e.cartoes_amarelos, e.cartoes_vermelhos, 
                        e.minutos_jogados, e.substituicoes
                  FROM estatisticas_partida e
                  JOIN jogadores j ON e.jogador_id = j.id
                  JOIN partidas p ON e.partida_id = p.id
                  ORDER BY p.data ASC";
    
        $result = $conn->query($query);
        if (!$result || $result->num_rows === 0) {
            die("Nenhuma estatística encontrada.");
        }
    
        $pdf = new FPDF();
        $pdf->AddPage('L');
    
        // Título
        $pdf->SetFillColor(50, 50, 50);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Estatisticas dos Jogadores por Partida', 1, 1, 'C', true);
        $pdf->Ln(3);
    
        // Cabeçalho
        $headers = ['Partida', 'Jogador', 'Gols', 'Assist.', 'Passes', 'Finaliz.', 'Faltas', 'Amarelos', 'Vermelhos', 'Min.', 'Subs'];
        $widths  = [40, 40, 12, 15, 20, 20, 18, 18, 20, 15, 15];
    
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(0);
        $pdf->SetFillColor(230, 230, 230);
        foreach ($headers as $i => $title) {
            $pdf->Cell($widths[$i], 8, $title, 1, 0, 'C', true);
        }
        $pdf->Ln();
    
        // Dados
        $pdf->SetFont('Arial', '', 8);
        $fill = false;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $partidaLabel = "Partida #{$row['partida_id']} - " . date('d/m/Y', strtotime($row['data_partida']));
            $pdf->SetFillColor($fill ? 245 : 255);
    
            $pdf->Cell($widths[0], 7, mb_convert_encoding($partidaLabel, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', $fill);
            $pdf->Cell($widths[1], 7, mb_convert_encoding($row['jogador_nome'] ?? '', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', $fill);
            $pdf->Cell($widths[2], 7, $row['gols'], 1, 0, 'C', $fill);
            $pdf->Cell($widths[3], 7, $row['assistencias'], 1, 0, 'C', $fill);
            $pdf->Cell($widths[4], 7, $row['passes_completos'], 1, 0, 'C', $fill);
            $pdf->Cell($widths[5], 7, $row['finalizacoes'], 1, 0, 'C', $fill);
            $pdf->Cell($widths[6], 7, $row['faltas_cometidas'], 1, 0, 'C', $fill);
            $pdf->Cell($widths[7], 7, $row['cartoes_amarelos'], 1, 0, 'C', $fill);
            $pdf->Cell($widths[8], 7, $row['cartoes_vermelhos'], 1, 0, 'C', $fill);
            $pdf->Cell($widths[9], 7, $row['minutos_jogados'], 1, 0, 'C', $fill);
            $pdf->Cell($widths[10], 7, $row['substituicoes'], 1, 1, 'C', $fill);
            $fill = !$fill;
        }
    
        // Rodapé com data de exportação
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 7, 'Exportado em: ' . date('d/m/Y H:i'), 0, 0, 'R');
    
        $pdf->Output('I', 'estatisticas.pdf');
        exit;
    }
    
    public function exportarEstatisticasCSV() {
        global $conn;
    
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="estatisticas.csv"');
    
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
    
        // Cabeçalho
        $cabecalho = [
            'Partida', 'Jogador', 'Gols', 'Assistências', 'Passes Completos', 
            'Finalizações', 'Faltas Cometidas', 'Cartões Amarelos', 'Cartões Vermelhos', 
            'Minutos Jogados', 'Substituições'
        ];
        fputcsv($output, $cabecalho, ';');
    
        $query = "SELECT e.partida_id, p.data AS data_partida, j.nome AS jogador_nome, 
                         e.gols, e.assistencias, e.passes_completos, e.finalizacoes, 
                         e.faltas_cometidas, e.cartoes_amarelos, e.cartoes_vermelhos, 
                         e.minutos_jogados, e.substituicoes
                  FROM estatisticas_partida e
                  JOIN jogadores j ON e.jogador_id = j.id
                  JOIN partidas p ON e.partida_id = p.id
                  ORDER BY p.data ASC";
    
        $result = $conn->query($query);
    
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $partidaTexto = "Partida #{$row['partida_id']} - " . date('d/m/Y', strtotime($row['data_partida']));
            $linha = [
                $partidaTexto,
                $row['jogador_nome'] ?? '',
                $row['gols'] ?? 0,
                $row['assistencias'] ?? 0,
                $row['passes_completos'] ?? 0,
                $row['finalizacoes'] ?? 0,
                $row['faltas_cometidas'] ?? 0,
                $row['cartoes_amarelos'] ?? 0,
                $row['cartoes_vermelhos'] ?? 0,
                $row['minutos_jogados'] ?? 0,
                $row['substituicoes'] ?? 0
            ];
            fputcsv($output, $linha, ';');
        }
    
        fclose($output);
        exit;
    }
    
}
