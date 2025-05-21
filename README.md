# ChampCore - Gestão Esportiva Profissional

Sistema de gestão de campeonatos esportivos para múltiplas modalidades, desenvolvido em PHP nativo com arquitetura MVC simplificada.

## Modalidades Esportivas

O sistema suporta as seguintes modalidades esportivas:

- 🟢 **Futebol**: Controle completo de partidas, escalações e desempenho dos jogadores.
- 🟢 **Futsal**: Variante do futebol para quadras.
- 🟢 **Queimada**: Organização de campeonatos e estatísticas de eliminações.
- 🟢 **Natação**: Registro de tempos, acompanhamento de recordes e gestão de provas.
- 🟢 **Vôlei**: Controle de sets, pontuações e estatísticas detalhadas de jogadores.
- 🟢 **1x1**: Modalidades de duelos individuais.
- 🟢 **2x2**: Modalidades de duelos em duplas.

## Funcionalidades Principais

- **Gestão de Campeonatos**: 
  - Criação de campeonatos por modalidade
  - Suporte a diferentes formatos (Pontos Corridos, Mata-Mata, Fase de Grupos)
  - Controle de temporadas

- **Gerenciamento de Times**:
  - Cadastro de times
  - Vinculação de times a campeonatos
  - Codificação pública para acesso simplificado

- **Controle de Partidas**:
  - Programação de rodadas e partidas
  - Escalações de jogadores
  - Registro de eventos (gols, cartões, substituições)
  - Estatísticas individuais e coletivas

- **Acompanhamento em Tempo Real**:
  - Placar ao vivo
  - Minuto a minuto
  - Visualização pública para torcedores

- **Perfis de Acesso**:
  - Administrador: controle geral do sistema
  - Time Essencial/Técnico: gestão de equipes específicas
  - Olheiro: acompanhamento de estatísticas
  - Patrocinador: visibilidade da marca

## Testes Automatizados

O sistema inclui um framework de testes abrangente com ambiente isolado, garantindo que testes não afetem dados de produção:

- **Banco de Dados Isolado**: Utiliza SQLite em memória por padrão para testes rápidos e isolados
- **Framework de Testes Personalizado**: Implementado em PHP para verificar a funcionalidade do sistema
- **Testes Unitários**: Validação das operações básicas de CRUD
- **Testes de Funcionalidade**: Verifica o filtro por modalidade e outras funcionalidades essenciais
- **Ambiente Configurável**: Permite usar MySQL dedicado para testes se desejado

### Para executar os testes:

```bash
# Executar todos os testes
php tests/run.php

# Executar teste específico
php tests/run.php campeonato
php tests/run.php filtro
```

Para mais detalhes sobre os testes, consulte a [documentação de testes](tests/README.md).

## Requisitos do Sistema

- PHP 7.4 ou superior
- MySQL 5.7 ou superior (para produção)
- SQLite (para testes)
- Servidor web (Apache/Nginx)
- Extensões PHP: mysqli, pdo, pdo_sqlite

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/JoseTayllan/campeonato_esportivo.git
```

2. Importe o banco de dados:
```bash
mysql -u usuario_mysql -p < db/Atual/dump_15_tabelas_truncate_fk_ok.sql
```

3. Configure o acesso ao banco de dados em `config/database.php`

4. Acesse a aplicação pelo navegador:
```
http://localhost/campeonato_esportivo
```

## Contribuindo

1. Faça um fork do projeto
2. Crie sua branch de feature (`git checkout -b feature/sua-feature`)
3. Escreva testes para sua nova funcionalidade
4. Commit suas mudanças (`git commit -m 'Adiciona nova feature'`)
5. Push para a branch (`git push origin feature/sua-feature`)
6. Abra um Pull Request
