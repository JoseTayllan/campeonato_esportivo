CREATE TABLE times_campeonatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    time_id INT NOT NULL,
    campeonato_id INT NOT NULL,
    FOREIGN KEY (time_id) REFERENCES times(id) ON DELETE CASCADE,
    FOREIGN KEY (campeonato_id) REFERENCES campeonatos(id) ON DELETE CASCADE
);


//16/04

CREATE TABLE fases_campeonato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    campeonato_id INT NOT NULL,
    nome ENUM('Fase de Grupos', 'Oitavas de Final', 'Quartas de Final', 'Semifinal', 'Final') NOT NULL,
    ordem INT DEFAULT 1,
    FOREIGN KEY (campeonato_id) REFERENCES campeonatos(id) ON DELETE CASCADE
);

CREATE TABLE rodadas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fase_id INT NOT NULL,
    numero INT NOT NULL,
    tipo ENUM('Ida', 'Volta') DEFAULT 'Ida',
    descricao VARCHAR(100),
    FOREIGN KEY (fase_id) REFERENCES fases_campeonato(id) ON DELETE CASCADE
);

ALTER TABLE partidas ADD COLUMN rodada_id INT;
ALTER TABLE partidas ADD CONSTRAINT fk_rodada_id FOREIGN KEY (rodada_id) REFERENCES rodadas(id) ON DELETE SET NULL;
