-- criar a tabela de produtos
create table if not exists tb_produtos(
    produto_id serial primary key,
    nome_produto text not null,
    preco_venda decimal not null,
    status boolean not null default true,
    unidades_estoque integer not null,
    foto text,
    categoria_id integer not null,
    foreign key(categoria_id) references tb_categorias(categoria_id)
);