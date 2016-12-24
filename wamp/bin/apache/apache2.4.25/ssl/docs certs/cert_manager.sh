#!/bin/bash
# Note that we use `"$@"' to let each command-line parameter expand to a 
# separate word. The quotes around `$@' are essential!
# We need TEMP as the `eval set --' would nuke the return value of getopt.
BASENAME=`basename $0`
export CERT_DIR=`dirname $0`

SCRIPT_CONFIG_FILE=cert_manager.cnf
CERTIFICATES_DATABASE=CERTIFICATE_AUTHORITY/certificate_database
CERTIFICATES_SERIAL=CERTIFICATE_AUTHORITY/serial
CA_CRL_FILE=CERTIFICATE_AUTHORITY/ca-crl.pem
SCRIPT_DIRECTORIES="CERTIFICATE_AUTHORITY CERTIFICATES PRIVATE_KEYS CERTIFICATES_REQUESTS TEMP_CERTIFICATES REVOCATION_LIST"
OPENSSL_CA_CONFIG_FILE=ca_openssl.cnf

# Print usage and exit with given error code
# usage 0 for normal exit with usage (--help option)
function usage {
	echo "$BASENAME help you to manage your certificates. The available
options are :

--help
	print this help message

--certificates-directory=directory_path
	allow you to use a directory different from the one where is run this
	script.

--init
	initialise the certificate creation environment. Use this to setup
	your environment.

--create-ca
	create a certificate authority

--generate-csr=csr_file_prefix
	generate a certificate request. The csr_file_prefix is a prefix for
	result file name to be recognize.

--sign-csr=request_file.csr|csr_file_prefix
	sign the given certificate request.

--revoke-cert=certificate_file.pem|cert_file_prefix
	revoke the given certificate and
	generate CRL.

--generate-crl
	update the Certificate Revocation List (CRL).

--clean-csr
	delete all certificate requests (those are useless once the
	certificate is signed).

--distclean
	delete everything from certificate authority to signed certificate.
	USE WITH CAUTION !!!. This is only there for reset all of your configuration.
";

	exit $1;
};



# Function to check if the directory is a valid one for this script.
function check_directory {
	# Check that the need directories are present.
	for DIR_NAME in $SCRIPT_DIRECTORIES; do
		if [ ! -d "$1/$DIR_NAME" ]; then
			echo "$1 is not a directory initialized by $BASE_NAME.
Please use this script with the option --init before trying anything else.";
			exit 1;
		fi;
	done;
	if [ ! -f "$1/$CERTIFICATES_DATABASE" ]; then
		echo "$1 is not a directory initialized by $BASE_NAME.
Please use this script with the option --init before trying anything else.";
		exit 1;
	fi;
	if [ ! -f "$1/$CERTIFICATES_SERIAL" ]; then
		echo "$1 is not a directory initialized by $BASE_NAME.
Please use this script with the option --init before trying anything else.";
		exit 1;
	fi;
	if [ ! -f "$1/$SCRIPT_CONFIG_FILE" ]; then
		echo "$1 is not a directory initialized by $BASE_NAME.
Please use this script with the option --init before trying anything else.";
		exit 1;
	fi;
}

# Check the presence of OpenSSL :
if [ ! -x /usr/bin/openssl ]; then echo "Error: this script depends upon OpenSSL."; exit 1; fi

# Check the version of OpenSSL :
OPENSSL_VERSION=`openssl version | awk '{if ($2 >= "0.9.11b") split($2, results, "."); integer_version = (results[1] * 10000) + (results[2]* 100) + results[3]; if (integer_version >= 908) print $2 }'`

