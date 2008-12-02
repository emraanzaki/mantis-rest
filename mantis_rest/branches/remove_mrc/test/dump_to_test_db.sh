#!/bin/bash

mysqldump -umantis -pmantis mantis > test/test_db_dump.sql
sed -i 's/`mantis_/`mantisrest_test_/g' test/test_db_dump.sql
