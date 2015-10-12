-- ----------------------------------------------------------
-- MDB Tools - A library for reading MS Access database files
-- Copyright (C) 2000-2011 Brian Bruns and others.
-- Files in libmdb are licensed under LGPL and the utilities under
-- the GPL, see COPYING.LIB and COPYING files respectively.
-- Check out http://mdbtools.sourceforge.net
-- ----------------------------------------------------------

-- That file uses encoding UTF-8

CREATE TABLE `Clientes`
 (
	`CódigoDoCliente`			int, 
	`CódigoDoProduto`			int, 
	`DescriçãoDoProduto`			varchar (510)
);

CREATE TABLE `Clientes1`
 (
	`CódigoDoCliente`			int, 
	`CódigoDoProduto`			int
);

CREATE TABLE `Clientes2`
 (
	`CódigoDoCliente`			int, 
	`NomeEmpresa`			varchar (100)
);

CREATE TABLE `Cópia de OP`
 (
	`Número da OP`			int, 
	`Cliente`			varchar (60), 
	`CODIGO CLIENTE`			varchar (100), 
	`Numero Pedido`			int, 
	`Prazo de entrega`			datetime, 
	`Nome da Peça`			varchar (100), 
	`Número da Máquina`			varchar (40) NOT NULL, 
	`Matriz`			varchar (10) NOT NULL, 
	`kg`			varchar (20), 
	`Kg ind`			varchar (20), 
	`kg2`			varchar (20), 
	`kg2 ind`			varchar (20), 
	`kg3`			varchar (20), 
	`kg3 ind`			varchar (20), 
	`Kg 4`			varchar (20), 
	`kg4 ind`			varchar (20), 
	`Peso Total`			float, 
	`peso milheiro`			float, 
	`peso bobina`			float, 
	`Quantidade`			float, 
	`bol bobinas`			int, 
	`Data emissão`			datetime, 
	`metragem`			int, 
	`contador dif`			int, 
	`iso bobinas`			int
);
#COMMENT ON COLUMN `Cópia de OP`.`Número da OP` IS 'Chave';
#COMMENT ON COLUMN `Cópia de OP`.`Cliente` IS 'Selecionar o cliente';
#COMMENT ON COLUMN `Cópia de OP`.`CODIGO CLIENTE` IS 'CÓDIGO DO CLIENTE';
#COMMENT ON COLUMN `Cópia de OP`.`Numero Pedido` IS 'numero do pedido';
#COMMENT ON COLUMN `Cópia de OP`.`Prazo de entrega` IS 'Inserir prazo de entrega';
#COMMENT ON COLUMN `Cópia de OP`.`Nome da Peça` IS 'Selecionar o nome da peça';
#COMMENT ON COLUMN `Cópia de OP`.`Número da Máquina` IS 'Inserir número da máquina';
#COMMENT ON COLUMN `Cópia de OP`.`Matriz` IS 'Inserir número da matriz';
#COMMENT ON COLUMN `Cópia de OP`.`Quantidade` IS 'Inserir quantidade do pedido';
#COMMENT ON COLUMN `Cópia de OP`.`Data emissão` IS 'data da emissão (automático)';
#COMMENT ON COLUMN `Cópia de OP`.`metragem` IS 'metagem da bobina extrudada';
#COMMENT ON COLUMN `Cópia de OP`.`contador dif` IS 'contador para o relatorio de OP entregues no prazo';

CREATE TABLE `Detalhes do Pedido`
 (
	`CódigoDoPedido`			int, 
	`DataDaVenda`			date, 
	`PreçoUnitário`			float
);