# Check if there is arguments
if [ $# -eq "0" ]; then usage 1; fi # Script invoked with no command-line args, whe print usage.

# If there is arguments, whe check them.
TEMP=`getopt --longoptions help,certificates-directory:,init,create-ca,sign-csr:,revoke-cert:,generate-csr:,generate-crl,clean-csr,distclean \
     -n $BASENAME -- $0 "$@"`

# Check that all run correctly
if [ $? != 0 ] ; then usage 1 ; fi

# Note the quotes around `$TEMP': they are essential!
eval set -- "$TEMP"

# Check all options
while true ; do
	case "$1" in
		--help) usage 0 ; shift ;;
		--init) echo "You will now be asked to give informations for your certificate authority.";
			read -p "Description du domaine [défaut : My Company]: " KEY_COMMONNAME;
			read -p "Code de votre pays [défaut : FR]: " KEY_COUNTRYCODE;
			read -p "Nom de votre région [défaut : Ile de France]: " KEY_PROVINCE;
			read -p "Nom de votre ville [défaut : Paris]: " KEY_CITY;
			read -p "Nom de votre domaine [défaut : my-domain.com]: " KEY_DOMAIN;
			read -p "Email de l'administrateur [défaut : root@my-domain.com]: " KEY_EMAIL;
			# Set the default value.
			if [ -z "$KEY_COMMONNAME" ]; then KEY_COMMONNAME="My Company"; fi;
			if [ -z "$KEY_COUNTRYCODE" ]; then KEY_COUNTRYCODE="FR"; fi;
			if [ -z "$KEY_PROVINCE" ]; then KEY_PROVINCE="Ile de France"; fi;
			if [ -z "$KEY_CITY" ]; then KEY_CITY="Paris"; fi;
			if [ -z "$KEY_DOMAIN" ]; then KEY_DOMAIN="my-domain.com"; fi;
			if [ -z "$KEY_EMAIL" ]; then KEY_EMAIL="root@my-domain.com"; fi;

			# Flag the need for an init.
			INIT_ASKED=1;

			shift;;
		--certificates-directory) export CERT_DIR=$2;
			if [ ! -d "$CERT_DIR" ]; then echo "Error: "$CERT_DIR" is not a directory."; exit 1; fi;
			shift 2;;
		--create-ca) CA_CREATION_ASKED=1; shift;;
		--generate-csr) CSR_GENERATION_ASKED=1;
			CSR_SHORT_NAME=$2;
			shift 2;;
		--sign-csr) CSR_SIGNING_ASKED=1;
			SIGNING_SHORT_NAME=$2;
			shift 2;;
		--revoke-cert) CERT_REVOKE_ASKED=1;
			REVOKE_SHORT_NAME=$2;
			shift 2;;
		--generate-crl) CRL_GEN_ASKED=1; shift;;
		--clean-csr) CSR_CLEAN_ASKED=1; shift;;
		--distclean) DISTCLEAN_ASKED=1; shift;;
		--) shift ; break ;;
		*) usage 1 ;;
	esac
done

# --init option has been used.
if [ ! -z "$INIT_ASKED" ]; then
	# Create the need directories
	for DIR_NAME in $SCRIPT_DIRECTORIES; do
		if [ ! -d "$CERT_DIR/$DIR_NAME" ]; then mkdir "$CERT_DIR/$DIR_NAME"; fi;
	done;

	touch $CERT_DIR/$CERTIFICATES_DATABASE;
	echo "01" > $CERT_DIR/$CERTIFICATES_SERIAL;

	# Create the configuration file.
	echo "# Cert Manager configuration
export KEY_COMMONNAME=\"$KEY_COMMONNAME\"
export KEY_COUNTRYCODE=\"$KEY_COUNTRYCODE\"
export KEY_PROVINCE=\"$KEY_PROVINCE\"
export KEY_CITY=\"$KEY_CITY\"
export KEY_DOMAIN=\"$KEY_DOMAIN\"
export KEY_EMAIL=\"$KEY_EMAIL\"" > $CERT_DIR/$SCRIPT_CONFIG_FILE;
fi

# --distclean option has been used.
if [ ! -z "$DISTCLEAN_ASKED" ]; then
	read -p "Etes-vous sûr de vouloir supprimer l'ensemble de vos certificats et clefs ? (oui/NON): " DISTCLEAN_CHECK;
	if [ "$DISTCLEAN_CHECK" = "oui" ]; then
		if [ -f "$CERT_DIR/$SCRIPT_CONFIG_FILE" ]; then /bin/rm --verbose "$CERT_DIR/$SCRIPT_CONFIG_FILE"; fi;
		if [ -f "$CERT_DIR/$CA_CRL_FILE" ]; then /bin/rm --verbose "$CERT_DIR/$CA_CRL_FILE"; fi;
		if [ -f "$CERT_DIR/$CERTIFICATES_DATABASE" ]; then /bin/rm --verbose "$CERT_DIR/$CERTIFICATES_DATABASE"; fi;
		if [ -f "$CERT_DIR/$CERTIFICATES_SERIAL" ]; then /bin/rm --verbose "$CERT_DIR/$CERTIFICATES_SERIAL"; fi;
		for DIR_NAME in $SCRIPT_DIRECTORIES; do
			if [ -d "$CERT_DIR/$DIR_NAME" ]; then /bin/rm --verbose --recursive "$CERT_DIR/$DIR_NAME"; fi;
		done;
		echo "Nettoyage terminé.";
	else
		echo "Nettoyage annulé.";
	fi;
	exit 0;
