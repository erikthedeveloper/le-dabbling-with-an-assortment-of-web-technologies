# PHP

## System Config and Boot Up Hello World

- ...
- ...

## MySQL

##### MySQL Basics

```sql
CREATE TABLE people (
id INT PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(255) NOT NULL,
age INT,
signed_in_at DATE);

SHOW TABLES;

EXPLAIN people;

INSERT INTO people (name, age, signed_in_at) VALUES ('DJ', 27, NOW());

SELECT * FROM people;
SELECT id, name, age FROM people;
```

### Credentials

### Use w/ PHP

## App Specs

- ...
- ...
- ...