CREATE TABLE `Fechamento`
 (
	`OP`			int NOT NULL, 
	`Horas prod ext`			int, 
	`Minutos prod ext`			int, 
	`QT prod ext`			int, 
	`Data ext`			datetime, 
	`Aparas Ext`			float, 
	`Horas prod corte`			int, 
	`Minutos prod corte`			int, 
	`Qt prod corte`			int, 
	`Data corte`			datetime, 
	`Aparas corte`			float, 
	`Horas prod impr`			int, 
	`Minutos prod impr`			int, 
	`Qt prod impr`			int, 
	`Data prod impr`			datetime, 
	`Aparas impressão`			float, 
	`Horas prod bolha`			int, 
	`Minutos prod bolha`			int, 
	`Qt prod bolha`			int, 
	`Data prod bolha`			datetime, 
	`Aparas bolha`			float, 
	`Data expediçao`			datetime, 
	`GRAMATURA`			int, 
	`Expedid`			char NOT NULL
);
#COMMENT ON COLUMN `Fechamento`.`OP` IS 'Número da OP';
#COMMENT ON COLUMN `Fechamento`.`Horas prod ext` IS 'Horas gastas na Extrusão';
#COMMENT ON COLUMN `Fechamento`.`Minutos prod ext` IS 'Minutos gastos na Extrusão';
#COMMENT ON COLUMN `Fechamento`.`QT prod ext` IS 'Qt produzida na extrusão';
#COMMENT ON COLUMN `Fechamento`.`Data ext` IS 'Data final da estrusão';
#COMMENT ON COLUMN `Fechamento`.`Aparas Ext` IS 'QT de aparas produzidas na extrusão';
#COMMENT ON COLUMN `Fechamento`.`Horas prod corte` IS 'Horas gastas no Corte / Solda';
#COMMENT ON COLUMN `Fechamento`.`Minutos prod corte` IS 'Minutos gastos no Corte / Solda';
#COMMENT ON COLUMN `Fechamento`.`Qt prod corte` IS 'Qt produzida no corte solda';
#COMMENT ON COLUMN `Fechamento`.`Data corte` IS 'Data final do Corte / Solda';
#COMMENT ON COLUMN `Fechamento`.`Aparas corte` IS 'QT de aparas produzidas no corte / solda';
#COMMENT ON COLUMN `Fechamento`.`Horas prod impr` IS 'Horas gastas na Impressão';
#COMMENT ON COLUMN `Fechamento`.`Minutos prod impr` IS 'Minutos gastos na Impressão';
#COMMENT ON COLUMN `Fechamento`.`Qt prod impr` IS 'Qt impressa';
#COMMENT ON COLUMN `Fechamento`.`Data prod impr` IS 'Data final da impressão';
#COMMENT ON COLUMN `Fechamento`.`Aparas impressão` IS 'QT de aparas produzidas na impressão';
#COMMENT ON COLUMN `Fechamento`.`Horas prod bolha` IS 'Horas gastas na produção da bolha';
#COMMENT ON COLUMN `Fechamento`.`Minutos prod bolha` IS 'Minutos gasto na produção da bolha';
#COMMENT ON COLUMN `Fechamento`.`Qt prod bolha` IS 'Qt de bolha prosuzida';
#COMMENT ON COLUMN `Fechamento`.`Data prod bolha` IS 'Data da produçao do bolha';
#COMMENT ON COLUMN `Fechamento`.`Aparas bolha` IS 'QT de aparas produzidas no bolha';
#COMMENT ON COLUMN `Fechamento`.`Data expediçao` IS 'Data de expedição';
#COMMENT ON COLUMN `Fechamento`.`GRAMATURA` IS 'GRAMATURA MEDIDA';

CREATE TABLE `OP`
 (
	`Número da OP`			int, 
	`Cliente`			varchar (60), 
	`CODIGO CLIENTE`			varchar (100), 
	`Numero Pedido`			int, 
	`Prazo de entrega`			datetime, 
	`Nome da Peça`			varchar (100), 
	`Número da Máquina`			varchar (40) NOT NULL, 
	`Matriz`			varchar (10) NOT NULL, 
	`kg`			varchar (20), 
	`Kg ind`			varchar (20), 
	`kg2`			varchar (20), 
	`kg2 ind`			varchar (20), 
	`kg3`			varchar (20), 
	`kg3 ind`			varchar (20), 
	`Kg 4`			varchar (20), 
	`kg4 ind`			varchar (20), 
	`kg5`			varchar (20), 
	`kg5ind`			varchar (20), 
	`kg6`			varchar (20), 
	`kg6ind`			varchar (20), 
	`Peso Total`			float, 
	`peso milheiro`			float, 
	`peso bobina`			float, 
	`Quantidade`			float, 
	`bol bobinas`			int, 
	`Data emissão`			datetime, 
	`metragem`			int, 
	`contador dif`			int, 
	`iso bobinas`			int, 
	`pedcli`			varchar (60), 
	`unidade`			varchar (6)
);
#COMMENT ON COLUMN `OP`.`Número da OP` IS 'Chave';
#COMMENT ON COLUMN `OP`.`Cliente` IS 'Selecionar o cliente';
#COMMENT ON COLUMN `OP`.`CODIGO CLIENTE` IS 'CÓDIGO DO CLIENTE';
#COMMENT ON COLUMN `OP`.`Numero Pedido` IS 'numero do pedido';
#COMMENT ON COLUMN `OP`.`Prazo de entrega` IS 'Inserir prazo de entrega';
#COMMENT ON COLUMN `OP`.`Nome da Peça` IS 'Selecionar o nome da peça';
#COMMENT ON COLUMN `OP`.`Número da Máquina` IS 'Inserir número da máquina';
#COMMENT ON COLUMN `OP`.`Matriz` IS 'Inserir número da matriz';
#COMMENT ON COLUMN `OP`.`Quantidade` IS 'Inserir quantidade do pedido';
#COMMENT ON COLUMN `OP`.`Data emissão` IS 'data da emissão (automático)';
#COMMENT ON COLUMN `OP`.`metragem` IS 'metagem da bobina extrudada';
#COMMENT ON COLUMN `OP`.`contador dif` IS 'contador para o relatorio de OP entregues no prazo';
#COMMENT ON COLUMN `OP`.`pedcli` IS 'numero produto cliente';
#COMMENT ON COLUMN `OP`.`unidade` IS 'unidade';

