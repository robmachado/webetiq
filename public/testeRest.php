<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container">
            <h2>Etiquetas Extrusão</h2>
            <form method="POST" action="restop.php">
            <div class="table borderless">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <label for="op">Número da OP</label>
                                    <input type="text" class="form-control" id="op" name="op" value="" placeholder="numero da OP" />
                                </div>
                            </td>
                            <td>    
                                <div class="input-group">
                                    <label for="copias">Cópias</label>    
                                    <input type="text" class="form-control" id="copias" name="copias" value="" placeholder="Cópias" />
                                </div>    
                            </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="input-group">
                                <label for="qtdade">Quantidade</label>    
                                <input type="text" class="form-control" id="qtdade" name="qtdade" value="" placeholder="Quantidade na embalagem" />
                            </div>    
                        </td>
                        <td>
                            <div class="input-group">
                                <label for="unidade">Unidade</label>
                                <input type="text" class="form-control" id="unidade" name="unidade" value="" placeholder="Unidade" />
                            </div>    
                        </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <button class="btn btn-success" type="submit" name="submeter" id="submeter">Gravar &amp; Imprime</button>
                                <div>    
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </form>
            <div class="alert alert-danger" role="alert" name="alertaPrinter" id="alertaPrinter" style="display:none;" ><div class="glyphicon glyphicon-exclamation-sign"></div><div>ERRO!!! Não foi encontrada a impressora ZEBRA. Chame o "administrador" da rede para corrigir esse problema.</div></div>
        </div>    
    </body>
</html>
