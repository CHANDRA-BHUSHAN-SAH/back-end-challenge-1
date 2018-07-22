<?php

// setting the base url of the project
define("BASE_URL", "http://modestreet-test.in/");

// ----------------- Database configuration starts here ----------------
define("DB_HOSTNAME", "localhost");  // database server host name
define("DB_NAME",     "script_db");  // database name
define("DB_USERNAME", "root");       // database user name
define("DB_PASSWORD", "pass");       // database password for user
define("DB_CACHE_ON", TRUE);         // enable database caching
// ----------------- Database configuration ends here ------------------

// Record Limit for Pagination
define("REC_LIMIT", 10);

// -------------- Elastic Search configuration starts here -------------
define("ES_ENABLE", FALSE);                    // enable elastic search
define("ES_SERVER", "http://localhost:9200"); // elastic search server host name with port number
define("ES_INDEX",  "cb");                    // Root Index of elastic search engine
define("ES_TYPE",   "products");              // Object type name
// -------------- Elastic Search configuration ends here ----------------