<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Editable {
    
    public function __construct() {
        
    }
    
    public function generate($name, $value, $type, $title='', $table, $pk='',$class='',$source='',$manager=true) {
        if ($manager) {
            $suffix = "<span style='font-size: .7em;' class='yellow glyphicon glyphicon-pencil'> </span>";
            $disabled = "";
        }else{
            $suffix = "";
            $disabled = "data-disabled='true'";
        }
        $url = site_url('ajax/'.$table);
        $editable = "<a class='editable $class' $disabled data-title='$title' data-type='$type' data-value=\"".htmlspecialchars($value)."\" data-url='$url' data-pk='$pk' data-source='$source' data-name='$name'> </a>";
        $editable .= $suffix;
        
        return $editable;
    }
}