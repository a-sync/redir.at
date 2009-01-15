<?php
  require('functions.php');

  $del = (strpos($_SERVER['REQUEST_URI'], '?') === false) ? '/' : '?';
  $req = end(explode($del, $_SERVER['REQUEST_URI'], 2));

  if(strlen($req) > 2) {
    if($del == '?') {
      $red = anonymus_redirection($req);
      $red = shortlink_redirection($req);
    }
    else {
      $red = nicelink_redirection($req);
    }

    if($red != true && substr($req, 0, 9) != 'index.php') headers('http://'.$_SERVER['HTTP_HOST']);
  }


  include('head.php');
  include('main.php');
  include('foot.php');
?>