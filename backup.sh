#!/bin/bash

export PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin

DB_NAME="sigto"
DB_USER="root"
DB_PASS="passwd123"
BACKUP_DIR="/home/backups/sigto"
DB_CONTAINER="sigto-repositorio-db-1"

mkdir -p "$BACKUP_DIR"

tables=$(docker exec "$DB_CONTAINER" mysql -u "$DB_USER" -p"$DB_PASS" -e "SHOW TABLES IN $DB_NAME;" -s --skip-column-names)


for table in $tables; do
    docker exec "$DB_CONTAINER" mysqldump -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" "$table" | gzip -9 > "$BACKUP_DIR/${table}_backup.sql.gz"
    echo "Backup for $table saved as ${table}_backup.sql.gz"
done

echo "Respaldo completo en : $BACKUP_DIR" 