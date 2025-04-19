
-- Tabela de Patrocinadores
CREATE TABLE patrocinadores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_empresa VARCHAR(100) NOT NULL,
    contrato TEXT,
    valor_investido DECIMAL(10,2),
    logo VARCHAR(255) -- caminho do arquivo da logo
);

-- Tabela de relacionamento entre Patrocinador e Time
CREATE TABLE patrocinador_time (
    id INT PRIMARY KEY AUTO_INCREMENT,
    patrocinador_id INT NOT NULL,
    time_id INT NOT NULL,
    data_inicio DATE,
    data_fim DATE,
    FOREIGN KEY (patrocinador_id) REFERENCES patrocinadores(id),
    FOREIGN KEY (time_id) REFERENCES times(id)
);
