CREATE TABLE people (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    age INT
);

CREATE TABLE new_uploads (
    id INT PRIMARY KEY AUTO_INCREMENT,
    original_filename VARCHAR(255) NOT NULL,
    stored_filename VARCHAR(255) NOT NULL,
    file_type VARCHAR(255) NOT NULL,
    file_size INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP
);

-------------------+------------------+------+-----+---------+----------------+
| id                | int(11) unsigned | NO   | PRI | NULL    | auto_increment |
| original_filename | varchar(255)     | YES  |     | NULL    |                |
| file_type         | varchar(255)     | YES  |     | NULL    |                |
| file_size         | int(11)          | YES  |     | NULL    |                |
| title             | varchar(255)     | YES  |     | NULL    |                |
| uploaded_at       | timestamp        | YES  |     | NULL    |                |
| stored_filename   | varchar(255)     | YES  |     | NULL


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