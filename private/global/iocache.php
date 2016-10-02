<?php

final class IOCache {

    private $link;
    private $is_cashe;
    private $storage;

    private function __construct() {
        $this->is_cashe = $GLOBALS['CONFIG']['cache'] ? true : false;
        if ($this->is_cashe) {
            $conf = $GLOBALS["CONFIG"]["cache"];
            $this->link = new Memcache;
            $this->link->connect($conf["host"], $conf["port"]);
            if (!$this->link)
                throw new Exception("mamcache connect error", E_USER_ERROR);
        }else {
            $instance->storage = array();
        }
    }

    function __destruct() {
        if ($this->is_cashe) {
            if ($this->link !== NULL)
                $this->link->close();
        }else {
            unset($this->storage);
        }
    }

    private static function getInstance() {
        static $instance;
        if ($instance === NULL)
            $instance = new self;
        return $instance;
    }

    public static function get($key) {
        $instance = self::getInstance();
        if ($instance->is_cashe) {
            return $instance->link->get($key);
        } else {
            return isset($instance->storage[$key]) ? $instance->storage[$key] : false;
        }
    }

    public static function set($key, $value, $expire = 0) {
        $instance = self::getInstance();
        if ($instance->is_cashe) {
            return $instance->link->set($key, $value, 0, $expire);
        } else {
            $instance->storage[$key] = $value;
            return true;
        }
    }

    public static function add($key, $value, $expire = 0) {
        $instance = self::getInstance();
        if ($instance->is_cashe) {
            return $instance->link->add($key, $value, 0, $expire);
        } else {
            if (isset($instance->storage[$key])) {
                return false;
            } else {
                $instance->storage[$key] = $value;
                return true;
            }
        }
    }

    /**
     * Увиличивает значение элемента на значение value
     * @param string $key- ключ 
     * @param int $value - число на которое увеличивается элемент
     * @return int - возвращает новое значение value при успехе или false в случае неудачи
     */
    public static function increment($key, $value) {
        $instance = self::getInstance();
        if ($instance->is_cashe) {
            return $instance->link->increment($key, $value);
        } else {
            if (!isset($instance->storage[$key])) {
                $instance->storage[$key] = 0;
            } elseif (!is_numeric($instance->storage[$key])) {
                return false;
            }
            $instance->storage[$key]+=$value;
            return true;
        }
    }

    public static function decrement($key, $value) {
        $instance = self::getInstance();
        if ($instance->is_cashe) {
            return $instance->link->decrement($key, $value);
        } else {
            if (!isset($instance->storage[$key])) {
                $instance->storage[$key] = 0;
            } elseif (!is_numeric($instance->storage[$key])) {
                return false;
            }
            $instance->storage[$key]-=$value;
            return true;
        }
    }

    public static function delete($key, $timeout = 0) {

        $instance = self::getInstance();
        if ($instance->is_cashe) {
            return $instance->link->delete($key);
        } else {
            unset($instance->storage[$key]);
            return true;
        }
    }

    /**
     * Блокировка на время обработки элемента
     * @param string $off - название блокированного элемента
     * @param int $expire - время жизни блокировки 
     * @return boolean
     */
    public static function block($off, $expire = 300) {
        $keycash = "lock#" . $off;
        $s = IOCache::get($keycash);
        $c = 0;
        while ($expire > 0) {
            if (IOCache::add($keycash, 1))
                return true;

            $expare--;
            sleep(1);
        }
        return false;
    }

    public static function unblock($off) {
        $keycash = "lock#" . $off;
        return IOcache::delete($keycash);
    }

}