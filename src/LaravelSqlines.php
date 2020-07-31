<?php

namespace brstuff\LaravelSqlines;

use File;

class LaravelSqlines
{
    private $files = [];
    private $sqlines_storage = "laravelsqlines";
    private $sqlines_app = "sqldata";

    private $configOptions = [
        'sd',
        'td',
        't',
        'ddl_tables',
        'indexes',
        'data',
        'batch_max_rows' => 10000,
        'fetch_lob_as_varchar',
        'lob_bind_buffer' => 1000000,
        'char_length_ratio',
        'mariadb_lib',
        'mariadb_set_sql_log_bin' => 0,
        'mariadb_set_unique_checks' => 0,
        'mariadb_max_allowed_packet',
        'mysql_set_character_set' => 'utf8',
        'mysql_set_collation' => 'utf8_bin',
        'mysql_set_foreign_key_checks' => 0,
        'mysql_validation_collate' => 'latin1_bin',
        'bcp_codepage',
        'oci_lib',
        'oracle_nls_lang' => 'AMERICAN_AMERICA.WE8ISO8859P1',
        'pg_client_encoding',
        'sybase_codepage' => 'cp850',
        'sybase_encrypted_password',
        'sybase_asa_char_as_wchar',
        'informix_client_locale',
        'validation_not_equal_max_rows',
        'validation_datetime_fraction',
        'trace',
        'trace_data',
        'trace_diff_data',
    ];

    /**
     *  todo:
     *  cmd
     *  queries
     *  etc
     */
    private $options = [
        'source' => '',
        'target' => '',
        'tables' => [],
        'tables_excluded' => [],
        'sql_selected' => [],
        'command' => '',    // TODO
        'topt' => [],
        'vopt' => '',
        'smap' => [],
        'cmap' => [],
        'dtmap' => [],
        'tmap' => [],
        'queries' => [],    // TODO
        'twhere' => [],
        'tsel' => [],
        'tsel_all' => [],
    ];

    private $connections = ['oracle','sql','db2','mariadb','mysql','pg','sybase','asa','informix'];

    /**
     * Source
     *
     * @param string $connection (oracle|sql|db2|mariadb|mysql|pg|sybase|asa|informix)
     * @param string $host Host of database
     * @param string $username Username of database
     * @param string $password Password of database
     * @param string $database Name of database
     * @param string $port Port
     * @throws \Exception
     * @return $this
     */
    public function source($connection, $username, $password = "", $database, $host = "", $port=""){
        $this->options['source'] = $this->connectionString($connection, $username, $password, $database, $host, $port);
        return $this;
    }

    /**
     * Target
     *
     * @param string $connection (oracle|sql|db2|mariadb|mysql|pg|sybase|asa|informix)
     * @param string $host Host of database
     * @param string $username Username of database
     * @param string $password Password of database
     * @param string $database Name of database
     * @param string $port Port
     * @throws \Exception
     * @return $this
     */
    public function target($connection, $username, $password = "", $database, $host = "", $port=""){
        $this->options['target'] = $this->connectionString($connection, $username, $password, $database, $host, $port);
        return $this;
    }

    /**
     * sourceConnection
     *
     * @param string $connection (oracle|sql|db2|mariadb|mysql|pg|sybase|asa|informix)
     * @param string $database_config config database name
     * @return $this
     */
    public function sourceConnection($connection, $database_config){
        $cfg = config("database.connections.".$database_config);
        $this->source($connection, $cfg['username'],  $cfg['password'],  $cfg['database'],  $cfg['host'],  $cfg['port']);
        return $this;
    }

    /**
     * targetConnection
     *
     * @param string $connection (oracle|sql|db2|mariadb|mysql|pg|sybase|asa|informix)
     * @param string $database_config config database name
     * @return $this
     */
    public function targetConnection($driver, $connection){
        $cfg = config("database.connections.".$connection);
        $this->target($driver, $cfg['username'],  $cfg['password'],  $cfg['database'],  $cfg['host'],  $cfg['port']);
        return $this;
    }

    /**
     * Tables to sync
     *
     * @param string|array $tables Can be single table, array of tables, or splited with commas
     * return $this
     */
    public function tables($tables){
        $tables = $this->textComasOrArray2Array($tables);

        if (empty($tables)) {
            throw new \Exception('Table(s) empty.');
        }

        $this->options['tables'] = array_merge($this->options['tables'], $tables);
        return $this;
    }

    /**
     * Tables to excluded
     *
     * @param string|array $tables Can be single table, array of tables, or splited with commas
     * return $this
     */
    public function tables_excluded($tables){
        $tables = $this->textComasOrArray2Array($tables);

        if (empty($tables)) {
            throw new \Exception('Table(s) empty.');
        }

        $this->options['tables_excluded'] = array_merge($this->options['tables_excluded'], $tables);
        return $this;
    }

