<?php
/**
 * Created by PhpStorm.
 * User: vishwas
 * Date: 1/10/2017
 * Time: 12:10 PM
 */
class Model_api extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getTotalPublicDigitalLibrary($id)
    {   
    	$query = $this->db->query('select count(*) AS totalCount from courses where public_library = 1 AND status = "Active"'); 
    
        
        return $query->row()->totalCount;
    }
    public function getTotalPublicDigitalLibrary2($id)
    {   
        $query = $this->db->query('select count(*) AS totalCount from courses where public_library = 1 AND status = "Active"'); 
        // $data['library'] = array(
     //        'totalCount'=>$query->row()->totalCount
     //        );
        //echo json_encode($query->result());
        return $query->row()->totalCount;
    }

    public function checkorganizationavaibility($name,$passcode)
    {
        $where=array("organization_name"=>$name,"organization_password"=>$passcode);
        $query=$this->db->get_where("user",$where);
        return $query->result();
    }

    public function checkuseravaibility($name,$password)
    { //echo $name; echo $password; exit;
        $where=array("email"=>$name,"password"=>$password);
        $query=$this->db->get_where("user",$where);
        return $query->result();
    }

    public function getMyTrainings($userId){
        //$query=$this->db->get_where("training",array("t_id"=>$id));
        //return $query->result();
        $where = 't.from_date <= CURRENT_DATE() AND t.to_date >= CURRENT_DATE() ';

        $this->db->select('t.t_id, `t`.`from_date`,`t`.`to_date`, tp.tg_name');
        $this->db->from("training_user tu");
        //$this->db->from('training');
        $this->db->join('training t', 't.t_id = tu.t_id','left');
        $this->db->join('training_program tp', 'tp.tp_id = t.tp_id','left');
        $this->db->where($where);
        $this->db->where("tu.u_id",$userId);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->result();
    }

    public function getmyprofile($id)
    {
        $this->db->select('`user`.`name`,`user`.`uid`,`user`.`email`,`role`.`role_name`');
        $this->db->from('user');
        $this->db->join('role', 'role.rid = user.role_id','left');
        $this->db->where('uid',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getTrainingDetail($id){
        //$query=$this->db->get_where("training",array("t_id"=>$id));
        //return $query->result();

        $this->db->select('*');
        $this->db->from('training');
        $this->db->join('training_program', 'training_program.tp_id = training.tp_id','left');
        $this->db->where("training.t_id",$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function GetMyPlan1($id,$t_id){
        $currentDateTime = date('Y-m-d H:i:s');
        /*$where = '(
        tc.start_date <= STR_TO_DATE("'.$currentDateTime.'", "%Y-%m-%d %H:%i:%s") AND tc.end_date >= STR_TO_DATE("'.$currentDateTime.'", "%Y-%m-%d %H:%i:%s"))';

        $array = array('tu.u_id' => $id, 'tu.t_id' => $t_id);
        $this->db->select("tu.tu_id,tu.t_id,tu.u_id,tc.t_id,c.cid,c.c_name,c.c_template,c.c_filepath,c.c_type,tc.trc_id,tc.start_date,tc.end_date, sv.'cmi.core.lesson_status' AS lessonStatus,sv.attempt");
        $this->db->from("training_user tu");
        $this->db->join("training_course tc","tc.t_id=tu.t_id");
        $this->db->join("courses c","c.cid=tc.c_id");
        $this->db->join("scormvars_new sv","sv.id=tc.trc_id",'left');
        $this->db->where($where);
        $this->db->where($array);
        $query=$this->db->get();*/


        $query = $this->db->query('SELECT `tu`.`tu_id`, `tu`.`t_id`, `tu`.`u_id`, `tc`.`t_id`,`tc`.`max_attempt`,  `c`.`cid`, `c`.`c_name`, `c`.`c_template`, `c`.`c_filepath`, `c`.`c_type`, `tc`.`trc_id`, `tc`.`start_date`, `tc`.`end_date`, `sv`.`cmi.core.lesson_status` AS lessonStatus, `sv`.`attempt` FROM `training_user` `tu` JOIN `training_course` `tc` ON `tc`.`t_id` = `tu`.`t_id` JOIN `courses` `c` ON `c`.`cid` = `tc`.`c_id` LEFT JOIN `scormvars_new` `sv` ON `sv`.`id` = `tc`.`trc_id` WHERE (
        tc.start_date <= STR_TO_DATE("'.$currentDateTime.'", "%Y-%m-%d %H:%i:%s") AND tc.end_date >= STR_TO_DATE("'.$currentDateTime.'", "%Y-%m-%d %H:%i:%s")) AND `tu`.`u_id` = '.$id.' AND `tu`.`t_id` = '.$t_id.'');

        //echo $this->db->last_query();die;
        return $query->result();
    }

    public function GetMyAssessment($id,$t_id){
        

        $currentDateTime = date('Y-m-d H:i:s');
        $query = $this->db->query('SELECT `ta`.`learn_minute`, `tu`.`tu_id`, `tu`.`t_id`, `tu`.`u_id`, `a`.`as_id`, `a`.`as_id`, `a`.`as_name`, `a`.`as_instruction`, `a`.`as_paper_mode`, `a`.`as_paper_template`, `a`.`as_duration`, `a`.`as_max_attempt`, `a`.`as_pass_marks`, `ta`.`start_date`, `ta`.`end_date`, courses.c_name, `scormvars_new`.`cmi.core.lesson_status` AS courseStatus  FROM `training_user` `tu` JOIN `training_assesment` `ta` ON `ta`.`t_id` = `tu`.`t_id` JOIN `assesment` `a` ON `a`.`as_id` = `ta`.`as_id` LEFT JOIN `scormvars_new` ON `scormvars_new`.`SCOInstanceID` = `ta`.`trc_id` LEFT JOIN `training_course` ON `training_course`.`trc_id` = `ta`.`trc_id` LEFT JOIN `courses` ON `courses`.`cid` = `training_course`.`c_id` WHERE (ta.start_date <= STR_TO_DATE("'.$currentDateTime.'","%Y-%m-%d %H:%i:%s") AND ta.end_date >= STR_TO_DATE("'.$currentDateTime.'","%Y-%m-%d %H:%i:%s")) AND `tu`.`u_id` = '.$id.' AND `tu`.`t_id` = '.$t_id.'');
         //echo $this->db->last_query();die;
        return $query->result();
    }

     public function getAssementDetailsById($userId, $asId){

        //$query=$this->db->get_where("assessment_details",array("user_id"=>$userId, "assessment_id" => $asId));
        //return $query->result();

         $query = $this->db->query('SELECT count(id) totalAttempts, MAX(score) AS HighestScore, COUNT(CASE WHEN `assessment_status` =  2 THEN "complete" END) AS 
        BestStatus, (select score from assessment_details where `user_id` = '.$userId.' AND `assessment_id` = '.$asId.' ORDER BY id DESC LIMIT 1) AS lastScore, (select assessment_status from assessment_details where `user_id` = '.$userId.' AND `assessment_id` = '.$asId.' ORDER BY id DESC LIMIT 1) AS lastStatus FROM `assessment_details` WHERE  `user_id` = '.$userId.' AND `assessment_id` = '.$asId);
        return $query->result();
        /*$query = $this->db->query('SELECT assesment.as_name,assesment.as_instruction, assesment.as_duration,section_assesment.s_id, section_assesment.as_id, section_assesment.s_instruction, section_question_link.qb_id as qb_parent_id, question_bank.qb_id,question_bank.qb_name, question_bank.qb_description, question_bank.qb_type, question_bank.qb_text FROM `assesment` LEFT JOIN `section_assesment` ON `section_assesment`.`as_id` = `assesment`.`as_id` LEFT JOIN `section_question_link` ON `section_question_link`.`s_id` = `section_assesment`.`s_id` LEFT JOIN `question_bank` ON `question_bank`.`qb_parent_id` = `section_question_link`.`qb_id` WHERE `question_bank`.`qb_description` IS NOT NULL AND `section_question_link`.`s_id` IN('.$s_id.')');
        return $query->result();*/

        
        /*$this->db->where("id",$as_id);
        $query=$this->db->get('assessment_details');
        return $query->result();*/
    }

    public function get_Section_assesment($as_id){
        $this->db->where("as_id",$as_id);
        $query=$this->db->get("section_assesment");
        return $query->result();
    }

    public function get_Section_assesment_question($s_id){
        //$this->db->where("s_id",$s_id);
       /* $this->db->where_in("s_id",$s_id);
        $this->db->join("question_bank","question_bank.qb_id=section_question_link.qb_id");
        $query=$this->db->get("section_question_link");*/
        //SELECT * FROM `section_assesment` LEFT JOIN `section_question_link` ON `section_question_link`.`s_id` = `section_assesment`.`s_id` LEFT JOIN `question_bank` ON `question_bank`.`qb_id` = `section_question_link`.`qb_id` WHERE `question_bank`.`qb_description` != " " AND `section_question_link`.`s_id` IN(27,28,29)
        //`question_bank`.`qb_description` IS NOT NULL AND
        $query = $this->db->query('SELECT assesment.as_name,assesment.as_instruction, assesment.as_duration,section_assesment.s_id, section_assesment.as_id, section_assesment.s_instruction, section_question_link.qb_id, question_bank.qb_parent_id,question_bank.qb_name, question_bank.qb_description, question_bank.qb_type, question_bank.qb_text FROM `assesment` LEFT JOIN `section_assesment` ON `section_assesment`.`as_id` = `assesment`.`as_id` LEFT JOIN `section_question_link` ON `section_question_link`.`s_id` = `section_assesment`.`s_id` LEFT JOIN `question_bank` ON `question_bank`.`qb_id` = `section_question_link`.`qb_id` WHERE `section_question_link`.`s_id` IN('.$s_id.')');
        return $query->result();
    }

     public function get_Section_assesment_answer($qb_id){
        $this->db->where("qb_id",$qb_id);
        $query=$this->db->get("answer_bank");
        return $query->result();
    }
    

}