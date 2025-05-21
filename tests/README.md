# ChampCore - Framework de Testes Automatizados

Este diretório contém os testes automatizados para o sistema ChampCore de gestão de campeonatos esportivos. Os testes foram projetados para serem executados em um ambiente isolado, garantindo que os dados de produção não sejam afetados durante o processo de teste.

## Banco de Dados Isolado

Os testes utilizam um banco de dados completamente separado do ambiente de produção:

- **SQLite em memória** (padrão): Rápido, sem persistência e totalmente isolado
- **MySQL dedicado** (configurável): Para testes que necessitam de recursos específicos do MySQL

Esta abordagem garante que:
- Nenhum dado de produção seja modificado durante os testes
- Os testes possam ser executados em qualquer ambiente sem preparação prévia
- Cada execução de teste comece com um banco limpo e consistente

## Testes Disponíveis

O framework inclui os seguintes conjuntos de testes:

### Campeonato

Testes para as operações básicas de gerenciamento de campeonatos:
- Criação de campeonatos de diferentes modalidades
- Busca de campeonatos por ID
- Listagem de todos os campeonatos
- Associação de times a campeonatos
- Atualização de campeonatos

### Filtro

Testes para a funcionalidade de filtrar campeonatos por modalidade:
- Listagem de todos os campeonatos ativos
- Filtragem de campeonatos por modalidade específica (Futebol, Queimada, Natação, Vôlei)
- Verificação de comportamento ao buscar por modalidade inexistente

## Como Executar os Testes

### Executar Todos os Testes

```bash
php tests/run.php
```

### Executar um Teste Específico

```bash
php tests/run.php campeonato
php tests/run.php filtro
```

## Configuração do Ambiente de Teste

Por padrão, os testes usam SQLite em memória, que não requer configuração adicional. Para usar MySQL:

1. Edite o arquivo `config/database.test.php`
2. Descomente e configure as variáveis de conexão MySQL
3. Altere a variável `$TEST_DB_TYPE` para 'mysql'

```php
$TEST_DB_TYPE = 'mysql';
$TEST_DB_HOST = 'localhost';
$TEST_DB_USER = 'seu_usuario';
$TEST_DB_PASS = 'sua_senha';
$TEST_DB_NAME = 'champcore_test';
```

## Estrutura do Framework de Testes

O framework de testes consiste em:

- **run.php**: Script principal para execução dos testes
- **database.test.php**: Configuração do banco de dados de teste
- **TestFramework**: Classe auxiliar para registro e execução de testes
- **Classes de teste**: CampeonatoTest, FilterTest, etc.

## Criando Novos Testes

Para criar um novo conjunto de testes:

1. Crie uma nova classe seguindo o padrão dos testes existentes
2. Implemente os métodos `setupInitialData()`, `registerTests()`, `run()` e `tearDown()`
3. Registre o teste em `run.php` adicionando-o ao array `$availableTests`

## Melhores Práticas

- Sempre limpe os dados criados durante os testes no método `tearDown()`
- Use identificadores aleatórios para evitar conflitos em execuções paralelas
- Mantenha os testes independentes uns dos outros
- Evite dependências de serviços externos ou APIs durante os testes

## Resolução de Problemas

Se os testes falharem:

1. Verifique se as configurações de banco de dados estão corretas
2. Confirme que todas as dependências estão sendo carregadas
3. Execute os testes individualmente para isolar o problema
4. Verifique os logs de erro em `tests/logs/` (se disponíveis) 