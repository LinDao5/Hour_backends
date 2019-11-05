<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */

class Bookuser extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('bookuser_model');
        $this->load->helper('form');
        $this->load->model('Api_model');
        $this->isLoggedIn();
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }


    /**
     * This function is used to load the user list
     */
    function bookuserListing()
    {
        $searchText = $this->security->xss_clean($this->input->post('searchText'));
        $schoolSearch = $this->security->xss_clean($this->input->post('schoolSearch'));
        $classSearch = $this->security->xss_clean($this->input->post('classSearch'));

        $data['searchText'] = $searchText;
        $data['schoolSearch']= $schoolSearch;
        $data['classSearch']=$classSearch;

        $this->load->library('pagination');

        $count = $this->bookuser_model->bookUserListingCount($searchText);

		$returns = $this->paginationCompress ( "bookuserListing/", $count, 10 );

			/* get the all bookUser from db*/
        $data['userRecords'] = $this->bookuser_model->bookuserListing($searchText,$schoolSearch, $classSearch, $returns["page"], $returns["segment"]);
//
        $dataArray['userRecords'] = $this->bookuser_model->bookuserListingArray($searchText, $schoolSearch, $classSearch, $returns["page"], $returns["segment"]);
            for ($i = 0; $i < $count; $i++){
//
//               $bookInfoWithMobile[$i] = $this->bookuser_model->getbookInfodWithisCurrent($dataArray['userRecords'][$i]['mobile']);
               $getisReadCountWithMobile[$i] = $this->bookuser_model->getisReadCountWithMobile($dataArray['userRecords'][$i]['userId']);
//
//               $bookInfoWithMobiles['bookDatas'][$i] = $bookInfoWithMobile[$i];
//
//                $data['bookDatas'][$i] = $bookInfoWithMobile[$i];
                $data['readingCount'][$i] = $getisReadCountWithMobile[$i];
                $data['allTime'][$i] = $this->getAllTimeWithMobile($dataArray['userRecords'][$i]['userId']);
            }

            $this->global['pageTitle'] = 'CodeInsect : User Listing';

            $this->loadViews("bookUser/bookusers", $this->global, $data, NULL);

    }


    /** get the all readed time with mobile */
    public function getAllTimeWithMobile($userId){

        $time = $this->bookuser_model->getAllTimeWithMobile($userId);
        $num = count($time);
        $allTime = 0;
        for ($i = 0; $i< $num; $i++){
            $allTime = intval($time[$i]['time']) + $allTime;
        }
        return $allTime;
    }


    /**
     * This function is used to load the add new form
     */
    function addBookUserScreen()
    {
            $this->load->model('bookuser_model');
            $data['roles'] = $this->bookuser_model->getUserRoles();
            
            $this->global['pageTitle'] = 'CodeInsect : Add New User';

            $this->loadViews("bookUser/addBookUserScreen", $this->global, $data, NULL);

    }


    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }


    /**
     * This function is used to add new user to the system
     */
    function bookAddNewUser()
    {

            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addBookUserScreen();
            }
            else
            {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'name'=> $name,
                                    'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $this->load->model('bookuser_model');
                $result = $this->bookuser_model->addNewUser($userInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('addBookUserScreen');
            }
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editBookUserScreen($userId = NULL)
    {
        if($userId == null)
        {
            redirect('bookuserListing');
        }
        log_message('error', 'editBookUserScreen(): userId = '.$userId);


        $data['userInfo'] = $this->bookuser_model->getUserInfoWithMobile($userId);
        $isReadCount = $this->bookuser_model->getisReadCountWithMobile($userId);
        $downloadedCount = $this->bookuser_model->getDownloadedCountWithMobile($userId);
        $allTime = $this->getAllTimeWithMobile($userId);
        $attentionCount = $this->bookuser_model->getAttentionCountWithMobile($userId);
        $favouriteCount =  $this->bookuser_model->getFavouriteCountWithMobile($userId);
//        $identifyImage = $this->bookuser_model->getImageUrlWithMobile($userId);
//
        $data['count'] = array('isReadCount' => $isReadCount,
                               'downloadedCount' => $downloadedCount,
                                'attentionCount' => $attentionCount,
                                'favouriteCount' => $favouriteCount,
                                'allTime' => $allTime);

        $this->global['pageTitle'] = 'CodeInsect : Edit User';

        $this->loadViews("bookUser/editBookUserScreen", $this->global, $data, NULL);

    }
    
    
    /**
     * This function is used to edit the bookUser information
     */
    function updateBookUser()
    {
//            $this->load->library('form_validation');

        $data['userId'] = $this->input->post('userId', TRUE);
        $data['userSerial'] = $this->input->post('userSerial', TRUE);
        $data['nickName'] = $this->input->post('nickName', TRUE);
        $data['mobile'] = $this->input->post('mobile', TRUE);
        $data['name'] = $this->input->post('name', TRUE);
        $data['studId'] = $this->input->post('studId', TRUE);
        $data['school'] = $this->input->post('school', TRUE);
        $data['class'] = $this->input->post('class', TRUE);
        $data['identyStatus'] = $this->input->post('identyStatus', TRUE);
        $data['faceStatus'] = $this->input->post('faceStatus', TRUE);
//        $data['isReadCount'] = $this->input->post('isReadCount', TRUE);
//        $data['downloadedCount'] = $this->input->post('downloadedCount', TRUE);
//        $data['attentionCount'] = $this->input->post('attentionCount', TRUE);
//        $data['favouriteCount'] = $this->input->post('favouriteCount', TRUE);
//        $data['allTime'] = $this->input->post('allTime', TRUE);
//        $data['identifyImage'] = $this->input->post('identifyImage', TRUE);

        $this->bookuser_model->updateBookUser($data);

        redirect('bookuserListing');
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteBookUser()
    {
        $userid = $this->input->post('userid');
        log_message('error', 'Bookuser(): deletingBookuser_id = '.$userid);
        $bookUserInfo = array('isDeleted'=> '1');

        $result = $this->bookuser_model->deleteBookUser($userid, $bookUserInfo);
        if ($result > 0) { echo(json_encode(array('res'=>TRUE))); }
        else { echo(json_encode(array('res'=>FALSE))); }

    }
    
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }

    /**
     * This function used to show login history
     * @param number $userId : This is user id
     */
    function loginHistoy($userId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $userId = ($userId == NULL ? 0 : $userId);

            $searchText = $this->input->post('searchText');
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');

            $data["userInfo"] = $this->user_model->getUserInfoById($userId);

            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->loginHistoryCount($userId, $searchText, $fromDate, $toDate);

            $returns = $this->paginationCompress ( "login-history/".$userId."/", $count, 10, 3);

            $data['userRecords'] = $this->user_model->loginHistory($userId, $searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : User Login History';
            
            $this->loadViews("loginHistory", $this->global, $data, NULL);
        }        
    }

    /**
     * This function is used to show users profile
     */
    function profile($active = "details")
    {
        $data["userInfo"] = $this->user_model->getUserInfoWithRole($this->vendorId);
        $data["active"] = $active;
        
        $this->global['pageTitle'] = $active == "details" ? 'CodeInsect : My Profile' : 'CodeInsect : Change Password';
        $this->loadViews("profile", $this->global, $data, NULL);
    }

    /**
     * This function is used to update the user details
     * @param text $active : This is flag to set the active tab
     */
    function profileUpdate($active = "details")
    {
        $this->load->library('form_validation');
            
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]|callback_emailExists');        
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile($active);
        }
        else
        {
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $email = strtolower($this->security->xss_clean($this->input->post('email')));
            
            $userInfo = array('name'=>$name, 'email'=>$email, 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->editUser($userInfo, $this->vendorId);
            
            if($result == true)
            {
                $this->session->set_userdata('name', $name);
                $this->session->set_flashdata('success', 'Profile updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Profile updation failed');
            }

            redirect('profile/'.$active);
        }
    }

    /**
     * This function is used to change the password of the user
     * @param text $active : This is flag to set the active tab
     */
    function changePassword($active = "changepass")
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile($active);
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password is not correct');
                redirect('profile/'.$active);
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }
                
                redirect('profile/'.$active);
            }
        }
    }


    /** upload identify image(front &  back) and face image from client*/
    public function uploadIdentifyFrontImage() {
        header('Content-Type: application/json');

        $userId = $this->input->post('userId');
        $mobile = $this->input->post('mobile');
        log_message('error', 'uploadImage: userId = '.$userId);
        $data['userId'] = $userId;
        $data['mobile'] = $mobile;
        $config['upload_path']   = $_SERVER['DOCUMENT_ROOT']."/Hour/assets/upload/identify/".$mobile;

        if (!file_exists($config['upload_path'])){
            mkdir($config['upload_path'], 0777, true);
        }

        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 2048;
        $now = time();
        $config['file_name'] = "front_$now";
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('front')) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        }else {
            $upload_data = $this->upload->data();

            //get the uploaded file name
//            $data['fileName'] = $_FILES['front']['name'];
            $data['idCardFront'] = "assets/upload/identify/".$mobile."/".$upload_data['file_name'];

            $this->bookuser_model->updateBookUser($data);
        }
        redirect('editBookUserScreen/'.$data['userId']);
    }


    public function uploadIdentifyBackImage() {

        header('Content-Type: application/json');
        $userId = $this->input->post('userId');
        $mobile = $this->input->post('mobile');
        $data['userId'] = $userId;
        log_message('error', 'uploadImage: userId = '.$userId);
        $config['upload_path']   = $_SERVER['DOCUMENT_ROOT']."/Hour/assets/upload/identify/".$mobile;

        if (!file_exists($config['upload_path'])){
            mkdir($config['upload_path'], 0777, true);
        }

        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 2048;
        $now = time();
        $config['file_name'] = "back_$now";
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('back')) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        }else {

            $upload_data = $this->upload->data();

            //get the uploaded file name
//            $data['fileName'] = $_FILES['back']['name'];
            $data['idCardBack'] = "assets/upload/identify/".$mobile."/".$upload_data['file_name'];

            $this->bookuser_model->updateBookUser($data);
        }

        redirect('editBookUserScreen/'.$data['userId']);
    }


    public function uploadFaceImage() {

        header('Content-Type: application/json');
        $userId = $this->input->post('userId');
        $mobile = $this->input->post('mobile');
        $data['userId'] = $userId;
        log_message('error', 'uploadImage: userId = '.$userId);
        $config['upload_path']   = $_SERVER['DOCUMENT_ROOT']."/Hour/assets/upload/face/".$mobile;

        if (!file_exists($config['upload_path'])){
            mkdir($config['upload_path'], 0777, true);
        }

        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 2048;
        $now = time();
        $config['file_name'] = "face_$now";
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('face')) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        }else {

            $upload_data = $this->upload->data();

            //get the uploaded file name
//            $data['fileName'] = $_FILES['back']['name'];
            $data['faceImageUrl'] = "assets/upload/face/".$mobile."/".$upload_data['file_name'];

            $this->bookuser_model->updateBookUser($data);
        }

        redirect('editBookUserScreen/'.$data['userId']);
    }

}
?>