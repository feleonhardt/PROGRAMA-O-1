create database PDO;

use PDO;

create table marcas(
codigo int primary key auto_increment,
descricao varchar(45)
);


create table produtos(
codigo int primary key auto_increment,
codMarca int,
descricao varchar(45),
valor double,
imagem varchar(45),
cod_barra varchar(45),
FOREIGN KEY (codMarca) REFERENCES marcas(codigo)
);

insert into marcas(descricao) values
('LG'),
('DELL'),
('SONY'),
('NESTLE'),
('MOTOROLA');


insert into produtos(descricao, valor, imagem, cod_barra, codMarca) values
('TV', 1200.00, 'tv_lg.png', '12345', 1),
('NOTEBOOK', 4600, 'notebook.png', '67890', 2),
('TV', 1500, 'tv_sony.png', '09876', 3),
('LEITE', 24, 'leite_nestle.png', '54321', 4),
('SMARTPHONE', 1000, 'cell.png', '13579', 5),
('CELULAR', 600.00, 'cell_lg.png', '97531', 1);

select * from marcas;
select * from produtos;




drop table MARCAS;
drop table produtos;