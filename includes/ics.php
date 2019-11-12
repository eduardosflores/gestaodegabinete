<?php
class ICS {
    var $data = "";
    var $name;
    var $start = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\n";
    var $end = "END:VCALENDAR\n";
    
    public function __construct($name) {
        $this->name = $name;
    }
    
    public function add($id, $start, $end, $name, $description) {
        
        $description = str_replace("\r\n", " / ", $description);
        
        $this->data .= "BEGIN:VEVENT\n"
                    . "DTSTART:".date("Ymd\THis", strtotime($start))."\n"
                    . "DTEND:".date("Ymd\THis", strtotime($end))."\n"
                    //. "LOCATION:".'Câmara Municipal de .....'."\n"
                    . "TRANSP: OPAQUE\n"
                    . "SEQUENCE:0\n"
                    . "UID:". md5($id)."\n"
                    . "DTSTAMP:".date("Ymd\TGis")."\n"
                    . "SUMMARY:".$name."\n"
                    . "DESCRIPTION:".$description."\n"
                    . "PRIORITY:1\n"
                    . "CLASS:PUBLIC\n"
                    . "BEGIN:VALARM\n"
                    . "TRIGGER:-PT15M\n"
                    . "ACTION:DISPLAY\n"
                    . "DESCRIPTION:Reminder\n"
                    . "END:VALARM\n"
                    . "END:VEVENT\n";
    }
    
    function save() {
        file_put_contents($this->name.".ics", $this->getData());
    }
    
    public function show() {
        header("Content-type:text/calendar");
        header('Content-Disposition: attachment; filename="'.$this->name.'.ics"');
        header('Content-Length: '.strlen($this->getData()));
        header('Connection: close');
        echo $this->getData();
    }
    
    public function getData() {
        return $this->start . $this->data . $this->end;
    }
}