<?php

namespace App\Controllers\Authentication;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Common_M;
use App\Models\Authentication_M;

class AuthenticationController extends BaseController
{
    public function __construct(){

        $session = session();
        if($session->logged_in == true and !empty($session->get('id'))) {
            $this->session_exists = 1;
        }else{
            $this->session_exists = 0;
        }
        
        helper(['url', 'form']);
        $this->common = new Common_M();
        // $this->authentication = new Authentication_M();
        
    }
    
    public function login(){
        // REDIRECT IF ALRADY LOGGED IN
        if($this->session_exists){
            return redirect()->to(base_url('portal/dashboard'));
        }

        $data['page_title'] = "Login || ";
        $data['meta_tag'] = '<meta content="Baazar Kolkata, Sketch Me Global" name="keywords"><meta content="Baazar Kolkata, Sketch Me Global" name="description">';
        // return view('authentication/signin', $data);
        return view('authentication/login', $data);
    }
    
    public function login_form(){
        // if form is submitted
        $final_flag = array();
        if($this->request->getPost()){
            $agent = $this->request->getUserAgent();
            $data=array(
                "ip"=>$this->request->getIPAddress(),
                "browser"=>$agent->getBrowser(),
                "version"=>$agent->getVersion(),
                "platform"=>$agent->getPlatform(),
                "username"=>$this->request->getPost('username'),
            );

            $session = session();
            $login_rule = [
                'username' => 'required', //|is_unique[users.email]
                'password' => 'required|min_length[8]'
            ];

            if ($this->validate($login_rule)) {

                $post_array = array( 'username' => $this->request->getPost('username'), 'row_status' => 1 );
                $username_rows = $this->common->data_count('users',$post_array);

                if($username_rows == 0){ // no username/username found

                    $session->setFlashdata('msg', 'Invalid User, please try again.');
                    $insertLogArray = array(
                        'target_table' =>'users',
                        'action_taken'=>'login',
                        'topic_details' => json_encode($data),
                        'user_id' => '',
                        'comment' => 'Invalid User, please try again.'
                    );

                    $this->common->LogInsert($insertLogArray);
                    
                    $final_flag = array('status' => false, 'code' => '002', 'msg' => EM002);

                } elseif($username_rows > 1){ // multiple username / username found

                    $session->setFlashdata('msg', 'Multiple Presence, Contact Admin');
                    $insertLogArray = array(
                        'target_table' =>'users',
                        'action_taken'=>'login',
                        'topic_details' => json_encode($data),
                        'user_id' => '',
                        'comment' => 'Multiple Presence, Contact Admin'
                    );

                    $this->common->LogInsert($insertLogArray);

                } elseif($username_rows == 1){

                    $post_array = array( 'username' => $this->request->getPost('username'), 'password' => hash('sha512', $this->request->getPost('password')));
                    $user_rows = $this->common->data_count('users',$post_array);
                    $row_cond_array = array('username' => $this->request->getPost('username'));
                    $user_data = $this->common->data_current_row($table = 'users', $row_cond_array);
                    
                    if($user_rows == 0 ){  // username - password mismatches

                        if($user_data->blocked == 1){

                            $session->setFlashdata('msg', 'You are blocked, Contact Admin');
                            $insertLogArray = array(
                                'target_table' =>'users',
                                'action_taken'=>'login',
                                'topic_details' => json_encode($data),
                                'user_id' => '',
                                'comment' => 'You are blocked, Contact Admin'
                            );

                            $this->common->LogInsert($insertLogArray);
                            $final_flag = array('status' => false, 'code' => '003', 'msg' => EM003);

                        } else{

                            if($user_data->login_attempt >= (MAX_LOGIN_ATTEMPT - 1) ){

                                $update_cond = array('id' => $user_data->id);
                                $update_array = array('blocked' => 1);
                                $this->common->data_update('users', $update_cond, $update_array);
                                $session->setFlashdata('msg', 'You are blocked, Contact Admin');
                                $insertLogArray = array(
                                    'target_table' =>'users',
                                    'action_taken'=>'login',
                                    'topic_details' => json_encode($data),
                                    'user_id' => '',
                                    'comment' => 'You are blocked, Contact Admin'
                                );

                                $this->common->LogInsert($insertLogArray);
                                $final_flag = array('status' => false, 'code' => '003', 'msg' => EM003);

                            } else{

                                $this->common->value_increment('users','id', $user_data->id, 'login_attempt', '1');
                                $session->setFlashdata('msg', 'Wrong credentials, please try again. <hr> You have used <b>' . ($user_data->login_attempt +1) . '/' . MAX_LOGIN_ATTEMPT . '</b> chances');
                                $insertLogArray = array(
                                    'target_table' =>'users',
                                    'action_taken'=>'login',
                                    'topic_details' => json_encode($data),
                                    'user_id' => '',
                                    'comment' => 'Wrong credentials, please try again.'
                                );

                                $this->common->LogInsert($insertLogArray);
                                $final_flag = array('status' => false, 'code' => '004', 'msg' => EM004);

                            }

                        }

                        // echo $this->authentication->getLastQuery()->getQuery();

                    }else{  // // username - password matches

                        if($user_data->blocked == 1){

                            $session->setFlashdata('msg', 'You are blocked, Contact Admin');
                            $insertLogArray = array(
                                'target_table' =>'users',
                                'action_taken'=>'login',
                                'topic_details' => json_encode($data),
                                'user_id' => '',
                                'comment' => 'You are blocked, Contact Admin'
                            );

                            $this->common->LogInsert($insertLogArray);
                            $final_flag = array('status' => false, 'code' => '003', 'msg' => EM003);

                        } else{
                            
                            $row_cond_array = array('id' => $user_data->id);
                            $update_array = array('login_attempt' => 0);
                            $this->common->data_update('users',$row_cond_array, $update_array);
                            $session->setFlashdata('msg', '');

                            $row_cond_array = array('id' => $user_data->id, 'row_status' => 1);
                            $usertype_id = $this->common->data_current_row('users',$row_cond_array)->user_type;
                            $userrole = $this->common->data_current_row('users',$row_cond_array)->role_id;
                            $user_detail_id = $this->common->data_current_row('users',$row_cond_array)->user_detail_id;
                            $email_id = $this->common->data_current_row('users',$row_cond_array)->email;
                            
                            $row_cond_array = array('id' => $usertype_id, 'row_status' => 1);
                            $usertype = $this->common->data_current_row('user_roles',$row_cond_array)->user_type_name;
                            if($usertype_id == 1){
                                $user_detail_id = '0'; // 0 for admin
                            }
                            
                            $sess_user_data = [
                                'id'           => $user_data->id,
                                'usertype'     => $usertype,
                                'userrole'     => $userrole,
                                'user_detail_id' => $user_detail_id,
                                'username'     => $user_data->username,
                                'email_id'     => $email_id,
                                'logged_in'    => TRUE
                            ];
                            $session->set($sess_user_data);

                            if($user_data->profile_activation == 0){
                                die('Should not happened; still, ask admin to activate your profile.');
                                // return redirect()->to(base_url('profile-activate'));
                            }else{
                                $final_flag = array('status' => true, 'code' => '011', 'msg' => EM011);
                                // return redirect()->to(base_url('dashboard'));
                            }

                        }

                    }
                } else{
                    $session->setFlashdata('msg', 'Invalid User, please try again.');
                }

            } else{
                $final_flag = array('status' => false, 'code' => '001', 'msg' => EM001);
            } // validation
            
        } // form submit
        
        return json_encode($final_flag);
        
    }
    
