CREATE TABLE people (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    age INT
);

INSERT INTO people (first_name, last_name) VALUES ("Joe", "Schmoe");
INSERT INTO people (first_name, last_name) VALUES ("Sally", "Jane");
INSERT INTO people (first_name, last_name) VALUES ("Wendy", "Burger");

-- CREATE TABLE people (
-- id INT PRIMARY KEY AUTO_INCREMENT,
-- name VARCHAR(255) NOT NULL,
-- age INT,
-- signed_in_at DATE);

-- SHOW TABLES;

-- EXPLAIN people;

-- INSERT INTO people (name, age, signed_in_at) VALUES ('DJ', 27, NOW());