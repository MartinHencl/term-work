CREATE TABLE user (
    id            integer,
    username      VARCHAR(100),
    password      VARCHAR(100),
    email         VARCHAR(100),
    description   VARCHAR(500),
    created       DATE,
    PRIMARY KEY (id)
);

insert into user(id, username, password, email, description, created) values(1, "Karel", "heslo", "mail", "pokus", '2008-7-04');
select * from user;