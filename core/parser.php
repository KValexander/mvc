<?php
// Parser
class Parser {
	private $url = "";
	private $html = "";
	private $wrap = array();
	private $content = array();
	private $n = NULL;

	// Getting site content
	public function url($url) {
		$this->url = $url;
		$this->html = file_get_contents($this->url);
		return $this;
	}

	// Getting the content of a specific wrapper
	public function wrap($tag, $attr, $value, $n=NULL) {
		$this->n = $n;
		preg_match_all("#<$tag $attr=(\"|')$value(\"|')>(.*?)</$tag>#su", $this->html, $result, PREG_PATTERN_ORDER);
		if ($n === NULL) $this->wrap = $result[0];
		else $this->wrap = $result[0][$n];
		return $this;
	}

	// Getting links from a wrapper
	public function link($attr="href") {
		if($this->n === NULL) foreach($this->wrap as $key => $val) $this->link_processing($attr, $key, $val);
		else $this->link_processing($attr, $this->n, $this->wrap);
		return $this;
	}

	// Getting content from a wrapper
	public function content($tag, $attr, $value) {
		if($this->n === NULL) foreach($this->wrap as $key => $val) $this->content_processing($tag, $attr, $value, $key, $val);
		else $this->content_processing($tag, $attr, $value, $this->n, $this->wrap);
		return $this;
	}

	// Link processing
	private function link_processing($attr, $key, $val) {
		preg_match_all("#$attr=(\"|')(.*?)(\"|')#su", $val, $result, PREG_PATTERN_ORDER);
		foreach($result[0] as $k => $v)
			$this->content[$key][$k][] = preg_replace("/(\"|\')/", "", preg_split("#$attr=#", $v)[1]);
	}

	// Content processing
	private function content_processing($tag, $attr, $value, $key, $val) {
		preg_match_all("#<$tag $attr=(\"|')$value(\"|')>(.*?)</$tag>#su", $val, $result, PREG_PATTERN_ORDER);
		foreach($result[0] as $k => $v) {
			preg_match_all("#<.*?>.*?</.*?>#su", $v, $tags, PREG_PATTERN_ORDER);
			foreach($tags[0] as $c)
				if(trim(strip_tags($c)) != "")
					$this->content[$key][$k][] = trim(strip_tags($c));
		}
	}

	// Retrieving content
	public function get() {
		if($this->n === NULL) return $this->content;
		else return $this->content[$this->n];
	}
}
?>