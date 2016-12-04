<?php
	function create_drop_downs() {
        global $iface, $page, $graph, $script;
        global $iface_list, $iface_title;
        global $page_list, $page_title;

        $p = "&graph=$graph";

        foreach($iface_list as $if) {
        	if ($iface == $if) {
                $dropIsActive = " active";
            } else {
                $dropIsActive = "";
            }
            
        	print '
        	<li class="dropdown'.$dropIsActive.'">
        	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$if.' <span class="caret"></span></a>
		      <ul class="dropdown-menu">';
		    
		    foreach ($page_list as $pg) {
		    	if(strtolower($page_title[$pg][0]) == $page && $iface == $if) {
		    		$pageIsSelected = "active";
		    	} else {
		    		$pageIsSelected = "";
		    	}
                print '<li class="'.$pageIsSelected.'"><a href="'.$script.'?if='.$if.$p.'&page='.$pg.'">'.ucfirst($page_title[$pg]).'</a></li>';
            }
		    
		    print '
		      </ul>
		    </li>
        	';
        	
        }
    }


    function kbytes_to_string($kb) {

        global $byte_notation;

        $units = array('TB','GB','MB','KB');
        $scale = 1024*1024*1024;
        $ui = 0;

        $custom_size = isset($byte_notation) && in_array($byte_notation, $units);

        while ((($kb < $scale) && ($scale > 1)) || $custom_size)
        {
            $ui++;
            $scale = $scale / 1024;

            if ($custom_size && $units[$ui] == $byte_notation) {
                break;
            }
        }

        return sprintf("%0.2f %s", ($kb/$scale),$units[$ui]);
    }

    function write_summary() {
        global $summary,$top,$day,$hour,$month;

        $trx = $summary['totalrx']*1024+$summary['totalrxk'];
        $ttx = $summary['totaltx']*1024+$summary['totaltxk'];

        //
        // build array for write_data_table
        //

        $sum = array();

        if (count($day) > 0 && count($hour) > 0 && count($month) > 0) {
            $sum[0]['act'] = 1;
            $sum[0]['label'] = T('This hour');
            $sum[0]['rx'] = $hour[0]['rx'];
            $sum[0]['tx'] = $hour[0]['tx'];

            $sum[1]['act'] = 1;
            $sum[1]['label'] = T('This day');
            $sum[1]['rx'] = $day[0]['rx'];
            $sum[1]['tx'] = $day[0]['tx'];

            $sum[2]['act'] = 1;
            $sum[2]['label'] = T('This month');
            $sum[2]['rx'] = $month[0]['rx'];
            $sum[2]['tx'] = $month[0]['tx'];

            $sum[3]['act'] = 1;
            $sum[3]['label'] = T('All time');
            $sum[3]['rx'] = $trx;
            $sum[3]['tx'] = $ttx;
        }

        write_data_table(T('Summary'), $sum);
        print '<br/>';
        write_data_table(T('Top 10 days'), $top);
    }
    
    function write_data_table($caption, $tab) {
		print '
		<div class="panel panel-default">
		  <div class="panel-heading"><h4>'.$caption.'</h4></div>
		  <div class="panel-body">
			  <table class="table table-striped">
				<thead>
					<tr>
						<th style="width:120px;">
							&nbsp;
						</th>
						<th>
							'.T('In').'
						</th>
						<th>
							'.T('Out').'
						</th>
						<th>
							'.T('Total').'
						</th>
					</tr>
				</thead>
				<tbody>';
				
        for ($i=0; $i<count($tab); $i++)
        {
            if ($tab[$i]['act'] == 1)
            {
                $t = $tab[$i]['label'];
                $rx = kbytes_to_string($tab[$i]['rx']);
                $tx = kbytes_to_string($tab[$i]['tx']);
                $total = kbytes_to_string($tab[$i]['rx']+$tab[$i]['tx']);
                $id = ($i & 1) ? 'odd' : 'even';
                print "<tr>";
                print "<td class=\"label_$id\">$t</td>";
                print "<td class=\"numeric_$id\">$rx</td>";
                print "<td class=\"numeric_$id\">$tx</td>";
                print "<td class=\"numeric_$id\">$total</td>";
                print "</tr>";
             }
        }
        print '
              </tbody>
			</table>
		  </div>
		</div>';
    }