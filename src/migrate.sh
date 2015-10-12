#!/bin/bash
#####################
# pacote mdbtools
#####################
# extrai do arquivo mdb o schema das tabelas
#mdb-schema OP.mdb mysql > schema.sql
#########################################
# remove o arquivo atual das OP
rm -f ../local/OP.mdb
# remove os arquivos enteriores de migração
rm -f ../sql/OP.sql
rm -f ../sql/produtos.sql
# copia o arquivo atual das OP's
cp /dados/producao/OP/OP.mdb ../local/OP.mdb

#nomes das tabelas de interesse
spro="produtos";
sop="OP";
# para cada tabela em OP.mdb
for i in $( mdb-tables OP.mdb );
 do echo $i;
 #extrai dados da tabela OP
 if [ $i = $sop ]; then
    echo $i;
    mdb-export -D "%Y-%m-%d %H:%M:%S" -H -I mysql OP.mdb $i > ../sql/$i.sql;
 fi
 #extrai dados da tabela produtos
 if [ $i = $spro ]; then
    echo $i;
    mdb-export -D "%Y-%m-%d %H:%M:%S" -H -I mysql OP.mdb $i > ../sql/$i.sql;
 fi
done;
