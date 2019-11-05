<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Api extends CI_Controller
{

    function __construct()
    {
//        @session_start();
        parent::__construct();
        $this->load->helper('url');

        $this->load->model('OauthUser_model');
        $this->load->model('Api_model');
//
//        $this->load->library("Server", "server");
//        $this->server->require_scope("userinfo cloud file node");//you can require scope here

    }


    public function index()
    {
        $this->load->library("Server", "server");
//        $token = $this->server->get_access_token_data();

    }


    /**  count of the book according to catetgory when turn over from login to main */
    public function searchList()
    {
//      get the mobile from token
        $access_token = $_POST['access_token'];
        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];

        $allBookListCount = $this->Api_model->allBookListCount();
        $bookUserDownloadedCount = $this->Api_model->bookUserDownloadedCount($mobile);
        $bookUserisReadCount = $this->Api_model->bookUserisReadCount($mobile);
        $bookUserisNotReadCount = $this->Api_model->bookUserisNotReadCount($mobile);
        $bookUserFavouriteCount = $this->Api_model->bookUserFavouriteCount($mobile);
//        $allBookData = $this->Api_model->searchAllBook();
//        $bookDatawithMobile = $this->searchAllBookandDownloaded();
        $searchList = array('all' => $allBookListCount,
            'DownloadedCount' => $bookUserDownloadedCount,
            'isReadCount' => $bookUserisReadCount,
            'isNotReadCount' => $bookUserisNotReadCount,
            'FavouriteCount' => $bookUserFavouriteCount);

        echo(json_encode($searchList));

    }


    public function getFaceInfoUrl(){

        $access_token = $_POST['access_token'];
        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];

        $result = $this->Api_model->getFaceInfoUrl($mobile);

        if (!is_null($result)){
            $res = array('res' => 'success', 'data' => $result);
        }else{
            $res = array('res' => 'fail');
        }

        echo json_encode($res);

    }


    public function getbookuserinfo(){

        $access_token = $_POST['access_token'];
        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];

        $result = $this->Api_model->getbookuserinfo($mobile);

        if (!is_null($result)){
            $res = array('res' => 'success', 'data' => $result);
        }else{
            $res = array('res' => 'fail', 'err' => 'no data');
        }

        echo json_encode($res);
    }



    /**  add items to all bookData  according to mobile, send to client*/
    public function searchAllBookwithMobile()
    {

        $access_token = $_POST['access_token'];

        $mobile = $this->OauthUser_model->getMobileFromToken($access_token);

        $num = json_encode($_SESSION['num']);
        $num1 = $num+ 1;

        $this->session->set_userdata('num', $num1);

        $this->load->library('pagination');
        $allBookListCount = $this->Api_model->allBookListCount();

        if ($num == 1){
            $result = $this->Api_model->searchAllBookArray(5,  $num);
        }elseif (($num+1) * 5  < $allBookListCount){
            $result = $this->Api_model->searchAllBookArray(5,  $num  );
        }else{
            $this->session->set_userdata('num', 0);
            $result = $this->Api_model->searchAllBookArray(5,  1 );
        }


        $allbookId = $this->Api_model->getbookIdWithMobile($mobile['user_id']);
        $bookId = $this->Api_model->getbookIdWithisRead($mobile['user_id']);
//      get the data(key: page, endPoint, time) accoridng to mobile
        $bookData = $this->Api_model->getbookDataWithMobile($mobile['user_id']);

//      initialize all item' s value
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]['isRead'] = "0";
            $result[$i]['page'] = "";
            $result[$i]['endPoint'] = "";
            $result[$i]['time'] = "";
        }

//       add value to item if user is done reading.
        for ($i = 0; $i < count($result); $i++) {

            for ($j = 0; $j < count($bookId); $j++) {

                if ($result[$i]['bookId'] == $bookId[$j]['bookId']) {
                    $result[$i]['isRead'] = "1";
                    break;
                }

            }
        }

