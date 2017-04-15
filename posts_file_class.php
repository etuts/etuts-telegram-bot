<?php 
define("LAST", -1);
class Posts_file {
	protected $pfile_name;

	protected $the_file; // FILE type

	function __construct($pfile_name, $for_write = true) {
		$this->pfile_name = $pfile_name;
		if ($for_write)
			$this->open_write_file();
		else
			$this->open_read_file();
	}
	function __destruct() {
		fclose($this->the_file);
	}
	function open_read_file() {
		$this->the_file = fopen($this->pfile_name, "r");
		return $this->the_file;
	}
	function open_write_file() {
		$this->the_file = fopen($this->pfile_name, "a");
		return $this->the_file;
	}
	function add_post($post_line, $priority = LAST) {
		if (is_writable($this->the_file)) {
			fwrite($this->the_file, $post_line);
		}
	}
	function read_post() {
		$post_line = '';
		if (is_readable($this->the_file)) {
			if (!feof($this->the_file)) {
				$post_line = fgets($this->the_file);
				$contents = file_get_contents($this->pfile_name);
				$contents = str_replace($post_line, '', $contents);
				file_put_contents($this->pfile_name, $contents);
			}
		}
		return $post_line;
	}
}
?>