    public function test_mail(){
        $to = 'sketchmeglobal@gmail.com';
        $message = "Hi";

        $to      = 'sketchmeglobal@gmail.com';
        $subject = 'Forget Password || Link verify';
        $headers = 'From: sayak@sketchmeglobal.com' . "\r\n" .
            'Reply-To: sayak@sketchmeglobal.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        // $email->setMessage($message);
        // $email->setMailType('html');
        // $email->send();
    }

    public function sendmail($mail_to,$msg,$mail_sub='',$mail_from='',$attachments=array(),$mailer_name='',$smtp_host='',$smtp_port='',$smtp_user='',$smtp_pass='') {

        $email = \Config\Services::email();


        if($mail_from == '') $mail_from=default_mail_from; else $mail_from=$mail_from;
        if($mailer_name == '') $mailer_name=default_mailer_name; else $mailer_name=$mailer_name;
        if($mail_sub == '') $mail_sub=default_mail_sub; else $mail_sub=$mail_sub;
        if($smtp_host == '') $smtp_host=default_smtp_host; else $smtp_host=$smtp_host;
        if($smtp_port == '') $smtp_port=default_smtp_port; else $smtp_port=$smtp_port;
        if($smtp_user == '') $smtp_user=default_smtp_user; else $smtp_user=$smtp_user;
        if($smtp_pass == '') $smtp_pass=default_smtp_pass; else $smtp_pass=$smtp_pass;

        $config = Array(
            'smtp_host' => $smtp_host,
            'smtp_port' => $smtp_port,
            'smtp_user' => $smtp_user,
            'smtp_pass' => $smtp_pass,
            'protocol' => 'smtp',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );
        $this->load->library('email', $config);

        $this->email->clear(TRUE);
        $this->email->set_mailtype("html");
        $this->email->from($mail_from, $mailer_name);
        $this->email->reply_to($mail_from, $mailer_name);
        $this->email->to($mail_to);
        $this->email->subject($mail_sub);
        $this->email->message($msg);
        //attaching files
        foreach($attachments as $att) {
            $this->email->attach($att);
        }
        //sending mail
        $this->email->send();
    }

    
    public function logout(){
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('login'));
    }
}
