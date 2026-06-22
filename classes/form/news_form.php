<?php
// This file is part of Moodle - http://moodle.org/

namespace local_floatingnews\form;

use local_floatingnews\manager;

/**
 * News edit form.
 *
 * @package    local_floatingnews
 * @copyright  2026 Julia Gabriela Gomes da Silva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class news_form extends \moodleform {
    /**
     * Form definition.
     *
     * @return void
     */
    public function definition(): void {
        $mform = $this->_form;
        $fileoptions = $this->_customdata['fileoptions'] ?? manager::IMAGE_OPTIONS;

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'title', get_string('title', 'local_floatingnews'), ['size' => 60]);
        $mform->setType('title', PARAM_TEXT);
        $mform->addRule('title', null, 'required', null, 'client');

        $mform->addElement('textarea', 'summary', get_string('summary', 'local_floatingnews'), [
            'rows' => 5,
            'cols' => 60,
        ]);
        $mform->setType('summary', PARAM_TEXT);

        $mform->addElement('filemanager', 'image_filemanager', get_string('image', 'local_floatingnews'), null, $fileoptions);

        $mform->addElement('text', 'linkurl', get_string('linkurl', 'local_floatingnews'), ['size' => 60]);
        $mform->setType('linkurl', PARAM_URL);

        $mform->addElement('text', 'buttontext', get_string('buttontext', 'local_floatingnews'), ['size' => 30]);
        $mform->setType('buttontext', PARAM_TEXT);
        $mform->setDefault('buttontext', get_string('readmore', 'local_floatingnews'));

        $mform->addElement('text', 'sortorder', get_string('sortorder', 'local_floatingnews'), ['size' => 5]);
        $mform->setType('sortorder', PARAM_INT);
        $mform->setDefault('sortorder', 1);
        $mform->addHelpButton('sortorder', 'sortorder', 'local_floatingnews');

        $mform->addElement('advcheckbox', 'enabled', get_string('enableditem', 'local_floatingnews'));
        $mform->setDefault('enabled', 1);

        $mform->addElement('date_time_selector', 'timestart', get_string('timestart', 'local_floatingnews'), ['optional' => true]);
        $mform->addElement('date_time_selector', 'timeend', get_string('timeend', 'local_floatingnews'), ['optional' => true]);

        $this->add_action_buttons(true);
    }

    /**
     * Validate form data.
     *
     * @param array $data Submitted data.
     * @param array $files Submitted files.
     * @return array
     */
    public function validation($data, $files): array {
        $errors = parent::validation($data, $files);
        if (isset($data['sortorder']) && (int)$data['sortorder'] < 1) {
            $errors['sortorder'] = get_string('invalidsortorder', 'local_floatingnews');
        }
        if (!empty($data['timestart']) && !empty($data['timeend']) && $data['timeend'] <= $data['timestart']) {
            $errors['timeend'] = get_string('invaliddate', 'local_floatingnews');
        }
        return $errors;
    }
}
