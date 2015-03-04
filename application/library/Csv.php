<?php

/**
 * 这是一个读取csv文件的迭代器，可以解决文件太大导致内存不足的问题。
 * Created by PhpStorm.
 * User: show
 * Date: 2015/3/4
 * Time: 11:44
 */
class Csv implements Iterator
{
	protected $file;
	protected $key = 0;
	protected $current;

	public function __construct($file) {
		$this->file = fopen($file, 'r');
	}

	public function __destruct() {
		fclose($this->file);
	}

	public function rewind() {
		rewind($this->file);
		$this->current = fgetcsv($this->file);
		$this->key = 0;
	}

	public function valid() {
		return !feof($this->file);
	}

	public function key() {
		return $this->key;
	}

	public function current() {
		return $this->current;
	}

	public function next() {
		$this->current = fgetcsv($this->file);
		$this->key++;
	}
}