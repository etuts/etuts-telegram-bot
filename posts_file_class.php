<?php 
class Posts_file {
	protected $pfile_name;
	protected $has_read_file;
	protected $has_write_file;
	protected $read_file;
	protected $write_file;
	function __construct($pfile_name) {
		$this->pfile_name = $pfile_name;
	}
	function open_read_file() {
		$this->read_file = fopen($this->pfile_name, "r");
		$this->has_read_file = true;
		return $this->read_file;
	}
	function open_write_file() {
		$this->write_file = fopen($this->pfile_name, "a");
		$this->has_write_file = true;
		return $this->write_file;
	}
	function close_files() {
		if ($this->has_read_file)
			fclose($this->read_file);

		if ($this->has_write_file)
			fclose($this->write_file);
	}
	function add_post($post_line) {
		$this->open_write_file();
	}
}
?>