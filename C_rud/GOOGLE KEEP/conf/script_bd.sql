create database google_keep;

use google_keep;

create table anotacoes(
codigo integer auto_increment not null primary key,
titulo varchar(225) not null,
texto varchar(2000) not null,
cor_fundo varchar(10),
tags varchar(1000) not null,
ativa int not null,
star boolean not null
);

insert into anotacoes(titulo, texto, cor_fundo, tags, ativa, star) values
("Meu nome", "Felipe André Leonhardt", "#337722", "#Nome#Gatao#Masculino", 1, 1),
("Cidade", "Braço do Trombudo", "#ff0000", "#Nome#Pequena#Cidade", 1, 0),
("Notebook", "Dell Inspiron i15", "#00ff00", "#Nome#Gatao#Masculino", 0, 0),
("Celular", "Moto G4 plus", "#0000ff", "#Nome#Celular#Ruim", 0, 1),
("Meu nome", "Felipe André Leonhardt", "#372", "#Nome#Gatao#Masculino", 1, 1);

select * from anotacoes where (titulo like '%o%' or texto like '%o%') and star = 0;
select * from anotacoes where ativa = 0;

Update anotacoes set ativa = 1 where ativa = 0 and codigo =1;

delete from anotacoes where codigo >0;
select * from anotacoes;
drop database google_keep;
