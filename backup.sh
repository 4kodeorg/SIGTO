#!/bin/bash

DB_NAME="sigto"
DB_USER="root"
DB_PASS="passwd123"
BACKUP_DIR="/home/backups/sigto"

# Crear directorio si no existe
mkdir -p "$BACKUP_DIR"

tables=$(mysql -u "$DB_USER" -p"$DB_PASS" -e "SHOW TABLES IN $DB_NAME;" -s --skip-column-names)

for table in $tables; do
    mysqldump -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" "$table" > "$BACKUP_DIR/${table}_backup.sql"
    echo "Respaldo de $table para ${table}_backup.sql"
done

echo "Respaldo completo en : $BACKUP_DIR" 