    /**
     * CMD
     *
     * @param string $option Option can be transfer, validate or assess
     * @throws \Exception
     * @return $this
     */
    public function cmd($option){
        $option = strtolower($option);

        if (in_array($option, ['transfer', 'validate', 'assess'])) {
            throw new \Exception('The cmd need to be transfer, validate or assess.');
        }

        $this->options['command'] = $option;
        return $this;
    }

    /**
     * topt
     *
     * return $this
     */
    public function topt($actions){
        $options = ['create','recreate','truncate','pnone'];

        $actions = $this->textComasOrArray2Array($actions);

        $actions = array_unique(array_intersect($actions, $options));

        if (empty($actions)) {
            throw new \Exception('topt empty.');
        }

        $this->options['topt'] = $actions;
        return $this;
    }

    /**
     * vopt
     *
     * @throws \Exception
     * @return $this
     */
    public function vopt($option){
        $option = strtolower($option);

        if (in_array($option, ['rowcount', 'rows'])) {
            throw new \Exception('The vopt need to be rowcount or rows.');
        }

        $this->options['vopt'] = $option;
        return $this;
    }



    /**
     * SMAP
     * option specifies the schema name mapping. For example, if you are migrating all tables from schema scott in Oracle, and want to move them to dbo schema in SQL Server, specify -smap = scott:dbo
     *
     * @throws \Exception
     * @return $this
     */
    public function smap($text){
        $text = $this->textComasOrArray2Array($text);

        if (empty($text)) {
            throw new \Exception('smap empty.');
        }

        $this->options['smap'] = array_merge($this->options['smap'], $text);
        return $this;
    }

    /**
     * cmap
     * option specifies an ASCII file containing a column name and data type mapping.
     *
     * @throws \Exception
     * @return $this
     */
    public function cmap($text){
        $text = is_array($text) ? $text : [$text];

        if (empty($text)) {
            throw new \Exception('cmap empty.');
        }

        $this->options['cmap'] = array_merge($this->options['cmap'], $text);
        return $this;
    }

    /**
     * dtmap
     * option specifies an ASCII file containing a column name and data type mapping.
     *
     * @throws \Exception
     * @return $this
     */
    public function dtmap($text){
        $text = is_array($text) ? $text : [$text];

        if (empty($text)) {
            throw new \Exception('dtmap empty.');
        }

        $this->options['dtmap'] = array_merge($this->options['dtmap'], $text);
        return $this;
    }


    /**
     * tmap
     * Table name mapping file. Example:
     * SALES.CONTACTS, CRM.SALES_CONTACTS
     *
     * @throws \Exception
     * @return $this
     */
    public function tmap($text){
        $text = is_array($text) ? $text : [$text];

        if (empty($text)) {
            throw new \Exception('tmap empty.');
        }

        $this->options['tmap'] = array_merge($this->options['tmap'], $text);
        return $this;
    }


    /**
     * queries
     * SQL SELECT queries
     *
     * @throws \Exception
     * @return $this
     */
    public function queries($text){
        $text = is_array($text) ? $text : [$text];

        if (empty($text)) {
            throw new \Exception('queries empty.');
        }

        $this->options['queries'] = array_merge($this->options['queries'], $text);
        return $this;
    }


    /**
     * twhere
     *
     * WHERE conditions for tables. Example :
     * SALES.ORDERS, created_dt >= CURRENT_DATE;
     *
     * @throws \Exception
     * @return $this
     */
    public function twhere($text){
        $text = is_array($text) ? $text : [$text];

        if (empty($text)) {
            throw new \Exception('twhere empty.');
        }

        $this->options['twhere'] = array_merge($this->options['twhere'], $text);
        return $this;
    }

    /**
     * tsel
     *
     * Select expressions for tables. Example:
     * SALES.CONTACTS, NAME, SUBSTR(CREATED_DT, 1, 10) AS CREATED_DT, 'HQ OFFICE' AS OFFICE;
     *
     * @throws \Exception
     * @return $this
     */
    public function tsel($text){
        $text = is_array($text) ? $text : [$text];

        if (empty($text)) {
            throw new \Exception('tsel empty.');
        }

        $this->options['tsel'] = array_merge($this->options['tsel'], $text);
        return $this;
    }

    /**
     * tsel_all
     *
     * Select expressions for all tables (not applied for tables defined in sqlines_tsel). Example:
     * *, 'NA REGION' AS REGION;
     *
     * @throws \Exception
     * @return $this
     */
    public function tsel_all($text){
        $text = is_array($text) ? $text : [$text];

        if (empty($text)) {
            throw new \Exception('tsel_all empty.');
        }

        $this->options['tsel_all'] = array_merge($this->options['tsel_all'], $text);
        return $this;
    }






