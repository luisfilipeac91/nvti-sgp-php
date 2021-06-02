-- developer.dbo.nvt_parametros definition

-- Drop table

-- DROP TABLE developer.dbo.nvt_parametros;

CREATE TABLE developer.dbo.nvt_parametros (
	id int IDENTITY(1,1) NOT NULL,
	acao varchar(20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	valor text COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	CONSTRAINT nvt_params_PK PRIMARY KEY (id),
	CONSTRAINT nvt_params_UN UNIQUE (id)
);
CREATE UNIQUE NONCLUSTERED INDEX nvt_params_UN ON developer.dbo.nvt_parametros (id);


-- developer.dbo.nvt_professores definition

-- Drop table

-- DROP TABLE developer.dbo.nvt_professores;

CREATE TABLE developer.dbo.nvt_professores (
	id int IDENTITY(1,1) NOT NULL,
	nome varchar(120) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	CONSTRAINT nvt_professores_PK PRIMARY KEY (id),
	CONSTRAINT nvt_professores_UN UNIQUE (id)
);
CREATE UNIQUE NONCLUSTERED INDEX nvt_professores_UN ON developer.dbo.nvt_professores (id);


-- developer.dbo.nvt_alunos definition

-- Drop table

-- DROP TABLE developer.dbo.nvt_alunos;

CREATE TABLE developer.dbo.nvt_alunos (
	id int IDENTITY(1,1) NOT NULL,
	nome varchar(120) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	professor int NULL,
	data_vencimento date NOT NULL,
	mensalidade decimal(8,2) DEFAULT 0 NOT NULL,
	CONSTRAINT nvt_alunos_PK PRIMARY KEY (id),
	CONSTRAINT nvt_alunos_UN UNIQUE (id),
	CONSTRAINT [nvt_alunos_FK-professores] FOREIGN KEY (professor) REFERENCES developer.dbo.nvt_professores(id)
);
CREATE UNIQUE NONCLUSTERED INDEX nvt_alunos_UN ON developer.dbo.nvt_alunos (id);