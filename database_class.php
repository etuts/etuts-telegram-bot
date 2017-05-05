<?php 
class Database {
	protected $db_name;
	protected $db_user;
	protected $db_pass;
	protected $db;
	protected $chat_id;
	protected $message_id;

	function __construct($db_name, $db_user, $db_pass, $chat_id = 0, $message_id = 0) {
		$this->db_name = $db_name;
		$this->db_user = $db_user;
		$this->db_pass = $db_pass;
		$this->db = mysqli_connect('localhost',$this->db_user,$this->db_pass,$this->db_name) or die('Error connecting to MySQL server.');
		$this->chat_id = $chat_id;
		$this->message_id = $message_id;
		return $this->db;
	}
	function __destruct() {
		mysqli_close($this->db);
	}
	function get_user_row() {
		return mysqli_query($this->db, "SELECT * FROM `chats` WHERE chat_id = '$this->chat_id' ");
	}
	function insert($state, $text, $username = '', $fullname = '', $permission = 0, $data = '') {
		$default_cats = json_encode([0,0,0,0,0,0]);
		return mysqli_query($this->db, "INSERT INTO `chats` (chat_id, state, last_message, permission, data, username, fullname, cats) VALUES ('$this->chat_id', '$state', '$text', '$permission', '$data', '$username', '$fullname', '$default_cats') ");
	}
	function set_permission($permission, $chat_id) {
		return mysqli_query($this->db, "UPDATE `chats` SET permission = '$permission' WHERE chat_id = '$chat_id' ");
	}
	function set_state($state) {
		return mysqli_query($this->db, "UPDATE `chats` SET state = '$state' WHERE chat_id = '$this->chat_id' ");
	}
	function set_data($data_string) {
		$data_string = json_encode($data_string);
		$data_string = addslashes($data_string);
		return mysqli_query($this->db, "UPDATE `chats` SET data = '$data_string' WHERE chat_id = '$this->chat_id' ");
	}
	function set_username($username) {
		return mysqli_query($this->db, "UPDATE `chats` SET username = '$username' WHERE chat_id = '$this->chat_id' ");
	}
	function set_fullname($fullname) {
		return mysqli_query($this->db, "UPDATE `chats` SET fullname = '$fullname' WHERE chat_id = '$this->chat_id' ");
	}
	function set_last_message($text) {
		return mysqli_query($this->db, "UPDATE `chats` SET last_message = '$text' WHERE chat_id = '$this->chat_id' ");
	}
	function set_categories_checked_array($cats) {
		$cats = json_encode($cats);
		$cats = addslashes($cats);
		return mysqli_query($this->db, "UPDATE `chats` SET cats = '$cats' WHERE chat_id = '$this->chat_id' ");
	}
	function get_state($chat_id = false) {
		if ($chat_id === false)
			$chat_id = $this->get_chat_id();
		$result = mysqli_query($this->db, "SELECT `state` FROM `chats` WHERE chat_id = '$chat_id' ");
		return (int)$result->fetch_assoc()['state'];
	}
	function get_data($chat_id = false) {
		if ($chat_id === false)
			$chat_id = $this->get_chat_id();
		$result = mysqli_query($this->db, "SELECT `data` FROM `chats` WHERE chat_id = '$chat_id' ");
		$data = (string)$result->fetch_assoc()['data'];
		$data = json_decode($data, true);
		return $data;
	}
	function get_username($chat_id = false) {
		if ($chat_id === false)
			$chat_id = $this->get_chat_id();
		$result = mysqli_query($this->db, "SELECT `username` FROM `chats` WHERE chat_id = '$chat_id' ");
		return (string)$result->fetch_assoc()['username'];
	}
	function get_fullname($chat_id = false) {
		if ($chat_id === false)
			$chat_id = $this->get_chat_id();
		$result = mysqli_query($this->db, "SELECT `fullname` FROM `chats` WHERE chat_id = '$chat_id' ");
		return (string)$result->fetch_assoc()['fullname'];
	}
	function get_user_permission($chat_id = false) {
		if ($chat_id === false)
			$chat_id = $this->get_chat_id();
		$result = mysqli_query($this->db, "SELECT `permission` FROM `chats` WHERE chat_id = '$chat_id' ");
		return (int)$result->fetch_assoc()['permission'];
	}
	function get_categories_checked_array($chat_id = false) {
		if ($chat_id === false)
			$chat_id = $this->get_chat_id();
		$result = mysqli_query($this->db, "SELECT `cats` FROM `chats` WHERE chat_id = '$chat_id' ");
		$cats = (string)$result->fetch_assoc()['cats'];
		$cats = json_decode($cats, true);
		return $cats;
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
	function get_chat_id() {
		return $this->chat_id;
	}
	function get_message_id() {
		return $this->message_id;
	}
	function get_users_with_permission($permission) {
		$result = mysqli_query($this->db, "SELECT `chat_id` FROM `chats` WHERE permission = '$permission' ");
		while ($row = mysqli_fetch_assoc($result)) {
			$result_array[] = $row['chat_id'];
		}
		return $result_array;
	}

	// channelposts table
	function add_channelpost($post_line) {
		return mysqli_query($this->db, "INSERT INTO `channelposts` (data) VALUES ('$post_line') ");
	}
	function read_channelpost() {
		$result = mysqli_query($this->db, "SELECT data FROM channelposts LIMIT 1 ");
		
		if (mysqli_num_rows($result) == 0)
			return false;

		$data = (string)$result->fetch_assoc()['data'];
		$data = json_decode($data, true);
		mysqli_query($this->db, "DELETE FROM `channelposts` LIMIT 1 "); // delete the row
		return $data;
	}
	function remove_last_channelpost() {
		return mysqli_query($this->db, "DELETE FROM `channelposts` order by id desc LIMIT 1 ");
	}
	function remove_first_channelpost() {
		return remove_nth_channelpost(1);
	}
	function remove_nth_channelpost($n) {
		if ($n < 1)
			return false;
		return mysqli_query($this->db, "DELETE FROM `channelposts` order by id asc LIMIT $n ");
	}
	function get_num_of_channelposts_left() {
		$result = mysql_query($this->db, "SELECT * FROM `channelposts`");
		return mysqli_num_rows($result);
	}

	// site_recommend_post table
	function add_site_recommend_post($post_line) {
		return mysqli_query($this->db, "INSERT INTO `site_recommend_posts` (post) VALUES ('$post_line') ");
	}
	function get_site_recommend_post() {
		$result = mysqli_query($this->db, "SELECT post FROM `site_recommend_posts` WHERE NOT state = '".RESERVED."' LIMIT 1 ");
		
		if (mysqli_num_rows($result) == 0)
			return false;

		$post = (string)$result->fetch_assoc()['post'];
		return $post;
	}
	function set_site_recommend_first_post_state($state) {
		return mysqli_query($this->db, "UPDATE `site_recommend_posts` SET state = '$state' LIMIT 1"); // Update state
	}
	function remove_last_site_recommend_post() {
		return mysqli_query($this->db, "DELETE FROM `site_recommend_posts` order by id desc LIMIT 1 ");
	}
	/*function remove_first_channelpost() {
		return remove_nth_channelpost(1);
	}
	function remove_nth_channelpost($n) {
		if ($n < 1)
			return false;
		return mysqli_query($this->db, "DELETE FROM `channelposts` order by id asc LIMIT $n ");
	}*/
	function get_num_of_site_recommend_posts_left() {
		$result = mysql_query($this->db, "SELECT * FROM `site_recommend_posts`");
		return mysqli_num_rows($result);
	}
}
