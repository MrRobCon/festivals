<?php
function get_words($text, $count = 10) {
  return implode(' ', array_slice(explode(' ', $text), 0, $count));
}
?>
