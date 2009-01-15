<?php
require('functions.php');

$type = (isset($_GET['type']) && is_numeric($_GET['type'])) ? $_GET['type'] : false;


headers();
//echo '00';//debug


if($type == 20) {
  if($_POST['v'] == '') die('21');

  $link = anonymus_redirection(urldecode($_POST['v']), true);
  if($link == false) die('22');

  die('20' . 'http://redir.at/?' . $link);
}
elseif($type == 30) {
  if($_POST['v'] == '') die('31');

  $link = anonymus_redirection(urldecode($_POST['v']), true);
  if($link == false) die('32');

  $nice = urldecode($_POST['n']);

  if($nice != '') {
    if(strlen($nice) < 3) die('33');
    if(strlen($nice) > 50) die('34');
    if(!preg_match('/^[a-zA-Z0-9]*$/', $nice)) die('35');
  }
  else $nice = false;

  $short = get_shortlink($link, $nice);

  if($short === false) die('03 - Database query failed!');
  elseif($short === true) die('36');

  if($nice == false) $short = '?'.$short;
  die('30' . 'http://redir.at/' . $short);
}


?>