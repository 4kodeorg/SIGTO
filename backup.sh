#!/bin/bash

# Idealmente no se ejecutaría en mi maquina más bien en una maquina virtual externa
# La clave publica que registré corresponde a una en mi maquina personal
# Para ejectuarlo desde otra maquina virtual para hacer los respaldos en la misma hay que crear sus respectivas claves
# Rregistrar la clave publica en el servidor host y luego cambiar el path de destino de la copia
scp sysadmin@192.168.1.22:/temp/data /Users/estebanmartinez/Documents/sigtodata
rm -rf sysadmin@192.168.1.22:/temp/data
exit