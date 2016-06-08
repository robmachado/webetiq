# Criação de Certificados (Auto Assinados)
Extraido do [original](https://jamielinux.com/docs/openssl-certificate-authority/sign-server-and-client-certificates.html)

# Certificados de Servidor e de Clientes
Nós vamos assinar certificados usando nosso certificado intermediário. Nós podemos usar estes certificados em uma gama variada de situações, como conexões seguras com umwebserver ou autenticar cliente conectando com um serviço.
>NOTA: Os passos abaixo descritos são como se você fosse a autoridade de certificação. Uma terceira parte pode criar o par de chaves deles, sem revelar a chave privada para você. Eles fornecem o CSR deles e você cria um certificado assinado. Neste cenario pule os comandos ```genrsa``` e ```req```.

## Criando a chave
Nossos para raiz de intermediário são de 4096 bits. Os certificados de servidores e de clientes normalmente expiram em um ano e podem seguramente ser de 2048 bits.
>NOTA: Com certeza chaves maiores são mais seguras mas para usar em servidores elas iriam demorar mais para serem processadas e iriam carregar muito mais os servidores, por esse motivo usamos chaves de 2048 bits.

Se você está criando pares de chaves criptograficas para uso em um webserver (ex. apache) você teria que entrar com a senha dessa chave, cada vez que você reinicia-se o serviço. Como forma de otimizar omita o argumento `-aes256` de forma a criar uma chave sem senha.
```
# cd /root/ca
# openssl genrsa -aes256 \
      -out intermediate/private/www.example.com.key.pem 2048
# chmod 400 intermediate/private/www.example.com.key.pem
```

## Criando o certificado
Use a chave privada criada para assinar o certificado (CSR). Os detalhes desse CSR não necessitam *bater* com os do CA intermediário. Para certificados de servidores, o "Common Name" deverá ser um nome de dominio totalmente qualificado (`ex. www.example.com`), enquanto que para os certificados de cliente pode ser qualquer identificador exclusivo (por exemplo, um endereço de e-mail). Note-se que o nome comum não pode ser o mesmo que foi usado no CA raiz ou no CA intermediário.
```
# cd /root/ca
# openssl req -config intermediate/openssl.cnf \
      -key intermediate/private/www.example.com.key.pem \
      -new -sha256 -out intermediate/csr/www.example.com.csr.pem

Enter pass phrase for www.example.com.key.pem: secretpassword
You are about to be asked to enter information that will be incorporated
into your certificate request.
-----
Country Name (2 letter code) [XX]:US
State or Province Name []:California
Locality Name []:Mountain View
Organization Name []:Alice Ltd
Organizational Unit Name []:Alice Ltd Web Services
Common Name []:www.example.com
Email Address []:
```

Para criar um certificado, use o CA intermediário para assinar o CSR. Se o certificado vai ser usado em um servidor, use a extensão ```server_cert```. Se o certificado vai ser usado para autenticação do usuário, use a extensão ```usr_cert```. Os certificados são geralmente dada uma validade de um ano, embora a CA irá tipicamente dar alguns dias extra para conveniência.

```
# cd /root/ca
# openssl ca -config intermediate/openssl.cnf \
      -extensions server_cert -days 375 -notext -md sha256 \
      -in intermediate/csr/www.example.com.csr.pem \
      -out intermediate/certs/www.example.com.cert.pem
# chmod 444 intermediate/certs/www.example.com.cert.pem
```

O arquivo `intermediate/index.txt` deve conter uma linha referindo-se a esse novo certificado.

```
V 160420124233Z 1000 unknown ... /CN=www.example.com
```

## Verificando o certificado

```
# openssl x509 -noout -text \
      -in intermediate/certs/www.example.com.cert.pem
```

Use o arquivo com a cadeia de certificação criado anteriormente (`ca-chain.cert.pem`) para verificar se esse novo certificado é valido por essa cadeia de acreditação.

```
# openssl verify -CAfile intermediate/certs/ca-chain.cert.pem \
      intermediate/certs/www.example.com.cert.pem

www.example.com.cert.pem: OK
```

## Forneça do certificado
Agora você pode implantar seu novo certificado em um servidor, ou distribuir-lo para um cliente. Ao implantar em um aplicativo de servidor (por exemplo, Apache), você precisa tornar os seguintes arquivos disponíveis:

- ca-chain.cert.pem
- www.example.com.key.pem
- www.example.com.cert.pem

Se você está assinando um CSR a partir de um certificado fornecido por terceiros, você não tem acesso a chave privada, portando você só precisa fornecer (`ca-chain.cert.pem`) e o certificado (`www.example.com.cert.pem`).
