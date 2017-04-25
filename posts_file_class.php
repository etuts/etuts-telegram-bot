<?php 
class Posts_file {
	protected $pfile_name;

	protected $the_file; // FILE type

	function __construct($for_write = true, $pfile_name = __DIR__."channelposts.txt") {
		$this->pfile_name = $pfile_name;
		if ($for_write)
			return $this->open_write_file();
		else
			return $this->open_read_file();
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
	function add_post($post_line, $priority = false) {
		log_debug($post_line);
		fwrite($this->the_file, $post_line . "\n");
		/*if (is_writable($this->the_file)) {
			if ($priority)
				rewind($this->the_file);
			log_debug($post_line);
		}*/
	}
	function read_post() {
		$post_line = false;
		if (!feof($this->the_file)) {
			$post_line = fgets($this->the_file);
			// remove the line from file
			$contents = file_get_contents($this->pfile_name);
			$contents = implode('', explode($post_line, $contents, 2)); // replace first occurrence
			file_put_contents($this->pfile_name, $contents);
		}
		return $post_line;
	}
}
