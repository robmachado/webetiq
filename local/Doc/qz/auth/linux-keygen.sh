#!/bin/bash
###############################################################################
#                  QZ Tray Linux KeyGen Utility                               #
###############################################################################
#  Description:                                                               #
#     1. Creates a self-signed Java Keystore for jetty wss://localhost        #
#     2. Exports public certificate from Java Keystore                        #
#                                                                             #
#  Depends:                                                                   #
#    java (sudo apt-get install openjdk-7-jre)                                #
#                                                                             #
#  Usage:                                                                     #
#    $ ./linux-keygen.sh                                                      #
#                                                                             #
###############################################################################

# Random password hash
password=$(cat /dev/urandom | env LC_CTYPE=C tr -dc 'a-z0-9' | fold -w 10 | head -n 1)

makekeystore="\"keytool\" -genkey -noprompt -alias qz-tray -keyalg RSA -keysize 2048 -dname \"CN=localhost, EMAILADDRESS=support@qz.io, OU=QZ Industries\\, LLC, O=QZ Industries\\, LLC, L=Canastota, S=NY, C=US\" -validity 7305 -keystore \"!install/auth/qz-tray.jks\" -storepass !storepass -keypass !keypass"
makedercert="\"keytool\" -exportcert -alias qz-tray -keystore \"!install/auth/qz-tray.jks\" -storepass !storepass -keypass !keypass -file \"!install/auth/qz-tray.crt\" -rfc"
installdir="/opt/qz-tray"

# Substitution variables (!storepass, !keypass, !install, etc)
install="!install"
storepass="!storepass"
keypass="!keypass"
keystore="!install/auth/qz-tray.jks"
dercert="!install/auth/qz-tray.crt"
props="!install/qz-tray.properties"

# Keystore generation variable substitutions
keystorepath="${keystore/$install/$installdir}"
makekeystore="${makekeystore/$storepass/$password}"
makekeystore="${makekeystore/$keypass/$password}"
makekeystore="${makekeystore/$keystore/$keystorepath}"

# Cert export variable substitutions
dercertpath="${dercert/$install/$installdir}"
makedercert="${makedercert/$storepass/$password}"
makedercert="${makedercert/$keypass/$password}"
makedercert="${makedercert/$keystore/$keystorepath}"
makedercert="${makedercert/$dercert/$dercertpath}"

# Property file containing jks signing info
propspath="${props/$install/$installdir}"

# Check to see if file exists
function check_exists {
    if [ -e "$1" ]; then
        echo -e "   [\e[1;32msuccess\033[0m]\n"
    else
        echo -e "   [\e[1;31mfailure\033[0m]\n"
    fi
}


# Delete old keystore, if exists
rm -f "$keystorepath" > /dev/null 2>&1

echo "Creating keystore for secure websockets..."
eval "$makekeystore" > /dev/null 2>&1
check_exists "$keystorepath"

echo "Converting keystore to native certificate..."
eval "$makedercert" > /dev/null 2>&1
check_exists "$dercertpath"

echo "Writing properties file..."
echo "wss.alias=qz-tray" > "$propspath"
echo "wss.keystore=$keystorepath" >> "$propspath"
echo "wss.keypass=$password" >> "$propspath"
echo "wss.storepass=$password" >> "$propspath"
echo "" >> "$propspath"
check_exists  "$propspath"

exit 0