//      add value to item from server according to mobile  9/16/19
        for ($i = 0; $i < count($result); $i++) {

            for ($j = 0; $j < count($allbookId); $j++) {

                if ($result[$i]['bookId'] == $allbookId[$j]['bookId']) {
                    $result[$i]['page'] = $bookData[$j]['page'];
                    $result[$i]['endPoint'] = $bookData[$j]['endPoint'];
                    $result[$i]['time'] = $bookData[$j]['time'];
                    break;
                }
            }
        }

        $count = count($result);
        for ($k = 0; $k < $count; $k++) {
            $data1[] = $result[$k];
        }
        $data2 = $data1;

        if (!is_null($data2)) {
            $res = array('res' => 'success', 'data' => $data2);
        } else {
            $res = array('res' => 'fail', 'data' => 'null');
        }
        echo json_encode($res);

    }


    public function searchAllBook()
    {

        $result = $this->Api_model->searchAllBook();


        echo(json_encode($result));
    }


     /**  when user download book ,  mark it to server with bookId and mobile*/
    public function notifyServerBookDownLoaded(){
        $access_token = $_POST['access_token'];
        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
         $mobile = $mobileArray['user_id'];

        $bookId = $_POST['bookID'];

        $bookName = $this->Api_model->getBookInfowithBookId($bookId);

        $bookUser = array('bookId' => $bookId, 'bookName' => $bookName['bookName'], 'mobile' => $mobile, 'downloaded' => "已下载");
//
        $result = $this->Api_model->isExistSameBookId($bookUser);
//
        if ($result == "no"){
            $this->Api_model->notifyServerBookDownLoaded($bookUser);
            $res = array('res' => 'success');
        }elseif ($result == 'bookId')
            $res = array('res' => 'fail');

        echo json_encode($res);
    }


    /** when user click every item, send book data on mobile*/
    public function searchDownloadedBook()
    {

        $access_token = $_POST['access_token'];
        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];
        $result = $this->Api_model->searchDownloadedBook($mobile);

        $res = array('res' => 'success', 'data' => $result);

        echo(json_encode($res));
    }


    public function searchisReadBook()
    {

        $access_token = $_POST['access_token'];
        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];
        $result = $this->Api_model->searchisReadBook($mobile);

        $res = array('res' => 'success', 'data' => $result);

        echo(json_encode($res));
    }


    public function searchisNotReadBook()
    {

        $access_token = $_POST['access_token'];
        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];
        $result = $this->Api_model->searchisNotReadBook($mobile);

        $res = array('res' => 'success', 'data' => $result);

        echo(json_encode($res));
    }


    public function searchFavouriteBook()
    {

        $access_token = $_POST['access_token'];
        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];
        $result = $this->Api_model->searchFavouriteBook($mobile);

        $res = array('res' => 'success', 'data' => $result);

        echo(json_encode($res));
    }


    public function searchCategory()
    {

        $allBookListCount = $this->Api_model->allBookListCount();
        $recommendCount = $this->Api_model->recommendCount();
        $scienceCount = $this->Api_model->scienceCount();
        $artCount = $this->Api_model->artCount();
        $societyCount = $this->Api_model->societyCount();
        $attentionCount = $this->Api_model->attentionCount();

        $searchList = array('all' => $allBookListCount,
            'recommendCount' => $recommendCount,
            'scienceCount' => $scienceCount,
            'artCount' => $artCount,
            'societyCount' => $societyCount,
            'attentionCount' => $attentionCount);

        $res = array('res' => 'success', 'data' => $searchList);

        echo(json_encode($res));
//        echo (json_encode($searchList));
    }


    /**  receive the reading time for updating from client according to bookId  */
    public function updatePageWithMobile()
    {

        $access_token = $_POST['access_token'];
        $data = array('page' => $_POST['page'],
            'bookId' => $_POST['bookId']);

        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];

        $result = $this->Api_model->updatePageWithMobile($data, $mobile);

        if ($result == true) {
            $res = array('res' => 'success');
        } else
            $res = array('res' => 'fail');
        echo json_encode($res);

    }


    public function updateTimeWithMobile()
    {

        $access_token = $_POST['access_token'];
        $data = array('time' => $_POST['time'],
            'bookId' => $_POST['bookId']);

        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];

        $result = $this->Api_model->updateTimeWithMobile($data, $mobile);

        if ($result == true) {
            $res = array('res' => 'success');
        } else
            $res = array('res' => 'fail');
        echo json_encode($res);
    }


    public function updateendPointWithMobile()
    {

        $access_token = $_POST['access_token'];
        $data = array('endPoint' => $_POST['endPoint'],
            'bookId' => $_POST['bookId']);

        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];

        $result = $this->Api_model->updateendPointWithMobile($data, $mobile);

        if ($result == true) {
            $res = array('res' => 'success');
        } else
            $res = array('res' => 'fail');
        echo json_encode($res);
    }


    public function updateParamWithMobile(){

        $access_token = $_POST['access_token'];
        $params = array('endPoint' => $_POST['endPoint'],
                         'bookId' => $_POST['bookId'],
                         'time' => $_POST['time'],
                         'page' => $_POST['page'],
                         'bookId' => $_POST['bookId'],
                          'isCurrent' => "1");

        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];

        $result = $this->Api_model->updateParamWithMobile($params, $mobile);

        if ($result == true) {
            $res = array('res' => 'success');
        } else
            $res = array('res' => 'fail');
        echo json_encode($res);
    }


    //    for the bookFragment
    public function getDownloadedStateWithMobile(){

        $access_token = $_POST['access_token'];
        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];

        $result = $this->Api_model->getDownloadedStateWithMobile($mobile);
        $res = array('res' => 'success' , 'data' => $result);

        echo  json_encode($res);
    }


    public function addfavouriteCount()
    {

        $bookId = $_POST['bookId'];

        $res = $this->Api_model->addfavouriteCount($bookId);

        echo(json_encode($res));
    }


    public function addreceiveInfoCount()
    {

        $bookId = $_POST['infoId'];

        $res = $this->Api_model->addreceiveInfoCount($bookId);

        echo(json_encode($res));
    }


    public function addAttentionCount()
    {

        $bookId = $_POST['bookId'];

        $res = $this->Api_model->addAttentionCount($bookId);

        echo(json_encode($res));
    }


    public function addReadingCount()
    {

        $bookId = $_POST['bookId'];

        $res = $this->Api_model->addReadingCount($bookId);

        echo(json_encode($res));
    }


    public function addReadedCount()
    {
        $bookId = $_POST['bookId'];

        $res = $this->Api_model->addReadedCount($bookId);

        echo(json_encode($res));
    }


    public function saveUserBookInfo()
    {

        $bookInfo = array('nickName' => $_POST['nickName'],
            'bookName' => $_POST['bookName'],
            'process' => $_POST['process'],
            'time' => $_POST['process'],
            'averageTime' => $_POST['averageTime'],
            'collection' => $_POST['collection'],
            'isRead' => $_POST['isRead'],
            'isCurrent' => $_POST['isCurrent'],
            'attention' => $_POST['attention']);

        $res = $this->Api_model->saveUserBookInfo($bookInfo);

        echo(json_encode($res));
    }


    /**   个人中心   API*/
    public function feedback()
    {

        $access_token = $_POST['access_token'];
        $feedback = $_POST['Information'];
        $submitTime = date("Y-m-d H:i:s");

        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];

        $data = array('Information' => $feedback,
            'date' => $submitTime,
            'mobile' => $mobile);

        $result = $this->Api_model->feedback($data);

        if ($result == true) {
            $res = array('res' => 'success');
        } else {
            $result = array('res' => 'fail');
        }

        echo json_encode($res);
    }


    public function updatePassword()
    {

        $access_token = $_POST['access_token'];
        $oldPassword = $_POST['oldPass'];
        $newPassword = $_POST['newPass'];

        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];

        $shaPassword = $this->Api_model->getOldPass($mobile);
        if (sha1($oldPassword) == $shaPassword["password"]) {

            $result = $this->Api_model->updatePassword($mobile, $newPassword);
            if ($result == true) {
                $res = array('res' => 'success');
            }
        } elseif (sha1($oldPassword) != $shaPassword['password']) {
            $res = array('res' => 'fail', 'err' => 'oldPass');
        }

        echo json_encode($res);
    }


