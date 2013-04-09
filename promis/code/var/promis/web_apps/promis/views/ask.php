<script>
var progressbar = null;

$(document).ready(function(){
	 progressbar = $( "#progressbar" );
	 progressLabel = $( ".progress-label" );
    	 progressbar.progressbar({
        	 value: false,
        	 change: function() {
            	 progressLabel.text( progressbar.progressbar( "value" ) + "%" );
            	 progressbar.progressbar( "value" ) || 0;
            	 progressbar.find( ".ui-progressbar-value" ).css({"background": 'darkgreen'});

        	 },
        	 complete: function() {
          	   progressLabel.text( "Done!" );
        	 }
    	 });

	 });


//the following script actually fires up the application

var head= document.getElementsByTagName('head')[0];
var script= document.createElement('script');
script.setAttribute('type', 'text/javascript');
script.setAttribute('src', Conf.home + '/assets/vendor/require/require.js');
script.setAttribute('data-main', Conf.home + "/assets/jsapp/config_ask");
head.appendChild(script);

var link = document.createElement("link");
link.type = "text/css";
link.rel = "stylesheet";
link.href = Conf.home + "/assets/jsapp/style.css";
head.appendChild(link);

var pin = '<?php echo $pin; ?>';
var pkey = '<?php echo $pkey; ?>';
var token = '<?php echo $token; ?>';
var expire = '<?php echo $expire; ?>';
var instrument_name = '<?php echo $instrument_name; ?>';
var instrument_id = '<?php echo $instrument_id; ?>';

</script>

<style>
 #instrument_list{
   width: 420px;
   height: 32px;
   line-height: 32px;
   font-size:1.2em;
   }

  #progressbar {
  width:200px;
  float:right;
  }

  #survey-title {
  width:600px;
  float:left;
  }

  .progress-label {
      float: left;
      margin-left: 50%;
      margin-top: 5px;
      font-weight: bold;
      text-shadow: 1px 1px 0 #fff;
  }

   .finish {
          position: fixed;
          top: 50%;
          left: 50%;
          margin-top: -100px;
          margin-left: -200px;
  }

  .question_main{
  margin-top:60px;
  }

  .question_sub{
  margin:40px;
  }

  #app{
  min-height:400px;
  }

</style>

<div id="content">
    <div id='app' class="navbar mini-layout">
        <h2 id='survey-title'><?php echo $pin; ?></h2>
        <div id="progressbar"><div class="progress-label">0 %</div></div>
        <div id='survey'>
        </div>
        </div>
    </div>
</div>