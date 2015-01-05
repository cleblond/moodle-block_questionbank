<?php
class block_questionbank extends block_base {
    public function init() {
        $this->title = get_string('questionbank', 'block_questionbank');
    }



public function get_content() {
    global $DB;
    if ($this->content !== null) {
      return $this->content;
    }
 
    $count = $DB->count_records('question');
    //echo $count;

    $this->content         =  new stdClass;
    $output = "<strong>$count question available!</strong>";

    $this->content->text   = $output;
    $this->content->footer = 'Footer here...';
 




    return $this->content;
  }
}   // Here's the closing bracket for the class definition
