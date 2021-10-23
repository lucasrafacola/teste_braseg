create table fornecedores(
	id_forn int not null auto_increment,
    nome_forn varchar(150) not null,
    primary key (id_forn)
);

create table produtos(
	id_prod int not null auto_increment,
    nome_prod varchar(100) not null,
    preco_prod float(10,2) not null,
    id_forn int not null,
    primary key (id_prod),
    foreign key (id_forn) references fornecedores(id_forn)
);

create table vendas(
	id_venda int not null auto_increment,
    id_prod int not null,
    primary key (id_venda),
    preco_venda float(10,2) not null,
    foreign key (id_prod) references produtos(id_prod)
);

alter table vendas
add data_venda date not null;