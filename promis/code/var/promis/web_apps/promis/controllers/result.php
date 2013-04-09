<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('PCHART',APPPATH."/libraries/pChart2.1.3");

include(PCHART . '/class/pData.class.php');
include(PCHART . '/class/pDraw.class.php');
include(PCHART . '/class/pImage.class.php');

class result extends MY_Controller {

    public function __construct()
    {
      parent::__construct();
      self::set_template('blank');
      $this->load->model('survey_model');

      $this->w = 800;
      $this->h = 500;
    }

    public function index()
    {
          /* Create and populate the pData object */
          $points = array();
          $instrument = array();
          $instrument[] = array('x'=>'jan', 'y'=>33, 'stdErr' => rand(1,4));
          $instrument[] = array('x'=>'feb', 'y'=>42, 'stdErr' => rand(1,4));
          $instrument[] = array('x'=>'mar', 'y'=>55, 'stdErr' => rand(1,4));
          $instrument[] = array('x'=>'apr', 'y'=>58, 'stdErr' => rand(1,4));
          $instrument[] = array('x'=>'may', 'y'=>65, 'stdErr' => rand(1,4));
          $instrument[] = array('x'=>'jun', 'y'=>75, 'stdErr' => rand(1,4));

          $points['Pain Index'] = $instrument;

          $instrument = array();
          $instrument[] = array('x'=>'jan', 'y'=>53, 'stdErr' => rand(1,4));
          $instrument[] = array('x'=>'feb', 'y'=>32, 'stdErr' => rand(1,4));
          $instrument[] = array('x'=>'mar', 'y'=>35, 'stdErr' => rand(1,4));
          $instrument[] = array('x'=>'apr', 'y'=>48, 'stdErr' => rand(1,4));
          $instrument[] = array('x'=>'may', 'y'=>65, 'stdErr' => rand(1,4));
          $instrument[] = array('x'=>'jun', 'y'=>55, 'stdErr' => rand(1,4));

          $points['Mobility'] = $instrument;


          $MyData = new pData();

          $series = array();

          foreach($points as $k=>$inst)
          {
               $inst_y = array();
               $inst_x = array();

               $inst_bt = array();
               $inst_bb = array();

               foreach($inst as $ki=>$vi)
               {
                   $inst_y[] = $vi['y'];
                   $inst_x[] = $vi['x'];
                   $inst_bt[] = $vi['y'] + $vi['y'] * $vi['stdErr'] * 0.01 ;
                   $inst_bb[] = $vi['y'] - $vi['y'] * $vi['stdErr'] * 0.01 ;
               }

               $series[$k]['y'] = $inst_y;
               $series[$k]['x'] = $inst_x;
               $series[$k]['bt'] = $inst_bt;
               $series[$k]['bb'] = $inst_bb;

          }

          $MyData->setAxisName(0,"Score");

          foreach($series as $k => $val)
          {
              $MyData->addPoints($val['y'],$k);
              $MyData->addPoints($val['bt'],"$k bt");
              $MyData->addPoints($val['bb'],"$k bb");

              $labels = $val['x'];
          }
          $MyData->addPoints($labels,"X");

          $MyData->setSerieDescription("X","Months");
          $MyData->setAbscissa("X");

          /* Create the pChart object */
          $myPicture = new pImage($this->w,$this->h, $MyData);

          /* Draw the background */
          $Settings = array("R"=>223,"G"=>223,"B"=>223,"Dash"=>TRUE,"DashR"=>223,"DashG"=>223,"DashB"=>223,"BorderR"=>223, "BorderG"=>223,"BorderB"=>223);
          $myPicture->drawFilledRectangle(0,0,$this->w,$this->h,$Settings);

          /* Draw the scale and do some cosmetics */
          $myPicture->setGraphArea(60,40,$this->w-80,$this->h-120);
          /* Overlay with a gradient */
          $Settings = array("StartR"=>0, "StartG"=>0, "StartB"=>0, "EndR"=>255, "EndG"=>255, "EndB"=>255, "Alpha"=>50);
          $myPicture->drawGradientArea(0,0,$this->w,$this->h,DIRECTION_VERTICAL,$Settings);

          $myPicture->drawFilledRectangle(60,40,$this->w-30,$this->h-120,array("R"=>200,"G"=>200,"B"=>200));

          /* Write the chart title */
          $myPicture->setFontProperties(array("FontName"=>PCHART . "/fonts/verdana.ttf","FontSize"=>11));
          $myPicture->drawText(400,10,"PROMIS Outcomes by Helppain.net",array("R"=>0,"G"=>0,"B"=>0, "FontSize"=>18,"Align"=>TEXT_ALIGN_TOPMIDDLE));


          $AxisBoundaries = array(0=>array("Min"=>10,"Max"=>90), 1=>array("Min"=>-4,"Max"=>4));

          $ScaleSettings  = array("XMargin"=>10,
              "YMargin"=>11,
              "Floating"=>TRUE,
              "Mode"=>SCALE_MODE_MANUAL,
              "ManualScale"=>$AxisBoundaries,
              "DrawSubTicks"=>FALSE,
              "DrawArrows"=>FALSE
              );

          //set right scale
          $MyData->addPoints(array(VOID),"mean");
          $MyData->setSerieOnAxis("mean",1);
          $MyData->setAxisPosition(1,AXIS_POSITION_RIGHT);
          $MyData->setAxisDisplay(1,AXIS_FORMAT_CUSTOM,'YAxisFormat');
          $MyData->setSerieDrawable('mean', FALSE);

          function YAxisFormat($val)
          {
              if(0 == $val)
             {
                 $val = 'mean';
             }
             else
             {
                 $val .= 'SD';
             }
              return $val;
          }

          $myPicture->drawScale($ScaleSettings);

          /* Draw one static threshold area */

          $myPicture->drawThreshold(50,array("Alpha"=>70,"Ticks"=>0,"R"=>255,"G"=>0,"B"=>0, 'WriteCaption'=>FALSE));

          $myPicture->drawThresholdArea(10,20,array("R"=>194,"G"=>0,"B"=>54,"Alpha"=>40));
          $myPicture->drawThresholdArea(30,40,array("R"=>194,"G"=>0,"B"=>54,"Alpha"=>20));
          $myPicture->drawThresholdArea(50,60,array("R"=>0,"G"=>194,"B"=>54,"Alpha"=>10));
          $myPicture->drawThresholdArea(70,80,array("R"=>0,"G"=>194,"B"=>54,"Alpha"=>30));

          foreach($series as $k=>$v)
          {
              $myPicture->drawZoneChart("$k bt","$k bb",array("LineAlpha"=>100,"AreaR"=>230,"AreaG"=>230,"AreaB"=>230,"AreaAlpha"=>20,"LineTicks"=>3));
              $MyData->setSerieDrawable(array("$k bt","$k bb"),FALSE);
          }


          $myPicture->setShadow(TRUE);

          $myPicture->drawSplineChart();

          $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80));

          $myPicture->drawLegend(60,$this->h-60,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

          $myPicture->drawText(400,200,"HELP",array("R"=>255,"G"=>0,"B"=>0, "FontSize"=>100, "Alpha"=>10,"Align"=>TEXT_ALIGN_TOPMIDDLE));


          /* Render the picture (choose the best way) */
          $myPicture->autoOutput(WEBROOTPATH.  "/assets/tmp/example.drawThresholdArea.png");

    }
}