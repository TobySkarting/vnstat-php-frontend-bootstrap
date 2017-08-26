<?php
    //
    // vnStat PHP frontend (c)2006-2010 Bjorge Dijkstra (bjd@jooz.net)
    //
    // This program is free software; you can redistribute it and/or modify
    // it under the terms of the GNU General Public License as published by
    // the Free Software Foundation; either version 2 of the License, or
    // (at your option) any later version.
    //
    // This program is distributed in the hope that it will be useful,
    // but WITHOUT ANY WARRANTY; without even the implied warranty of
    // MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    // GNU General Public License for more details.
    //
    // You should have received a copy of the GNU General Public License
    // along with this program; if not, write to the Free Software
    // Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
    //
    //
    // see file COPYING or at http://www.gnu.org/licenses/gpl.html
    // for more information.
    //
    
    
    // This code was written with love.
    // There are/were _NO_ malicious intents in making this.
    // If I am disrespecting any licensing please let me know,
    // but I've tried my best as a new programmer to follow them.
	// ~GotKrypto
	
	
    require_once 'config.php';
    require_once 'localize.php';
    require_once 'vnstat.php';
	require_once 'functions.php';
	
	
    validate_input();

    switch($page) {
		case 's':
			$pageType = 'summary';
			break;

		case 'h':
			$pageType = 'hours';
			break;

		case 'd':
			$pageType = 'days';
			break;

		case 'm':
			$pageType = 'months';
			break;

		default:
			//Unknown page type, just do summary.
			$pageType = 'summary';
	}
	
	get_vnstat_data();
	
    //
    // html start
    //
    header('Content-type: text/html; charset=utf-8');
    print '<?xml version="1.0"?>';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php print T('Server Bandwidth Information'); ?></title>

    <meta name="description" content="<?php print T('Meta Description'); ?>">

    <link href="css/<?php echo DEFAULT_THEME; ?>.bootstrap.min.css" rel="stylesheet">
    <link href="css/hack.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/live.js"></script>
    </head>
    <body>
        <div class="container">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only"><?php print T('Toggle navigation'); ?></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php print BRAND_LOCATION; ?>"><?php print T('Server Bandwidth'); ?></a>
              </div>
              <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                  <?php create_drop_downs(); ?>
                </ul>
              </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
          </nav>
          <br/>
          <br/>
        <div class="row">
            <div class="col-xs-12">
                <div class="page-header">
                    <h1>
                        <?php print (isset($iface_title[$iface]) ? $iface_title[$iface] : '') .' ('.$iface.')' . ' <small>'. T('Traffic data') .' | '.ucfirst(T($pageType)); ?>
                    </h1>
                </div>
                <div class="col-xs-3">
                    <div id="live">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h4>Live Traffic</h4></div>
                            <div class="panel-body">
                            <?php
                                if (LIVE_DATA) {
                                    echo '<div id="download">Download: FETCHING',
                                         '</div>',
                                         '<div id="upload">Upload: FETCHING',
                                         '</div>',
                                         '<script type="text/javascript">',
                                         '$(document).ready(startPolling("' . $iface . '", '. LIVE_DATA_INTERVAL .'));',
                                         '</script>'
                                    ;

                                } else {
                                    print "Live data deactivated";
                                }
                            ?>
                            </div>

                        </div>
                    </div>
                    <div id="services">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4>Services</h4>
                            </div>
                            <div class="panel-body">
                                <?php require_once 'services.php'; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-9">
                    <?php
                    $graph_params = "if=$iface&page=$page";
                    if ($page != 's') {
                        print '
                        <div id="graph">
                        <center>
                            <div class="panel panel-default">
                              <div class="panel-heading">Traffic Graph</div>
                              <div class="panel-body">';
                        if ($graph_format == 'svg') {
                            print "
                            <div class='svg-container'>
                                <object class='svg-content' type=\"image/svg+xml\"  data=\"graph_svg.php?$graph_params\"></object>
                            </div>";
                        } else {
                            print "<img class='img-responsive' src=\"graph.php?$graph_params\" alt=\"graph\"/>";
                        }
                        print '
                                    </div>
                                </div>
                            </center>
                        </div>';
                    }
                        switch($page) {
                            case 's':
                                write_summary();
                                break;

                            case 'h':
                                write_data_table(T('Last 24 hours'), $hour);
                                break;

                            case 'd':
                                write_data_table(T('Last 30 days'), $day);
                                break;

                            case 'm':
                                write_data_table(T('Last 12 months'), $month);
                                break;

                            default:
                                //Unknown page type, just show summary.
                                write_summary();
                        }

                    if(SHOW_FOOTER) {
                        print '
                        <br/>
                        <div id="footer">
                            <center>
                                <p><a href="http://www.sqweek.com/">vnStat PHP frontend</a> 1.5.2 - ©2006-2011 <a href="https://github.com/bjd">Bjorge Dijkstra</a> (bjd _at_ jooz.net)</p>
                                <p><a href="https://github.com/gotkrypto76/vnstat-php-frontend-bootstrap.git">Bootstrap version</a> of <a href="http://www.sqweek.com/">vnStat PHP frontend</a> 1.5.2 by <a href="https://github.com/gotkrypto76">GotKrypto76</a></p>
                            </center>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>