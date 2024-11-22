-- CreateTable
CREATE TABLE "administradores" (
    "matricula" SERIAL NOT NULL,
    "cargo" VARCHAR(20) NOT NULL,
    "dataadmissao" DATE NOT NULL,
    "datarecisao" DATE,
    "statusadministrador" BOOLEAN NOT NULL,
    "cpf" VARCHAR(14) NOT NULL,

    CONSTRAINT "pk_administrador" PRIMARY KEY ("matricula")
);

-- CreateTable
CREATE TABLE "clientes" (
    "numero" SERIAL NOT NULL,
    "empresa" VARCHAR(20) NOT NULL,
    "statususuarios" BOOLEAN NOT NULL,
    "cpf" VARCHAR(14) NOT NULL,

    CONSTRAINT "pk_usuario" PRIMARY KEY ("numero")
);

-- CreateTable
CREATE TABLE "experimentos" (
    "numerolote" INTEGER NOT NULL,
    "dataexperimento" DATE NOT NULL,
    "datavalidadeexperimento" DATE NOT NULL,
    "peso" DOUBLE PRECISION NOT NULL,
    "volume" DOUBLE PRECISION NOT NULL,
    "presencasm" BOOLEAN NOT NULL,
    "temperaturalote" DOUBLE PRECISION NOT NULL,
    "ph" DOUBLE PRECISION NOT NULL,
    "condicaoexperimento" VARCHAR(20) NOT NULL,
    "obsexperimento" VARCHAR(255) NOT NULL,
    "matriculatecnico" INTEGER NOT NULL,

    CONSTRAINT "pk_experimento" PRIMARY KEY ("numerolote")
);

-- CreateTable
CREATE TABLE "pessoas" (
    "cpf" VARCHAR(14) NOT NULL,
    "nome" VARCHAR(100) NOT NULL,
    "telefonefixo" VARCHAR(15),
    "telefonecelular" VARCHAR(15) NOT NULL,
    "email" VARCHAR(100) NOT NULL,
    "rua" VARCHAR(100),
    "bairro" VARCHAR(100),
    "cidade" VARCHAR(100),
    "estado" VARCHAR(2),
    "senha" VARCHAR(255) NOT NULL,
    "tipo_usuario" INTEGER NOT NULL,

    CONSTRAINT "pk_pessoa" PRIMARY KEY ("cpf")
);

-- CreateTable
CREATE TABLE "tecnicos" (
    "matricula" SERIAL NOT NULL,
    "cargo" VARCHAR(20) NOT NULL,
    "registro" VARCHAR(15) NOT NULL,
    "dataadmissao" DATE NOT NULL,
    "datarecisao" DATE,
    "statustecnico" BOOLEAN NOT NULL,
    "cpf" VARCHAR(14) NOT NULL,

    CONSTRAINT "pk_tecnico" PRIMARY KEY ("matricula")
);

-- CreateIndex
CREATE UNIQUE INDEX "uk_registro" ON "tecnicos"("registro");

-- AddForeignKey
ALTER TABLE "administradores" ADD CONSTRAINT "fk_adm_pessoa" FOREIGN KEY ("cpf") REFERENCES "pessoas"("cpf") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- AddForeignKey
ALTER TABLE "clientes" ADD CONSTRAINT "fk_user_pessoa" FOREIGN KEY ("cpf") REFERENCES "pessoas"("cpf") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- AddForeignKey
ALTER TABLE "experimentos" ADD CONSTRAINT "fk_experimento_tecnico" FOREIGN KEY ("matriculatecnico") REFERENCES "tecnicos"("matricula") ON DELETE NO ACTION ON UPDATE NO ACTION;

-- AddForeignKey
ALTER TABLE "tecnicos" ADD CONSTRAINT "fk_tec_pessoa" FOREIGN KEY ("cpf") REFERENCES "pessoas"("cpf") ON DELETE NO ACTION ON UPDATE NO ACTION;
