<?php

    class Model{

        protected $tablename;
        protected $attributes;
        private   $db;
        public function __construct(){
            $this->db = new Db(db_host,db_name,db_user,db_pass,db_charset);
        }
        /**
         * @return mixed
         */
        public function getAttributes()
        {
            return $this->attributes;
        }
    }
?>