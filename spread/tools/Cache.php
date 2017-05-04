<?php
namespace spread\tools;
abstract class Cache{
	/**
	*设置value
	*/
	abstract public function s_set($key, $value, $time);
	abstract public function s_get($key);
}