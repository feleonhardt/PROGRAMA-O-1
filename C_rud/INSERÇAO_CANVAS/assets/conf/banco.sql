create database select_canvas;

use select_canvas;

create table vendedores(
codigo integer auto_increment not null primary key,
login varchar(40) not null,
senha varchar(100) not null,
nome varchar(255) not null,
e_mail varchar(255) not null,
telefone varchar(20) not null
);

create table funcionarios(
codigo integer auto_increment not null primary key,
nome varchar(255) not null,
salario float not null,
data_admissao date not null
);

create table carros(
codigo integer auto_increment not null primary key,
ano_fabricacao year not null,
data_venda date not null,
valor float not null
);

create table computadores(
codigo integer auto_increment not null primary key,
fabricante varchar(100) not null,
processador varchar(255) not null,
memoria varchar(255) not null,
hd varchar(255) not null
);

create table predios(
codigo integer auto_increment not null primary key,
nome varchar(255) not null,
salas int not null,
andares int not null
);

create table escolas(
codigo integer auto_increment not null primary key,
nome varchar(255) not null,
cidade varchar(255) not null,
alunos int not null,
diretor varchar(255) not null
);

insert into vendedores(login, senha, nome, e_mail, telefone)
values('felipe', '123456', 'Felipe André Leonhardt', 'felipeleonhardt@hotmail.com', '(47) 9 96994858'),
('uelinton', '654321', 'Uelinton Teske', 'uelinton.teske.9@gmail.com', '(47) 9 99994566'),
('fabio', '78901', 'Fabio Vitor Loterio', 'fabio@bol.com.br', '(47) 9 96569344'),
('henrique', '0987654', 'Henrique Borges dos Santos', 'henrique_dos_santos@gmail.com', '(47) 9 88884534');

insert into funcionarios(nome, salario, data_admissao)
values('felipe', 12345.60, '2019-02-23'),
('uelinton', 6543.21, '2019-04-01'),
('fabio', 78.90, '2019-06-26'),
('henrique', 98765.40, '2019-05-23');

insert into carros(ano_fabricacao, data_venda, valor)
values(2019, '2019-02-23', 12345.60),
(2000, '2019-04-01', 6543.21),
(2018, '2019-06-26', 78.90),
(2010, '2019-05-23', 98765.40);

insert into computadores(fabricante, processador, memoria, hd)
values('Dell', 'Intel core i9', '32GB',  '1TB'),
('Positivo', 'Intel core i5', '8GB',  '1TB'),
('Acer', 'Intel core i5', '16GB',  '500GB'),
('Lenovo', 'Intel core i7', '4GB', '500GB');

insert into predios(nome, salas, andares)
values('Itamarati', 900, 32),
('Oscar Niemayer', 120, 8),
('Abrahan', 50, 6),
('Globo', 1000, 50);

insert into escolas(nome, cidade, alunos, diretor)
values('IFC', 'Rio do Sul', 2000, 'Fabio Alexandrini'),
('Dom Bosco', 'Rio do Sul', 800, 'Virgulino'),
('COC', 'Rio do Sul', 2000, 'Ricão da Silva'),
('EBAM', 'Braço do Trombudo', 150, 'Lígia Vogel');

SHOW COLUMNS FROM escolas;
drop table escolas;