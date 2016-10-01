<?php

abstract class Model {

    protected static $table;
    protected static $columes = array();

    public static function get($id) {
        if (!filter_var($id, FILTER_VALIDATE_INT) || empty(static::$table))
            return FALSE;
        $nameclass = get_called_class();
        $get = $nameclass . "#Blockread";
//        $keycache = static::getKeyCacheId($id);
//        $element = IOCache::get($keycache);
//        if ($element == false) {
//            IOCache::block($get);
            
            $element = IOMysqli::row("SELECT * FROM `" . IOMysqli::esc(static::$table) . "` WHERE id='" . $id . "'");
            
//            static::getLinked($element);
//            IOCache::add($keycache, $element);
//            IOCache::unblock($get);
//        }
        return $element;
    }

    protected static function getInstance() {
        static $instance;
        $class=get_called_class();
        if ($instance[$class] === NULL)
            $instance[$class] = array();
        return $instance;
    }

    protected static function getLinked(&$element) {
        
    }

    protected static function getKeyCacheId($id) {
        return get_called_class() . "#getid#".$id;
    }
	public static function myQuery($query, $grid){

		switch($grid){
			case 1:
				return IOMysqli::one(IOMysqli::esc($query));
			break;
			case 2:
				return IOMysqli::row(IOMysqli::esc($query));
			break;
			case 3:
				return IOMysqli::table(IOMysqli::esc($query));
			break;
		}
	}
	
    /**
     * запись данных в таблицу модели
     * @param int $id - ID модели
     * @param array $fields - массив значений
     * @return boolean - результат записи данных в таблицу
     */
    public static function set($id, $fields = array()) {
        if (!filter_var($id, FILTER_VALIDATE_INT) || empty(static::$table))
            return FALSE;
        unset($fields["id"]);
        unset($fields["dt"]);
        $data = array();
        $nameclass = get_called_class();
        $set = $nameclass . "#blockset#{$id}";
        IOCache::block($set);
        if ($fields) {
            foreach (static::$columes as $col_name) {
                if (isset($fields[$col_name]) && is_scalar($fields[$col_name])) {
                    $data[$col_name] = IOMysqli::esc($fields[$col_name]);
                    $update[] = "`{$col_name}`='{$data[$col_name]}'";
                }
            }
        }

        if ($data) {
            $q = "INSERT INTO `" . IOMysqli::esc(static::$table) . "` (`id`,`dt`,`" . join("`,`", array_keys($data)) . "`) values ('{$id}',now(),'" . join("','", $data) . "') "
                    . "ON DUPLICATE KEY UPDATE " . join(",", $update);
            $result = IOMysqli::query($q);
        } else {
            throw new Exception("попытка добавить пустые данные", E_USER_ERROR);
        }
        IOCache::unblock($set);
        return $result;
    }

    /**
     * удаление записи из таблицы модели
     * @param int $id - ID модели
     * @return boolean - результат удаления записи из таблицы
     */
    public static function delete($id) {
        if (!filter_var($id, FILTER_VALIDATE_INT) || empty(static::$table))
            return FALSE;
        $nameclass = get_called_class();
        $get = $nameclass . "#Blockread";
        $set = $nameclass . "#blockset";
        IOCache::block($set);
        IOCache::block($get);
        $q = "DELETE FROM " . IOMysqli::esc(static::$table) . " WHERE id=" . $id;
        $result = IOMysqli::query($q);
        IOCache::delete(static::getKeyCacheId());
        IOCache::unblock($set);
        IOCache::unblock($get);
        return $result;
    }

    /**
     * выводит количество записей из таблицы модели
     * @return int - Выводит следущий id
     */
    public static function nextId() {
        if (empty(static::$table))
            return FALSE;
        $nameclass = get_called_class();
        $key = $nameclass . "#id";
        if (!IOCache::block($key))
            return false;

        $id = IOCache::get($key);
        if ($id === false) {
            $q = "select max(id) from `" . IOMysqli::esc(static::$table) . "`";
            $id = (int) IOMysqli::one($q) + 1;
            $add = IOCache::add($key, $id);
        } else {
            $id = IOCache::increment($key, 1);
        }
        IOCache::unblock($key);
        return $id;
    }

    public static function log($string, $level = IOLog::LEVEL_INFO, $file = "", $row = "") {
        $instance = self::getInstance();

        $class = get_called_class();
        if ($instance[$class]['log'] === NULL)
            $instance[$class]['log'] = new IOLog("log_" . $class, IOLog::LEVEL_DEBUG);

        $instance[$class]['log']->log($string, $level, $file, $row);
    }
	public static function addFields($table, $fields){
		if($table && is_string($table) && $fields && is_array($fields)){
			$q = "INSERT INTO `" . IOMysqli::esc(static::$table) . "` (`" . join("`,`", array_keys($data)) . "`) values ('" . join("','", $data) . "') ";
			return IOMysqli::query($q);
		}else{
			return 'error';
		}
	}

}