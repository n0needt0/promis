<script>
$(document).ready(function(){

	  $('#progress').dataTable( {
	    "bJQueryUI": true,
	    "bPaginate": false,
	    "bFilter": false,
	    "bInfo": false,
	    "bProcessing": true,
	    "aaSorting": [[ 1, "asc" ]],
	    "aoColumns": [
	                  { "sType": "string" },
	                  { "sType": "string" },
	                  { "sType": "string" },
	                  { "bSortable": false, 'sClass': 'noSort' }
	                 ]
	  });
	});


//the following script actually fires up the application

var head= document.getElementsByTagName('head')[0];
var script= document.createElement('script');
script.setAttribute('type', 'text/javascript');
script.setAttribute('src', Conf.home + '/assets/vendor/require/require.js');
script.setAttribute('data-main', Conf.home + "/assets/jsapp/config_survey");
head.appendChild(script);

var link = document.createElement("link");
link.type = "text/css";
link.rel = "stylesheet";
link.href = Conf.home + "/assets/jsapp/style.css";
head.appendChild(link);

var pin = '<?php echo $pin; ?>';
var pkey = '<?php echo $pkey; ?>';

</script>

<style>
 #instrument_list{
   width: 420px;
   height: 32px;
   line-height: 32px;
   font-size:1.2em;
   }

#form {
    margin-left: auto;
    margin-right: auto;
    padding-bottom: 10px;
    padding-top: 10px;
    text-align: left;
    width: 100%;
}

   #survey-title {
   }

    #app{
    min-height:60px;
    }


</style>

<div id="content">
 <div id='app' class="navbar mini-layout">
      <div id='form' class='form-inline'>
        <span id='survey-title'><?php echo $pin; ?></span> &nbsp;
        <span id='instruments'></span>
      </div>
 </div>
  <h3>Completed so far</h3>
  <table cellpadding="0" cellspacing="0" border="0" id="progress" class='display' ">
  <thead>
    <tr>
      <th>Last</th>
      <th>Instrument</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php

    foreach ($surveys as $row)
    {
      $admin = false;
      ?>
      <tr class='line_item' ref='<?php echo $row['token']; ?>'>
          <td><?php echo htmlspecialchars(date('Y-m-d', $row['updated'])); ?></td>
          <td><?php echo htmlspecialchars($row['instrument_name']); ?></td>
          <td><?php echo htmlspecialchars($row['status']); ?></td>
          <td>
          <?php
              switch ($row['status'])
              {
                case 'completed':
                    echo "<a class='action_result' ref='" . $row['token'] . "'>see result</a>";
                  break;
                case 'incomplete':
                  echo "<a class='action_continue' ref='" . $row['token'] . "'>continue</a>";
                  break;
                case 'expired':
                  echo "<a class='action_delete' ref='" . $row['token'] . "'>delete</a>";;
                  break;
              }
          ?>
          </td>
      </tr>
      <?php
    }
    ?>
  </tbody>
</table>
</div>
