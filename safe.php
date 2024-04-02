<?php
foreach ($_POST as $key => $value) {
  $_POST[$key] = is_array($key) ? $_POST[$key]: strip_tags($_POST[$key]);
}
?>