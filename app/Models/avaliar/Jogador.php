<?php
require_once __DIR__ . '/../../../config/database.php';

class Jogador
{
    // Lista todos os jogadores (usado para seleção em formulários)
    public static function buscarTodos()
    {
        global $conn;
        $query = "SELECT id, nome FROM jogadores ORDER BY nome ASC";
        $result = $conn->query($query);
        return $result ? $result->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    // Lista jogadores filtrados por treinador/criador (se necessário)
    public static function buscarPorCriador($criador_id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT id, nome FROM jogadores WHERE criado_por = ?");
        $stmt->bindValue(1, $criador_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->get_result()->fetchAll(PDO::FETCH_ASSOC);
    }

    // Salva avaliação do jogador
    public static function salvarAvaliacao($dados)
    {
        global $conn;
        $stmt = $conn->prepare("
            INSERT INTO avaliacoes (
                jogador_id, olheiro_id, forca, velocidade, drible,
                finalizacao, nota_geral, observacoes
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "iiiiiiis",
            $dados['jogador_id'],
            $dados['olheiro_id'],
            $dados['forca'],
            $dados['velocidade'],
            $dados['drible'],
            $dados['finalizacao'],
            $dados['nota_geral'],
            $dados['observacoes']
        );

        return $stmt->execute();
    }
}
