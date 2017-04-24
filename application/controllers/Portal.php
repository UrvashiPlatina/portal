<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portal extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('javascript');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->library('session');
        $this->load->library("pagination");
        $this->load->library('calendar');
        $this->load->helper(array('form', 'url'));
        $this->load->database();

        if(empty($this->session->userdata('name')))
         {
        //redirect('crm/login');
        
         }
    }
    public function common(){
        
        if(empty($this->session->userdata('name')))
         {
            redirect('portal/logout');        
         }
         else{
            $this->load->view('templates/header');
            $this->load->model("Portalmodel");
         }

    }

    public function index(){ $this->login(); }
    function login($try = NULL){ 
          $this->load->view('login');
          }
   /******************************login / logout *********************/
    public function user_login()
    {
            $this->load->model("Portalmodel");
            $result=$this->Portalmodel->login_validate();
            //call function in model to check user is valid or not
            if(!$result)                    
            {
                $this->session->set_flashdata('err_message', 'Please enter valid User Name or Password!');  //display the flashdata using session
                redirect('portal/login');  //user is not valid so goto login page again                   
            }
            else
            {   
                redirect('portal/dashboard');   //user is valid so goto dashboard
            } 
    }
    public function logout()
    {
            $this->session->unset_userdata('name');
            $this->session->set_flashdata("logoutmsg","You Have Been Successfully Logged Out."); 
            redirect("portal/login");
    }
    /****************************** Dashboard*********************/ 
     function dashboard(){
      $this->load->view('templates/header');
      $this->load->view('index');
      $this->load->view('templates/footer');
    }

    function projects(){
        $this->common();
        $config = array();
       // $session_role=$this->session->userdata('name'); 
       
        
        $config["base_url"] = base_url() . "index.php/portal/projects";
        $config["total_rows"] = $this->Portalmodel->record_count('project');
        $config["per_page"] = 15;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['results'] = $this->Portalmodel->projectlist();
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('projects', $data);
        $this->load->view('templates/footer');

    }


     function maintainance(){      
        $this->common();
        $this->load->view('maintainance');
        $this->load->view('footer');
    }
    
    
    /***********************Delete ****************/
     function delete()
    {
        $this->load->model('portalmodel');
        $table=  $this->input->post('deltable');
         $name=  $this->input->post('name');
         $id=  $this->input->post('delid');
         switch ($table) {
    case "file_category":
        $cond="file_catid";
        $url="file_category";
        break;
      case "notification":
        $cond="id";       
        break;
    case "project":
         $cond="id";
        //$cond1='name';
        break;
    case "criminal_justice":
         $cond="id";
        break;
    case "education":
          $cond="e_id";
        break;
    case "ethnicity":
          $cond="ethnicity_id";
        break;
    case "first_language":
          $cond="language_id";
        break;
    case "gender":
          $cond="gender_id";
        break;
    case "income":
          $cond="id";
        break;
    case "living_situation":
          $cond="living_id";
        break;
    case "office":
          $cond="id";
        break;
    case "program":
          $cond="id";
        break;
    case "age_group":
          $cond="age_id";
        break;
      
    default:
       $cond="id";
}
 //$cond="file_catid";
    $result= $this->portalmodel->deleteid($table,$cond,$id);
     if($result==TRUE){
                  echo 'sucess';
                }else{
              echo 'failed';
                }
        
        //redirect("file_category".$id);
      // redirect("crm/".$url);
    }
    
     /***********************edit ****************/
  function add()
    {
        $this->load->model('portalmodel');
       // $this->load->library('form_validation');
        //$this->form_validation->set_rules('name', 'name', 'required');
      /*  if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','File Category Inserted Failed' );
            } else {*/
            $data = array(
            'name' => $this->input->post('name'),
            'status'=> $this->input->post('status')
               //'user'=> $this->input->post('user'),
            );
            $result= $this->portalmodel->insert($data);
                if($result==TRUE){
                   $this->session->set_flashdata('failed', 'File Category already Existed' );
                }else{
                $this->session->set_flashdata('success', 'File Category Inserted Successfully' );
                }
        //}
       // redirect("portal/insert");
    }   
         function edit()
    {
        $this->load->model('Portalmodel');
        //$this->form_validation->set_rules('editname', 'Name', 'trim|required');
         //run validation check
       /* if ($this->form_validation->run() == FALSE)
        {   //validation fails
            echo validation_errors();
        }
        else
        {  */  
          $table=  $this->input->post('table');
          $name=  $this->input->post('name');
          $id=  $this->input->post('id');
          $status=  $this->input->post('status');
          $created=  $this->input->post('created');
          $accountmanager=  $this->input->post('accountmanager');
          $projectmanager=  $this->input->post('projectmanager');
          $developer=  $this->input->post('developer');
          $details=  $this->input->post('details');
          $no_of_task=  $this->input->post('no_of_task');

         switch ($table) {
    case "project":
        $cond="id";
        $cond1='name';
        $cond2='status';
        $cond3='created';
        $cond4='accountmanager';
        $cond5='projectmanager';
        $cond6='developer';
        $cond7='details';
        $cond8='no_of_task';
        break;
     case "notification":
        $cond="id";
        $cond1='notification';
        break;
    case "user":
         $cond="user_id";
        $cond1='counselor';
        break;
    case "criminal_justice":
         $cond="id";
        $cond1='criminal_justice';
        break;
    case "education":
          $cond="e_id";
        $cond1='education';
        break;
    case "ethnicity":
          $cond="ethnicity_id";
        $cond1='ethnicity';
        break;
    case "first_language":
          $cond="language_id";
        $cond1='language';
        break;
    case "gender":
          $cond="gender_id";
        $cond1='gender';
        break;
    case "income":
          $cond="id";
        $cond1='income';
        break;
    case "living_situation":
          $cond="living_id";
        $cond1='living';
        break;
    case "office":
          $cond="id";
        $cond1='office';
        break;
    case "program":
          $cond="id";
        $cond1='program';
        break;
     case "age_group":
          $cond="age_id";
          $cond1='age';
        break;
    default:
        $cond="id";
        $cond1='';
}
 $data = array(
           $cond1 =>  $name,
           $cond2 =>  $status,
           $cond3 =>  $created,
           $cond4 =>  $accountmanager,
           $cond5 =>  $projectmanager,
           $cond6 =>  $developer,
           $cond7 =>  $details,
           $cond8 =>  $no_of_task

           );
   echo $result= $this->Portalmodel->update_query($table,$data,$id,$cond);
    if($result==FALSE){
                  echo 'sucess';
                }else{
              echo 'failed';
                }
        }
    
    /***********************documents ****************/
    
    function do_upload(){
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fname', 'fname', 'required');
        $this->form_validation->set_rules('categories', 'categories', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','File Category Inserted Failed' );
            } else {
            $filename=$this->input->post('fname');
            $cat =$this->input->post('categories');
         
            $config['upload_path']   = './documents/'.$cat.'/'; 
            $config['allowed_types'] = 'gif|jpg|png|pdf|docx'; 
            $ext = end(explode(".", $_FILES['userfile']['name']));
               $path='/documents/'.$cat.'/'.$filename.'.'.$ext;
            //$config['max_size']      = 200; 
            //$config['max_width']     = 1024; 
            //$config['max_height']    = 768; 
            $config['file_name'] = $filename;
            $this->load->library('upload', $config);            
        if ( $this->upload->do_upload('userfile')) {
            $datas = array('upload_data' => $this->upload->data()); 
            $data = array(
                    'file' => $this->input->post('fname'),
                    'file_description' => $this->input->post('description'),
                    'file_category' => $this->input->post('categories'),
                    'file_path' => $path
                    );

            $result= $this->crmmodel->file_insert($data);
            if($result==TRUE){
               $this->session->set_flashdata('failed', 'File Category already Existed' );
            }else{
            $this->session->set_flashdata('success', 'File Category Inserted Successfully' );
            }
        }  
        redirect("crm/file_upload");
        }
    }
    function file_category(){
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/file_category";
        $config["total_rows"] = $this->crmmodel->record_count('file_category');
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->select($config["per_page"], $page,'file_category');
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('filecategory', $data);
        $this->load->view('footer');
    }
    function file_upload()
    {
        $this->load->model('crmmodel');
        $data = array();
        $this->load->view('header');
        $data['dropdown'] = $this->crmmodel->get_dropdown_list('file_category','file_catid','file_category','');
        $this->load->view('file_upload',$data);
        $this->load->view('footer');
    }
   
      function selectdata() {
       $this->load->model('crmmodel');
       $config = array();
        $config["base_url"] = base_url() . "crm/file_category";
        $config["total_rows"] = $this->crmmodel->record_count();
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->
            fetch_countries($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $data['h']=$this->crmmodel->select();
    }
    function filecat_edit()
    {
       $this->load->model('crmmodel');  
       $id=$this->input->post('editid');
      $data = array(
            'file_category' => $this->input->post('editname'),
               'manager'=> $this->input->post('editmngr'),
                'user'=> $this->input->post('edituser'),
            );
      $result= $this->crmmodel->update_query('file_category',$data,$id,'file_catid');
    if($result==FALSE){
                  echo 'sucess';
                }else{
              echo 'failed';
                }
        
    }
    /************************user ************/
    function user()
    {
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/user";
        $config["total_rows"] = $this->crmmodel->record_count('file');
        $config["per_page"] = 15;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->select($config["per_page"], $page,'user');
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('user', $data);
        $this->load->view('footer');
    }
     function adduser()
    {  
       $this->common();
          $data['dropdown'] = $this->crmmodel->get_dropdown_list('roles','id_role','role_name','');
        $this->load->view('adduser', $data);
        $this->load->view('footer');

    }
    function user_insert()
    {
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('uname', 'uname', 'required');
        $this->form_validation->set_rules('user', 'user', 'required');
        $this->form_validation->set_rules('password', 'password', 'required|required|matches[repassword]');
        $this->form_validation->set_rules('repassword', 'repassword', 'required');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
        $this->form_validation->set_rules('role', 'uname', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','All fields are mandatory' );
            } else {
            $data = array(
            'user_name' => $this->input->post('uname'),
            'userid' => $this->input->post('user'),
            'password' => md5($this->input->post('password')),
            'user_email' => $this->input->post('email'),
            'user_active' => $this->input->post('status'),
            'user_role' => $this->input->post('role'),
            'created_by'=> $this->session->userdata('id')
            );
           $result= $this->crmmodel->insert_query('user',$data,$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'User already Existed' );
                }else{
                $this->session->set_flashdata('success', 'User Inserted Successfully' );
                }
        }
        redirect("crm/adduser");
    }
       function edituser($id)
    {  
            $id = $this->uri->segment(3);
     if (empty($id))
        {
            show_404();
        }
        $this->common();
       // $id=$this->input->post('uname');
        $data["results"] =  $this->crmmodel->list_select('user','user_id',$id);
        $data['dropdown'] = $this->crmmodel->get_dropdown_list('roles','id_role','role_name','');
        $this->load->view('edituser', $data);
        $this->load->view('footer');

    }
      function user_update()
    {
          $id = $this->uri->segment(3);
         if (empty($id))
        {
            show_404();
        }
       
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $id=$this->input->post('edit_id');
        $this->form_validation->set_rules('uname', 'uname', 'required');
        $this->form_validation->set_rules('user', 'user', 'required');
        $this->form_validation->set_rules('password', 'password', 'required|required|matches[repassword]');
        $this->form_validation->set_rules('repassword', 'repassword', 'required');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
        $this->form_validation->set_rules('role', 'uname', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','All fields are mandatory' );
            } else {
            $data = array(
            'user_name' => $this->input->post('uname'),
            'userid' => $this->input->post('user'),
            'password' => md5($this->input->post('password')),
            'user_email' => $this->input->post('email'),
            'user_active' => $this->input->post('status'),
            'user_role' => $this->input->post('role'),
            'created_by'=> $this->session->userdata('id')
            );
           $result= $this->crmmodel->update_query('user',$data,$id,'user_id');
                if($result==TRUE){
                   $this->session->set_flashdata('failed', 'User already Existed' );
                }else{
                $this->session->set_flashdata('success', 'User Updated Successfully' );
                }
        }
        redirect("crm/edituser/".$id);
    }
   /*********************** New Intake ************/ 
    function newintakeform()
    {
        $this->common();
        $cond="counselor=1";
        $data['counselor'] = $this->crmmodel->get_dropdown_list('user','user_id','user_name',$cond);//$this->crmmodel->get_dropdown_list('counselor','counselorid','counselor','');
        $data['office'] = $this->crmmodel->get_dropdown_list('office','id','office','');
        $data['gender'] = $this->crmmodel->get_dropdown_list('gender','gender_id','gender',''); 
        $data['age'] = $this->crmmodel->get_dropdown_list('age_group','age_id','age','');
        $data['ethnicity'] = $this->crmmodel->get_dropdown_list('ethnicity','ethnicity_id','ethnicity','');
       $data['language'] = $this->crmmodel->get_dropdown_list('first_language','language_id','language','');
       $data['livingsituation'] = $this->crmmodel->get_dropdown_list('living_situation','living_id','living','');
        $data['education'] = $this->crmmodel->get_dropdown_list('education','e_id','education','');
        $data['program'] = $this->crmmodel->list_select1('program');
        $data['income'] = $this->crmmodel->list_select1('income');
        $this->load->view('newintakeform', $data);
        $this->load->view('footer');
    }
    function impact()
    {
        $this->common();
        $id=$this->input->get('id');
        $data['client'] = $this->crmmodel->list_select('client','client_id',$id);
        $data['impact'] = $this->crmmodel->list_select('impact','client_intake_id',$id);
        $this->load->view('impact',$data);
        $this->load->view('footer');
          
    }
    function impact_insert()
    {        
        $id=$this->input->post('clientid');
         $intakeid=$this->input->get('intakeid');
        for($j = 1; $j <= 10; $j++){
        $varin='in'.$j;
        $varout='out'.$j;         
        if($this->input->post($varin)==''){ $$varin=0;} else{ $$varin=$this->input->post($varin);}
        if($this->input->post($varout)==''){ $$varout=0;} else { $$varout=$this->input->post($varout); }
        }
      
          if($this->input->post('doi')=="")
        {
            $dateformat="";
        }else{
          $dateformat=date('Y-m-d', strtotime($this->input->post('doi')));
        }
        if($this->input->post('dob')=="")
        {
            $dateformat1="";
        }else{
        $dateformat1=date('Y-m-d', strtotime($this->input->post('dob')));
        }
        $this->common();
            $data = array(
            'client_intake_id' =>$id,
            'assessment_date'=>$dateformat, 
            'avg_in'=>$this->input->post('avgin'),
            'avg_out'=>$this->input->post('avgout'),
            'indicators'=>$this->input->post('impacts'),
            'exit_date'=>$dateformat1, 
            'in1'=>$in1,'in2'=>$in2,'in3'=>$in3, 'in4'=>$in4, 'in5'=>$in5, 'in6'=>$in6, 'in7'=>$in7, 'in8'=>$in8,'in9'=>$in9,'in10'=>$in10, 
            'out1'=>$out1,'out2'=>$out2, 'out3'=>$out3, 'out4'=>$out4,'out5'=>$out5,'out6'=>$out6,'out7'=>$out7, 'out8'=>$out8, 'out9'=>$out9, 'out10'=>$out10,  'created_by'=> $this->session->userdata('id'),
            );
            if($this->input->post('insert_update')=='new'){
            $data1 = array(
            'client_intake_id' =>$id);
             $result= $this->crmmodel->insert_query('impact',$data,$data1);
              if($result==False){
                    $this->session->set_flashdata('failed', 'Impact already Existed' );
                    }else{
                    $this->session->set_flashdata('success', 'Impact Inserted Successfully' );
                    }    
            }else{
                    $result= $this->crmmodel->update_query('impact',$data,$id,'client_intake_id');
                    if($result==true){
                    $this->session->set_flashdata('failed', 'Impact already Existed' );
                    }else{
                    $this->session->set_flashdata('success', 'Impact Inserted Successfully' );
                    }    
            }
                    
        redirect("crm/impact?id=$id&intakeid=$intakeid");          
     }
      function intakedelete()
    {
        $this->load->model('crmmodel');
        $id=  $this->input->post('delid');
        $result1= $this->crmmodel->deleteid('client','intakeid',$id);
        //$result1= $this->crmmodel->deleteid('impact','intakeid',$id);
        $result= $this->crmmodel->deleteid('intake','id',$id);
        if($result==TRUE){
            echo 'sucess';
            }else{
          echo 'failed';
            }
    }
    function deleteimpact()
    {
        $this->load->model('crmmodel');
        $id=  $this->input->post('delid');
        $result1= $this->crmmodel->deleteid('impact','client_intake_id',$id);
        //$result1= $this->crmmodel->deleteid('impact','intakeid',$id);
        $result= $this->crmmodel->deleteid('client','client_id',$id);
        if($result==TRUE){
            echo 'sucess';
            }else{
          echo 'failed';
            } 
    }
    function impactreport(){
       
        $this->common();
         $data['office'] = $this->crmmodel->get_dropdown_list('office','id','office','');
        $data['program'] = $this->crmmodel->get_dropdown_list('program','id','program',''); 
        $data['user'] = $this->crmmodel->get_dropdown_list('user','user_id','user_name','');
        $indicators=$this->input->post('impacts');
        $office=$this->input->post('office');
        $program=$this->input->post('program');
        $user=$this->input->post('user');        
        $from=$this->input->post('doi');
        $to=$this->input->post('dob');
        $cond='1';
        if(($program!="")){
            $cond.= " and FIND_IN_SET( $program, program )";
        }
        if(($office!="")){
            $cond.= " and office=".$office;
        }
        if($user!=""){
            $cond.= " and counselor=".$user;
        }
      
        $data['postoffice']=$office;
        $data['postprogram']=$program; 
        $data['postuser']=$user;
        $data['postdoi']=$from;
        $data['postdob']=$to;
        $data['postindicators']=$indicators;
     if($from!="" && $to!=""){
            $dateformat=date('Y-m-d', strtotime($from));
                $dateformat1=date('Y-m-d', strtotime($to));
                $cond.=  " and exit_date between '".$dateformat."' and '".$dateformat1."' ";
        }
         $data["results"]=$this->crmmodel->impactreport($cond);
        $this->load->view('impactreport',$data);
        $this->load->view('footer');
    }
    function intakeclient_details()
    {
        $id=$this->input->get('id');
         if (empty($id)){$id=$this->uri->segment(3);}
    
        $this->common();
   
        $data["results"] =  $this->crmmodel->list_select('client','client_id',$id);
        
       $cond="counselor=1";
        $data['counselor'] = $this->crmmodel->get_dropdown_list('user','user_id','user_name',$cond);//$this->crmmodel->get_dropdown_list('counselor','counselorid','counselor','');
        $data['office'] = $this->crmmodel->get_dropdown_list('office','id','office','');
        $data['gender'] = $this->crmmodel->get_dropdown_list('gender','gender_id','gender','');
         $data['livingsituation'] = $this->crmmodel->get_dropdown_list('living_situation','living_id','living','');
      
        $data['ethnicity'] = $this->crmmodel->get_dropdown_list('ethnicity','ethnicity_id','ethnicity','');
       $data['language'] = $this->crmmodel->get_dropdown_list('first_language','language_id','language','');
        $data['education'] = $this->crmmodel->get_dropdown_list('education','e_id','education','');
        $data['program'] = $this->crmmodel->list_select1('program');
        $data['income'] = $this->crmmodel->list_select1('income');
        $this->load->view('intakeclient_details', $data);
        $this->load->view('footer');
      //  redirect("crm/intakeclient_details?id=$id");  
    }
    function updateclient()
    {
         $this->load->model('crmmodel');
        $id=  $this->input->post('intakeclietid');    
          $this->form_validation->set_rules('doi', 'Date of Intake', 'required');
        $this->form_validation->set_rules('counselor', 'Counselor', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed', validation_errors());
            } else {
           
           
                 $income="";
                if(count($this->input->post('income'))!=0){
                 foreach ($this->input->post('income') as $pgm){
                     $income=$pgm.','.$income;
                 }
                }
                $program="";
                if(count($this->input->post('program'))!=0){
                 foreach ($this->input->post('program') as $pgm){
                     $program=$pgm.','.$program;
                 }
                }
                $dateformat=date('Y-m-d', strtotime($this->input->post('doi')));
                $dateformat1=date('Y-m-d', strtotime($this->input->post('dob')));
           
            $data = array(   
            'intakeid'=>$id,
            'doi' => $dateformat,
            'counselor' => $this->input->post('counselor'),
            'office' => $this->input->post('office'),
            'program' => $program,        
            'living_situation' => $this->input->post('living'),
            'ethnicity' => $this->input->post('ethnicity'),
            'first_language' => $this->input->post('language'),
            'education' => $this->input->post('education'),
            'employment' => $this->input->post('employment'),
            'income_socurce' => $income,
            'criminal_justice' => $this->input->post('criminal'),
            'other_issues' => $this->input->post('other'),
            'referred_agency' => $this->input->post('referred'),
            'created_by' => $this->session->userdata('id'),   
            );
             $result= $this->crmmodel->update_query('client',$data,$id,'client_id');
          
                if($result==true){
                   $this->session->set_flashdata('failed', ' Client  Already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Client  Successfully Update'  );
                }
        
            }
        redirect("crm/intakeclient_details?id=$id");
    }
    function clientreopen()
    {
         $this->load->model('crmmodel');
        $id=  $this->input->post('intakeclietid');
      
        
           
                 $income="";
                if(count($this->input->post('income'))!=0){
                 foreach ($this->input->post('income') as $pgm){
                     $income=$pgm.','.$income;
                 }
                }
                $program="";
                if(count($this->input->post('program'))!=0){
                 foreach ($this->input->post('program') as $pgm){
                     $program=$pgm.','.$program;
                 }
                
                $dateformat=date('Y-m-d', strtotime($this->input->post('doi')));
                $dateformat1=date('Y-m-d', strtotime($this->input->post('dob')));
           
            $data = array(   
            'intakeid'=>$id,
            'doi' => $dateformat,
            'counselor' => $this->input->post('counselor'),
            'office' => $this->input->post('office'),
            'program' => $program,        
            'living_situation' => $this->input->post('living'),
            'ethnicity' => $this->input->post('ethnicity'),
            'first_language' => $this->input->post('language'),
            'education' => $this->input->post('education'),
            'employment' => $this->input->post('employment'),
            'income_socurce' => $income,
            'criminal_justice' => $this->input->post('criminal'),
            'other_issues' => $this->input->post('other'),
            'referred_agency' => $this->input->post('referred'),
            'created_by' => $this->session->userdata('id'),   
            );
             $result= $this->crmmodel->insert_query_('client',$data);
             $data1= array( 'status'=>2,);
            $result1= $this->crmmodel->update_query('intake',$data1,$id,'id'); 
                if($result==true){
                   $this->session->set_flashdata('failed', ' Client  Already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Client  Successfully Created'  );
                }
        }
        redirect("crm/editclient?id=$id");
    }
      
      function editclient()
    {
        $id=$this->input->get('id');
         if (empty($id)){$id=$this->uri->segment(3);}
    
        $this->common();
       // $id=$this->input->post('uname');
        $data["results"] =  $this->crmmodel->list_select('intake','id',$id);
         $cond="intakeid=$id";
        $data["listintake"] =  $this->crmmodel->select_where('','','client',$cond);
        
       $cond="counselor=1";
        $data['counselor'] = $this->crmmodel->get_dropdown_list('user','user_id','user_name',$cond);//$this->crmmodel->get_dropdown_list('counselor','counselorid','counselor','');
        $data['office'] = $this->crmmodel->get_dropdown_list('office','id','office','');
        $data['gender'] = $this->crmmodel->get_dropdown_list('gender','gender_id','gender','');
         $data['livingsituation'] = $this->crmmodel->get_dropdown_list('living_situation','living_id','living','');
      
        $data['ethnicity'] = $this->crmmodel->get_dropdown_list('ethnicity','ethnicity_id','ethnicity','');
       $data['language'] = $this->crmmodel->get_dropdown_list('first_language','language_id','language','');
        $data['education'] = $this->crmmodel->get_dropdown_list('education','e_id','education','');
        $data['program'] = $this->crmmodel->list_select1('program');
        $data['income'] = $this->crmmodel->list_select1('income');
        $this->load->view('editclient', $data);
        $this->load->view('footer');
    }
      function editclient_update()
    {
        $this->common();
       $id=$this->input->post('intakeid');
             $data1 = array(
             'status'=>$this->input->post('status'),
            'email' => $this->input->post('email'),
            'contact' => $this->input->post('cnum'),
            'phone' => $this->input->post('cnum2'),
           'modified_on' => date('Y-m-d H:i:s'),  
            'modified_by' => $this->session->userdata('id'),  
            );
             $result1= $this->crmmodel->update_query('intake',$data1,$id,'id'); 
            
                if($result1==TRUE){
                   $this->session->set_flashdata('failed', ' Client  Already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Client  Successfully updated'  );
                }
        
        redirect("crm/editclient?id=$id");
    }
    function newintake_insert()
    {
        $this->common();
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('cnum', 'Primary Contact Number', 'required');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
        $this->form_validation->set_rules('doi', 'Date of Intake', 'required');
        $this->form_validation->set_rules('counselor', 'Counselor', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed', validation_errors());
            } else {
           
                 $income="";
                if(count($this->input->post('income'))!=0){
                 foreach ($this->input->post('income') as $pgm){
                     $income=$pgm.','.$income;
                 }
                }
                $program="";
                if(count($this->input->post('program'))!=0){
                 foreach ($this->input->post('program') as $pgm){
                     $program=$pgm.','.$program;
                 }
                }
                $dateformat=date('Y-m-d', strtotime($this->input->post('doi')));
                $dateformat1=date('Y-m-d', strtotime($this->input->post('dob')));
             $data1 = array(
            'first_name' => $this->input->post('fname'),  
            'last_name' => $this->input->post('lname'),
            'email' => $this->input->post('cnum'),
            'contact' => $this->input->post('cnum'),
            'phone' => $this->input->post('cnum'),
            'dob' => $dateformat1,
             'age_group' => $this->input->post('age'),
            'gender' => $this->input->post('gender'),
            'created_by' => $this->session->userdata('id'),  
            );  
              $result1= $this->crmmodel->insert_query('intake',$data1,$data1);
            $data = array(   
            'intakeid'=>$result1,
            'doi' => $dateformat,
            'counselor' => $this->input->post('counselor'),
            'office' => $this->input->post('office'),
            'program' => $program,         
           
            'living_situation' => $this->input->post('living'),
            'ethnicity' => $this->input->post('ethnicity'),
            'first_language' => $this->input->post('language'),
            'education' => $this->input->post('education'),
            'employment' => $this->input->post('employment'),
            'income_socurce' => $income,
            'criminal_justice' => $this->input->post('criminal'),
            'other_issues' => $this->input->post('other'),
            'referred_agency' => $this->input->post('referred'),
            'created_by' => $this->session->userdata('id'),   
            );
             $result= $this->crmmodel->insert_query_('client',$data);
            
                if($result1==FALSE){
                   $this->session->set_flashdata('failed', ' Client  Already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Client  Successfully Created'  );
                }
        }
        redirect("crm/newintakeform");
    }
    function client()
    {
        $this->common();
        $search=$this->input->post('search');
        $dob=$this->input->post('doa');
        $from=$this->input->post('doi');
        $to=$this->input->post('dob');
        $cond="1";
        if(($search!="")){
            
            $cond.= " and first_name  LIKE '%$search%' or last_name LIKE '%$search%'" ;
        }
        if(($dob!="")){
             $date=date('Y-m-d', strtotime($dob));
            $cond.= " and dob LIKE '%$date%'";
        }
      
           
        if($from!="" && $to!=""){
            $dateformat=date('Y-m-d', strtotime($from));
                $dateformat1=date('Y-m-d', strtotime($to));
                $cond.=  " and doi between '".$dateformat."' and '".$dateformat1."' ";
        }
        $cond.=" Order BY `client`.`intakeid`";
        $data['search']=$search;
        $data['dob']=$dob;
        $data['from']=$from;
        $data['to']=$to;
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/briefservices";
        $config["total_rows"] = $this->crmmodel->record_count('intake');
        $config["per_page"] = 15;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->clientlist($config["per_page"], $page,$cond);
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('client', $data);
        $this->load->view('footer');
    
    }
    
    /*******************Brief-Services***************/
     function briefservices()
    {
        $this->common();
        $data['office'] = $this->crmmodel->get_dropdown_list('office','id','office','');
        $data['gender'] = $this->crmmodel->get_dropdown_list('gender','gender_id','gender',''); 
        $data['age'] = $this->crmmodel->get_dropdown_list('age_group','age_id','age','');
        $office=$this->input->post('office');
        $gender=$this->input->post('gender');
        $age=$this->input->post('age');
        $service=$this->input->post('service');
        $from=$this->input->post('doi');
        $to=$this->input->post('dob');
        $cond='1';
        if(($gender!="")){
            $cond.= " and gender=".$gender;
        }
        if(($office!="")){
            $cond.= " and office=".$office;
        }
        if($age!=""){
            $cond.= " and age_group=".$age;
        }
        if(($service!="")){
            if($service=='phone')
            $cond.= " and phone=1"; else if($service=='inperson')   $cond.= " and inperson=1"; 
        }
        $data['postoffice']=$office;
        $data['postgender']=$gender; 
        $data['postage']=$age;
        $data['postservice']=$service;
        $data['postdoi']=$from;
        $data['postdob']=$to;
      
     if($from!="" && $to!=""){
            $dateformat=date('Y-m-d', strtotime($from));
                $dateformat1=date('Y-m-d', strtotime($to));
                $cond.=  " and created_on between '".$dateformat."' and '".$dateformat1."' ";
        }
         $data["results"]=$this->crmmodel->record_count_where('briefservice',$cond);
        $this->load->view('briefservices', $data);
        $this->load->view('footer');
    }
       function briefservices_insert()
    {
        $this->common();
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('fname', 'First Name', 'required');
         if(($this->input->post('service_phone'))=='phone') $phone='1';else$phone='0';
         if(($this->input->post('service_inperson'))=='inperson') $inperson='1';else $inperson='0';       
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed',validation_errors() );
            } else {
                $dateformat=date('Y-m-d', strtotime($this->input->post('doi')));
            $data = array(
            'fname' => $this->input->post('fname'),  
            'lname' => $this->input->post('lname'),
            'doi' => $dateformat,
            'office' => $this->input->post('office'),
            'gender' => $this->input->post('gender'),
            'age_group' => $this->input->post('age'),
            'ethnicity' => $this->input->post('ethnicity'),
            'first_language' => $this->input->post('language'),
            'other_issues' => $this->input->post('other'),
                'phone'=>$phone,
                'inperson'=>$inperson, 
                'repeated'=>$this->input->post('repeated'),
            'referred_agency' => $this->input->post('referred'),
            'created_by' => $this->session->userdata('id'),   
            );
             $result= $this->crmmodel->insert_query('briefservice',$data,$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Brief Service Already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Brief Service Inserted Successfully' );
                }
        }
        redirect("crm/addbriefservices");
    }
    function addbriefservices()
    {
        $this->common();
        $data['office'] = $this->crmmodel->get_dropdown_list('office','id','office','');
        $data['gender'] = $this->crmmodel->get_dropdown_list('gender','gender_id','gender',''); 
        $data['age'] = $this->crmmodel->get_dropdown_list('age_group','age_id','age','');
        $data['ethnicity'] = $this->crmmodel->get_dropdown_list('ethnicity','ethnicity_id','ethnicity','');
        $data['language'] = $this->crmmodel->get_dropdown_list('first_language','language_id','language','');
        $this->load->view('addbriefservices', $data);
        $this->load->view('footer');
    }
   /*********************counselor*************/
    function counselor() {
       $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/file_category";
         $cond="counselor=0";
        $cond1="counselor=1";
        $config["total_rows"] = $this->crmmodel->record_count_where('user',$cond1);
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
       
       // $where="where counselor=1 ";
        $data['counselor'] = $this->crmmodel->get_dropdown_list('user','user_id','user_name',$cond);
        $data["results"] = $this->crmmodel->select_where($config["per_page"], $page,'user',$cond1);
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('counselor', $data);
        $this->load->view('footer');
    }
    function counselor_insert()
    {
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('counselor', 'counselor', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','Counselor Inserted Failed' );
            } else {
                $id= $this->input->post('counselor');
            $data = array(
            'counselor' => 1
            );
             $result= $this->crmmodel->update_query('user',$data,$id,'user_id');
                if($result==TRUE){
                   $this->session->set_flashdata('failed', 'Counselor already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Counselor Inserted Successfully' );
                }
        }
        redirect("crm/counselor");
    }
    /*********************Office Location*********************/
    function office_locations() {
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/office_locations";
        $config["total_rows"] = $this->crmmodel->record_count('office');
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->select($config["per_page"], $page,'office');
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('office_locations', $data);
        $this->load->view('footer');
    }
    function officeLocation_insert()
    {
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cname', 'cname', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','Office Location Inserted Failed' );
            } else {
            $data = array(
            'office' => $this->input->post('cname')
            );
             $result= $this->crmmodel->insert_query('office',$data,$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Office Location already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Office Location Inserted Successfully' );
                }
        }
        redirect("crm/office_locations");
    }
 /*********************age*********************/
    function age() {
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/age";
        $config["total_rows"] = $this->crmmodel->record_count('age_group');
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->select($config["per_page"], $page,'age_group');
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('age', $data);
        $this->load->view('footer');
    }
    function age_insert()
    {
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cname', 'cname', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','Age Group Inserted Failed' );
            } else {
            $data = array(
            'age' => $this->input->post('cname')
            );
             $result= $this->crmmodel->insert_query('age_group',$data,$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Age Group already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Age Group Inserted Successfully' );
                }
        }
        redirect("crm/age");
    }

 /*********************gender*********************/
    function gender() {
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/gender";
        $config["total_rows"] = $this->crmmodel->record_count('gender');
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->select($config["per_page"], $page,'gender');
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('gender', $data);
        $this->load->view('footer');
    }
    function gender_insert()
    {
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cname', 'cname', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','gender Inserted Failed' );
            } else {
            $data = array(
            'gender' => $this->input->post('cname')
            );
             $result= $this->crmmodel->insert_query('gender',$data,$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'gender already Existed' );
                }else{
                $this->session->set_flashdata('success', 'gender Inserted Successfully' );
                }
        }
        redirect("crm/gender");
    }