CREATE TABLE `produtos`
 (
	`Nome da peça`			varchar (100) NOT NULL, 
	`Código da Peça`			varchar (60) NOT NULL, 
	`ean`			varchar (26), 
	`validade`			int, 
	`Materia prima`			varchar (100), 
	`%1`			float, 
	`MP2`			varchar (40), 
	`%2`			float, 
	`MP3`			varchar (40), 
	`%3`			float, 
	`materia prima 4`			varchar (40), 
	`% 4`			float, 
	`mp5`			varchar (40), 
	`qmp5`			float, 
	`mp6`			varchar (40), 
	`qmp6`			float, 
	`densidade`			float, 
	`gramatura`			float, 
	`Tipo de Bobina`			varchar (100), 
	`Tratamento porcentagem`			varchar (100), 
	`Lados`			varchar (100), 
	`Bobina Largura (cm)`			varchar (40) NOT NULL, 
	`tol largura bob`			float, 
	`tol largura bob -`			float, 
	`refilar`			varchar (100), 
	`bobinas por vez`			varchar (100), 
	`Bobina Espessura 1 (micras)`			varchar (100) NOT NULL, 
	`tol espess1`			float, 
	`tol espess1 -`			float, 
	`Bobina Espessura 2 (micras)`			varchar (100), 
	`tol espess2`			float, 
	`tol espess2 -`			float, 
	`Bobina Sanfona (cm)`			varchar (100) NOT NULL, 
	`tol sanfona ext`			float, 
	`tol sanfona ext -`			float, 
	`Impressão`			varchar (100), 
	`Dentes do Cilindro`			int, 
	`Codigo Cyrel1`			varchar (100), 
	`Codigo Cyrel2`			varchar (100), 
	`Codigo Cyrel3`			varchar (100), 
	`Codigo Cyrel4`			varchar (100), 
	`Cor 1`			varchar (100), 
	`Cor 2`			varchar (100), 
	`Cor 3`			varchar (100), 
	`Cor 4`			varchar (100), 
	`Cor 5`			varchar (100), 
	`Cor 6`			varchar (100), 
	`Cor 7`			varchar (100), 
	`Cor 8`			varchar (100), 
	`Modelo Saco`			varchar (100), 
	`Ziper`			char NOT NULL, 
	`N Ziper`			int, 
	`Tipo Solda`			varchar (100), 
	`Cortar por vez`			varchar (100), 
	`Saco Largura/Boca`			float, 
	`tol largura`			float, 
	`tol largura -`			float, 
	`Saco Comprimento`			float, 
	`tol comprimento`			float, 
	`tol comprimento -`			float, 
	`Saco Espessura`			float, 
	`tol espessura`			float, 
	`tol espessura -`			float, 
	`microperfurado`			char NOT NULL, 
	`estampado`			char NOT NULL, 
	`estampar`			varchar (100), 
	`laminado`			char NOT NULL, 
	`laminar`			varchar (100), 
	`bolha`			char NOT NULL, 
	`bolhar`			varchar (200), 
	`isolmanta`			char NOT NULL, 
	`isolmantar`			varchar (100), 
	`colagem`			varchar (20), 
	`teste dinas`			varchar (100), 
	`sanfona corte`			varchar (100), 
	`tol sanf corte`			float, 
	`tol sanf corte -`			float, 
	`Aba`			varchar (100), 
	`tol aba`			float, 
	`tol aba -`			float, 
	`AMARRAR`			int, 
	`QT PECAS BOB BOLHA`			int, 
	`FATIAR EM`			int, 
	`QT PECAS BOB MANTA`			int, 
	`bolhaFilm1`			varchar (100), 
	`bolhaFilm2`			varchar (100), 
	`bolhaFilm3`			varchar (100), 
	`bolhaFilm4`			varchar (100), 
	`PACOTE COM`			int, 
	`EMBALAGEM`			varchar (90)
);
#COMMENT ON COLUMN `produtos`.`Código da Peça` IS 'Selecionar o código da peça';
#COMMENT ON COLUMN `produtos`.`ean` IS 'codigo ean do produto';
#COMMENT ON COLUMN `produtos`.`validade` IS 'Periodo de validade em dias';
#COMMENT ON COLUMN `produtos`.`Bobina Largura (cm)` IS 'Inserir largura da bobina';
#COMMENT ON COLUMN `produtos`.`tol largura bob` IS 'tolerância da largura da bobina extrudada positiva';
#COMMENT ON COLUMN `produtos`.`tol largura bob -` IS 'tolerância da largura da bobina extrudada negativa';
#COMMENT ON COLUMN `produtos`.`Bobina Espessura 1 (micras)` IS 'Inserir espessura da bobina 1';
#COMMENT ON COLUMN `produtos`.`tol espess1` IS 'tolerância da espessura da bobina 1 positiva';
#COMMENT ON COLUMN `produtos`.`tol espess1 -` IS 'tolerância da espessura da bobina 1 negativa';
#COMMENT ON COLUMN `produtos`.`Bobina Espessura 2 (micras)` IS 'Inserir espessura da bobina 2 (para bolha)';
#COMMENT ON COLUMN `produtos`.`tol espess2` IS 'tolerância da espessura 2 positiva';
#COMMENT ON COLUMN `produtos`.`tol espess2 -` IS 'tolerância da espessura 2 negativa';
#COMMENT ON COLUMN `produtos`.`Bobina Sanfona (cm)` IS 'Inserir dimensões da sanfona da bobina';
#COMMENT ON COLUMN `produtos`.`tol sanfona ext` IS 'tolerância da sanfona feita na extrusão positiva';
#COMMENT ON COLUMN `produtos`.`tol sanfona ext -` IS 'tolerância da sanfona feita na extrusão negativa';
#COMMENT ON COLUMN `produtos`.`Dentes do Cilindro` IS 'Inderir número de dentes do cilindro';
#COMMENT ON COLUMN `produtos`.`Saco Largura/Boca` IS 'Inserir largura do saco pronto';
#COMMENT ON COLUMN `produtos`.`tol largura` IS 'tolerância da largura do saco feito no corte/solda positiva';
#COMMENT ON COLUMN `produtos`.`tol largura -` IS 'tolerância da largura do saco feito no corte/solda negativa';
#COMMENT ON COLUMN `produtos`.`Saco Comprimento` IS 'Inserir comprimento do saco pronto';
#COMMENT ON COLUMN `produtos`.`tol comprimento` IS 'tolerância do comprimento do saco do corte/solda positiva';
#COMMENT ON COLUMN `produtos`.`tol comprimento -` IS 'tolerância do comprimento do saco do corte/solda negativa';
#COMMENT ON COLUMN `produtos`.`Saco Espessura` IS 'Inserir espessura do saco pronto';
#COMMENT ON COLUMN `produtos`.`tol espessura` IS 'tolerância da espessura do saco no corte/solda positiva';
#COMMENT ON COLUMN `produtos`.`tol espessura -` IS 'tolerância da espessura do saco no corte/solda negativa';
#COMMENT ON COLUMN `produtos`.`colagem` IS 'inserir o lado que deve ser feita a colagem do Cyrel';
#COMMENT ON COLUMN `produtos`.`teste dinas` IS 'Qt de dinas a ser realizado o teste dinas';
#COMMENT ON COLUMN `produtos`.`sanfona corte` IS 'inserir a sanfona feita no corte/solda';
#COMMENT ON COLUMN `produtos`.`tol sanf corte` IS 'tolerância da sanfona do corte/solda positiva';
#COMMENT ON COLUMN `produtos`.`tol sanf corte -` IS 'tolerância da sanfona do corte/solda negativa';
#COMMENT ON COLUMN `produtos`.`Aba` IS 'inserir a aba';
#COMMENT ON COLUMN `produtos`.`tol aba` IS 'tolerância da aba positiva';
#COMMENT ON COLUMN `produtos`.`tol aba -` IS 'tolerância da abanegativa';

CREATE TABLE `unidades`
 (
	`id`			int, 
	`unidade`			varchar (6)
);
#COMMENT ON COLUMN `unidades`.`unidade` IS 'unidade de venda';


