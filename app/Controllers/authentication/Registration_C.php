<?php

namespace App\Controllers\Authentication;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Common_M;

use App\Models\Registration_M;

class Registration_C extends BaseController
{

    public function __construct(){
        $this->common_obj = new Common_M();
    }

    public function index()
    {
        $cond=array('row_status' => 1);
        $data['master_state'] = $this->common_obj->data_all('master_state',$cond);
       // echo "<pre>"; print_r($this->request->getVar()); die;
       if($this->request->getVar('submit')){
        $rules = [
            'full_name' => 'required',
            'username' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required|numeric|max_length[14]',
            'password' => 'required|max_length[10]',
            'user_address' =>'required',
            'user_pin' =>'required',
            'state' =>'required',
        ];
        if(!$this->validate($rules)){
            // $data['validation'] = $this->validator;
            return view('authentication/registration',["validation"=> $this->validator]);
            //return redirect()->back()->withInput();
            //echo "<pre>"; print_r( $this->validator->getErrors()); die;
        }else{
        $full_name = $this->request->getVar('full_name');
        $username = $this->request->getVar('username');
        $email = $this->request->getVar('email');
        $phone = $this->request->getVar('phone');
        $password = $this->request->getVar('password');
        $user_address = $this->request->getVar('user_address');
        $user_pin = $this->request->getVar('user_pin');
        $state = $this->request->getVar('state');
        $model = new Registration_M();
        $ins_data = [
            'full_name' => $full_name,
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'password' => md5($password),
            'user_address' => $user_address,
            'user_pin' => $user_pin,
            'state' =>$state,
        ];
        $insert = $model->register($ins_data);
        return redirect()->to('/login');
        }
        
        // print_r($ins_data);
        // die();
}      
    
        return view('authentication/registration', $data);
    }
    
}