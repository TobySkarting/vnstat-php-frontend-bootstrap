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
    error_reporting(E_ALL | E_NOTICE);

    //
    // configuration parameters
    //
    // edit these to reflect your particular situation
    //
    $locale = 'en_US.UTF-8';
    $language = 'en';

    // Set local timezone
    date_default_timezone_set("Europe/Copenhagen");

    // list of network interfaces monitored by vnStat
    $iface_list = array('eno1');

    //
    // optional names for interfaces
    // if there's no name set for an interface then the interface identifier
    // will be displayed instead
    //
    $iface_title['eno1'] = 'WAN';

    // Show live data -- set to false if you don't want live network data
    DEFINE('LIVE_DATA', true);
    DEFINE('LIVE_DATA_INTERVAL', 3000);

    // Services
    $service_list = array('deluged', 'deluge-web');

    //
    // There are two possible sources for vnstat data. If the $vnstat_bin
    // variable is set then vnstat is called directly from the PHP script
    // to get the interface data.
    //
    // The other option is to periodically dump the vnstat interface data to
    // a file (e.g. by a cronjob). In that case the $vnstat_bin variable
    // must be cleared and set $data_dir to the location where the dumps
    // are stored. Dumps must be named 'vnstat_dump_$iface'.
    //
    // You can generate vnstat dumps with the command:
    //   vnstat --dumpdb -i $iface > /path/to/data_dir/vnstat_dump_$iface
    //
    $vnstat_bin = '/usr/bin/vnstat';
    $data_dir = './dumps';

    // graphics format to use: svg or png
    // Note: png has best results for bootstrap
    $graph_format='png'; 

    // Font to use for PNG graphs
    define('GRAPH_FONT',dirname(__FILE__).'/fonts/Verdana.ttf');

    // Font to use for SVG graphs
    define('SVG_FONT', 'Verdana');

	// Location of navbar brand href
    define('BRAND_LOCATION', '/vnstat');
    
    // Default bootstrap theme
    // Themes are located in /css
    // Themes are named "*.bootstrap.min.css"
    define('DEFAULT_THEME', 'darkly');
    
    // Shows or hides footer on site
    define('SHOW_FOOTER', 0);
    
    // SVG Depth scaling factor
    define('SVG_DEPTH_SCALING', 1);
    
    // Show errors
    ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);


	/* * * * Config Preprocessing * * * */
	// Don't touch this stuff.
	
	// Make sure style exists.
	if(!file_exists(dirname(__FILE__).'/css/'.DEFAULT_THEME.'.bootstrap.min.css')) { die("The theme '".DEFAULT_THEME."' does not exist."); }
	// Make sure graph font exists.
	if(!file_exists(GRAPH_FONT)) { die("The font '".basename(GRAPH_FONT)."' does not exist."); }
	/* * * * End Preprocessing * * * */
?>
