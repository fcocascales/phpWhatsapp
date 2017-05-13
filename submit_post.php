<?php
	function submit_post($url, $params) {
    $content = http_build_query($params);
    $options = array(
      'http' => array(
        'header'  =>
          "Content-type: application/x-www-form-urlencoded\r\n".
          "Content-Length: ".strlen($content)."\r\n",
        'method'  => 'POST',
        'content' => $content,
      ),
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result; //var_dump($result);
  }

	function get_url($file) {
		$uri = dirname($_SERVER['REQUEST_URI']);
		return get_protocol().get_domain()."$uri/$file";
	}
	function get_domain() {
    $domain = $_SERVER['HTTP_HOST'];
    return $domain;
	}
	function get_protocol() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol;
	}
