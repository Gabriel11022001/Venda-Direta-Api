-- criar a tabela de clientes
create table if not exists tb_clientes(
    cliente_id serial primary key,
    nome text not null,
    cpf text not null,
    data_nascimento date not null,
    status boolean not null default true,
    usuario_id integer not null,
    foreign key(usuario_id) references tb_usuarios(usuario_id)
);

-- criar tabela de e-mails
create table if not exists tb_emails(
    email_id serial primary key,
    email text not null,
    cliente_id integer not null,
    foreign key(cliente_id) references tb_clientes(cliente_id)
);

-- criar tabela de enderecos
create table if not exists tb_enderecos(
    endereco_id serial primary key,
    cep text not null,
    logradouro text not null,
    complemento text,
    cidade text not null,
    bairro text not null,
    uf text not null,
    numero text,
    cliente_id integer not null,
    foreign key(cliente_id) references tb_clientes(cliente_id)
);

-- criar tabela de telefone
create table if not exists tb_telefones(
    telefone_id serial primary key,
    telefone text not null,
    principal boolean not null default false,
    cliente_id integer not null,
    foreign key(cliente_id) references tb_clientes(cliente_id)
);
