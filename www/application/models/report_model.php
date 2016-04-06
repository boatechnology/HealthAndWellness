<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {
    
    public function get_ytd_months_js_array() {
        
        $current_month = date('m');
        
        $str = "[ ";
        
        for ($i = 1; $i <= $current_month; $i++)
        {
                $date_obj = DateTime::createFromFormat('!m', $i);
                $str .= "'".$date_obj->format('F')."', ";
        }
        $str = rtrim($str,', ');
        $str .= "]";
        return $str;
    }
    
    public function get_monthly_totals($idusers=0) {
        $query = "call monthly_total(".$idusers.")";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    
    public function get_point_monthly_totals_js_array($idusers=0) {
        $result = $this->get_monthly_totals($idusers);
        
        $js_array = '[';
        foreach($result as $k => $v) {
            $js_array .= "[".($v['month']-1).",".$v['points']."],";
        }
        $js_array = rtrim($js_array,',');
        $js_array .= ']';
        return $js_array;
    }
    
    public function get_public_column_js_array(){
        $monthly_totals = $this->get_monthly_totals();
        
        $points = array();
        foreach($monthly_totals as $v) {
            if (!array_key_exists($v['hwnumber'], $points)) {
                $points[$v['hwnumber']] = array();
            }
            $points[$v['hwnumber']][] = $v['points'];
        }

        foreach($points as $k=>$v) {
            foreach($v as $k1=>$v2) {
                if (!array_key_exists($k1, $points))
                    $points[$k1] = array();
                $points[$k1][] = $v2;
            }
        }
        
        for($k = 0; $k <= 11; $k++) {
            if (array_key_exists($k, $points)) {
            $points[$k]['avg'] = (array_sum($points[$k])/count($points[$k]));
            $points[$k]['total'] = array_sum($points[$k]);
            }
        }
        
        foreach($points as $k=>$v) {
            if ($k > 12) {
                $points[$k]['avg'] = (array_sum($points[$k])/count($points[$k]));
                $points[$k]['total'] = array_sum($points[$k]);
                foreach($points[$k] as $k1=>$v1) {
                    if ($k1 < 12 ) {
                        $points[$k1][$k] = $v1;
                    }
                }
            }
        }
        
        ksort($points);
        $year_view = "[";
        $month = "[";
        for($i = 0; $i <= 11; $i++) {
            $year_view .=  "{ name: '".date('M', mktime(0, 0, 0, ($i+1), 10))."',";
            $year_view .= " y: ".round($points[$i]['avg']).",";
            $year_view .= " drilldown: '".date('m', mktime(0, 0, 0, ($i+1), 10))."'";
            $year_view .= "},";
            $month .= "{ id: '".date('m', mktime(0, 0, 0, ($i+1), 10))."',";
            $month .= " name: '".date('F', mktime(0, 0, 0, ($i+1), 10))." Points by HW#',";
            $month .= " data: [";
            if (array_key_exists($i, $points)) {
            ksort($points[$i]);
            foreach($points[$i] as $hw=>$p) {
                if ($hw > 1000) {
                    $month .= "['".$hw."', ".$p."],";
                }
            }
            }
            $month .= "]},";

        }
        $month .= "]";
        $year_view .= "]";
        
        
        foreach($points as $hw_num => $p) {
            
        }
                
        return array('year'=>$year_view, 'month'=>$month);
    }
}