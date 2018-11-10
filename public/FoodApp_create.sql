CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT,
    email varchar(200) NOT NULL,
    password text NOT NULL,
    name varchar(500) NOT NULL,
    school varchar(100) NOT NULL,
    CONSTRAINT users_pk PRIMARY KEY(id)
);

INSERT INTO users (email, password, name, school)
VALUES ('lacherv@gmail.com', '123456', 'Christian Awelakoue', 'Robertsham School');

SELECT email, password, name, school FROM users;