//   when user update phone number, send the verify code and save new Password in temp db.
    public function getupdateMobileOtp()
    {
        $otp = rand(100000, 999999);
        $access_token = $_POST['access_token'];

        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = array('mobile' => $mobileArray['user_id']);

        $tempUser = array(
            'mobile' => $mobileArray['user_id'],
            'password' => "",
            'updateMobile' => $_POST['updateMobile'],
            'otp' => $otp,
            'verified' => 0
        );

//         check if same user with mobile exist
        $check = $this->Api_model->isExist($mobile);

        if ($check == "mobile") {

            $tempId = $this->Api_model->insertOtp($tempUser);
            $res = array('res' => 'success', 'tempId' => $tempId);

//            $subject = "Hours Reading MobileNUmber Verification";
//            $message = "Hello $mobile,\n\nVerify that you own $mobile.\n\nYou may be asked to enter this confirmation code:\n\n$otp\n\nRegards,\nAndroid Learning.";
//            $from = "Hours@androidlearning.in";
//            $headers = "From:" . $from;
//
//            mail($mobile,$subject,$message,$headers);

            $result = $this->post('http://sh2.ipyy.com/sms.aspx', array(
                'action' => 'send',
                'userid' => '9437',
                'account' => 'yinyuelaoshi',
                'password' => '5D549AA7D70E3B09A445C781C15F923A',
                'mobile' => $mobileArray['user_id'],
                'content' => '您的验证码是：'.$otp.'请不要把验证码泄露给其他人。【hours阅读】'
            ));
            echo $result;

        } elseif ($check == "no") {
            $res = array('res' => 'fail', 'err' => 'empty mobile');
        }

        echo json_encode($res);

    }


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
            throw new Exception('POST request failed: ' . $error['message']);
        }
        //If everything went OK, return the response.
        return $result;
    }


    public function confirmUpdateMobile()
    {

        $otp = $_POST['otp'];
        $access_token = $_POST['access_token'];

//      get phone number from oauth_user db with token which is send from client
        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];

        $otpFromServer = $this->Api_model->getOtpFromTemp($mobile);

        if ($otp == $otpFromServer['otp']) {
            $tempUser = $this->Api_model->getMobilePassFromTemp($otp);

            $oldMobile = $tempUser['mobile'];
            $newMobile = array('mobile' => $tempUser['updateMobile']);
//          bacause differ oauth_db and bookuser _db , so differ  parameter.
            $newMobileOauth = array('username' => $tempUser['updateMobile']);

//          check if there is same phone number with updating phone number.
            $check = $this->Api_model->isExist($newMobile);
            if ($check == "no") {
                $this->Api_model->updateMobile($oldMobile, $newMobile);
                $this->OauthUser_model->updateMobile($oldMobile, $newMobileOauth);
                $ress = array('res' => 'success');
            } elseif ($check == "mobile") {
                $ress = array('res' => 'fail', 'err' => 'mobile');

            }
            $res = $ress;
        } elseif ($otp != $otpFromServer['otp']) {
            $res = array('res' => 'fail');
        }

        echo json_encode($res);
    }


