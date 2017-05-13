<?php
/*
	Convert downloaded Whatsapp chat into html
	by Francisco Cascales, 20-feb-2016
*/
class Whatsapp {

	// Attributes
	private $path = ""; // Whatsapp file & photos directory
	private $lines = array(); // Content of Whatsapp file
	private $reverse = false; // I talk first or later? (left or right)

	// Working data
	private $names = array(); // People names
	private $list = array(); // Array of (date, time, user, text, image)

	//----------------------------------------------
	// CONSTRUCTOR

	public function __construct ()  {
		$this->prepare_emoticons();
	}

	//----------------------------------------------
	// GETTERS & SETTERS

	public function setPath($value) {
		if (file_exists($value)) {
			$this->path = $value;
			$this->setChat(file_get_contents($this->path));
			return true;
		}
		else return false;
	}
	public function setChat($value) {
		$this->lines = explode("\n", $value);
	}
	public function setReverse($value) {
		$this->reverse = $value != 0;
	}

	public function getTitle() {
		return pathinfo($this->path, PATHINFO_FILENAME); // basename($path);
	}

	//----------------------------------------------
	// HTML

	public function asHTML() {
		$this->lines_to_data();
		return $this->data_to_html();
	}

	//----------------------------------------------
	// LINES TO DATA

	private function lines_to_data() {
		// Input
		$this->list = array();
		$dir = dirname($this->path);
		$users = array();
		$re1 = "^(\d{1,2}\/\d{1,2}\/\d{2,4}), (\d{1,2}:\d{2}) - ([^:]*): (.*)";
		$re2 = "^([^ ]*) \(archivo adjuntado\)";
		$index = 0;
		// Loop
		foreach ($this->lines as $line) {
			$count = preg_match("/$re1/i", $line, $matches);
			if ($count > 0) {
				$date = $matches[1];
				$time = $matches[2];
				$user = $matches[3];
				$text = $matches[4];
				$image = "";
				$count = preg_match("/$re2/i", $text, $matches);
				if ($count) {
					$photo = $matches[1];
					$text = "";
					$image = "<img src=\"$dir/$photo\" />";
				}
				$this->list[$index++]= array(
					'date'=> $date,
					'time'=> $time,
					'user'=> $user,
					'text'=> $text,
					'image'=> $image,
				);
				if (isset($users[$user])) $users[$user]++;
				else $users[$user] = 0;
			}
			else if ($index > 0) {
				$this->list[$index-1]['text'] .= "\n$line";
			}
		}
		$this->names = array_keys($users);
		if ($this->reverse) $this->names = array_reverse($this->names);
	}

	//----------------------------------------------
	// DATA TO HTML

	private function data_to_html() {
		return $this->names_to_html().$this->list_to_html();
	}

	private function names_to_html() {
		$html = "";
		$index = 0;
		foreach($this->names as $name) {
			$class = "user".$index++;
			$html.= "<div class=\"user $class\">";
			$html.=   "<div>";
			$html.=     "<div class=\"text\"><strong>$name</strong></div>";
			$html.=   "</div>";
			$html.= "</div>";
		}
		return $html;
	}

	private function list_to_html() {
		$html = "";
		$previousDate = "";
		setlocale(LC_ALL, 'es_ES.utf8'); // sudo apt-get install language-pack-$LANG-base
		$classes = $this->names_to_classes(); //$classes = array_combine($this->names, array('user0', 'user1'));
		foreach($this->list as $item) {
			extract($item); // $date, $time, $user, $text, $image
			if ($date != $previousDate) {
				$previousDate = $date;
				$html.= "<div class=\"date\"><div>".$this->date_format($date)."</div></div>";
			}
			$class = $classes[$user];
			$html.= "<div class=\"user $class\">";
			$html.=   "<div>";
			$html.=     "<div class=\"text\">".$this->text_to_html($text)."$image</div>";
			$html.=     "<div class=\"time\">$time</div>";
			$html.=   "</div>";
			$html.= "</div>";
		}
		return $html;
	}
	private function names_to_classes() {
		$classes = array();
		$index = 0;
		foreach($this->names as $name) {
			$classes[$name] = "user$index";
			$index++;
		}
		return $classes;
	}

	private function date_format($ymd) {
		////setlocale(LC_ALL, 'es_ES.utf8'); // sudo apt-get install language-pack-$LANG-base
		$ymd = str_replace("/","-",$ymd);
		if (strlen($ymd) == 8) {
			$parts = explode("-", $ymd);
			$parts[2] = "20".$parts[2]; //var_dump($parts);
			$ymd = implode("-", $parts);
		}
		$dt = new DateTime($ymd);
		$txt = strftime('%a %e de %B de %Y', $dt->getTimestamp());
		return $txt;
	}

	private function text_to_html($text) {
		$text = str_replace('  ',' &nbsp;', nl2br(htmlentities($text)));
		$text = str_replace($this->emoticons_keys, $this->emoticons_imgs, $text);
		return $text;
	}

	//----------------------------------------------
	// EMOTICONS

	private $emoticons_keys;
	private $emoticons_imgs;

	private function prepare_emoticons() {
		$emoticons = array(
			'😊'=> "e056", // smile
			'😞'=> "e058", // sad
			'😴'=> "em_1f634", // face zzz
			'💤'=> "e13c", // zzz
		);
		$keys = array_keys($emoticons);
		$imgs = array_values($emoticons);
		foreach ($imgs as &$img) {
			$img = "<img src=\"styles/emoticons/$img.png\" class=\"emoticon\" />";
		}
		$this->emoticons_keys = $keys;
		$this->emoticons_imgs = $imgs;
	}

	//----------------------------------------------

}
