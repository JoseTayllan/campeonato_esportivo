CREATE TABLE times_campeonatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    time_id INT NOT NULL,
    campeonato_id INT NOT NULL,
    FOREIGN KEY (time_id) REFERENCES times(id) ON DELETE CASCADE,
    FOREIGN KEY (campeonato_id) REFERENCES campeonatos(id) ON DELETE CASCADE
);