//    get the face and identy status according to phone number
    public function getIdentyStatus()
    {

        $access_token = $_POST['access_token'];

//      get phone number from oauth_user db with token which is send from client
        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];

//       return faceStateInfomation and identyStatus 's value according to phone number
        $result = $this->Api_model->getIdentyStatus($mobile);
        if ($result['identyStatus'] == "已认证" && $result['faceStateInfo'] != null) {
            $res = array('res' => 'success');
        } elseif ($result['identyStatus'] != "已认证") {
            $res = array('res' => 'fail', 'err' => 'identyStatus');
        } elseif ($result['faceStateInfo'] == null) {
            $res = array('res' => 'fail', 'err' => 'faceStateInfo');
        }

        echo json_encode($res);
    }


    public function updatePersonalInfo()
    {
        $access_token = $_POST['access_token'];

//      get phone number from oauth_user db with token which is send from client
        $mobileArray = $this->OauthUser_model->getMobileFromToken($access_token);
        $mobile = $mobileArray['user_id'];

        $bookUser = array('mobile' => $mobile,
            'name' => $_POST['name'],
            'school' => $_POST['school'],
            'class' => $_POST['class'],
            'studId' => $_POST['studId']);

        $result = $this->Api_model->updateBookUser($bookUser);

        if ($result == true) {
            $res = array('res' => 'success');
        } else {
            $res = array('res' => 'fail');
        }

        echo json_encode($res);
    }
}

?>