    public function sync(){
        $sqlines_path = storage_path($this->sqlines_storage);
        $tmp_prefix = uniqid("tmp_");


        $this->files = [
            'app'       => $this->sqlines_storage."/".$this->sqlines_app,
            'cfg'       => $this->sqlines_storage."/".$tmp_prefix."_cfg.tmp",
            'tables'    => $this->sqlines_storage."/".$tmp_prefix."_tables.tmp",
            'tmap'      => $this->sqlines_storage."/".$tmp_prefix."_tmap.tmp",
            'cmap'      => $this->sqlines_storage."/".$tmp_prefix."_cmap.tmp",
            'twhere'    => $this->sqlines_storage."/".$tmp_prefix."_twhere.tmp",
            'cnsmap'    => $this->sqlines_storage."/".$tmp_prefix."_cnsmap.tmp",
            'tsel'      => $this->sqlines_storage."/".$tmp_prefix."_tsel.tmp",
            'tsel_all'  => $this->sqlines_storage."/".$tmp_prefix."_tsel_all.tmp",
        ];

        if (empty($this->options['source'])) {
            throw new \Exception('Source is empty.');
        }
        if (empty($this->options['target'])) {
            throw new \Exception('Target is empty.');
        }
        if (empty($this->options['tables'])) {
            throw new \Exception('Tables is empty.');
        }

        if(!File::exists(storage_path($this->files['app']))) {
            throw new \Exception('SQlines App not present in: '.storage_path($this->files['app'])."\nTry run: php artisan vendor:publish --tag=laravelsqlines.app");
        }

        $exports = "";
        if(!empty(config('laravelsqlines.export_paths'))){
            $exports .= sprintf('export LD_LIBRARY_PATH=\$LD_LIBRARY_PATH:%s; ', config('laravelsqlines.export_paths'));
        }

        if(config('laravelsqlines.export_nls_lang') === true){
            $exports .= sprintf(' export NLS_LANG=%s;', config('laravelsqlines.data-options.oracle_nls_lang'));
        }

        $options = [];
        $options[] = $this->option2File("tmap", "tmapf");
        $options[] = $this->option2File("cmap", "cmapf");
        $options[] = $this->option2File("tables", "tf");
        $options[] = $this->option2File("tsel", "tself");
        $options[] = $this->option2File("cnsmap", "cnsmapf");
        $options[] = $this->option2File("tsel_all", "tsel_allf");
        $options = array_filter($options);

        $this->config2File($options);
        $conn = sprintf("cd %s; %s %s -cfg=%s", $sqlines_path, $exports, storage_path($this->files['app']), storage_path($this->files['cfg']));

        $log = shell_exec($conn);
        $this->deleteTmp();
        return $log;
    }

    private function config2File($optionsfiles = []){
        $config = array_filter(config('laravelsqlines.data-options'));
        $config['sd'] = $this->options['source'];
        $config['td'] = $this->options['target'];
        $config['smap'] = implode(",", $this->options['smap']);

        $cfg_content = empty($optionsfiles) ?  "" : implode(" \n", $optionsfiles)."\n";
        foreach ($config as $key => $value){
            $cfg_content .= sprintf("-%s=%s \n", $key, $value);
        }

        $file = storage_path($this->files['cfg']);
        file_put_contents($file, $cfg_content);
    }

    private function option2File($option, $optionf){
        if(!empty($this->options[$option])){
            file_put_contents(storage_path($this->files[$option]), implode("\n", $this->options[$option]));
            return sprintf("-%s=%s", $optionf, storage_path($this->files[$option]));
        }
        return "";
    }


    private function textComasOrArray2Array($text){
        if(is_array($text)){
            $array = $text;
        }elseif( strpos($text, ",") !== false ) {
            $array = explode(",", $text);
        }else{
            $array = [$text];
        }
        return $array;
    }

    private function deleteTmp(){
        $sqlines_path = storage_path($this->sqlines_storage)."/";
        array_map('unlink', glob( $sqlines_path."*.{tmp,txt,sql,log}", GLOB_BRACE));
    }


    private function connectionString($connection, $username, $password = "", $database, $host = "", $port="")
    {
        if (!in_array($connection, $this->connections)) {
            throw new \Exception('Invalid type of connection.');
        }

        switch ($connection){
            case 'oracle':
                $host = empty($port) ? $host : $host.':'.$port;
                $credentials = empty($password) ? $username : $username."/".$password;
                $connection_string = sprintf("%s, %s@%s/%s", $connection, $credentials, $host, $database);
                break;

            case 'asa':
            case 'db2':
                $credentials = empty($password) ? $username : $username."/".$password;
                $connection_string = sprintf("%s, %s@%s", $connection, $credentials, $database);
                break;

            default:
                $host = empty($port) ? $host : $host.':'.$port;
                $credentials = empty($password) ? $username : $username."/".$password;
                $connection_string = sprintf("%s, %s@%s,%s", $connection, $credentials, $host, $database);
                break;
        }

        return $connection_string;
    }


}
