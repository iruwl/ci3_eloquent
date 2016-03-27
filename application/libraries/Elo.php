<?php
/**
 * CodeIgniter 3.0.6 With Eloquent ORM
 * @author  : Khairul Anwar <http://github.com/iruwl>
 * @created : 2016-03-27
 */

defined('BASEPATH') or die();
class Elo extends Illuminate\Database\Capsule\Manager
{
    static function _config() {
        $db['default'] = array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'YOUR_DB',
            'username'  => 'YOUR_DB_USERNAME',
            'password'  => 'YOUR_DB_PASSWORD',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        );

        $db['other'] = array(
            'driver'    => 'pgsql',
            'host'      => 'localhost',
            'database'  => 'YOUR_DB',
            'username'  => 'YOUR_DB_USERNAME',
            'password'  => 'YOUR_DB_PASSWORD',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        );

        return $db;
    }

    public function __construct()
    {
        parent::__construct();

        // Create a new instance of the database component and add a new connection
        $db = $this->_config();
        $events = new Illuminate\Events\Dispatcher;
        foreach($db as $con => $val) {
            $this->addConnection($val, $con);
            $this->setAsGlobal();

            // $this->connection($con)->disableQueryLog();
            if(ENVIRONMENT == 'development')
                $this->connection($con)->enableQueryLog();
            $this->connection($con)->setEventDispatcher($events);
        }

        $this->bootEloquent();

        // Listen for Query Events for Debug
        self::listen(function ($event) {
            // dump($event->sql);
            // dump($event->bindings);
            // dump($event->connection->getDatabaseName());

            $cn = 'Eloquent|'.$event->connection->getName();
            $d = $event->connection->getDatabaseName();
            $t = $event->time;
            $sql = $event->sql;
            $bindings = $event->bindings;

            // Format binding data for sql insertion
            foreach ($bindings as $i => $binding)
                $bindings[$i] = "'$binding'";

            // Insert bindings into query
            $q = str_replace(array('%', '?'), array('%%', '%s'), $sql);
            $q = vsprintf($q, $bindings);

            // Add to CI profiler log
            $CI =& get_instance();
            if(isset($CI->$cn)) {
                $CI->$cn->database = $d;
                $CI->$cn->queries[] = $q;
                $CI->$cn->query_times[] = $t/1000;
                $CI->$cn->query_count = (int) $CI->$cn->query_count + 1;
            } else {
                $dbc = new CI_DB(array(
                    'database' => $d,
                    'queries' => array($q),
                    'query_times' => array($t/1000),
                    'query_count' => 1,
                ));
                $CI->$cn = (object) $dbc;
            }

            // Debug SQL queries
            // echo '<pre>Debug SQL: ['.$t/1000 .'] ['.$q .']<br></pre>';
        });
    }

    public static function last_query(){
        $db = self::_config();
        $query = [];
        foreach($db as $con => $val) {
            $dbName = self::connection($con)->getDatabaseName();
            $qLogs = self::connection($con)->getQueryLog();

            foreach ($qLogs as $i => $log)
            {
                $bindings = $log['bindings'];
                foreach ($bindings as $i => $binding)
                    $bindings[$i] = "'$binding'";

                $t = $log['time'];
                $q = $log['query'];
                $q = str_replace(array('%', '?'), array('%%', '%s'), $q);
                $q = vsprintf($q, $bindings);
                $query[] = array(
                    'db'    => $dbName,
                    'query' => $q,
                    'time'  => $t,
                );
            }
        }
        return $query;
    }
}
