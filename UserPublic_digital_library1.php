<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserPublic_digital_library1 extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('UserPublic_digital_library_model');
        $this->load->model('Model_api');
        $this->load->model('UserDashboard_model');
    }

    public function index()
    {
        
    }

    public function dashboardcount($id)
    {
        //echo "hello"; exit;
        $data['library'] = $this->Model_api->getTotalPublicDigitalLibrary($id);
        $data2['myAssessment'] = $this->Model_api->getTotalPublicDigitalLibrary2($id);

        $librarycount = array(
            'library' => $data['library'],
            'assessment' => $data2['myAssessment']
        );
        echo json_encode( $librarycount, JSON_NUMERIC_CHECK );
        // echo $json;
        //echo "<pre>"; print_r($dataa); 
        exit;


    }

    public function organisation_login()
    {
        $name = $_POST['name'];
        $passcode = $_POST['passcode'];
        $request_type = $_POST['request_type'];
        $data['organization_count'] = $this->Model_api->checkorganizationavaibility($name,$passcode);
        if(!empty($data['organization_count'][0]))
        {
            $result['status'] = "True";
            $result['message'] = "Success";

        }else
        {
            $result['status'] = "False";
            $result['message'] = "Failure";
        }
        echo json_encode( $result,JSON_NUMERIC_CHECK );

    }

    public function user_login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $request_type = $_POST['request_type'];
        $password2=md5($password);
        $data = $this->Model_api->checkuseravaibility($email,$password2);
        $user_data = array();
        if(!empty($data[0]))
        {
            $temp['uid'] = $data[0]->uid;
            $temp['username'] = $data[0]->name;
            $user_data[0] = $temp;
            $result['user_data'] = $user_data;
            $result['status'] = "True";
            $result['message'] = "Success";

        }else
        {
            $result['status'] = "False";
            $result['message'] = "Failure";
        }
        echo json_encode( $result,JSON_NUMERIC_CHECK );

    }

    public function my_learning_plan()
    {
        $uid = $_POST['uid']; 
        $data = $this->Model_api->getMyTrainings($uid);
        //echo "<pre>"; print_r($data[0]); exit;
        $planarray = array();
        for($i=0;$i<count($data); $i++)
        {
            
            $temp['t_id'] = $data[$i]->t_id;
            $temp['from_date'] = $data[$i]->from_date;
            $temp['to_date'] = $data[$i]->to_date;
            $temp['tg_name'] = $data[$i]->tg_name;
            $planarray[$i] = $temp;
            // $data2 = array()
        }

        if(!empty($planarray))
        {
            $result['data']     =   $planarray;
            $result['status']   =   'True';
            $result['message']  =   'Success';
        }
        else
        {
            $result['status']='False';
            $result['message']='No Data Found';
        }
        // exit;
        echo json_encode( $result,JSON_NUMERIC_CHECK );
       // $array
    }

    public function get_my_profile()
    {
        
        $uid = $_POST['uid'];
        $userdata=$this->Model_api->getmyprofile($uid); 
        //echo "<pre>"; print_r($userdata); exit;
        $user_data = array();
        if(!empty($userdata[0]))
        {
            
            $temp['uid'] = $userdata[0]->uid;
            $temp['username'] = $userdata[0]->name;
            $temp['email'] = $userdata[0]->email;
            $temp['role_name'] = $userdata[0]->role_name;
            $user_data[0] = $temp;
            $result['user_data'] = $user_data;
            $result['status'] = "True";
            $result['message'] = "Success";

        }else
        {
            $result['status'] = "False";
            $result['message'] = "No Data Found";
        }
        echo json_encode( $result,JSON_NUMERIC_CHECK );

    }

    public function getAssessmentDetail(){
        //echo "<pre>"; print_r($_POST); exit;
        $uid = $_POST['uid'];
        $t_id = $_POST['t_id'];
        
        $data['training_detail'] = $this->Model_api->getTrainingDetail($t_id);
        $training_detail = array();
        $temp1['t_id'] = $data['training_detail'][0]->t_id;
        $temp1['tp_id'] = $data['training_detail'][0]->tp_id;
        $temp1['t_name'] = $data['training_detail'][0]->t_name;
        $temp1['user_count'] = $data['training_detail'][0]->user_count;
        $temp1['from_date'] = $data['training_detail'][0]->from_date;
        $temp1['to_date'] = $data['training_detail'][0]->to_date;
        $temp1['approver_id'] = $data['training_detail'][0]->approver_id;
        $temp1['approval_date'] = $data['training_detail'][0]->approval_date;
        $temp1['notification_duration'] = $data['training_detail'][0]->notification_duration;
        $temp1['notification_type'] = $data['training_detail'][0]->notification_type;
        $temp1['nofication_event'] = $data['training_detail'][0]->nofication_event;
        $temp1['trc_id'] = $data['training_detail'][0]->trc_id;
        $temp1['created_at'] = $data['training_detail'][0]->created_at;
        $temp1['modified_at'] = $data['training_detail'][0]->modified_at;
        $temp1['status'] = $data['training_detail'][0]->status;
        $temp1['tc_id'] = $data['training_detail'][0]->tc_id;
        $temp1['tg_name'] = $data['training_detail'][0]->tg_name;
        $training_detail[0] = $temp1;
        
        $data['All_courses'] = $this->Model_api->GetMyPlan1($uid,$t_id);
        $All_courses = array();

        for($j=0;$j<count($data['All_courses']); $j++)
        {
            $temp2['tu_id'] = $data['All_courses'][$j]->tu_id;
            $temp2['t_id'] = $data['All_courses'][$j]->t_id;
            $temp2['u_id'] = $data['All_courses'][$j]->u_id;
            $temp2['max_attempt'] = $data['All_courses'][$j]->max_attempt;
            $temp2['cid'] = $data['All_courses'][$j]->cid;
            $temp2['c_name'] = $data['All_courses'][$j]->c_name;
            $temp2['c_template'] = $data['All_courses'][$j]->c_template;
            $temp2['c_filepath'] = $data['All_courses'][$j]->c_filepath;
            $temp2['c_type'] = $data['All_courses'][$j]->c_type;
            $temp2['trc_id'] = $data['All_courses'][$j]->trc_id;
            $temp2['start_date'] = $data['All_courses'][$j]->start_date;
            $temp2['end_date'] = $data['All_courses'][$j]->end_date;
            $temp2['lessonStatus'] = $data['All_courses'][$j]->lessonStatus;
            $temp2['attempt'] = $data['All_courses'][$j]->attempt;

            $All_courses[$j] = $temp2;
        }

        @$data['All_assessment'] = $this->Model_api->GetMyAssessment($uid,$t_id);
       
        $data['TrainingId'] = $t_id;
        $All_assessment = array();
        for($i=0;$i<count($data['All_assessment']);$i++){
           
           $temp3['learn_minute'] = $data['All_assessment'][$i]->learn_minute;
           $temp3['tu_id'] = $data['All_assessment'][$i]->tu_id;
           $temp3['t_id'] = $data['All_assessment'][$i]->t_id;
           $temp3['u_id'] = $data['All_assessment'][$i]->u_id;
           $temp3['as_id'] = $data['All_assessment'][$i]->as_id;
           $temp3['as_name'] = $data['All_assessment'][$i]->as_name;
           $temp3['as_instruction'] = $data['All_assessment'][$i]->as_instruction;
           $temp3['as_paper_mode'] = $data['All_assessment'][$i]->as_paper_mode;
           $temp3['as_paper_template'] = $data['All_assessment'][$i]->as_paper_template;
           $temp3['as_duration'] = $data['All_assessment'][$i]->as_duration;
           $temp3['as_max_attempt'] = $data['All_assessment'][$i]->as_max_attempt;
           $temp3['as_pass_marks'] = $data['All_assessment'][$i]->as_pass_marks;
           $temp3['start_date'] = $data['All_assessment'][$i]->start_date;
           $temp3['end_date'] = $data['All_assessment'][$i]->end_date;
           $temp3['c_name'] = $data['All_assessment'][$i]->c_name;
           $temp3['courseStatus'] = $data['All_assessment'][$i]->courseStatus;
           // $temp3['learn_minute'] = $data['All_assessment'][$i]['learn_minute'];
            
            if($data['All_assessment'][$i]->as_id){

                $assessmentDetails=$this->Model_api->getAssementDetailsById($uid, $data['All_assessment'][$i]->as_id);
                $temp3['details']=$assessmentDetails[0];
            }
            $All_assessment[$i] = $temp3;
           
        }
        //echo "<pre>",print_r($data); exit;

         if(!empty($training_detail[0]))
         {
            $result['training_data'] = $training_detail;
            $result['course_data'] = $All_courses;
            $result['assessment_data'] = $All_assessment;
            $result['status'] = "True";
            $result['message'] = "Success";
         }
         else
         {
            $result['status'] = "False";
            $result['message'] = "Failure";
         }

         echo json_encode( $result,JSON_NUMERIC_CHECK );
        
    }

    public function getStartQuestion(){

        //echo $id; echo $TrainingId; //exit;
        //*******************************************
        //error handling not done properly

        $id= $_POST['as_id'];
        $TrainingId = $_POST['t_id'];

        $startquestion = array();
        $section_assessment=$this->Model_api->get_Section_assesment($id);
        // echo "<pre>"; print_r($section_assessment); exit;
        //$data['assessment_id'] = $id;
        $temp['assessment_id'] = $id;
        $sIds = array();
        foreach ($section_assessment as $value) {
            array_push($sIds, $value->s_id);
        }
        $sIds = implode(',', $sIds);
        $temp['TrainingId'] = $TrainingId;
        //$data['TrainingId'] = $TrainingId;
        // echo 

        $temp['assessment'] = $section_assessment;
        //$sIds = '34,35';
        $assessment_question=$this->Model_api->get_Section_assesment_question($sIds);
        //echo "<pre>"; print_r($assessment_question); exit; 
        if($assessment_question){

            for($i=0;$i<count($assessment_question);$i++){

                $temp3['as_name'] = $assessment_question[$i]->as_name;
                $temp3['as_instruction'] = $assessment_question[$i]->as_instruction;
                $temp3['as_duration'] = $assessment_question[$i]->as_duration;
                $temp3['s_id'] = $assessment_question[$i]->s_id;
                $temp3['as_id'] = $assessment_question[$i]->as_id;
                $temp3['s_instruction'] = $assessment_question[$i]->s_instruction;
                $temp3['qb_id'] = $assessment_question[$i]->qb_id;
                $temp3['qb_parent_id'] = $assessment_question[$i]->qb_parent_id;
                $temp3['qb_name'] = $assessment_question[$i]->qb_name;
                // $temp3['qb_description'] = $assessment_question[$i]->qb_description;
                $temp3['qb_type'] = $assessment_question[$i]->qb_type;
                $temp3['qb_text'] = $assessment_question[$i]->qb_text;

                
                if($assessment_question[$i]->qb_description){

                    $assessment_answer=$this->Model_api->get_Section_assesment_answer($assessment_question[$i]->qb_id);
                    $temp3['answer_bank']=$assessment_answer;
                }
                $temp['assmntName'] = $assessment_question[$i]->as_name;
                $temp['assmntDuration'] = $assessment_question[$i]->as_duration;
                $temp['assmntInstruction'] = ($assessment_question[$i]->as_instruction) ? $assessment_question[$i]->as_instruction : 'Good Luck!';
               
                $startquestion[$i] = $temp3;
            }
            $temp['seconds'] = strtotime($temp['assmntDuration']) - strtotime('00:00:00');
            //$data['seconds']= strtotime($data['assmntDuration']) - strtotime('00:00:00');
            
             $data2[] = $temp;
            //$temp['assessment_qu_ans'] = $assessment_question;
            // $result['training_data'] = $training_detail;
            $result['assessment_data'] = $data2;
            $result['assessment_qu_ans'] = $startquestion;
            $result['status'] = "True";
            $result['message'] = "Success";
            $result['status'] = "False";
            $result['message'] = "Failure";
        }
        echo json_encode( $result,JSON_NUMERIC_CHECK );

    }



 
 


}
