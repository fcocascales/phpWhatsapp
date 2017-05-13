<?php
/*
	Upload a zipped Whatsapp chat (with photos)

	Ubuntu php7 ZipArchive:
		  $ sudo apt-get install php7.0-zip
	  [	$ sudo apt-cache search php7.0-* ]
*/

class UploadZip {

	const UPLOADED = "uploaded"; // Target folder for uploaded zip

	private $id; // Identifier for the zip and folder
	private $chat; // First text file in unzipped folder (the chat file)

	//----------------------------------------------
	// CONSTRUCTOR

	public function __construct() {
	}

	//----------------------------------------------
	// GETTERS

	public function getPath() { // Path of unzipped text file chat
		return $this->getFolder()."/".$this->chat;
	}
	public function getReverse() { // Reversed chat?
		$reverse = isset($_POST['reverse'])? boolval($_POST['reverse']) : false;
		return $reverse;
	}
	public function getTitle() { // Title of chat from text file
		return basename($this->chat, '.txt');
	}

	private function getZip() { // Path of uploaded zip
		return self::get_zip($this->id);
	}
	private function getFolder() { // Folder of unzipped zip files
		return self::get_folder($this->id);
	}

	private static function get_zip($id) {
		return self::UPLOADED."/$id.zip";
	}
	private static function get_folder($id) {
		return self::UPLOADED."/$id";
	}

	//----------------------------------------------
	// UPLOAD

	public function upload() {
		$this->id = uniqid();
		$this->chat = "";
		$this->input();
		$this->unzip();
		$this->search();
		$this->remember();
	}

	//----------------------------------------------
	// INPUT CHAT

	private function input() {
		////echo "<pre>"; var_dump($_FILES);
		$zip = isset($_FILES['zip'])? $_FILES['zip'] : array();
		if (empty($zip)) throw new Exception("INPUT: It's necessary to upload the zip file");
		extract($zip); // $name, $tmp_name, $size, $type, $error
		if ($error > 0) throw new Exception(self::ERRORS[$error]);
		if ($type != 'application/zip') throw new Exception("INPUT: The file is not a zip");
		move_uploaded_file($tmp_name, $this->getZip());
	}

	const ERRORS = array(
		0=> "UPLOAD_ERR_OK: All right",
		1=> "UPLOAD_ERR_INI_SIZE: The file is too large (php.ini)",
		2=> "UPLOAD_ERR_FORM_SIZE: The file is too large (<form>)",
		3=> "UPLOAD_ERR_PARTIAL: The file is incomplete",
		4=> "UPLOAD_NO_FILE: There is no file",
		6=> "UPLOAD_NO_TMP_DIR: No temporary folder (php.ini)",
		7=> "UPLOAD_CANT_WRITE: There are no write permissions",
		8=> "UPLOAD_ERR_EXTENSION: The file has an incorrect extension (<form>)",
	);

	//----------------------------------------------
	// UNZIP CHAT

	private function unzip() {
		$za = new ZipArchive();
		$zip = $this->getZip();
		if ($za->open($zip) !== true) throw new Exception("UNZIP: I can't open '$zip' file");
		$folder = $this->makeFolder();
		if (!$za->extractTo($folder)) throw new Exception("UNZIP: I can't extract '$zip' to '$folder'");
		$za->close();
	}

	private function makeFolder() {
		$folder = $this->getFolder();
		if (!mkdir($folder)) throw new Exception("MKDIR: I can't create '$folder' folder");
		return $folder;
	}

	//----------------------------------------------
	// SEARCH CHAT

	private function search() {
		$this->chat = self::search_extension($this->getFolder(), "txt");
	}

	private static function search_extension($folder, $extension) {
		if (!is_dir($folder)) throw new Exception("SEARCH: '$folder' is not a folder");
		try {
			$dir = opendir($folder);
			while (($file = readdir($dir)) !== false) {
				$path = "$folder/$file";
				if (filetype($path) != "file") continue;
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				if ($ext == $extension) return $file;
			}
			return "";
		}
		finally {
			closedir($dir);
		}
	}

	//----------------------------------------------
	// UPLOADED LIST

	public static function all() {
		$list = array();
		$folder = self::UPLOADED;
		$dir = opendir($folder);
		while (($file = readdir($dir)) !== false) {
			if ($file == '.' || $file == '..') continue;
			$path = "$folder/$file";
			if (filetype($path) == "dir") {
				$reverse = file_exists("$path/reverse.conf");
				$chat = self::search_extension($path, "txt");
				$list[$file] = array(
					'path'=> "$path/$chat",
					'reverse'=> $reverse,
					'title'=> basename($chat, '.txt'),
				);
			}
		}
		closedir($dir);
		return $list;
	}

	public static function list() {
		@session_start();
		$list = empty($_SESSION['whatsapp_list'])? array() : $_SESSION['whatsapp_list'];
		return $list;
	}

	private function remember() {
		$list = self::list();
		$list[$this->id] = array(
			'path'=> $this->getPath(),
			'reverse'=> $this->getReverse(),
			'title'=> $this->getTitle(),
		);
		$_SESSION['whatsapp_list'] = $list;
		if ($this->getReverse()) {
			file_put_contents($this->getFolder()."/reverse.conf", 1);
		}
	}

	private static function forget($id) {
		$list = self::list();
		unset($list[$id]);
		$_SESSION['whatsapp_list'] = $list;
	}

	public static function delete($id) {
		@unlink(self::get_zip($id));
		self::deleteDir(self::get_folder($id));
		self::forget($id);
	}

	private static function deleteDir($dirPath) {
    if (!is_dir($dirPath)) {
      return; //throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath)-1, 1) != '/') {
      $dirPath .= '/';
    }
    $files = glob("$dirPath*", GLOB_MARK);
    foreach ($files as $file) {
      if (is_dir($file)) {
        self::deleteDir($file);
      } else {
        unlink($file);
      }
    }
    rmdir($dirPath);
}

	//----------------------------------------------
	//

}
