-- criar a tabela de categorias de produtos
create table if not exists tb_categorias(
    categoria_id serial primary key,
    nome text not null,
    status boolean not null default true
);