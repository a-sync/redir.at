
      <div id="box1_nest" class="box_nest">
        <div id="box1" class="box">
          <h2>Why redir.at?</h2>
          <p class="why_text">
            We provide fast and reliable redirecting services, like anonymus, and short url redirection.
            <br/><br/>
            No ads, <span title="Although... some robots are talking about a hidden microlog." style="cursor: default;">no logs</span>, no waiting, no referer, no no.
          </p>
          <p class="why_high">
            We&#8217;r cool guys and girls
            <br /><br />
            Easiest way for redirection
            <br /><br />
            Unlimited redir forever<span class="star" title="Unless our server dies :)">*</span>
          </p>
          <span class="box_form_error" id="reportbox1"> </span>
        </div>
      </div>

      <div id="box2_nest" class="box_nest">
        <div id="box2" class="box">
          <h2>Anonymus redirection</h2>
          <form id="box2_form" name="box2_form" method="post" action="" onsubmit="return box2_form_onsubmit();">
            <div class="box_content">
              <h3>URL: <span class="box_form_error" id="reportbox2"> </span></h3>
              <input id="box2_url" type="text" name="box2_url" />
              <br />
              <h3>New URL: <span class="box_form_info" id="reportbox3"> </span></h3>
              <input id="box2_new" type="text" name="box2_new" readonly="readonly" />
            </div>
            <input id="box2_submit" type="submit" value="Submit" />
          </form>
        </div>
      </div>

      <div id="box3_nest" class="box_nest">
        <div id="box3" class="box">
          <h2>Nicelink / Shortlink</h2>
          <form id="box3_form" name="box3_form" method="post" action="" onsubmit="return box3_form_onsubmit();">
            <div class="box_content">
              <h3>URL: <span class="box_form_error" id="reportbox4"> </span></h3>
              <input id="box3_url" type="text" name="box3_url" />
              <br />
              <h3>Nicename: <span class="box_form_info" id="reportbox5">(Leave empty for a shortname!)</span></h3>
              <input id="box3_nice" type="text" name="box3_nice" maxlength="50" />
              <h3>New URL: <span class="box_form_info" id="reportbox6"> </span></h3>
              <input id="box3_new" type="text" name="box3_new" readonly="readonly" />
            </div>
            <input id="box3_submit" type="submit" value="Submit" />
          </form>
        </div>
      </div>
