<?php

Class Portalmodel extends CI_Model
{

    function login_validate()
    {
        $name=$this->input->post('name'); 
        $password=$this->input->post('password');
        $this->db->select("*"); 
        $this->db->from("user");
        $this->db->where('username',$name);
        $this->db->where('password',MD5($password));
        $this->db->where('status','1');
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
            $row=$query->row();
            $data=array(
            'name'=>$row->name,
            'id'=>$row->id,
            'username'=>$row->username,
            'role'=>$row->role,
            'useremail'=>$row->email,  
            );
            $this->session->set_userdata($data);
            return true;
        }
        else{
            return false;
        }
    }
    function deleteid($table,$cond,$id)
    {
    $this->db->where($cond,$id);
   $this->db->delete($table);
   return true;
 // return $this->output->enable_profiler(TRUE);;
    }
    
    
     function insert($data){
       $this->db->where($data);
       $query = $this->db->get('project');
       $count_row = $query->num_rows();
       if ($count_row > 0) {
           return TRUE;
       } else {
           $this->db->insert('project', $data);
          // $path=$this->db->insert_id();
       }
   }
    public function record_count($tablename) {
        return $this->db->count_all($tablename);
    }
    public function record_count_where($tablename,$where) {
        if($where !='' && $where!='1'){
        $this->db->where($where);
        }$this->db->from($tablename);
        $count = $this->db->count_all_results();
        return $count;
    }
    public function select($limit, $start,$tablename) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
    public function select_where($limit, $start,$tablename,$where) {
        $this->db->limit($limit, $start);
        $this->db->where($where);
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    function get_dropdown_list($table,$id,$name,$where)
    {
        $select=$id.','.$name;
        $this->db->select($select); //change this to the two main values you want to use
        $this->db->from($table);
    if($where!=""){
        $this->db->where($where);
    }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
        $dropdowns = $query->result();
        $data[''] = 'Please Select'; 
            foreach($query->result_array() as $row){
                $data[$row[$id]]=$row[$name];
                }
            return $data;
        } else { return false;    }     // return false if no items for dropdown         
    }
    function insert_query($table,$data,$data1)
    {
        $this->db->where($data1);
        $query = $this->db->get($table);
        $count_row = $query->num_rows();
         if ($count_row > 0) {
            return FALSE;
         } else {
            $this->db->insert($table, $data);
          return  $id=$this->db->insert_id();          
        }
    }
    function insert_query_($table,$data)
    {
        $this->db->insert($table, $data);
        $id=$this->db->insert_id();          
    }
    function update_query($table,$data,$id,$cond){
        $this->db->where($cond, $id);
        $this->db->update($table, $data);
        //return true;
    }

    function list_select($tablename,$cond,$id)
    {
        $result = $this->db->from($tablename)
            ->where($cond,$id)
            ->get();
        return $result->result_array();  
    }
    function list_select1($tablename)
    {
        $result = $this->db->from($tablename)     
                ->get();
        return $result->result();  
    }
    function selectdocuments($limit, $start,$tablename) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
            $result = $this->db->select('file_category')
            ->from('file_category')
            ->where('file_catid',$row->file_category)
            ->get();
            $row['filecat']=$result;//$this->list_select1($row->file_category);
            $data[] = $row();
            }
            return $data;
        }
        return false;
    }

   public function projectlist()
   {
       //if($where!=""){
        //      $this->db->where($where);
      // }
        $this->db->select('*');
        $this->db->from('project');
        $query = $this->db->get();
         return $query->result();
   }
    public function todaycalender($tablename,$date,$users) {
        $cond="and user_id='$users'";
      $where="app_date ='$date' $cond  ORDER BY `appointments`.`time` ASC";
        $this->db->where($where);
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    } 
   public function calenders($tablename,$year,$month,$users) {
             $cond="";
             if($users!="" ){            
             $cond.="and user_id='$users'";
             } 
        $where="YEAR(app_date)='$year' AND MONTH(app_date) ='$month' $cond  GROUP BY app_date";
        $this->db->select(" GROUP_CONCAT(time,  '-', notes, '/') as notes,app_date");
        $this->db->where($where);
        $query = $this->db->get($tablename);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    } 
    function clientlist($limit, $start,$cond)
    {
        $this->db->limit($limit, $start);
        $this->db->select('id,first_name,last_name,intake.status as status,accept_again,doi,dob,client_id,intakeid');
        $this->db->from('intake');
        $this->db->join('client', 'intake.id= client.intakeid');
            if($cond!="" ){            
              $this->db->where($cond);
            } 
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
             foreach ($query->result() as $row) {
                 $data[] = $row;
             }
             return $data;
         }
        return false;
    }
    function impactreport($cond)
    {
  
        $this->db->select('count(*) as count,SUM(in1-out1) AS avg1,SUM(in2-out2) AS avg2,SUM(in3-out3) AS avg3,SUM(in4-out4) AS avg4,SUM(in5-out5) AS avg5,SUM(in6-out6) AS avg6,SUM(in7-out7) AS avg7,SUM(in8-out8) AS avg8,SUM(in9-out9) AS avg9,SUM(in10-out10) AS avg10');
        $this->db->from('client');
        $this->db->join('impact', 'client_id= client_intake_id');
            if($cond!="" ){            
              $this->db->where($cond);
            } 
        $query = $this->db->get();
         if ($query->num_rows() > 0) {
             foreach ($query->result() as $row) {
                 $data[] = $row;
             }
             return $data;
         }
        return false;
    }
}
?>