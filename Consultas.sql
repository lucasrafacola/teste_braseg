select * from fornecedores;

select * from produtos;

select * from produtos t0
inner join fornecedores t1 on t0.id_forn = t1.id_forn
order by t0.nome_prod;

select * from vendas;

select * from vendas t0
inner join produtos t1 on t0.id_prod = t1.id_prod
inner join fornecedores t2 on t1.id_forn = t2.id_forn;