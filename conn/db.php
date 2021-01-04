<?php

class db {
    protected $connection;
    protected $query;
    protected $show_errors = TRUE;
    protected $query_closed = TRUE;
    public $query_count = 0;

    public function __construct($dbhost, $dbuser, $dbpass, $dbname, $charset)
    {
        $this->connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($this->connection->connect_error) {
			$this->error('Ffalha ao conectar com mysql - ' . $this->connection->connect_error);
		}
    }
}