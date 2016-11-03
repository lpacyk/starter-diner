<?php
class Crud extends Application {
    
	function __construct() {
		parent::__construct();
	}
    
	public function index()	{
                
		$role = $this->session->userdata('userrole');
		$this->data['content'] = '';
                
                if ($role == 'admin'){
                    $this->data['message'] = 'You are an admin, please stay!';
                    $this->data['bodymessage'] = 'WELCOME TO THE mainteannce PAGE. THIS PAGE SHOWS YOU
                                    ALL OF THE CRAZY AMOUNT OF THINGS THAT HAVE NOT BEEN FIXED
                                    HERE FOR THE PAST THREE YEARS. THERE IS MORE THAN THAT, BUT WE
                                    GOT A BUFFER OVERFLOW FOR HAVING TOO MANY PROBLEMS TO FIX, SO 
                                    WE JUST STOPPED RECORDING THEM. HAVE FUN!';
                } else {
                    $this->data['message'] = 'You are a normal user. Please leave this page and go back to the main page.';
                    $this->data['bodymessage'] = 'Yeah.... please leave. I mean, this is an admin-only page so having you here is a bit akward...';
                }
                 $this->render('template-maintenance'); 
	}
}