<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Served-From" content="<?php echo $served_from; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="/assets/favicon.ico" />
<title><?php echo $html_title;?> : Medical Survey</title>

<script src="/assets/combined.js.php?r=<?php echo CACHEVER; ?>"></script>

<script>
var Conf = Conf || {};

<?php
  if( JSDEBUG )
  {
      echo " Conf.DEBUG_MODE = 'console'; ";
  }
?>

Conf.APP_NAME = 'survey'; //application name is hard coded
Conf.server_name = '<?php echo $_SERVER['SERVER_NAME']?>';
Conf.protocol = 'http';
<?php
if(!empty($_SERVER['SERVER_HTTPS']))
{
	echo "Conf.protocol = 'https';";
}
?>

Conf.home = Conf.protocol + '://' + Conf.server_name;

Conf.api = { home:Conf.home, // this is location of a rest api for this application
             key:'ABCDEFG' //this is key for use in this API
           };


function debug(msg){

   if('debug' === Conf.DEBUG_MODE)
   {
       eval('debugger;');
   }

   if('console' === Conf.DEBUG_MODE)
   {
       console.log(msg);
   }
}


function waiting(){
	  $('#wait').html("<div class='wait_message'><img class='special_image' src = '/assets/images/loading.gif' /> Thinking...</div>");
	  $('#wait').dialog({
	      title:'One moment..',
	      autoOpen: true,
	      resizable: false,
	      width:300,
	      height:200,
	      modal: true
	    });

	    $('.ui-widget-overlay').css('height', 3000);
	    $('.ui-widget-overlay').css('width', $(window).width());
	    $(".ui-dialog-titlebar").hide();
 }

 function done(){
	 $('#wait').dialog("close");
	 $('#wait').html("");
 }

</script>
<link rel="stylesheet" type="text/css" href="/assets/combined.css.php?r=<?php echo CACHEVER; ?>" />

<style>
    .container{
    width:100%;
    }

      body {
        padding-top: 50px;
        padding-bottom: 40px;
        background-color: #ffffff;
        font-size:14px;
      }

      .wait_message {
          position: fixed;
          top: 50%;
          left: 50%;
          margin-top: -40px;
          margin-left: -80px;
     }

     #info{
       background:#EEEEEE;
       padding:0px;
       margin:0px;
     }

      .hl-yellow{
        background:yellow;
      }

      .hl-underline{
       text-decoration: underline;
      }


      .normaltext{
        font-size:16px;
      }

     .footerholder {
            background: none repeat scroll 0 0 transparent;
            bottom: 0;
            position: fixed;
            text-align: center;
            width: 100%;
        }

        .footer{
            position:fixed;
            bottom:0;
            left:50%;
            margin-left:-200px; /*negative half the width */
            width:400px;
            height:30px;
        }

      #title{
      float:right;
      }

     /* Mini layout previews
        -------------------------------------------------- */
        .mini-layout {
          border: 1px solid #ddd;
          -webkit-border-radius: 6px;
             -moz-border-radius: 6px;
                  border-radius: 6px;
          -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.075);
             -moz-box-shadow: 0 1px 2px rgba(0,0,0,.075);
                  box-shadow: 0 1px 2px rgba(0,0,0,.075);
        }
        .mini-layout,
        .mini-layout .mini-layout-body,
        .mini-layout.fluid .mini-layout-sidebar {
          height: 100%;
        }
        .mini-layout {
          margin-bottom: 20px;
          padding: 9px;
        }
        .mini-layout div {
          -webkit-border-radius: 3px;
             -moz-border-radius: 3px;
                  border-radius: 3px;
        }
        .mini-layout .mini-layout-body {
          background-color: #dceaf4;
          margin: 0 auto;
          width: 100%;
          padding-left:5px;
          text-align:left;
        }
        .mini-layout.fluid .mini-layout-sidebar,
        .mini-layout.fluid .mini-layout-header,
        .mini-layout.fluid .mini-layout-body {
          float: left;
        }
        .mini-layout.fluid .mini-layout-sidebar {
          background-color: #bbd8e9;
          width: 20%;
        }
        .mini-layout.fluid .mini-layout-body {
          width: 77.5%;
          margin-left: 2.5%;
        }

  #navbar {
    width: 100%;
}



         /*
 *  File:         demo_table_jui.css
 *  CVS:          $Id$
 *  Description:  CSS descriptions for DataTables demo pages
 *  Author:       Allan Jardine
 *  Created:      Tue May 12 06:47:22 BST 2009
 *  Modified:     $Date$ by $Author$
 *  Language:     CSS
 *  Project:      DataTables
 *
 *  Copyright 2009 Allan Jardine. All Rights Reserved.
 *
 * ***************************************************************************
 * DESCRIPTION
 *
 * The styles given here are suitable for the demos that are used with the standard DataTables
 * distribution (see www.datatables.net). You will most likely wish to modify these styles to
 * meet the layout requirements of your site.
 *
 * Common issues:
 *   'full_numbers' pagination - I use an extra selector on the body tag to ensure that there is
 *     no conflict between the two pagination types. If you want to use full_numbers pagination
 *     ensure that you either have "example_alt_pagination" as a body class name, or better yet,
 *     modify that selector.
 *   Note that the path used for Images is relative. All images are by default located in
 *     ../images/ - relative to this CSS file.
 */