fi

# Before doing anything else, whe check that the working directory is initialized.
check_directory $CERT_DIR;

# We source the ssl configuration options.
source $CERT_DIR/$SCRIPT_CONFIG_FILE;



# --create-ca option has been used.
if [ ! -z "$CA_CREATION_ASKED" ]; then
	# NOTE use "-newkey rsa:2048" if running OpenSSL 0.9.8a or higher
	if [ -z "$OPENSSL_VERSION" ]; then
		/usr/bin/openssl req -nodes -config "$CERT_DIR/$OPENSSL_CA_CONFIG_FILE" \
				-days 1825 -x509 -newkey rsa \
				-out "$CERT_DIR/CERTIFICATE_AUTHORITY/ca-cert.pem" -outform PEM;
	else
		/usr/bin/openssl req -nodes -config "$CERT_DIR/$OPENSSL_CA_CONFIG_FILE" \
				-days 1825 -x509 -newkey rsa:2048 \
				-out "$CERT_DIR/CERTIFICATE_AUTHORITY/ca-cert.pem" -outform PEM;
	fi;
fi



# --generate-csr option has been used.
if [ ! -z "$CSR_GENERATION_ASKED" ]; then
	# create a config file for openssl
	CONFIG=`mktemp -q /tmp/openssl-conf.XXXXXXXX`
	if [ ! $? -eq 0 ]; then
	    echo "Could not create temporary config file. exiting"
	    exit 1
	fi

	echo "You will now be asked to give informations for your certificate authority."
	read -p "Description du domaine [défaut : $KEY_COMMONNAME]: " USER_COMMONNAME
	read -p "Type de serveur [défault : HTTP server]: " USER_SECTION
	read -p "Code de votre pays [défaut : $KEY_COUNTRYCODE]: " USER_COUNTRYCODE
	read -p "Nom de votre région [défaut : $KEY_PROVINCE]: " USER_PROVINCE
	read -p "Nom de votre ville [défaut : $KEY_CITY]: " USER_CITY
	read -p "Email de l'administrateur [défaut : $KEY_EMAIL]: " USER_EMAIL
	read -p "Nom de votre domaine [défaut : $KEY_DOMAIN]: " USER_DOMAIN

	# Set the default value.
	if [ -z "$USER_COMMONNAME" ]; then USER_COMMONNAME="$KEY_COMMONNAME"; fi
	if [ -z "$USER_SECTION" ]; then USER_SECTION="HTTP server"; fi
	if [ -z "$USER_COUNTRYCODE" ]; then USER_COUNTRYCODE="$KEY_COUNTRYCODE"; fi
	if [ -z "$USER_PROVINCE" ]; then USER_PROVINCE="$KEY_PROVINCE"; fi
	if [ -z "$USER_CITY" ]; then USER_CITY="$KEY_CITY"; fi;
	if [ -z "$USER_EMAIL" ]; then USER_EMAIL="$KEY_EMAIL"; fi
	if [ -z "$USER_DOMAIN" ]; then USER_DOMAIN="$KEY_DOMAIN"; fi

	echo "Noms de domaines supplémentaires, un par ligne. Finissez par une ligne vide."
	SAN=1        # bogus value to begin the loop
	SANAMES=""   # sanitize
	while [ ! "$SAN" = "" ]; do
	    printf "SubjectAltName: DNS:"
	    read SAN
	    if [ "$SAN" = "" ]; then break; fi # end of input
	    if [ "$SANAMES" = "" ]; then
		SANAMES="DNS:$SAN"
	    else
		SANAMES="$SANAMES,DNS:$SAN"
	    fi
	done

	# Config File Generation

	cat <<EOF > $CONFIG
