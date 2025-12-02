CREATE TABLE Users (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL,
    Firstname VARCHAR(100),
    Lastname VARCHAR(100),
    Email VARCHAR(255) NOT NULL UNIQUE,
    Role ENUM('Ecole', 'Entreprise', 'Admin', 'Default'),
    Password VARCHAR(255) NOT NULL,
    Active BOOL DEFAULT 1
);

CREATE TABLE Quizzs (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Creator_id INT NOT NULL,
    Active BOOL DEFAULT 1,
    Finished BOOL DEFAULT 0,
    FOREIGN KEY (Creator_id) REFERENCES Users(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Participation_users (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Id_quizz INT NOT NULL,
    Id_user INT NOT NULL,
    Note INT,
    FOREIGN KEY (Id_quizz) REFERENCES Quizzs(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (Id_user) REFERENCES Users(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Questions_checkbox_ecole (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Quizz_id INT NOT NULL,
    Question TEXT NOT NULL,
    Position INT,
    Passed INT DEFAULT 0,
    Points INT,
    FOREIGN KEY (Quizz_id) REFERENCES Quizzs(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Answers_checkbox_ecole (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Question_id INT NOT NULL,
    Text TEXT NOT NULL,
    Is_answer BOOL DEFAULT 0,
    FOREIGN KEY (Question_id) REFERENCES Questions_checkbox_ecole(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Questions_libre_ecole (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Quizz_id INT NOT NULL,
    Question TEXT NOT NULL,
    Position INT,
    Reponse TEXT,
    Passed INT DEFAULT 0,
    Points INT,
    FOREIGN KEY (Quizz_id) REFERENCES Quizzs(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Questions_libre_entreprise (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Quizz_id INT NOT NULL,
    Question TEXT NOT NULL,
    Position INT,
    FOREIGN KEY (Quizz_id) REFERENCES Quizzs(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Reponses_libre_entreprise (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Question_id INT NOT NULL,
    Text TEXT NOT NULL,
    FOREIGN KEY (Question_id) REFERENCES Questions_libre_entreprise(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Questions_checkbox_entreprise (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Question TEXT NOT NULL,
    Quizz_id INT NOT NULL,
    Position INT,
    FOREIGN KEY (Quizz_id) REFERENCES Quizzs(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE Answers_checkbox_entreprise (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Question_id INT NOT NULL,
    Text TEXT NOT NULL,
    FOREIGN KEY (Question_id) REFERENCES Questions_checkbox_entreprise(ID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);