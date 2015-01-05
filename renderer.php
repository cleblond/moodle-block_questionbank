<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Renderer for block questionbank
 *
 * @package    block_questionbank
 * @copyright  2014 onward Carl LeBlond
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * questionbank block rendrer
 *
 * @package    block_questionbank
 * @copyright  2014 onward Carl LeBlond
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_questionbank_renderer extends plugin_renderer_base {

    /**
     * Renders HTML to display questionbank block
     *
     * @param stdClass $course
     * @param int $timestart
     * @param array $recentenrolments array of changes in enrolments
     * @param array $structuralchanges array of changes in course structure
     * @param array $modulesrecentactivity array of changes in modules (provided by modules)
     * @return string
     */
    public function questionbank($course, $questionbankchanges, $timestart) {
       global $CFG;

        $content = false;
        $output = '';

        // Now display question bank data 
        $output .= html_writer::tag('h5', 'Questions Available (' . $questionbankchanges[0] . ')' , array('class' => 'message'));
        $output .= html_writer::tag('h5', 'New Questions (' . $questionbankchanges[1] . ')' , array('class' => 'message'));
        $output .= html_writer::tag('h5', 'My Questions (' . $questionbankchanges[2] . ')' , array('class' => 'message'));


        $output .= html_writer::tag('div',
                "as of " . userdate($timestart),
                array('class' => 'activityhead'));

        $output .= html_writer::tag('p', '<a href="'.$CFG->wwwroot.'/question/edit.php?courseid='.$course->id.'">Question Bank</a>' , array('class' => 'message'));

http://localhost/moodle27/question/edit.php?courseid=2
        return $output;
    }
}
