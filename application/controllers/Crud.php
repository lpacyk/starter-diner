<?php
class Crud extends Application {
	public function index()	{

		$role = $this->session->userdata('userrole');
                if ($role == 'user'){
                    $this->data['message'] = 'You are a user, go away';
                } else if ($role == 'admin'){
                    $this->data['message'] = 'You are an admin, please stay';
                    $this->data['bodymessage'] = 'WELCOME TO THE mainteannce PAGE. THIS PAGE SHOWS YOU
                                ALL OF THE CRAZY AMOUNT OF THINGS THAT HAVE NOT BEEN FIXED
                                HERE FOR THE PAST THREE YEARS. THERE IS MORE THAN THAT, BUT WE
                                GOT A BUFFER OVERFLOW FOR HAVING TOO MANY PROBLEMS TO FIX, SO 
                                WE JUST STOPPED RECORDING THEM. HAVE FUN!';
                   
                }
                 $this->render('template-maintenance'); 
		
	}
}