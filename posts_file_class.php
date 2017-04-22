<?php 
class Posts_file {
	protected $pfile_name;

	protected $the_file; // FILE type

	function __construct($for_write = true, $pfile_name = "channel-posts.txt") {
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
		if ($priority)
			rewind($this->the_file);
		fwrite($this->the_file, $post_line . PHP_EOL);
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