/*
 * jQuery UI specific styling
 */

.paging_two_button .ui-button {
    float: left;
    cursor: pointer;
    * cursor: hand;
}

.paging_full_numbers .ui-button {
    padding: 2px 6px;
    margin: 0;
    cursor: pointer;
    * cursor: hand;
    color: #333 !important;
}

.dataTables_paginate .ui-button {
    margin-right: -0.1em !important;
}

.paging_full_numbers {
    width: 350px !important;
}

.dataTables_wrapper .ui-toolbar {
    padding: 5px;
}

.dataTables_paginate {
    width: auto;
}

.dataTables_info {
    padding-top: 3px;
}

table.display thead th {
    padding: 3px 0px 3px 10px;
    cursor: pointer;
    * cursor: hand;
}

div.dataTables_wrapper .ui-widget-header {
    font-weight: normal;
}


/*
 * Sort arrow icon positioning
 */
table.display thead th div.DataTables_sort_wrapper {
    position: relative;
    padding-right: 20px;
}

table.display thead th div.DataTables_sort_wrapper span {
    position: absolute;
    top: 50%;
    margin-top: -8px;
    right: 0;
}




/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 * Everything below this line is the same as demo_table.css. This file is
 * required for 'cleanliness' of the markup
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * DataTables features
 */

.dataTables_wrapper {
    position: relative;
    clear: both;
}

.dataTables_processing {
    position: absolute;
    top: 0px;
    left: 50%;
    width: 250px;
    margin-left: -125px;
    border: 1px solid #ddd;
    text-align: center;
    color: #999;
    font-size: 11px;
    padding: 2px 0;
}

.dataTables_length {
    width: 40%;
    float: left;
}

.dataTables_filter {
    width: 50%;
    float: right;
    text-align: right;
}

.dataTables_info {
    width: 50%;
    float: left;
}

.dataTables_paginate {
    float: right;
    text-align: right;
}



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * DataTables display
 */
table.display {
    margin: 0 auto;
    width: 100%;
    clear: both;
    border-collapse: collapse;
}

table.display tfoot th {
    padding: 3px 0px 3px 10px;
    font-weight: bold;
    font-weight: normal;
}

table.display tr.heading2 td {
    border-bottom: 1px solid #aaa;
}

table.display td {
    padding: 3px 10px;
}

table.display td.center {
    text-align: center;
}



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * DataTables sorting
 */

.sorting_asc {
    background: url('../images/sort_asc.png') no-repeat center right;
}

.sorting_desc {
    background: url('../images/sort_desc.png') no-repeat center right;
}

.sorting {
    background: url('../images/sort_both.png') no-repeat center right;
}

.sorting_asc_disabled {
    background: url('../images/sort_asc_disabled.png') no-repeat center right;
}

.sorting_desc_disabled {
    background: url('../images/sort_desc_disabled.png') no-repeat center right;
}




/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * DataTables row classes
 */
table.display tr.odd.gradeA {
    background-color: #ddffdd;
}

table.display tr.even.gradeA {
    background-color: #eeffee;
}




table.display tr.odd.gradeA {
    background-color: #ddffdd;
}

table.display tr.even.gradeA {
    background-color: #eeffee;
}

table.display tr.odd.gradeC {
    background-color: #ddddff;
}

table.display tr.even.gradeC {
    background-color: #eeeeff;
}

table.display tr.odd.gradeX {
    background-color: #ffdddd;
}

table.display tr.even.gradeX {
    background-color: #ffeeee;
}

table.display tr.odd.gradeU {
    background-color: #ddd;
}

table.display tr.even.gradeU {
    background-color: #eee;
}


tr.odd {
    background-color: #E2E4FF;
}

tr.even {
    background-color: white;
}





/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Misc
 */
.dataTables_scroll {
    clear: both;
}

.dataTables_scrollBody {
    -webkit-overflow-scrolling: touch;
}

.top, .bottom {
    padding: 15px;
    background-color: #F5F5F5;
    border: 1px solid #CCCCCC;
}

.top .dataTables_info {
    float: none;
}

.clear {
    clear: both;
}

.dataTables_empty {
    text-align: center;
}

tfoot input {
    margin: 0.5em 0;
    width: 100%;
    color: #444;
}

tfoot input.search_init {
    color: #999;
}

