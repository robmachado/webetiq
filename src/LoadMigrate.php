<?php

/*
 * executar a migração
 * varrer todos os dados extraidos e procurar na base de dados as OP
 * se não encontrar a OP na base inserir a partir do arquivo de migração
 * 
 * SELECT codigo FROM produtos ORDER BY codigo; => arrayProd
 * 
 * SELECT numop FROM opmigrate ORDER BY numop; => arrayBase
 * 
 * para cada op em arrayExtraido
 *  verifique se não existe em arrayBase if (!in_array(opExtraido, arrayBase)
 *     caso não exista inserir
 *          verifique se existe o produto if (!in_array(prodExtraidoOP, arrayProd)
 *                 caso não exista inserir   
 *     caso exista continue
 * 
 * 
 * um cron deve ser executado a cada 1 hora
 */

/**
 * Description of LoadMigrate
 *
 * @author administrador
 */
class LoadMigrate
{
    //put your code here
}
