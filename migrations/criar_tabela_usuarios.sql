-- criar a tabela de usuários
create table if not exists tb_usuarios(
    usuario_id serial primary key,
    nome text not null,
    email text not null,
    login text not null,
    senha text not null,
    nivel_acesso text not null,
    status boolean not null default true
);