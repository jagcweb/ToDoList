CREATE DATABASE IF NOT EXISTS todolist;
USE todolist;

CREATE TABLE IF NOT EXISTS users(

    id                 int(255) auto_increment not null,
    role               varchar(50) not null,
    name               varchar(100) not null,
    surname            varchar(200) not null,
    email              varchar(200) not null,
    password           varchar(255) not null,
    created_at         datetime,
    CONSTRAINT pk_users PRIMARY KEY (id)

)ENGINE=InnoDb;


CREATE TABLE IF NOT EXISTS tasks(

    id                 int(255) auto_increment not null,
    user_id            int(255) not null,
    title              varchar(100) not null,
    content            text not null,
    priority           varchar(100)  not null,
    hours              int(100) not null,
    created_at         datetime,
    CONSTRAINT pk_tasks PRIMARY KEY (id),
    CONSTRAINT fk_task_user FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;