# Criação de Certificados (Auto Assinados)
Extraido do [original](https://jamielinux.com/docs/openssl-certificate-authority/create-the-intermediate-pair.html)

# Certificado intermediário (CA)

Um certificado de autoridade intermediário é uma entidade capaz de assinar certificados em nome do CA raiz. O CA raiz assina o certificado intermediário, formando uma cadeia de confiança.

O proposito de usar um certificado intermediário é primariamente a segurança. O CA raiz pode ser mantido offline e usado o menos frequentemente possível. Se a chave intermediária é comprometida, o CA raiz pode revogar o certificado intermedirário e criar um novo par criptografico intermediário.

# Praparando o diretório
O certificado CA raiz é mantido em ` /root/ca `. Escolha um diretorio diferente para manter os certificados intemediários.

```
# mkdir /root/ca/intermediate
```

Crie a mesma estrutura anteriormente usada para os CA raiz, e também crie um diretorio `csr` para manter as requisições de certificados.

```
# cd /root/ca/intermediate
# mkdir certs crl csr newcerts private
# chmod 700 private
# touch index.txt
# echo 1000 > serial
```

Adicione o arquivo `crlnumber`. Ele será usado para manter o rastreamento para a lista de certificados revogados.

```
# echo 1000 > /root/ca/intermediate/crlnumber
```
Crie o arquivo de configuração para uso do OpenSSL em `/root/ca/intermediate/openssl.cnf`, conforme estrutura abaixo:

```
# OpenSSL intermediate CA configuration file.
# Copy to `/root/ca/intermediate/openssl.cnf`.

[ ca ]
# man ca
default_ca = CA_default

[ CA_default ]
# Directory and file locations.
dir               = /root/ca/intermediate
certs             = $dir/certs
crl_dir           = $dir/crl
new_certs_dir     = $dir/newcerts
database          = $dir/index.txt
serial            = $dir/serial
RANDFILE          = $dir/private/.rand

# The root key and root certificate.
private_key       = $dir/private/intermediate.key.pem
certificate       = $dir/certs/intermediate.cert.pem

# For certificate revocation lists.
crlnumber         = $dir/crlnumber
crl               = $dir/crl/intermediate.crl.pem
crl_extensions    = crl_ext
default_crl_days  = 30

# SHA-1 is deprecated, so use SHA-2 instead.
default_md        = sha256

name_opt          = ca_default
cert_opt          = ca_default
default_days      = 375
preserve          = no
policy            = policy_loose

[ policy_strict ]
# The root CA should only sign intermediate certificates that match.
# See the POLICY FORMAT section of man ca.
countryName             = match
stateOrProvinceName     = match
organizationName        = match
organizationalUnitName  = optional
commonName              = supplied
emailAddress            = optional

[ policy_loose ]
# Allow the intermediate CA to sign a more diverse range of certificates.
# See the POLICY FORMAT section of the ca man page.
countryName             = optional
stateOrProvinceName     = optional
localityName            = optional
organizationName        = optional
organizationalUnitName  = optional
commonName              = supplied
emailAddress            = optional

[ req ]
# Options for the req tool (man req).
default_bits        = 2048
distinguished_name  = req_distinguished_name
string_mask         = utf8only

# SHA-1 is deprecated, so use SHA-2 instead.
default_md          = sha256

# Extension to add when the -x509 option is used.
x509_extensions     = v3_ca

[ req_distinguished_name ]
# See <https://en.wikipedia.org/wiki/Certificate_signing_request>.
countryName                     = Country Name (2 letter code)
stateOrProvinceName             = State or Province Name
localityName                    = Locality Name
0.organizationName              = Organization Name
organizationalUnitName          = Organizational Unit Name
commonName                      = Common Name
emailAddress                    = Email Address

# Optionally, specify some defaults.
countryName_default             = GB
stateOrProvinceName_default     = England
localityName_default            =
0.organizationName_default      = Alice Ltd
organizationalUnitName_default  =
emailAddress_default            =

[ v3_ca ]
# Extensions for a typical CA (man x509v3_config).
subjectKeyIdentifier = hash
authorityKeyIdentifier = keyid:always,issuer
basicConstraints = critical, CA:true
keyUsage = critical, digitalSignature, cRLSign, keyCertSign

[ v3_intermediate_ca ]
# Extensions for a typical intermediate CA (man x509v3_config).
subjectKeyIdentifier = hash
authorityKeyIdentifier = keyid:always,issuer
basicConstraints = critical, CA:true, pathlen:0
keyUsage = critical, digitalSignature, cRLSign, keyCertSign

[ usr_cert ]
# Extensions for client certificates (man x509v3_config).
basicConstraints = CA:FALSE
nsCertType = client, email
nsComment = "OpenSSL Generated Client Certificate"
subjectKeyIdentifier = hash
authorityKeyIdentifier = keyid,issuer
keyUsage = critical, nonRepudiation, digitalSignature, keyEncipherment
extendedKeyUsage = clientAuth, emailProtection

[ server_cert ]
# Extensions for server certificates (man x509v3_config).
basicConstraints = CA:FALSE
nsCertType = server
nsComment = "OpenSSL Generated Server Certificate"
subjectKeyIdentifier = hash
authorityKeyIdentifier = keyid,issuer:always
keyUsage = critical, digitalSignature, keyEncipherment
extendedKeyUsage = serverAuth

[ crl_ext ]
# Extension for CRLs (man x509v3_config).
authorityKeyIdentifier=keyid:always

[ ocsp ]
# Extension for OCSP signing certificates (man ocsp).
basicConstraints = CA:FALSE
subjectKeyIdentifier = hash
authorityKeyIdentifier = keyid,issuer
keyUsage = critical, digitalSignature
extendedKeyUsage = critical, OCSPSigning
```
## Crie a chave intermediaria
Crie a chave privada intermediária (`intermediate.key.pem`). Que deve ser encriptada com AES 256-bit e uma senha forte.

```
# cd /root/ca
# openssl genrsa -aes256 \
      -out intermediate/private/intermediate.key.pem 4096

Enter pass phrase for intermediate.key.pem: secretpassword
Verifying - Enter pass phrase for intermediate.key.pem: secretpassword

# chmod 400 intermediate/private/intermediate.key.pem
```

## Crie o certificado intermediário
Use a chave intermediaria para criar o certificado (CSR). Os detalhes geralmente batem com os do CA raiz. Mas o "Common Name", necessita ser diferente.

```
# cd /root/ca
# openssl req -config intermediate/openssl.cnf -new -sha256 \
      -key intermediate/private/intermediate.key.pem \
      -out intermediate/csr/intermediate.csr.pem

Enter pass phrase for intermediate.key.pem: secretpassword
You are about to be asked to enter information that will be incorporated
into your certificate request.
-----
Country Name (2 letter code) [XX]:GB
State or Province Name []:England
Locality Name []:
Organization Name []:Alice Ltd
Organizational Unit Name []:Alice Ltd Certificate Authority
Common Name []:Alice Ltd Intermediate CA
Email Address []:
```
Para criar um certificado intermediário, será usado o CA raiz com a extenção `v3_intermediate_ca` para assinar o CSR intermediário. A validade desse certificado deverá ser menor que a do certificado CA raiz, digamos 10 anos.

```
# cd /root/ca
# openssl ca -config openssl.cnf -extensions v3_intermediate_ca \
      -days 3650 -notext -md sha256 \
      -in intermediate/csr/intermediate.csr.pem \
      -out intermediate/certs/intermediate.cert.pem

Enter pass phrase for ca.key.pem: secretpassword
Sign the certificate? [y/n]: y

# chmod 444 intermediate/certs/intermediate.cert.pem
```

O arquivo `index.txt` é onde o OpenSSL `ca` armazena a base de dados dos certificados. Não apague ou edite este aquivo manualmente. Pois ele deve conter uma linha referente ao certificado intermediário criado.

```
V 250408122707Z 1000 unknown ... /CN=Alice Ltd Intermediate CA
```

## Verificando o certificado intermediário
Como já foi dito, o CA raiz verifica se os dados do certificado intermediário estão corretos.

```
# openssl x509 -noout -text \
      -in intermediate/certs/intermediate.cert.pem

intermediate.cert.pem: OK
```

## Criando o arquivo da cadeia de certificação
Quando uma aplicação (ex. browser) tenta verificar um certificado assinado por um CA intermediário, ele deve verificar também com o certificado CA raiz. Para completar a cadeia de acreditação, deve ser criada uma CA chain para apresentar a essa aplicação.

Para criar a cadeia de certificação, devemos concatenar o certificado intermediário e o certificado raiz juntos. E vamos usar isso depois para veridicar os certificados assinados pelo CA intermediário.

```
# cat intermediate/certs/intermediate.cert.pem \
      certs/ca.cert.pem > intermediate/certs/ca-chain.cert.pem
# chmod 444 intermediate/certs/ca-chain.cert.pem
```
