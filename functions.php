<?php
error_reporting(0); // nincs
//error_reporting(E_ALL ^ E_NOTICE); // mind, kivéve notice


$defcon1 = @mysql_connect('localhost', 'onethreestudio', 'va1chaiV');// or die('01 - Failed to connect to the server!');
@mysql_select_db('onethreestudio', $defcon1);// or die('02 - Failed to connect to the database!');


function get_shortlink($link, $nice = false) {
  if($nice != false) {
    $type = '1';
    $sym = mysql_real_escape_string($nice);

    $q[0] = @mysql_query("SELECT `liid` FROM `redir_links` WHERE `type` = '$type' AND `nicename` = '$sym' LIMIT 1");

    if(@mysql_num_rows($q[0]) > 0) return true;
  }
  else {
    $type = '2';

    $q[0] = @mysql_query("SELECT `num` FROM `redir_options` WHERE `opid` = 'next_shortlink' LIMIT 1");
    $q[0] = @mysql_fetch_assoc($q[0]);
    $q[1] = @mysql_query("UPDATE `redir_options` SET `num` = `num` + 1 WHERE `opid` = 'next_shortlink' LIMIT 1");

    $sym = num2sym($q[0]['num']);
  }

  $link = @mysql_real_escape_string($link);
  $time = time();

  if($q[0] != false && ($q[1] != false || $type == '1')) $q[2] = @mysql_query("INSERT INTO `redir_links` (`nicename`, `url`, `type`, `date`) VALUES ('$sym', '$link', '$type', '$time')");
  else $q[2] = false;

  if($q[2] == false) return false;
  else return $sym;
}

function nicelink_redirection($str) {
  if(preg_match('/[a-zA-Z0-9]{3,50}$/', $str)) {
    $sym = @mysql_real_escape_string($str);
    $q[0] = @mysql_query("SELECT `liid`, `url` FROM `redir_links` WHERE `type` = '1' AND `nicename` = '$sym' LIMIT 1");
    $q[0] = @mysql_fetch_assoc($q[0]);

    if($q[0] == false) return false;
    else {
      $time = time();
      $q[1] = @mysql_query("UPDATE `redir_links` SET `used` = `used` + 1, `lastuse` = '$time' WHERE `liid` = '{$q[0]['liid']}' LIMIT 1");
      $q[2] = @mysql_query("UPDATE `redir_options` SET `num` = `num` + 1 WHERE `opid` = 'nice_redir_num' LIMIT 1");

      return headers($q[0]['url']);
    }
  }
  else return false;
}

function shortlink_redirection($str) {
  if(preg_match('/[a-zA-Z0-9]{3,50}$/', $str)) {
    $sym = @mysql_real_escape_string($str);
    $q[0] = @mysql_query("SELECT `liid`, `url` FROM `redir_links` WHERE `type` = '2' AND `nicename` = '$sym' LIMIT 1");
    $q[0] = @mysql_fetch_assoc($q[0]);

    if($q[0] == false) return false;
    else {
      $time = time();
      $q[1] = @mysql_query("UPDATE `redir_links` SET `used` = `used` + 1, `lastuse` = '$time' WHERE `liid` = '{$q[0]['liid']}' LIMIT 1");
      $q[2] = @mysql_query("UPDATE `redir_options` SET `num` = `num` + 1 WHERE `opid` = 'short_redir_num' LIMIT 1");

      return headers($q[0]['url']);
    }
  }
  else return false;
}

function anonymus_redirection($str, $ajax = false)
{
  // ha nincs http, https vagy ftp protokol, addjon hozzá http-t
  if(!preg_match("!((http(s?)://)|(ftp://))!i", $str)) { $str = 'http://'.$str; }

  if(preg_match(
    // -- protocol tag vagy www
    "!(((http(s?)://)|(ftp://)|(www\.))".
    // -- host maradéka, topdomain 2-4 karakter
    "([-a-z0-9.]{2,}\.[a-z]{2,4}".
    // -- port (ha van)
    "(:[0-9]+)?)".
    // -- mappa (ha van)
    "((/([^\s]*[^\s.,\"'])?)?)".
    // -- paraméterek (ha van, de kérdőjellel kell kezdődnie)
    "((\?([^\s]*[^\s.,\"'])?)?))!i",
    // -- amiben keresünk
    $str)) {

    //echo '<pre>'.print_r($data, true).'</pre>'; exit; //debug

    if($ajax) { return $str; }

    $q[0] = @mysql_query("UPDATE `redir_options` SET `num` = `num` + 1 WHERE `opid` = 'anon_redir_num' LIMIT 1");

    return headers($str);
  }

  return false;
}


function num2sym($int, $char = 3)
{
  if(is_numeric($int)) {
    $sym = base_convert($int, 10, 36);
    
    //str_repeat()
    while($char > strlen($sym)) {
      $sym = '0'.$sym;
    }
    
    return $sym;
  }
  else return false;
}

function headers($location = false) {
  //header('Expires: Sat, 22 Aug 1987 06:06:06 GMT');
  //header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
  //header('Cache-Control: no-store, no-cache, must-revalidate');
  //header('Cache-Control: post-check=0, pre-check=0');
  //header('Pragma: no-cache');

  if($location != false) {
    //header("Status: 301");
    header("HTTP/1.1 301 Moved Permanently"); // the proper way 
    header("Location: " . $location);
    exit;
  }

  return true;
}

function microstat($table) {
  $q = @mysql_query("SELECT * FROM `{$table}`");
  
  echo '<table width="100%" bgcolor="gray" border="0" bordercolor="gray" cellspacing="2" cellpadding="4">';
  $n = 0;
  
  while(false !== ($row = @mysql_fetch_assoc($q))) {
    $header = '<tr bgcolor="gray">';
    $inner = '<tr>';
    
    foreach($row as $i => $val) {
      if($n == 0) $header .= '<td>'.$i.'</td>';
      $inner .= '<td bgcolor="lavender">'.$val.'</td>';
    }
    if($n == 0) echo $header.'</tr>';
    $n++;
    
    echo $inner.'</tr>';
  }
  echo '</table>';
  echo '<span>Table: `'.$table.'` :: '.(($n < 1) ? 'No' : $n).' '.(($n > 1 || $n < 1) ? 'rows.' : 'row.').'</span>';
  
  //add pw stat :)
  //@mysql_query("INSERT INTO `redir_options` (`opid`, `type`, `text`, `num`) VALUES ('password1', '0', '', '0')");
  
  @mysql_query("UPDATE `redir_options` SET `num` = `num` + 1 WHERE `opid` = 'password1' LIMIT 1");
}

?>