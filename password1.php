<?php
  require('functions.php');

  include('head.php');
?>
      <div id="box1_nest" class="box_nest" style="visibility: hidden;">
        <div id="box1" class="box">
        
        </div>
      </div>

      <div id="box2_nest" class="box_nest">
        <div id="box2" class="box">
          <h2>Microstat</h2>
          <p class="why_text" title="This is the log table printed.">
            This is the only `log`!
          </p>
          <?php microstat('redir_options'); ?>
          
        </div>
      </div>

      <div id="box3_nest" class="box_nest" style="visibility: hidden;">
        <div id="box3" class="box">
        
        </div>
      </div>

<?php
  
  include('foot.php');
?>