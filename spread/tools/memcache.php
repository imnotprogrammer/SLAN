<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace spread\tools;

use spread\tools;

/**
 * MemCache implements a cache application component based on [memcache](http://pecl.php.net/package/memcache)
 * and [memcached](http://pecl.php.net/package/memcached).
 *
 * MemCache supports both [memcache](http://pecl.php.net/package/memcache) and
 * [memcached](http://pecl.php.net/package/memcached). By setting [[useMemcached]] to be true or false,
 * one can let MemCache to use either memcached or memcache, respectively.
 *
 * MemCache can be configured with a list of memcache servers by settings its [[servers]] property.
 * By default, MemCache assumes there is a memcache server running on localhost at port 11211.
 *
 * See [[Cache]] for common cache operations that MemCache supports.
 *
 * Note, there is no security measure to protected data in memcache.
 * All data in memcache can be accessed by any process running in the system.
 *
 * To use MemCache as the cache application component, configure the application as follows,
 *
 * ~~~
 * [
 *     'components' => [
 *         'cache' => [
 *             'class' => 'yii\caching\MemCache',
 *             'servers' => [
 *                 [
 *                     'host' => 'server1',
 *                     'port' => 11211,
 *                     'weight' => 60,
 *                 ],
 *                 [
 *                     'host' => 'server2',
 *                     'port' => 11211,
 *                     'weight' => 40,
 *                 ],
 *             ],
 *         ],
 *     ],
 * ]
 * ~~~
 *
 * In the above, two memcache servers are used: server1 and server2. You can configure more properties of
 * each server, such as `persistent`, `weight`, `timeout`. Please see [[MemCacheServer]] for available options.
 *
 * @property \Memcache|\Memcached $memcache The memcache (or memcached) object used by this cache component.
 * This property is read-only.
 * @property MemCacheServer[] $servers List of memcache server configurations. Note that the type of this
 * property differs in getter and setter. See [[getServers()]] and [[setServers()]] for details.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class memcache extends Cache{
    /**
     * @var boolean whether to use memcached or memcache as the underlying caching extension.
     * If true, [memcached](http://pecl.php.net/package/memcached) will be used.
     * If false, [memcache](http://pecl.php.net/package/memcache) will be used.
     * Defaults to false.
     */
    public $useMemcached = false;
    /**
     * @var string an ID that identifies a Memcached instance. This property is used only when [[useMemcached]] is true.
     * By default the Memcached instances are destroyed at the end of the request. To create an instance that
     * persists between requests, you may specify a unique ID for the instance. All instances created with the
     * same ID will share the same connection.
     * @see http://ca2.php.net/manual/en/memcached.construct.php
     */
    public $persistentId;
    /**
     * @var array options for Memcached. This property is used only when [[useMemcached]] is true.
     * @see http://ca2.php.net/manual/en/memcached.setoptions.php
     */
    public $options;
    /**
     * @var string memcached sasl username. This property is used only when [[useMemcached]] is true.
     * @see http://php.net/manual/en/memcached.setsaslauthdata.php
     */
    public $username;
    /**
     * @var string memcached sasl password. This property is used only when [[useMemcached]] is true.
     * @see http://php.net/manual/en/memcached.setsaslauthdata.php
     */
    public $password;

    /**
     * @var \Memcache|\Memcached the Memcache instance
     */
    private $_cache;
    /**
     * @var array list of memcache server configurations
     */
    private $_servers = [];

    public function __construct(){
		
	}
	public function s_set($key, $value, $time){
		
	}
	public function s_get($key){
		
	}
}
           