// redir.at
// main.js
// 
// Javascript / Ajax handler

if(window.attachEvent) window.attachEvent('onload', redir_init);
else window.addEventListener('load', redir_init, false);

function redir_init(event)
{
  //var elem = event.currentTarget || event.srcElement;
  img_preload();

  // select onclick
  var box2_new = document.getElementById('box2_new');
  if(box2_new.attachEvent) box2_new.attachEvent('onclick', select);
  else box2_new.addEventListener('click', select, false);

  var box3_new = document.getElementById('box3_new');
  if(box3_new.attachEvent) box3_new.attachEvent('onclick', select);
  else box3_new.addEventListener('click', select, false);

  // focus onload
  document.getElementById('box2_url').focus();
}

function select(event)
{
  var elem = event.currentTarget || event.srcElement;
  elem.select();
}

function box2_form_onsubmit(type, data)
{
  if (!type)
  {
    report(3, 'Loading...');
    ajax_post('v=' + escape(encodeURI(document.getElementById('box2_url').value)), 20, 3);
    return false;
  }
  else
  {
    if (type == 20)
    {
      report(2, '');
      document.getElementById('box2_new').value = data;
      document.getElementById('box3_url').value = document.getElementById('box2_url').value;
      document.getElementById('box2_url').value = '';
    }
    else
    {
      if (type == 21) report(2, 'No URL!');
      else if (type == 22) report(2, 'Invalid URL!');
    }
  }
}

function box3_form_onsubmit(type, data)
{
  if (!type)
  {
    report(6, 'Loading...');
    ajax_post('v=' + escape(encodeURI(document.getElementById('box3_url').value)) + '&n=' + escape(encodeURI(document.getElementById('box3_nice').value)), 30, 6);
    return false;
  }
  else
  {
    if (type == 30)
    {
      report(4, '');
      report(5, 'Leave empty for a shortname!');
      document.getElementById('box3_new').value = data;
      document.getElementById('box3_url').value = '';
    }
    else
    {
      if (type == 31) report(4, 'No URL!');
      else if (type == 32) report(4, 'Invalid URL!');
      else if (type == 33 || type == 34) report(5, 'Min. 3, max. 50 char!');
      else if (type == 35) report(5, 'Only a-z, 0-9 letters!');
      else if (type == 36) report(5, 'Nicename taken!');
    }
  }
}

function filter(e)
{
  if (req.readyState == 4)
  {
    if (req.status == 200)
    {
      report(e, 'Loading.');
      var t = req.responseText.substr(0, 1);
      var type = req.responseText.substr(0, 2);
      var data = req.responseText.substr(2);

      //if(type == '00') alert(" - Debug:\n"+req.responseText);// debug

      // response router
      if (t == 2) box2_form_onsubmit(type, data);
      else if (t == 3) box3_form_onsubmit(type, data);

      else if (t == 0) report(1, '<pre style="background-color: #e0efef">'+req.responseText+'</pre>'); // debug
      else
      {
        report(1, 'Invalid request / response!');
        t = '';
      }

      if (t != '' && t != 0) report(1, '');
      report(e, '');
    }
    else report(1, 'An error occurred during the ajax request!');
  }
}

function report(n, msg)
{
//alert(n + ' :: ' + msg);//dbg
  if (msg != '') msg = '(' + msg + ')';
  document.getElementById('reportbox' + n).innerHTML = msg;
}

// kép preloader
function img_preload()
{
  var preImg = [];

  preImg[0] = "images/submit.jpg";
  preImg[1] = "images/submit_active.jpg";
  preImg[2] = "images/submit_hover.jpg";

  var objImg = [];
  for (i in preImg)
  {
    objImg[i] = new Image();
    objImg[i].src = preImg[i];
  }
}

// ajax posztoló
var req = false;
function ajax_post(parameters, type, extra)
{
   req = false;
   if (window.XMLHttpRequest)
   {//Mozilla, Safari
      req = new XMLHttpRequest();
      if (req.overrideMimeType) req.overrideMimeType("text/html");
   }
   else if (window.ActiveXObject)
   {//IE
      try { req = new ActiveXObject("Msxml2.XMLHTTP"); }
      catch (e)
      {
        try { req = new ActiveXObject("Microsoft.XMLHTTP"); }
        catch (e) {}
      }
   }
   //if (!req) return false;
   if (!req) report(1, 'An error occurred during the XMLHttpRequest!');
   report(extra, 'Loading..');

   req.onreadystatechange = function () { filter(extra); };
   req.open("POST", "ajax.php?type=" + type, true);
   req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.setRequestHeader("Content-length", parameters.length);
   req.setRequestHeader("Connection", "close");
   req.send(parameters);

   return true;
}

/*
// ajax poster
var req = false;
function ajax_post(data, type)
{
   req = false;
   if (window.XMLHttpRequest)
   {//Mozilla, Safari
      req = new XMLHttpRequest();
      if (req.overrideMimeType) req.overrideMimeType("text/html");
   }
   else if (window.ActiveXObject)
   {//IE
      try { req = new ActiveXObject("Msxml2.XMLHTTP"); }
      catch (e)
      {
        try { req = new ActiveXObject("Microsoft.XMLHTTP"); }
        catch (e) {}
      }
   }
   if (!req) return false;
   //if (!req) alert('An error occurred during the XMLHttpRequest!');

   var parameters = '';
   var amp = '';
   for(var i in data)
   {
     parameters += amp + i + '=' + escape(encodeURI( data[i] ));
     if(amp == '') amp = '&';
   }

   req.onreadystatechange = ajax_response;
   req.open("POST", "ajax.php?type=" + type, true);
   req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   //req.setRequestHeader("Content-type", "text/plain;charset=utf-8");
   req.setRequestHeader("Content-length", parameters.length);
   req.setRequestHeader("Connection", "close");
   req.send(parameters);

   return true;
}

function ajax_response()
{
  if (req.readyState == 4)
  {
    if (req.status == 200)
    {
*/


/* "Everything is gonna burn,
    We'll all take turns
    I'll get mine, too... " */