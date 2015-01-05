<?php




class block_questionbank extends block_base {


    protected $timestart = null;
    public function init() {
        $this->title = get_string('questionbank', 'block_questionbank');
    }



    public function get_content() {
    global $DB;
    if ($this->content !== null) {
      return $this->content;
    }
 
   
    //echo $count;

    //$this->content         =  new stdClass;
    //$output = "<strong>$count question available!</strong>";
    //$output .= '<a href="http://localhost/moodle27/question/edit.php?courseid=1">Question Bank</a>';

    //$this->content->text   = $output;
    //$this->content->footer = 'Footer here...';
 
 $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        $renderer = $this->page->get_renderer('block_questionbank');
        $this->content->text = $renderer->questionbank($this->page->course, $this->get_question_bank_activity(), $this->get_timestart());

        return $this->content;







    return $this->content;
  }


    /**
     * Returns the time since when we want to show recent activity
     *
     * For guest users it is 2 days, for registered users it is the time of last access to the course
     *
     * @return int
     */
    protected function get_timestart() {
        global $USER;
        if ($this->timestart === null) {
            $this->timestart = round(time() - COURSE_MAX_RECENT_PERIOD, -2); // better db caching for guests - 100 seconds

            if (!isguestuser()) {
                if (!empty($USER->lastcourseaccess[$this->page->course->id])) {
                    if ($USER->lastcourseaccess[$this->page->course->id] > $this->timestart) {
                        $this->timestart = $USER->lastcourseaccess[$this->page->course->id];
                    }
                }
            }
        }
        return $this->timestart;
    }


    /**
     * Returns list of recent activity within modules
     *
     * For each used module type executes callback MODULE_print_recent_activity()
     *
     * @return array array of pairs moduletype => content
     */
    protected function get_question_bank_activity() {
    global $DB, $USER;
   
        //$timestart = $this->get_timestart();
        $context = context_course::instance($this->page->course->id);
        //print_object($context);

        $totalnumquestions = $DB->count_records('question');
        //echo "<br>total=".$totalnumquestions;

       //get question categories from contextid
        $categories = $DB->get_records_sql('SELECT id FROM {question_categories} WHERE contextid = ?', array($context->id));
        //print_object($categories);
        //print_object(array_keys($categories));

        $viewfullnames = has_capability('moodle/site:viewfullnames', $context);
        //get all new questions in course
        //$questions = $DB->get_records_sql('SELECT * FROM {question} WHERE category = ?', array_keys($categories));
        $questions = $DB->get_records_sql("SELECT * FROM {question} WHERE timecreated > ".$this->get_timestart()." AND category = ?", array_keys($categories));
        //print_object($questions);
        $select = "timecreated > ".$this->get_timestart()." AND category = ?";
        $newestquestions = $DB->count_records_select('question', $select, array_keys($categories), $countitem="COUNT('x')");
        //echo "newest=".$newestquestions;

        //echo $this->get_timestart();
        //echo "<br>".time();
        //$cat = $DB->get_records('question_categories');
        //print_object($cat);

        //all questions by user
        $select = "createdby = ?";
        $usersquestions = $DB->count_records_select('question', $select, array($USER->id));
        //$result = $DB->get_records_sql('SELECT * FROM {question} WHERE createdby = ?', array($USER->id));
        //print_object($result);

        //echo "<br>user=".$usersquestions;
        $summary = array($totalnumquestions, $newestquestions, $usersquestions);


        return $summary;
    }




}   // Here's the closing bracket for the class definition
