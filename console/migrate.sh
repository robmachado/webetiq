#!/bin/bash
#########################################
# pacote mdbtools
#
# extrai do arquivo mdb o schema das tabelas
# mdb-schema OP.mdb mysql > schema.sql
#########################################
# remove o arquivo atual das OP
rm -f /var/www/webetiq/storage/OP.mdb
# remove os arquivos enteriores de migração
rm -f /var/www/webetiq/storage/OP.txt
rm -f /var/www/webetiq/storage/OP.sql
rm -f /var/www/webetiq/storage/produtos.txt
rm -f /var/www/webetiq/storage/produtos.sql
# copia o arquivo atual das OP's
cp /dados/producao/OP/OP.mdb /var/www/webetiq/storage/OP.mdb
echo "Copiado";
#nomes das tabelas de interesse
spro="produtos";
sop="OP";
# para cada tabela em OP.mdb
for i in $( mdb-tables /var/www/webetiq/storage/OP.mdb );
    do echo $i;
    # extrai dados da tabela OP
    if [ $i = $sop ]; then
        echo $i;
        ## extrai os dados para arquivo txt com os campos separados por ; e as linhas com \n
        mdb-export -D "%Y-%m-%d %H:%M:%S" -H -d"|" -R"\n" /var/www/webetiq/storage/OP.mdb $i > /var/www/webetiq/storage/$i.txt;
        ## extrai os dados para arquivo SQL com os campos separados por ; 
        ##mdb-export -D "%Y-%m-%d %H:%M:%S" -H -d";" -I mysql /var/www/webetiq/storage/OP.mdb $i > /var/www/webetiq/storage/$i.sql;
    fi
    # extrai dados da tabela produtos
    if [ $i = $spro ]; then
        echo $i;
        ## extrai os dados para arquivo txt com os campos separados por ; e as linhas com \n 
        mdb-export -D "%Y-%m-%d %H:%M:%S" -H -d"|" -R"\n" /var/www/webetiq/storage/OP.mdb $i > /var/www/webetiq/storage/$i.txt;
        ## extrai os dados para arquivo SQL com os campos separados por ; 
        ##mdb-export -D "%Y-%m-%d %H:%M:%S" -H -d";" -I mysql /var/www/webetiq/storage/OP.mdb $i > /var/www/webetiq/storage/$i.sql;
    fi
done;