# -------------- BEGIN custom openssl.cnf -----
HOME                    = $HOME
EOF

	if [ "`uname -s`" = "HP-UX" ]; then
	    echo " RANDFILE                = $RANDOMFILE" >> $CONFIG
	fi

	cat <<EOF >> $CONFIG
oid_section             = new_oids
[ new_oids ]
[ req ]
default_days            = 1825 # how long to certify for
default_keyfile         = $CERT_DIR/PRIVATE_KEYS/${CSR_SHORT_NAME}_key.pem
distinguished_name      = req_distinguished_name
encrypt_key             = no
string_mask = nombstr
EOF

	if [ ! "$SANAMES" = "" ]; then
	    echo "req_extensions = v3_req # Extensions to add to certificate request" >> $CONFIG
	fi

	cat <<EOF >> $CONFIG
[ req_distinguished_name ]
countryName			= Country Name (2 letter code)
countryName_default		= $USER_COUNTRYCODE
countryName_min			= 2
countryName_max			= 2

stateOrProvinceName		= State or Province Name (full name)
stateOrProvinceName_default	= $USER_PROVINCE

localityName			= Locality Name (eg, city)
localityName_default		= $USER_CITY

0.organizationName		= Organization Name (eg, company)
0.organizationName_default	= $USER_COMMONNAME

organizationalUnitName		= Organizational Unit Name (eg, section)
organizationalUnitName_default	= $USER_SECTION

commonName			= Common Name (eg, YOUR domain)
commonName_max			= 64
commonName_default		= $USER_DOMAIN

emailAddress			= Email Address
emailAddress_max		= 64
emailAddress_default		= $USER_EMAIL

[ v3_req ]
EOF

	if [ ! "$SANAMES" = "" ]; then
	    echo "subjectAltName=$SANAMES" >> $CONFIG
	fi

	echo "# -------------- END custom openssl.cnf -----" >> $CONFIG

	/usr/bin/openssl req -batch -config $CONFIG -newkey rsa:2048 \
		-out "$CERT_DIR/CERTIFICATES_REQUESTS/${CSR_SHORT_NAME}_csr.csr"

	# We print out the csr (for cacert.org usage).
	cat "$CERT_DIR/CERTIFICATES_REQUESTS/${CSR_SHORT_NAME}_csr.csr"

fi



# --sign-csr option has been used.
if [ ! -z "$CSR_SIGNING_ASKED" ]; then
	if [ -f $SIGNING_SHORT_NAME ]; then
		/usr/bin/openssl ca -config "$CERT_DIR/$OPENSSL_CA_CONFIG_FILE" \
			-in $SIGNING_SHORT_NAME -out ${SIGNING_SHORT_NAME:.csr=.cert}
	else
		/usr/bin/openssl ca -config "$CERT_DIR/$OPENSSL_CA_CONFIG_FILE" \
			-in "$CERT_DIR/CERTIFICATES_REQUESTS/${SIGNING_SHORT_NAME}_csr.csr" \
			-out "$CERT_DIR/CERTIFICATES/${SIGNING_SHORT_NAME}_cert.cert"
	fi;
fi;



# --revoke-cert option has been used.
if [ ! -z "$CERT_REVOKE_ASKED" ]; then
	if [ -f $REVOKE_SHORT_NAME ]; then
		/usr/bin/openssl ca -config "$CERT_DIR/$OPENSSL_CA_CONFIG_FILE" \
			-revoke $REVOKE_SHORT_NAME
	else
		/usr/bin/openssl ca -config "$CERT_DIR/$OPENSSL_CA_CONFIG_FILE" \
			-revoke "$CERT_DIR/CERTIFICATES/${REVOKE_SHORT_NAME}_cert.cert"
	fi;
fi;



# --generate-crl option has been used.
if [ ! -z "$CRL_GEN_ASKED" -a -z "$CERT_REVOKE_ASKED" ]; then
	/usr/bin/openssl ca -config "$CERT_DIR/$OPENSSL_CA_CONFIG_FILE" \
		-gencrl -out "$CERT_DIR/$CA_CRL_FILE"
fi;



# --clean-csr option has been used.
if [ ! -z "$CSR_CLEAN_ASKED" ]; then
	/usr/bin/find $CERT_DIR/CERTIFICATES_REQUESTS/ -type f | \
		/usr/bin/xargs --replace=FILE /bin/rm --verbose FILE
fi;

exit 0;
