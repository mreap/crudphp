-- script de creación de la base de datos crudphp. 
-- Ejecutar con el usuario root de mysql:
-- mysql -u root -p < scriptbdd.sql
drop database if exists crudphp;
create database crudphp;
grant all privileges on crudphp.* to curso@localhost identified by "curso";
use crudphp;

create table producto(
    codigo serial primary key,
    nombre varchar(50) not null unique,
    precio float(7,2) not null,
    cantidad int not null
);
insert into producto(nombre,precio,cantidad) values('computador',720.3,10);
insert into producto(nombre,precio,cantidad) values('mouse usb',4.25,40);
insert into producto(nombre,precio,cantidad) values('teclado',7.5,30);

    