td.group {
    background-color: #d1cfd0;
    border-bottom: 2px solid #A19B9E;
    border-top: 2px solid #A19B9E;
}

td.details {
    background-color: #d1cfd0;
    border: 2px solid #A19B9E;
}


.example_alt_pagination div.dataTables_info {
    width: 40%;
}

.paging_full_numbers a.paginate_button,
    .paging_full_numbers a.paginate_active {
    border: 1px solid #aaa;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    padding: 2px 5px;
    margin: 0 3px;
    cursor: pointer;
    *cursor: hand;
    color: #333 !important;
}

.paging_full_numbers a.paginate_button {
    background-color: #ddd;
}

.paging_full_numbers a.paginate_button:hover {
    background-color: #ccc;
    text-decoration: none !important;
}

.paging_full_numbers a.paginate_active {
    background-color: #99B3FF;
}

table.display tr.even.row_selected td {
    background-color: #B0BED9;
}

table.display tr.odd.row_selected td {
    background-color: #9FAFD1;
}


/*
 * Sorting classes for columns
 */
/* For the standard odd/even */
tr.odd td.sorting_1 {
    background-color: #D3D6FF;
}

tr.odd td.sorting_2 {
    background-color: #DADCFF;
}

tr.odd td.sorting_3 {
    background-color: #E0E2FF;
}

tr.even td.sorting_1 {
    background-color: #EAEBFF;
}

tr.even td.sorting_2 {
    background-color: #F2F3FF;
}

tr.even td.sorting_3 {
    background-color: #F9F9FF;
}


/* For the Conditional-CSS grading rows */
/*
    Colour calculations (based off the main row colours)
  Level 1:
        dd > c4
        ee > d5
    Level 2:
      dd > d1
      ee > e2
 */
tr.odd.gradeA td.sorting_1 {
    background-color: #c4ffc4;
}

tr.odd.gradeA td.sorting_2 {
    background-color: #d1ffd1;
}

tr.odd.gradeA td.sorting_3 {
    background-color: #d1ffd1;
}

tr.even.gradeA td.sorting_1 {
    background-color: #d5ffd5;
}

tr.even.gradeA td.sorting_2 {
    background-color: #e2ffe2;
}

tr.even.gradeA td.sorting_3 {
    background-color: #e2ffe2;
}

tr.odd.gradeC td.sorting_1 {
    background-color: #c4c4ff;
}

tr.odd.gradeC td.sorting_2 {
    background-color: #d1d1ff;
}

tr.odd.gradeC td.sorting_3 {
    background-color: #d1d1ff;
}

tr.even.gradeC td.sorting_1 {
    background-color: #d5d5ff;
}

tr.even.gradeC td.sorting_2 {
    background-color: #e2e2ff;
}

tr.even.gradeC td.sorting_3 {
    background-color: #e2e2ff;
}

tr.odd.gradeX td.sorting_1 {
    background-color: #ffc4c4;
}

tr.odd.gradeX td.sorting_2 {
    background-color: #ffd1d1;
}

tr.odd.gradeX td.sorting_3 {
    background-color: #ffd1d1;
}

tr.even.gradeX td.sorting_1 {
    background-color: #ffd5d5;
}

tr.even.gradeX td.sorting_2 {
    background-color: #ffe2e2;
}

tr.even.gradeX td.sorting_3 {
    background-color: #ffe2e2;
}

tr.odd.gradeU td.sorting_1 {
    background-color: #c4c4c4;
}

tr.odd.gradeU td.sorting_2 {
    background-color: #d1d1d1;
}

tr.odd.gradeU td.sorting_3 {
    background-color: #d1d1d1;
}

tr.even.gradeU td.sorting_1 {
    background-color: #d5d5d5;
}

tr.even.gradeU td.sorting_2 {
    background-color: #e2e2e2;
}

tr.even.gradeU td.sorting_3 {
    background-color: #e2e2e2;
}


/*
 * Row highlighting example
 */
.ex_highlight #example tbody tr.even:hover, #example tbody tr.even td.highlighted {
    background-color: #ECFFB3;
}

.ex_highlight #example tbody tr.odd:hover, #example tbody tr.odd td.highlighted {
    background-color: #E6FF99;
}

.dataTables_info { padding-top: 0; }
            .dataTables_paginate { padding-top: 0; }
            .css_right { float: right; }



</style>

</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div id='navbar' class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="/">Helppain.net</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="/">Home</a></li>
              <li><a href="about">About</a></li>
              <li><a href="">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>


<div class='container'>
      <div> <?php echo $content; ?> </div>
 </div>
  <div id="btmfooter"> Copyright &copy; <?php echo date('Y') ; ?> All Rights Reserved</div>

 <!-- rMY_REVISION -->
  <div id='wait' class='wait'></div>
  <div id='info' class='info'></div>
 </body>
</html>