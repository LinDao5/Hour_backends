<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Reg extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');

        $this->load->model('OauthUser_model');
        $this->load->model('Api_model');

    }


    public function index()
    {

    }


    /**    register part*/
    /**  when user register  , get otp from server by mobile*/
    public function verifyCode(){

        $mobile = $_POST['mobile'];

        $otp = rand(100000, 999999);
        $created = date('Y-m-d H:i:s');
        $tempUser = array(
            'mobile'  => $mobile,
            'otp' => $otp,
            'created' => $created
        );


        $res = [];
        do {
            if (is_null($_POST['mobile'])|| $_POST['mobile'] == "") {
                $res = array('res' => 'fail', 'err' => '请输入手机号码');
                break;
            }

            if($this->Api_model->isExistBookUser($mobile) || $this->OauthUser_model->isExistOauthUser($mobile)) {
                $res = array('res' => 'fail', 'err' => '存在相同的手机号码');
                break;
            }

            $prevOtp = $this->Api_model->getOtpFromTemp($mobile);
            if($prevOtp != null)  {
                $to = strtotime($prevOtp['created']);
                $from = strtotime($created);

                $timeDiff =  $from - $to;
                if($timeDiff < 60) {
                    $res = array('res' => 'fail', 'err' => '请在' . (60 - $timeDiff) . 's后点击');
                    break;
                }
            }

            $tempId = $this->Api_model->insertOtp($tempUser);

            try{
                $this->post(SMS_URL, array(
                    'action' => 'send',
                    'userid' => SMS_USERID,
                    'account' => SMS_ACCOUNT,
                    'password' => SMS_TOKEN,
                    'mobile' => $mobile,
                    'content' => '您的验证码是：'.$otp.'请不要把验证码泄露给其他人。【hours阅读】'
                ));
            } catch(Exception $e){
                log_message('error', "verifyCode".$e->getMessage());
                $res = array('res' => 'fail', 'err' => '短信发送失败');
                break;
            }

            $res = array('res' => 'success', 'tempId' => $tempId);

        } while(false);

        echo (json_encode($res));
    }


    /** for the SMS */
    function post($url, $postVars = array()){
        //Transform our POST array into a URL-encoded query string.
        $postStr = http_build_query($postVars);
        //Create an $options array that can be passed into stream_context_create.
        $options = array(
            'http' =>
                array(
                    'method'  => 'POST', //We are using the POST HTTP method.
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postStr //Our URL-encoded query string.
                )
        );
        //Pass our $options array into stream_context_create.
        //This will return a stream context resource.
        $streamContext  = stream_context_create($options);
        //Use PHP's file_get_contents function to carry out the request.
        //We pass the $streamContext variable in as a third parameter.
        $result = file_get_contents($url, false, $streamContext);
        //If $result is FALSE, then the request has failed.
        if($result === false){
            //If the request failed, throw an Exception containing
            //the error.
            $error = error_get_last();
            throw new Exception('POST request failed:'.$error['message']);
        }
        //If everything went OK, return the response.
        return $result;
    }


    /** confirm with  otp from client*/
    public function confirmVerify(){

        $otp = $_POST['otp'];
        $mobile = $_POST['mobile'];
        $password = $_POST['password'];
        $confirmcreate_at = date("Y-m-d H:i:s");

        $prevOtp = $this->Api_model->getOtpFromTemp($mobile);

        do{
            if($prevOtp != null)  {
                $to = strtotime($prevOtp['created']);
                $from = strtotime($confirmcreate_at);

                $timeDiff =  ($from - $to) / 60;
                if($timeDiff > 3) {
                    $res = array('res' => 'fail', 'err'=> '验证码是旧的, 请输入新的验证码');
                    break;
                }
            }

            if ($otp == $prevOtp['otp']) {

                $bookUser = array('mobile' => $mobile,
                    'password' => $password,
                    'otp' => $otp,
                    'created_at' => $confirmcreate_at,
                    'verified' => "1");

                //for oauth table
                $this->OauthUser_model->insert($bookUser);
                //for bookUser table
                $result = $this->Api_model->insert($bookUser);

                if ($result == true){
                    $res = array('res' => 'success');
                }else
                    $res = array('res' => 'fail', 'err' => '存在相同的手机号码');

            }elseif ($otp != $prevOtp){
                $res = array('res' => 'fail', 'err' => '不一样的验证码, 请再次输入验证码');
            }
        }while(false);

        echo json_encode($res);

    }


    public function uploadIdentify() {

        $mobile['mobile'] = $_POST['mobile'];
        log_message('error', 'mobile='.$mobile['mobile']);

        $target_dir = $_SERVER['DOCUMENT_ROOT']."/Hour/assets/upload/identify/".$mobile['mobile'];  //todo: in realdb remove "Hour"

        if (!file_exists($target_dir)){
            mkdir($target_dir, 0777, true);
        }

        if(move_uploaded_file($_FILES['front']['tmp_name'], $target_dir."/identify_front.jpg") &&
            move_uploaded_file($_FILES['back']['tmp_name'], $target_dir."/identify_back.jpg")) {

            $mobile['frontIdentifyUrl'] = "assets/upload/face/".$mobile['mobile']. '/identify_front.jpg';
            $mobile['backIdentifyUrl'] = "assets/upload/face/".$mobile['mobile']. '/identify_back.jpg';
            $mobile['identyStatus'] = "1";
            $result = $this->Api_model->uploadIdentify($mobile);
            if ($result == true){
                $res = array("res" => "success");
            }else{
                $res = array('res' => 'fail', 'err' => '操作失败。请再试一次。');
            }
        } else{
            $res = array("res" => "fail", "err" => "操作失败。请再试一次。");
        }

        echo json_encode($res);
    }


    /** upload facestate image and file from client 9/17/19 */
    public function uploadFaceInfo() {

        $mobile['mobile'] = $_POST['mobile'];

        $target_dir = $_SERVER['DOCUMENT_ROOT']."/Hour/assets/upload/face/".$mobile['mobile'];

        if (!file_exists($target_dir)){
            mkdir($target_dir, 0777, true);
        }

        // copy file
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target_dir."/face_image.jpg") &&
            move_uploaded_file($_FILES['feature']['tmp_name'], $target_dir."/face_feature")) {

            $mobile['faceImageUrl'] = "assets/upload/face/".$mobile['mobile']. '/face_image.jpg';
            $mobile['faceInfoUrl'] = "assets/upload/face/".$mobile['mobile']. '/face_feature';
            $mobile['faceState'] = "1";

            $result = $this->Api_model->uploadFaceInfo($mobile);
            if ($result == true){
                $res = array("res" => "success", 'url' => $mobile['faceInfoUrl']);
            }else{
                $res = array('res' => 'fail', 'err' => "操作失败。请再试一次。");
            }

        } else{
            $res = array("res" => "fail", "err" => "操作失败。请再试一次。");
        }

        echo json_encode($res);
    }


    public function register(){

        $name  = $_POST['name'];
        $mobile = $_POST['mobile'];
        $school = $_POST['school'];
        $class = $_POST['class'];
        $studId = $_POST['studId'];

        $bookUser = array(
            'name'  => $name,
            'mobile' => $mobile,
            'school' => $school,
            'class' => $class,
            'studId' => $studId
        );

        $result = $this->Api_model->updateBookUser($bookUser);

        if ($result == true){
            $res = array('res' => 'success');
        }else{
            $res = array('res' => 'fail', 'err' => '保存失败。请再试一次');
        }

        echo json_encode($res);
    }


    /**  Forgot password part*/
    public function verifyForgot(){

        $otp = rand(100000, 999999);
        $created = date('Y-m-d H:i:s');
        $mobile = $_POST['mobile'];
        $fogotUsers = array(
            'mobile'  => $mobile,
            'otp' => $otp,
            'created' => $created
        );
        log_message('error', 'verifyFogot ='.$_POST['mobile']);

        do{
            if (is_null($mobile)|| $mobile == ""){
                $res = array('res' => 'fail', 'err' => '请输入手机号码');
                break;
            }
            if (!$this->$this->Api_model->isExistBookUser($fogotUsers) || !$this->OauthUser_model->isExistOauthUser($fogotUsers)){
                $res = array('res' => 'fail', 'err' => '不存在手机号码。请输入新的手机号码。');
            }

            $prevOtp = $this->Api_model->getForgotOtp($fogotUsers);
            if($prevOtp != null)  {
                $to = strtotime($prevOtp['created']);
                $from = strtotime($created);

                $timeDiff =  $from - $to;
                if($timeDiff < 60) {
                    $res = array('res' => 'fail', 'err' => '请在' . (60 - $timeDiff) . 's后点击');
                    break;
                }
            }
        }while(false);



        // check if same user with mobile exist
        $checkBookUser = $this->Api_model->isExistBookUser($fogotUsers);
        $checkOauthUser = $this->OauthUser_model->isExistOauthUser($fogotUsers);
        $checkTemUser = $this->Api_model->getForgotOtp($fogotUsers);

        if($checkBookUser == "mobile"){

            // if user click otp button double in 32s, invalidate it.
            $this->isDoubleClick($created, $checkTemUser['created']);

            if ($checkOauthUser == true){

                $res = array('res' => 'success');

                //  SMS verifycode  forgot part/
                try{
                    $this->post('http://sh2.ipyy.com/sms.aspx', array(
                        'action' => 'send',
                        'userid' => '9437',
                        'account' => 'yinyuelaoshi',
                        'password' => '5D549AA7D70E3B09A445C781C15F923A',
                        'mobile' => $_POST['mobile'],
                        'content' => '您的验证码是：'.$otp.'请不要把验证码泄露给其他人。【hours阅读】'
                    ));
                }catch(Exception $e){
                    echo $e->getMessage();
                    log_message('error', "verifyCode".$e->getMessage());
                }
            }else{
                $res = array('res' => 'fail', 'err' => '保存失败。请再试一次');
            }

        }else if ($checkBookUser == 'no'){
            $res = array('res' => 'fail', 'err' => '不存在手机号码。请输入新的手机号码。');
        }

        echo (json_encode($res));

    }


    public function confirmForgot(){

        $otp = $_POST['otp'];
        $mobile = $_POST['mobile'];
        $password = $_POST['password'];

        $otpFromServer = $this->Api_model->getOtpFromForgot($mobile);

        if ($otp == $otpFromServer['otp']) {
            $fogotUsers = array('mobile' => $otpFromServer['mobile'],
                'verified' => "1",
                'password' => sha1($password));
            $result = $this->Api_model->confirmForgot($fogotUsers);
            if ($result == true){
                $res = array('res' => 'success');
            }
        }elseif ($otp != $otpFromServer){
            $res = array('res' => 'fail', 'err' => 'not same otp');
        }

        echo json_encode($res);

    }


    public function identify(){
        $identify = array(
            'userId' => $_POST['userId'],
            'identyStatus' => $_POST['identyStatus'],
            'faceState' => $_POST['faceState']
        );
        $userId = $identify['userId'];
        $result = $this->Api_model->updateBookUser($identify, $userId);
        if ($result == true){
            $res = array('res' => 'success');
        }else{
            $res = array('res' => 'fail');
        }

        echo (json_encode($res));
    }


    /**  face login part*/
    //  send mobile & faceStateInfo from server where face_using_state is active to client
    public function sendAllFaceStateInfo(){

        $result = $this->Api_model->getAllFaceStateInfo();

        echo json_encode($result);

    }


//   check mobile sent from client  with db & send token
    function faceLogin() {

        $username = $_POST['username'];
        $this->server->password_faceLogin($username);

    }


    function getFaceSateInfo() {

        $mobile['mobile'] = $_POST['username'];
//      because don't get password from db, so make  the special password by hand.

        $result = $this->Api_model->getFaceInfoUrl($mobile);
        if (!empty($result)){
            $res = array('res' => 'success', 'data' => $result);
        }elseif (empty($result)){
            $res = array('res' => 'fail');
        }
        echo json_encode($res);
    }


    public function getFaceInfoUrl(){

        $mobile = $_POST['mobile'];
        $result = $this->Api_model->getFaceInfoUrl($mobile);

        if (!is_null($result)){
            $res = array('res' => 'success', 'data' => $result);
        }else{
            $res = array('res' => 'fail');
        }

        echo json_encode($res);
    }
}

?>