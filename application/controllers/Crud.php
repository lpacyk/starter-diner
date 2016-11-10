<?php
class Crud extends Application {

    function __construct() {
            parent::__construct();
            $this->load->helper('formfields');
    }

    public function index()	
    {
        $role = $this->session->userdata('userrole');

        $message = 'You are an admin, please stay!';

        if ($role != 'admin'){
            $message = 'You are a normal user. Please leave this page and go back to the main page.';
            $this->data['content'] = $message;
            $this->render();
            return;
        }

        $this->data['pagebody'] ='mtce';
        $this->data['items'] = $this->menu->all();

        $this->render(); 
    }

    public function edit($id = null)
    {
        $this->session->unset_userdata('key');
        $this->session->unset_userdata('record');
        
        // try the session first
        $key = $this->session->userdata('key');
        $record = $this->session->userdata('record');
        
        // if not there, get them from the database
        if (empty($key)) {
            $record = $this->menu->get($id);
            $key = $id;
            $this->session->set_userdata('key',$id);
            $this->session->set_userdata('record',$record);
        }
        
        // build the form fields
        $this->data['fid'] = makeTextField('Menu code', 'id', $record->id);
        $this->data['fname'] = makeTextField('Item name', 'name', $record->name);
        $this->data['fdescription'] = makeTextArea('Description', 'description', $record->description);
        $this->data['fprice'] = makeTextField('Price, each', 'price', $record->price);
        $this->data['fpicture'] = makeTextField('Item image', 'picture', $record->picture);
        
        $this->categories->all(); // get an array of category objects
        foreach($cats as $code => $category) // make it into an associative array
            $codes[$code] = $category->name;        
        $this->data['fcategory'] = makeCombobox('Category', 'category', $record->category, $codes);
        
        $this->data['zsubmit'] = makeSubmitButton('Save', 'Submit changes');
        
        // show the editing form
        $this->data['pagebody'] = "mtce-edit";
        $this->render();
    }
    
    public function save(){
        
    }
    
    public function cancel(){
        $this->session->unset_userdata('key');
    $this->session->unset_userdata('record');
    $this->index();
    }
}