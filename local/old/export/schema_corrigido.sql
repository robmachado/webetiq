

CREATE TABLE `OP`
 (
    `id`            int NOT NULL AUTO_INCREMENT,
	`numop`			int NOT NULL, 
	`cliente`			varchar (60), 
	`codcli`			varchar (100), 
	`pedido`			int, 
	`prazo`			datetime, 
	`produto`			varchar (100) NOT NULL, 
	`nummaq`			varchar (40) NOT NULL, 
	`matriz`			varchar (10) NOT NULL, 
	`kg1`			varchar (20), 
	`kg1ind`			varchar (20), 
	`kg2`			varchar (20), 
	`kg2ind`			varchar (20), 
	`kg3`			varchar (20), 
	`kg3ind`			varchar (20), 
	`kg4`			varchar (20), 
	`kg4ind`			varchar (20), 
	`kg5`			varchar (20), 
	`kg5ind`			varchar (20), 
	`kg6`			varchar (20), 
	`kg6ind`			varchar (20), 
	`pesototal`			float, 
	`pesomilheiro`			float, 
	`pesobobina`			float, 
	`quantidade`			float, 
	`bolbobinas`			int, 
	`dataemissao`			datetime, 
	`metragem`			int, 
	`contadordif`			int, 
	`isobobinas`			int, 
	`pedcli`			varchar (60), 
	`unidade`			varchar (6),
    PRIMARY KEY (`id`),
    UNIQUE KEY `numop` (`numop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `produtos`
 (
    `id`            int NOT NULL AUTO_INCREMENT,
	`produto`		varchar (100) NOT NULL, 
	`codigo`		varchar (60) NOT NULL, 
	`ean`			varchar (26), 
	`validade`		int, 
	`mp1`			varchar (100), 
	`p1`			float, 
	`mp2`			varchar (40), 
	`p2`			float, 
	`mp3`			varchar (40), 
	`p3`			float, 
	`mp4`			varchar (40), 
	`p4`			float, 
	`mp5`			varchar (40), 
	`p5`			float, 
	`mp6`			varchar (40), 
	`p6`			float, 
	`densidade`			float, 
	`gramatura`			float, 
	`tipobobina`			varchar (100), 
	`tratamento`			varchar (100), 
	`lados`			varchar (100), 
	`boblargura`			varchar (40) NOT NULL, 
	`tollargbobmax`			float, 
	`tollargbobmin`			float, 
	`refilar`			varchar (100), 
	`bobinasporvez`			varchar (100), 
	`espessura1`			varchar (100) NOT NULL, 
	`tolespess1max`			float, 
	`tolespess1min`			float, 
	`espessura2`			varchar (100), 
	`tolespess2max`			float, 
	`tolespess2min`			float, 
	`sanfona`			varchar (100) NOT NULL, 
	`tolsanfonamax`			float, 
	`tolsanfonamin`			float, 
	`impressao`			varchar (100), 
	`cilindro`			int, 
	`cyrel1`			varchar (100), 
	`cyrel2`			varchar (100), 
	`cyrel3`			varchar (100), 
	`cyrel4`			varchar (100), 
	`cor1`			varchar (100), 
	`cor2`			varchar (100), 
	`cor3`			varchar (100), 
	`cor4`			varchar (100), 
	`cor5`			varchar (100), 
	`cor6`			varchar (100), 
	`cor7`			varchar (100), 
	`cor8`			varchar (100), 
	`modelosaco`			varchar (100), 
	`ziper`			char NOT NULL, 
	`nziper`			int, 
	`solda`			varchar (100), 
	`cortarporvez`			varchar (100), 
	`largboca`			float, 
	`tollargbocamax`			float, 
	`tollargbocamin`			float, 
	`comprimento`			float, 
	`tolcomprmax`			float, 
	`tolcomprmin`			float, 
	`sacoespess`			float, 
	`tolsacoespessmax`			float, 
	`tolsacoespessmin`			float, 
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
	`dinas`			varchar (100), 
	`sanfcorte`			varchar (100), 
	`tolsanfcortemax`			float, 
	`tolsanfcortemin`			float, 
	`aba`			varchar (100), 
	`tolabamax`			float, 
	`tolabamin`			float, 
	`amarrar`			int, 
	`qtdpcbobbolha`			int, 
	`fatiar`			int, 
	`qtdpcbobmanta`			int, 
	`bolhafilm1`			varchar (100), 
	`bolhafilm2`			varchar (100), 
	`bolhafilm3`			varchar (100), 
	`bolhafilm4`			varchar (100), 
	`pacote`			int, 
	`embalagem`			varchar (90),
    PRIMARY KEY (`id`),
    UNIQUE KEY `produto` (`produto`),
    UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `unidades`
(
    `id`			int, 
	`unidade`			varchar (6),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



