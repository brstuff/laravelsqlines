<?php

return [


    // Paths of libraries needed to run sqlines
    // ex: /usr/lib64/mysql/:/usr/lib/oracle/10.2.0.5/client64/lib/
    'export_paths' => '',



    // SQLines Data options
    'data-options' => [
        // DDL Options
        //////////////

        // Set yes to to migrate table definitions, or no to not migrate
        // DDL statements executed depends on -topt option (CREATE; DROP and CREATE TABLE, or TRUNCATE TABLE)
        'ddl_tables' => '',

        // Set yes to to migrate constraints (this is default), or no to not migrate
        'constraints' => '',

        // Set yes to to migrate indexes (this is default), or no to not migrate
        'indexes' => '',

        // Data Options
        //////////////-

        // Set yes to to migrate data (this is default), or no to not migrate
        'data' => '',

        // The maximum number of rows in read/write batch, by default it is defined by the buffer size divided by the table row size
        'batch_max_rows' => 10000,

        // Work with LOBs as VARCHAR columns to increase performance (use if LOB columns contain short values less than a few MB i.e.), default is no
        'fetch_lob_as_varchar' => '',

        // Fixed size buffer in bytes to read LOB values by binding not by reading part by part (can cause truncation error if the buffer is less than
        // the maximum LOB value, default is to read LOBs by separate calls
        'lob_bind_buffer' => 1000000,

        // When converting from ASCII or UTF16/UCS-2 character sets in the source database to UTF8 i.e. in the target database depending on
        // the actual data you may need greater storage size. And vice versa converting in opposite direction you may require smaller storage size.
        // This parameter specifies the length change ratio. If the source length is 100, and ratio is 1.1 then the target length will be 110
        'char_length_ratio' => '',

        // MariaDB options
        //////////////////

        // Path to MariaDB library including the file name. For example, for MariaDB Connector C on Windows:
        //   -mariadb_lib=C:\Program Files\MariaDB\MariaDB Connector C 64-bit\lib\libmariadb.dll
        // By default, on Windows the tool tries to load libmariadb.dll library from PATH; if not found the tool tries to use MySQL connector libmysql.dll
        'mariadb_lib' => '',

        // Disable or enable binary logging for the connection (the client must have the SUPER privilege for this operation). By default, MariaDB default is used.
        'mariadb_set_sql_log_bin' => 0,

        // Run SET UNIQUE_CHECKS=value at the beginning of each session, not executed if no value set (MariaDB as target)
        'mariadb_set_unique_checks' => 0,

        // Set global max_allowed_packet option to the specified value (use only values in multiples of 1024, for example, 1073741824 for 1GB)
        // Use this option when you receive 'MySQL has gone away' error during the data load
        'mariadb_max_allowed_packet' => '',

        // MySQL options
        ////////////////

        // Set the character set for the connection (utf8mb4 i.e.)
        'mysql_set_character_set' => 'utf8',

        // Set the collation for the connection (ex utf8mb4_bin)
        'mysql_set_collation' => 'utf8_bin',

        // Run SET FOREIGN_KEY_CHECKS=value at the beginning of each session, not executed if no value set (MySQL as target)
        'mysql_set_foreign_key_checks' => 0,

        // Collate used for data validation. Use _bin or _cs collates to order values ABCabc instead of AaBbCc
        'mysql_validation_collate' => 'latin1_bin',

        // SQL Server options
        ////////////////////'

        // Codepage for input data (BCP -C option)
        'bcp_codepage' => '',

        // Oracle options
        ////////////////'

        // Path to Oracle OCI library including the file name. For example, for Oracle on Windows:
        //   -oci_lib=C:\oraclexe\app\oracle\product\11.2.0\server\bin\oci.dll
        // By default, on Windows the tool tries to load oci.dll library from PATH; if not found the tool tries to search Windows registry to find Oracle client installations
        // See also http://www.sqlines.com/sqldata_oracle_connection
        'oci_lib' => '',

        // NLS_LANG setting to use for Oracle connection
        'oracle_nls_lang' => 'AMERICAN_AMERICA.WE8ISO8859P1',

        // PostgreSQL options
        ////////////////////'

        // Set client encoding (you can also use PGCLIENTENCODING environment variable)
        'pg_client_encoding' => 'latin1',

        // Sybase ASE options
        ////////////////////'

        // Codepage
        'sybase_codepage' => 'cp850',

        // Set to yes to use encrypted password handshakes with the server
        'sybase_encrypted_password' => '',

        // Sybase ASA (Sybase SQL Anywhere) options
        //////////////////////////////////////////'

        // Set to yes to extract all character data as 2-byte Unicode (UTF-16/UCS-2)
        'sybase_asa_char_as_wchar' => '',

        // Informix options
        //////////////////'

        // Set CLIENT_LOCALE for connection (Note that Setnet32 and environment variable has no effect on Informix ODBC driver)
        'informix_client_locale' => '',

        // Validation Options
        ////////////////////'

        // Maximum number of found not equal rows per table after which the validation stops for this table, by default no limit set
        'validation_not_equal_max_rows' =>'',

        // Number of digits in the fractional part (milliseconds, microseconds i.e.) of datetime/timestamp values to validate. By default, all digits are compared
        'validation_datetime_fraction' => '',

        // Misc Options
        //////////////'

        // Set to yes to generate trace file sqldata.trc with debug information, default is no
        'trace' => '',

        // Set to yes to create dump files containing data for tables
        'trace_data' => '',

        // Set to yes to create dump files containing differences in data found during data validation
        'trace_diff_data' => '',
    ]
];
