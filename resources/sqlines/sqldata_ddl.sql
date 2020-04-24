-- SQLines Data 3.1.777 x86_64 Linux - Database Migration Tool.
-- Copyright (c) 2018 SQLines. All Rights Reserved.

-- All DDL SQL statements executed for the target database

-- Current timestamp: 2020:04:23 04:58:06.373

DROP TABLE IF EXISTS MIDW.COM_LOJAS;

-- Ok (2 ms)

CREATE TABLE MIDW.COM_LOJAS
(
   `NUMERO_SAP` VARCHAR(30) NOT NULL,
   `ORG_VENDAS` VARCHAR(12) NOT NULL,
   `CANAL` VARCHAR(6) NOT NULL,
   `SECTOR` VARCHAR(6) NOT NULL,
   `NAME1` VARCHAR(120) NOT NULL,
   `NAME4` VARCHAR(120) NOT NULL,
   `PESQUISA` VARCHAR(60) NOT NULL,
   `RUA1` VARCHAR(180) NOT NULL,
   `CODIGO_POSTAL` VARCHAR(30) NOT NULL,
   `LOCALIDADE` VARCHAR(120) NOT NULL,
   `PAIS` VARCHAR(9) NOT NULL,
   `COD_CONCELHO` VARCHAR(12),
   `COD_DISTRITO` VARCHAR(24),
   `TELEFONE` VARCHAR(90) NOT NULL,
   `EMAIL` VARCHAR(723),
   `NIF` VARCHAR(60) NOT NULL,
   `ESCRITORIO_VENDAS` VARCHAR(75),
   `EQUIPA_VENDAS` VARCHAR(72),
   `TIPO_CLIENTE` VARCHAR(60)
);

-- Failed (0 ms)
-- Unknown database 'MIDW'