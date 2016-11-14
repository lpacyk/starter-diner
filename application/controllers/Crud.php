<?php

class Crud extends Application {

    function __construct() {
        parent::__construct();
        $this->load->helper('formfields');
        $this->error_messages = array();
    }

    function show_any_errors() {
        $result = '';
        if (empty($this->error_messages)) {
            $this->data['error_messages'] = '';
            return;
        }
        // add the error messages to a single string with breaks
        foreach ($this->error_messages as $onemessage)
            $result .= $onemessage . '<br/>';
        // and wrap these per our view fragment
        $this->data['error_messages'] = $this->parser->parse('mtce-errors', ['error_messages' => $result], true);
    }

    public function index() {
        $role = $this->session->userdata('userrole');

        $message = 'You are an admin, please stay!';

        if ($role != 'admin') {
            $message = 'You are a normal user. Please leave this page and go back to the main page.';
            $this->data['content'] = $message;
            $this->render();
            return;
        }

        $this->data['pagebody'] = 'mtce';
        $this->data['items'] = $this->menu->all();

        $this->render();
    }

    public function edit($id = null) {
        //Debugging Note
        //As you work through the tutorial, a common problem is the retention of a previous data transfer object in the session. The symptom: when you click on X in the menu item list, you get the edit page for the previously selected menu item.
        //To fix this, click "Cancel" on the edit page. That will clear the DTO stored in the session, and the "correct" menu item should then show up on the edit page when selected from the list.
        // try the session first
        $key = $this->session->userdata('key');
        $record = $this->session->userdata('record');
        // if not there, get them from the database
        if (empty($record)) {
            $record = $this->menu->get($id);
            $key = $id;
            $this->session->set_userdata('key', $id);
            $this->session->set_userdata('record', $record);
        }
        
        $this->data['action'] = (empty($key)) ? 'Adding' : 'Editing';
        
        // build the form fields
        $this->data['fid'] = makeTextField('Menu code', 'id', $record->id);
        $this->data['fname'] = makeTextField('Item name', 'name', $record->name);
        $this->data['fdescription'] = makeTextArea('Description', 'description', $record->description);
        $this->data['fprice'] = makeTextField('Price, each', 'price', $record->price);
        $this->data['fpicture'] = makeTextField('Item image', 'picture', $record->picture);
        
        $cats = $this->categories->all(); // get an array of category objects
        
        foreach ($cats as $code => $category)
        {// make it into an associative array
            $codes[$category->id] = $category->name;
        }
        
        $this->data['fcategory'] = makeCombobox('Category', 'category', $record->category, $codes);
        $this->data['zsubmit'] = makeSubmitButton('Save', 'Submit changes');
        
        // show the editing form
        $this->data['pagebody'] = "mtce-edit";
        $this->show_any_errors();
        $this->render();
    }

    public function save() {
        // try the session first
        $key = $this->session->userdata('key');
        $record = $this->session->userdata('record');

        // if not there, nothing is in progress
        if (empty($record)) {
            $this->index();
            return;
        }


        // update our data transfer object
        $incoming = $this->input->post();
        foreach (get_object_vars($record) as $index => $value)
            if (isset($incoming[$index]))
                $record->$index = $incoming[$index];

        $newguy = $_FILES['replacement'];
        if (!empty($newguy['name'])) {
            $record->picture = $this->replace_picture();
            if ($record->picture != null)
                $_POST['picture'] = $record->picture; // override picture name
        }
        $this->session->set_userdata('record', $record);



        // validate
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->menu->rules());
        if ($this->form_validation->run() != TRUE)
            $this->error_messages = $this->form_validation->error_array();

// check menu code for additions
        if ($key == null)
            if ($this->menu->exists($record->id))
                $this->error_messages[] = 'Duplicate key adding new menu item';
        if (!$this->categories->exists($record->category))
            $this->error_messages[] = 'Invalid category code: ' . $record->category;

        // save or not
        if (!empty($this->error_messages)) {
            $this->edit();
            return;
        }

        // update our table, finally!
        if ($key == null)
            $this->menu->add($record);
        else
            $this->menu->update($record);
        // and redisplay the list
        $this->index();
    }

    public function cancel() {
        $this->session->unset_userdata('key');
        $this->session->unset_userdata('record');
        $this->index();
    }

    // handle uploaded image, and use its name as the picture name
    function replace_picture() {
        $config = [
            'upload_path' => './images', // relative to front controller
            'allowed_types' => 'gif|jpg|jpeg|png',
            'max_size' => 100, // 100KB should be enough for our graphical menu
            'max_width' => 256,
            'max_height' => 256, // actually, we want exactly 256x256
            'min_width' => 256,
            'min_height' => 256, // fixed it
            'remove_spaces' => TRUE, // eliminate any spaces in the name
            'overwrite' => TRUE, // overwrite existing image
        ];
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('replacement')) {
            $this->error_messages[] = $this->upload->display_errors();
            return NULL;
        } else
            return $this->upload->data('file_name');
    }

    function delete() {
        $key = $this->session->userdata('key');
        $record = $this->session->userdata('record');

        // only delete if editing an existing record
        if (!empty($record)) {
            $this->menu->delete($key);
        }
        $this->index();
    }

    function add() {
        $key = NULL;
        $record = $this->menu->create();

        $this->session->set_userdata('key', $key);
        $this->session->set_userdata('record', $record);    
        $this->edit();
    }

}