/*********************Education*********************/
    function education() {
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/education";
        $config["total_rows"] = $this->crmmodel->record_count('education');
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->select($config["per_page"], $page,'education');
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('education', $data);
        $this->load->view('footer');
    }
    function eductaion_insert()
    {
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cname', 'cname', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','Education Inserted Failed' );
            } else {
            $data = array(
            'education' => $this->input->post('cname')
            );
             $result= $this->crmmodel->insert_query('education',$data,$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Education already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Education Inserted Successfully' );
                }
        }
        redirect("crm/education");
    }
/*********************Ethnicity*********************/
    function ethnicity() {
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/ethnicity";
        $config["total_rows"] = $this->crmmodel->record_count('ethnicity');
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->select($config["per_page"], $page,'ethnicity');
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('ethnicity', $data);
        $this->load->view('footer');
    }
    function ethnicity_insert()
    {
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cname', 'cname', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','Ethnicity Inserted Failed' );
            } else {
            $data = array(
            'ethnicity' => $this->input->post('cname')
            );
             $result= $this->crmmodel->insert_query('ethnicity',$data,$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Ethnicity already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Ethnicity Inserted Successfully' );
                }
        }
        redirect("crm/ethnicity");
    }
    /*********************Language*********************/
    function language() {
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/language";
        $config["total_rows"] = $this->crmmodel->record_count('first_language');
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->select($config["per_page"], $page,'first_language');
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('language', $data);
        $this->load->view('footer');
    }
    function language_insert()
    {
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cname', 'cname', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','Language Inserted Failed' );
            } else {
            $data = array(
            'language' => $this->input->post('cname')
            );
             $result= $this->crmmodel->insert_query('first_language',$data,$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Language already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Language Inserted Successfully' );
                }
        }
        redirect("crm/language");
    }
        /*********************Criminal Justice*********************/
    function criminal() {
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/criminal";
        $config["total_rows"] = $this->crmmodel->record_count('criminal_justice');
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->select($config["per_page"], $page,'criminal_justice');
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('criminal', $data);
        $this->load->view('footer');
    }
    function criminal_insert()
    {
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cname', 'cname', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','Criminal Justice Inserted Failed' );
            } else {
            $data = array(
            'criminal_justice' => $this->input->post('cname')
            );
             $result= $this->crmmodel->insert_query('criminal_justice',$data,$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Criminal Justice already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Criminal Justice Inserted Successfully' );
                }
        }
        redirect("crm/criminal");
    }
            /*********************Living Situations*********************/
    function living() {
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/living";
        $config["total_rows"] = $this->crmmodel->record_count('living_situation');
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->select($config["per_page"], $page,'living_situation');
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('living', $data);
        $this->load->view('footer');
    }
    function living_insert()
    {
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cname', 'cname', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','Living Situations Inserted Failed' );
            } else {
            $data = array(
            'living' => $this->input->post('cname')
            );
             $result= $this->crmmodel->insert_query('living_situation',$data,$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Living Situations already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Living Situations Inserted Successfully' );
                }
        }
        redirect("crm/living");
    }
     /*********************Case Notes*********************/
     function casenotes() {
        $id=$this->input->get('id');
        if (empty($id)){$id=$this->uri->segment(3);}
       $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/casenotes/$id";
        $where='client_id='.$id;
        $config["total_rows"] = $this->crmmodel->record_count_where('casenotes',$where);
        $config["per_page"] = 10;
        $config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['client_id']=$id;
        $data["results"] = $this->crmmodel->select_where($config["per_page"], $page,'casenotes',$where);
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('casenotes', $data);
        $this->load->view('footer');
    }
    function casenotes_insert()
    {
        $id=$this->input->post('clientid');
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cname', 'cname', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','Case Notes Inserted Failed' );
            } else {
            $data = array(
            'notes' => $this->input->post('cname'),
            'creadted_by'=>$this->session->userdata('userid'),
            'client_id'=>$this->input->post('clientid')
            );
             $result= $this->crmmodel->insert_query_('casenotes',$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Case Notes already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Case Notes Inserted Successfully' );
                }
        }
       redirect("crm/casenotes?id=".$id);
    }
     /*********************Appointments*********************/
     function appointments() {
        $id=$this->input->get('id');
         if (empty($id)){$id=$this->uri->segment(3);}
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/appointments/$id";
        $where='client_id='.$id;
        $config["total_rows"] = $this->crmmodel->record_count_where('appointments',$where);
        $config["per_page"] = 15;
        $config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $cond="counselor=1";
        $data['counselor'] = $this->crmmodel->get_dropdown_list('user','user_id','user_name',$cond);
        $data["results"] = $this->crmmodel->select_where($config["per_page"], $page,'appointments',$where);
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('appointments', $data);
        $this->load->view('footer');
    }
    function appointments_insert()
    {
        $id=$this->input->post('clientid');
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cname', 'Notes', 'required');
        $this->form_validation->set_rules('dob', 'Appointment Date', 'required');
        $this->form_validation->set_rules('hour', 'Hour', 'required');
        $this->form_validation->set_rules('minute', 'Minute', 'required');
              if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','Appointments Inserted Failed' );
            } else {
                 $dateformat=date('Y-m-d', strtotime($this->input->post('dob')));
            $time=$this->input->post('hour').':'.$this->input->post('minute');
            $data = array(
            'notes' => $this->input->post('cname'),
            'created_by'=>$this->session->userdata('id'),
            'client_id'=>$this->input->post('clientid'),
            'time'=>$time,    
            'counselor'=>$this->input->post('counselor'),
            'app_date'=> $dateformat,
            );
             $result= $this->crmmodel->insert_query_('appointments',$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Appointments already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Appointments Inserted Successfully' );
                }
        }
       redirect("crm/appointments?id=".$id);
    }
     /*********************Program*********************/

     function program() {
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/program";
        $config["total_rows"] = $this->crmmodel->record_count('program');
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->select($config["per_page"], $page,'program');
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('program', $data);
        $this->load->view('footer');
    }
    function program_insert()
    {
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cname', 'cname', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','Program Inserted Failed' );
            } else {
            $data = array(
            'program' => $this->input->post('cname')
            );
             $result= $this->crmmodel->insert_query('program',$data,$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Program already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Program Inserted Successfully' );
                }
        }
        redirect("crm/program");
    }
         /*********************Income*********************/

     function income() {
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/income";
        $config["total_rows"] = $this->crmmodel->record_count('income');
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->select($config["per_page"], $page,'income');
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('income', $data);
        $this->load->view('footer');
    }
    function income_insert()
    {
        $this->load->model('crmmodel');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cname', 'cname', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata( 'failed','Income Inserted Failed' );
            } else {
            $data = array(
            'income' => $this->input->post('cname')
            );
             $result= $this->crmmodel->insert_query('income',$data,$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Income already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Income Inserted Successfully' );
                }
        }
        redirect("crm/income");
    }
    
    
     /*********************ADD Appointments*********************/
     function addappointments() {
        $id=$this->input->get('id');
        if (empty($id)){$id=$this->uri->segment(3);}
        $this->common();
        $this->load->view('addappointments');
        $this->load->view('footer');
    }
    function addappointments_insert()
    {
        $this->load->model('crmmodel');
      $dateformat=date('Y-m-d', strtotime($this->input->post('dob')));
            $time=$this->input->post('hour').':'.$this->input->post('minute');
            $data = array(
            'notes' => $this->input->post('cname'),
            'user_id'=>$this->session->userdata('id'),
            'created_by'=>$this->session->userdata('id'),
            'time'=>$time, 
            'app_date'=> $dateformat,
            );
           
             $result= $this->crmmodel->insert_query('appointments',$data,$data);
                if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Appointments already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Appointments Inserted Successfully' );
                }
        
        redirect("crm/notification");
    }
         /*********************ADD Notification*********************/
     function notification() {
        $this->common();
        $config = array();
        $config["base_url"] = base_url() . "index.php/crm/notification";
        $config["total_rows"] = $this->crmmodel->record_count('notification');
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->crmmodel->select($config["per_page"], $page,'notification');
        $data["links"] = $this->pagination->create_links();     
        $this->load->view('notification', $data);
        $this->load->view('footer');
    }
    function notification_insert()
    {
       
        $this->load->model('crmmodel');   
          $this->form_validation->set_rules('cname', 'Notification', 'required');
          $this->form_validation->set_rules('doi', 'From Date', 'required');
          $this->form_validation->set_rules('dob', 'To Date', 'required');
        if ($this->form_validation->run() == FALSE) {
             $this->session->set_flashdata( 'failed', validation_errors());
            } else {
        $dateformat=date('Y-m-d', strtotime($this->input->post('doi')));
        $dateformat1=date('Y-m-d', strtotime($this->input->post('dob')));
        $data = array(
        'notification' => $this->input->post('cname'),
        'created_by'=>$this->session->userdata('id'),
        'from'=>$dateformat,
        'to'=>$dateformat1,    
        );
        $result= $this->crmmodel->insert_query_('notification',$data);
         if($result==FALSE){
                   $this->session->set_flashdata('failed', 'Income already Existed' );
                }else{
                $this->session->set_flashdata('success', 'Income Inserted Successfully' );
                }
            }
       redirect("crm/notification");
    }

}

?>
