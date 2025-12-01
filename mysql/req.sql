CREATE TABLE Users (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Username TEXT NOT NULL,
    Firstname TEXT,
    Lastname TEXT,
    Email TEXT NOT NULL UNIQUE,
    Role TEXT CHECK (Role IN ('Ecole', 'Entreprise', 'Admin', 'Default')),
    Password TEXT NOT NULL,
    active BOOL DEFAULT 1
);

CREATE TABLE Quizzs (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name TEXT NOT NULL,
    Creator_id INT NOT NULL,
    active BOOL DEFAULT 1,
    finished BOOL DEFAULT 0,
    FOREIGN KEY (Creator_id) REFERENCES Users(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Participation_users (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Id_quizz INT NOT NULL,
    Id_user INT NOT NULL,
    note INT,
    FOREIGN KEY (Id_quizz) REFERENCES Quizzs(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (Id_user) REFERENCES Users(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Questions_checkbox (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Quizz_id INT NOT NULL,
    Position INT,
    Passed INT DEFAULT 0,
    Points INT,
    FOREIGN KEY (Quizz_id) REFERENCES Quizzs(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Answers_checkbox (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Question_id INT NOT NULL,
    Text TEXT NOT NULL,
    Is_answer BOOL DEFAULT 0,
    FOREIGN KEY (Question_id) REFERENCES Questions_checkbox(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Questions_libre (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Quizz_id INT NOT NULL,
    Position INT,
    Reponse TEXT,
    Passed INT DEFAULT 0,
    Points INT,
    FOREIGN KEY (Quizz_id) REFERENCES Quizzs(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
