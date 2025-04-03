CREATE DATABASE IF NOT EXISTS my_database;
USE my_database;
CREATE TABLE IF NOT EXISTS student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    birthday DATE NOT NULL
);
INSERT INTO student (name, birthday)
VALUES 
    ('Aymen', '1982-02-07'),
    ('Skander', '2018-07-11');
