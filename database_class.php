<?php 
class Database {
	protected $db_name;
	protected $db_user;
	protected $db_pass;
	protected static $db;
	protected $chat_id;

	function __construct($db_name, $db_user, $db_pass, $chat_id) {
		$this->db_name = $db_name;
		$this->db_user = $db_user;
		$this->db_pass = $db_pass;
		$this->db = mysqli_connect('localhost',$this->db_user,$this->db_pass,$this->db_name) or die('Error connecting to MySQL server.');
		$this->chat_id = $chat_id;
		return $this->db;
	}
	function __destruct() {
		mysqli_close($this->db);
	}
	function get_user_row() {
		return mysqli_query($this->db, "SELECT * FROM `chats` WHERE chat_id = '$this->chat_id' ");
	}
	function insert($state, $text, $permission = 0) {
		return mysqli_query($this->db, "INSERT INTO `chats` (chat_id, state, last_message, permission) VALUES ('$this->chat_id', '$state', '$text', '$permission') ");
	}
	function set_permission($permission) {
		return mysqli_query($this->db, "UPDATE `chats` SET permission = '$permission' WHERE chat_id = '$this->chat_id' ");
	}
	function get_state() {
		$result = mysqli_query($this->db, "SELECT `state` FROM `chats` WHERE chat_id = '$this->chat_id' ");
		return (int)$result->fetch_assoc()['state'];
	}
	function update_last_message($text) {
		return mysqli_query($this->db, "UPDATE `chats` SET last_message = '$text' WHERE chat_id = '$this->chat_id' ");
	}
	function set_state($state) {
		return mysqli_query($this->db, "UPDATE `chats` SET state = '$state' WHERE chat_id = '$this->chat_id' ");
	}
	function reset_state() {
		return $this->set_state(0);
	}
	function check_user_permission($permission) {
		$result = mysqli_query($this->db, "SELECT * FROM `chats` WHERE (chat_id, permission) = ('$this->chat_id', '$permission') ");
		return mysqli_num_rows($result) == 1;
	}
	function user_is_new() {
		$result = $this->get_user_row();
		return mysqli_num_rows($result) == 0;
	}
}
?>