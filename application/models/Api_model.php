<?php

class Api_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**  when user regiter , get otp from server by mobile*/
    function isExistBookUser($mobile){

        $query = $this->db->get_where('tbl_bookusers', $mobile);
        if ($query->num_rows() > 0){
            return true;
        }
        return false;
    }


    public function insertOtp($tempUser){

        $this->db->delete('tbl_otp', array('mobile' => $tempUser['mobile']));
        $this->db->insert('tbl_otp', $tempUser);
        return $this->db->insert_id();
    }


//  get the otp from tbl_otp : temp db
    public function getOtpFromTemp($mobile){

        $this->db->select();
        $this->db->from('tbl_otp as BaseTbl');
        $this->db->where('BaseTbl.mobile', $mobile);
        $query = $this->db->get();

        $result = $query->row_array();
        return $result;
    }


    public function insert($bookUser){

        $query = $this->db->get_where('tbl_bookusers', array('mobile' => $bookUser['mobile']));
        if ($query->num_rows() > 0){
            return ;
        }

        $password = sha1($bookUser['password']);
        $bookUsers = array(
            'password'=>$password,
            'otp'  => $bookUser['otp'],
            'created_at' => $bookUser['created_at'],
            'mobile' => $bookUser['mobile'],
            'verified' => $bookUser['verified'],
            'identyStatus' => '0',
            'faceState' => '0'
        );

        $this->db->insert('tbl_bookusers', $bookUsers);
        $this->db->order_by('tbl_bookusers.userId', 'ASC');
//        return $this->db->insert_id();
        return true;
    }


    public function uploadIdentify($mobile){

        $this->db->where('tbl_bookusers.mobile', $mobile['mobile']);
        $result = $this->db->update('tbl_bookusers', $mobile);

        return $result;
    }


    public function uploadFaceInfo($mobile){

        $this->db->where('tbl_bookusers.mobile', $mobile['mobile']);
        $this->db->update('tbl_bookusers', $mobile);

        return true;
    }


    function updateBookUser($bookUser){

        $this->db->where('tbl_bookusers.mobile', $bookUser['mobile']);
        $this->db->update('tbl_bookusers', $bookUser);
        $this->db->trans_complete();

        if ($this->db->trans_status() === false){
            $result = false;
        }else{
            if ($this->db->affected_rows() > 0){
                $result = true;
            }else{
                $result = false;
            }
        }

        return $result;
    }


    /**  forgot Password part*/
    public function insertForgotOtp($tempUser){

        $this->db->delete('tbl_forgotpassword', array('mobile' => $tempUser['mobile']));
        $this->db->insert('tbl_otp', $tempUser);
        return $this->db->insert_id();
    }


    public function getOtpFromFogrot($mobile){

        $this->db->select();
        $this->db->from('tbl_forgotpassword as BaseTbl');
        $this->db->where('BaseTbl.mobile', $mobile);
        $query = $this->db->get();

        $result = $query->row_array();
        return $result;
    }


    public function insertBookInfor($bookUser){
        $bookUserInfo = array('bookName' => "", 'process' => "", 'time' => "", 'averageTime' => "",
            'isRead' => "0", 'collection' => "未收藏", 'isCurrent' => "2",
            'attention' => "", 'state' => "", 'downloaded' => "",'bookId' => "",
            'category' => "", 'mobile' => $bookUser['mobile']);
        $this->db->insert('tbl_book_information', $bookUserInfo);

        $this->db->order_by('tbl_book_information.id', 'ASC');
        $bookUserInfoId = $this->db->insert_id();
        return $bookUserInfoId;
    }


    public function getVerifyOtp($mobile){

        $this->db->select('BaseTbl.otp');
        $this->db->from('tbl_bookusers as BaseTbl');
        $this->db->where('BaseTbl.mobile', $mobile);
        $query = $this->db->get();

        $result = $query->row_array();
        return $result;
    }


    /** face_login part*/
//  get all faceStateInfomation  according to mobile from server where face_use_state is active
    public function getAllFaceStateInfo(){

        $this->db->select('BaseTbl.faceStateInfo, BaseTbl.mobile');
        $this->db->where('BaseTbl.isFaceUsing', "1");
        $this->db->from('tbl_bookusers as BaseTbl');
        $query = $this->db->get();

        $result = $query->result_array();
        return $result;
    }


    public function isUsingFaceUser($mobile, $faceStateInfos){

        $faceStateInfo = $faceStateInfos;

        $this->db->select('BaseTbl.faceStateInfo');
        $this->db->where('BaseTbl.isFaceUsing', "1");
        $this->db->where('BaseTbl.mobile', $mobile);
        $this->db->from('tbl_bookusers as BaseTbl');
        $query = $this->db->get();
        $result = $query->row_array();

        if ($faceStateInfo == $result['faceStateInfo']){
            return true;
        }else
            return false;
        return $result;

    }


    public function getFaceStateInfo($mobile){

        $this->db->select('BaseTbl.faceInfoUrl, BaseTbl.faceImageUrl');
        $this->db->from('tbl_bookusers as BaseTbl');
        $this->db->where('BaseTbl.mobile', $mobile['mobile']);
        $query = $this->db->get();

        $result = $query->row_array();
        return $result;
    }





    public function getFaceInfoUrl($mobile){

        $this->db->select('BaseTbl.faceInfoUrl');
        $this->db->where('BaseTbl.mobile', $mobile);
        $this->db->from('tbl_bookusers as BaseTbl');
        $query = $this->db->get();

        $result = $query->row_array();
        return $result;;
    }


    public function getbookuserinfo($mobile){

        $this->db->select();
        $this->db->where('BaseTbl.mobile', $mobile);
        $this->db->from('tbl_bookusers as BaseTbl');
        $query = $this->db->get();

        $result = $query->row_array();
        return $result;;
    }



    public function confirmVerify($bookUser){

        $bookUsers = array(
            'verified'  => $bookUser['verified']
        );

        $this->db->where('tbl_bookusers.mobile', $bookUser['mobile']);
        $this->db->update('tbl_bookusers', $bookUsers);

        return TRUE;
    }




    public function getOtpFromForgot($mobile){

        $this->db->select();
        $this->db->from('tbl_forgotpassword as BaseTbl');
        $this->db->where('BaseTbl.mobile', $mobile);
        $query = $this->db->get();

        $result = $query->row_array();
        return $result;
    }


    public function confirmForgot($fogotUsers){

        $this->db->where('tbl_bookusers.mobile', $fogotUsers['mobile']);
        $this->db->update('tbl_bookusers', $fogotUsers);

        return true;
    }


    public function bookUserFaceInfo($bookUser){

        $this->db->where('tbl_bookusers.mobile', $bookUser['mobile']);
        $this->db->update('tbl_bookusers', $bookUser);

        return true;
    }



    public function isExistSameNickname($bookUser){
        $this->db->where('userId!=', $bookUser['userId']);
        $query = $this->db->get_where('tbl_bookusers', array('nickName' => $bookUser['nickName']));

        if ($query->num_rows() > 0){
            return "nickName";
        }

        return "no";
    }


    public function forgotPass($forgotPass){
        $password = sha1($forgotPass['password']);
        $bookUsers = array(
            'password'=>$password,
            'otp'  => $forgotPass['otp'],
            'created_at' => $forgotPass['created_at'],
            'mobile' => $forgotPass['mobile'],
            'verified' => $forgotPass['verified']
        );
        $this->db->where('tbl_bookusers.mobile', $bookUsers['mobile']);
        $this->db->update('tbl_bookusers', $bookUsers);
        return true;
    }



     function addCount($infoId){
        $this->db->select('BaseTb.count');
        $this->db->from('tbl_information as BaseTb');
        $this->db->where('BaseTb.infoId', $infoId['infoId']);
        $query = $this->db->get();
        $count =  $query->row_array();

        $num = intval($count['count']);
        $num = $num + 1;

        $count = array('count' => $num);

        $this->db->where('tbl_information.infoId', $infoId['infoId']);
        $this->db->update('tbl_information', $count);

        return $num;
    }


/**  count of the book according to catetgory when login to main */
    public function allBookListCount(){

        $query = $this->db->get('tbl_booklist');
        $count = $query->num_rows();

        return $count;
    }


    public function bookUserDownloadedCount($mobile){

        $downloaded = array('已下载');
        $this->db->where('tbl_book_information.mobile', $mobile);
        $this->db->where_in('tbl_book_information.downloaded',$downloaded );
        $query = $this->db->get('tbl_book_information');
        $count = $query->num_rows();

        return $count;

    }


    public function bookUserisReadCount($mobile){

        $this->db->where('tbl_book_information.mobile', $mobile);
        $this->db->where_in('tbl_book_information.isRead',1 );
        $query = $this->db->get('tbl_book_information');
        $count = $query->num_rows();

        return $count;

    }


    public function bookUserisNotReadCount($mobile){

        $this->db->where('tbl_book_information.mobile', $mobile);
        $this->db->where_in('tbl_book_information.isRead',0);
        $query = $this->db->get('tbl_book_information');
        $count = $query->num_rows();

        return $count;

    }


    public function bookUserFavouriteCount($mobile){

        $collection = array('收藏');
        $this->db->where('tbl_book_information.mobile', $mobile);
        $this->db->where_in('tbl_book_information.collection',$collection);
        $query = $this->db->get('tbl_book_information');
        $count = $query->num_rows();

        return $count;

    }


    public function recommendCount(){

        $recommend = array('推荐');
        $this->db->where_in('tbl_booklist.category',$recommend);
        $query = $this->db->get('tbl_booklist');
        $count = $query->num_rows();

        return $count;
    }


    public function scienceCount(){

        $recommend = array('自然科学');
        $this->db->where_in('tbl_booklist.category',$recommend);
        $query = $this->db->get('tbl_booklist');
        $count = $query->num_rows();

        return $count;
    }


    public function artCount(){

        $art = array('文学艺术');
        $this->db->where_in('tbl_booklist.category',$art);
        $query = $this->db->get('tbl_booklist');
        $count = $query->num_rows();

        return $count;
    }


    public function societyCount(){

        $society = array('人文社科');
        $this->db->where_in('tbl_booklist.category',$society);
        $query = $this->db->get('tbl_booklist');
        $count = $query->num_rows();

        return $count;
    }


    public function attentionCount(){

        $attention = array('关注');
        $this->db->where_in('tbl_booklist.category',$attention);
        $query = $this->db->get('tbl_booklist');
        $count = $query->num_rows();

        return $count;
    }

/**  all book data information and downloaded state with mobile when login to main and search all book information*/
    public function searchAllBook(){

        $this->db->select('BaseTbl.bookId, BaseTbl.cover, BaseTbl.bookName, BaseTbl.bookNameUrl');
        $this->db->from('tbl_booklist as BaseTbl');

        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }


    public function isExistSameBookId($bookUser){
        $this->db->where('mobile', $bookUser['mobile']);
        $query = $this->db->get_where('tbl_book_information', array('bookId' => $bookUser['bookId']));

        if ($query->num_rows() > 0){
            return "bookId";
        }

        return "no";
    }


    public function getBookInfowithBookId($bookId){

        $this->db->select(' BaseTbl.bookName');
        $this->db->from('tbl_booklist as BaseTbl');

        $this->db->where('BaseTbl.bookId', $bookId);
        $query = $this->db->get();

        $result = $query->row_array();

        return $result;
    }


    public function notifyServerBookDownLoaded($bookUser){

        $this->db->insert('tbl_book_information', $bookUser);
        $this->db->order_by('tbl_book_information.bookId', 'ASC');
        return $this->db->insert_id();
    }


    public function getbookIdWithMobile($mobile){
        $this->db->select('BaseTbl.bookId');
        $this->db->from('tbl_book_information as BaseTbl');

        $this->db->where_in('BaseTbl.mobile', $mobile);
        $downloaded = array('已下载');
        $this->db->order_by('BaseTbl.bookId', 'ASC');
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }


    public function getbookIdWithisRead($mobile){
        $this->db->select('BaseTbl.bookId');
        $this->db->from('tbl_book_information as BaseTbl');

        $this->db->where('BaseTbl.mobile', $mobile);
        $downloaded = array('已下载');
        $this->db->where_in('BaseTbl.isRead', 1);
        $this->db->order_by('BaseTbl.bookId', 'ASC');
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }


//  get the data(key: page, endPoint, time) accoridng to mobile
    public function getbookDataWithMobile($mobile){

        $this->db->select('BaseTbl.page, BaseTbl.time, BaseTbl.endPoint');
        $this->db->from('tbl_book_information as BaseTbl');

        $this->db->where('BaseTbl.mobile', $mobile);
        $this->db->order_by('BaseTbl.bookId', 'ASC');
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }


    public function updatePageWithMobile($page, $mobile){

        $this->db->where('tbl_book_information.mobile', $mobile);
        $this->db->where('tbl_book_information.bookId', $page['bookId']);
        $result = $this->db->update('tbl_book_information', $page);

        return $result;
    }


    public function updateTimeWithMobile($time, $mobile){

        $this->db->where('tbl_book_information.mobile', $mobile);
        $this->db->where('tbl_book_information.bookId', $time['bookId']);
        $result = $this->db->update('tbl_book_information', $time);

        return $result;
    }


    public function updateendPointWithMobile($endPoint, $mobile){

        $this->db->where('tbl_book_information.mobile', $mobile);
        $this->db->where('tbl_book_information.bookId', $endPoint['bookId']);
        $result = $this->db->update('tbl_book_information', $endPoint);

        return $result;
    }


    public function updateParamWithMobile($params, $mobile){

        $isCurrent = array('isCurrent' => "0");
        $this->db->where('tbl_book_information.mobile', $mobile);
        $this->db->update('tbl_book_information', $isCurrent);
        $this->db->where('tbl_book_information.bookId', $params['bookId']);
        $result = $this->db->update('tbl_book_information', $params);

        return $result;
    }



    public function searchAllBookArray($page='5', $segment='2'){
        $this->db->select('BaseTbl.bookId, BaseTbl.cover, BaseTbl.bookName, BaseTbl.bookNameUrl,  BaseTbl.publisher, BaseTbl.introduce');
        $this->db->from('tbl_booklist as BaseTbl');

        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.bookId', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }


    public function searchDownloadedBook($mobile){

        $this->db->select('BaseTbl.bookId, BaseTbl.cover, BaseTbl.bookName, BaseTbl.bookNameUrl, SecTbl.downloaded');
        $this->db->from('tbl_booklist as BaseTbl');
        $this->db->join('tbl_book_information as SecTbl', 'SecTbl.bookId = BaseTbl.bookId','left');

        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('SecTbl.mobile', $mobile);
        $downloaded = array('已下载');
        $this->db->where_in('SecTbl.downloaded', $downloaded);
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }


    public function searchisReadBook($mobile){
        $this->db->select('BaseTbl.bookId, BaseTbl.cover, BaseTbl.bookName, BaseTbl.bookNameUrl,  BaseTbl.publisher, BaseTbl.introduce');
        $this->db->from('tbl_booklist as BaseTbl');
        $this->db->join('tbl_book_information as SecTbl', 'SecTbl.bookId = BaseTbl.bookId','left');

        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('SecTbl.mobile', $mobile);
        $this->db->where('SecTbl.isRead', 1);
        $this->db->order_by('BaseTbl.bookId', 'ASC');
        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }


    public function searchisNotReadBook($mobile){
        $this->db->select('BaseTbl.bookId, BaseTbl.cover, BaseTbl.bookName, BaseTbl.bookNameUrl,  BaseTbl.publisher, BaseTbl.introduce');
        $this->db->from('tbl_booklist as BaseTbl');
        $this->db->join('tbl_book_information as SecTbl', 'SecTbl.bookId = BaseTbl.bookId','left');

        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('SecTbl.mobile', $mobile);
        $this->db->where('SecTbl.isRead', 0);
        $this->db->order_by('BaseTbl.bookId', 'ASC');
        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }


    public function searchFavouriteBook($mobile){

        $this->db->select('BaseTbl.bookId, BaseTbl.cover, BaseTbl.bookName, BaseTbl.bookNameUrl,  BaseTbl.publisher, BaseTbl.introduce');
        $this->db->from('tbl_booklist as BaseTbl');
        $this->db->join('tbl_book_information as SecTbl', 'SecTbl.bookId = BaseTbl.bookId','left');

        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('SecTbl.mobile', $mobile);
        $collection = array('收藏');
        $this->db->where_in('SecTbl.collection', $collection);
        $this->db->order_by('BaseTbl.bookId', 'ASC');
        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }


    public function getDownloadedbookId($mobile){
        $this->db->select('BaseTbl.bookId');
        $this->db->from('tbl_book_information as BaseTbl');

        $this->db->where('BaseTbl.mobile', $mobile);
        $downloaded = array('已下载');
        $this->db->where_in('BaseTbl.downloaded', $downloaded);
        $this->db->order_by('BaseTbl.bookId', 'ASC');
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }


    public function getDownloadedStateWithMobile($mobile){

        $this->db->select('BaseTbl.bookId, BaseTbl.bookName, BaseTbl.process, BaseTbl.endPoint, BaseTbl.page, BaseTbl.time, 
                            BaseTbl.averageTime, BaseTbl.isRead, BaseTbl.collection, BaseTbl.isCurrent, BaseTbl.attention,
                            BaseTbl.state, SecTbl.demandTime, SecTbl.deadline, SecTbl.category, SecTbl.cover, SecTbl.bookNameUrl');
        $this->db->from('tbl_book_information as BaseTbl');
        $this->db->join('tbl_booklist as SecTbl','SecTbl.bookId = BaseTbl.bookId','left');

        $this->db->where('BaseTbl.mobile', $mobile);
        $downloaded = array('已下载');
        $this->db->where_in('BaseTbl.downloaded', $downloaded);
        $this->db->order_by('BaseTbl.bookId', 'ASC');
        $query = $this->db->get();

        $result = $query->result_array();

        return $result;
    }


    function addfavouriteCount($bookId){

        $this->db->select('BaseTb.favouriteCount');
        $this->db->from('tbl_booklist as BaseTb');
        $this->db->where('BaseTb.bookId', $bookId);
        $query = $this->db->get();
        $count =  $query->row_array();

        $num = intval($count['favouriteCount']);
        $num = $num + 1;

        $count = array('favouriteCount' => $num);

        $this->db->where('tbl_booklist.bookId', $bookId);
        $this->db->update('tbl_booklist', $count);

        return $num;
    }


    function addreceiveInfoCount($infoId){

        $this->db->select('BaseTb.count');
        $this->db->from('tbl_information as BaseTb');
        $this->db->where('BaseTb.infoId', $infoId);
        $query = $this->db->get();
        $count =  $query->row_array();

        $num = intval($count['count']);
        $num = $num + 1;

        $count = array('count' => $num);

        $this->db->where('tbl_information.infoId', $infoId);
        $this->db->update('tbl_information', $count);

        return $num;
    }


    function addDownloadedCount($bookId){
        $this->db->select('BaseTb.downloadedCount');
        $this->db->from('tbl_booklist as BaseTb');
        $this->db->where('BaseTb.bookId', $bookId['bookId']);
        $query = $this->db->get();
        $count =  $query->row_array();

        $num = intval($count['downloadedCount']);
        $num = $num + 1;

        $count = array('downloadedCount' => $num);

        $this->db->where('tbl_booklist.bookId', $bookId['bookId']);
        $this->db->update('tbl_booklist', $count);

        return $num;
    }


    function addAttentionCount($bookId){
        $this->db->select('BaseTb.attentionCount');
        $this->db->from('tbl_booklist as BaseTb');
        $this->db->where('BaseTb.bookId', $bookId);
        $query = $this->db->get();
        $count =  $query->row_array();

        $num = intval($count['attentionCount']);
        $num = $num + 1;

        $count = array('attentionCount' => $num);

        $this->db->where('tbl_booklist.bookId', $bookId);
        $this->db->update('tbl_booklist', $count);

        return $num;
    }


    function addReadingCount($bookId){
        $this->db->select('BaseTb.readingCount');
        $this->db->from('tbl_booklist as BaseTb');
        $this->db->where('BaseTb.bookId', $bookId);
        $query = $this->db->get();
        $count =  $query->row_array();

        $num = intval($count['readingCount']);
        $num = $num + 1;

        $count = array('readingCount' => $num);

        $this->db->where('tbl_booklist.bookId', $bookId);
        $this->db->update('tbl_booklist', $count);

        return $num;
    }


    function addReadedCount($bookId){
        $this->db->select('BaseTb.isReadCount');
        $this->db->from('tbl_booklist as BaseTb');
        $this->db->where('BaseTb.bookId', $bookId);
        $query = $this->db->get();
        $count =  $query->row_array();

        $num = intval($count['isReadCount']);
        $num = $num + 1;

        $count = array('isReadCount' => $num);

        $this->db->where('tbl_booklist.bookId', $bookId);
        $this->db->update('tbl_booklist', $count);

        return $num;
    }


    function saveUserBookInfo($userBookInfo){
//        $this->db->select('BaseTb.bookName, BaseTb.process, BaseTb.time, BaseTb.averageTime, BaseTb.isRead');
//        $this->db->from('tbl_book_information as BaseTb');
        $this->db->where('tbl_book_information.nickName', $userBookInfo['nickName']);
        $this->db->where('tbl_book_information.bookName', $userBookInfo['bookName']);
        $this->db->update('tbl_book_information', $userBookInfo);

        return $userBookInfo;
    }



    /**   个人中心   API*/
    function feedback($feedback){

        $this->db->insert('tbl_feedback', $feedback);

        return true;
    }


    function getOldPass($mobile){

        $this->db->select('BaseTbl.password');
        $this->db->from('tbl_bookusers as BaseTbl');
        $this->db->where('BaseTbl.mobile', $mobile);
        $query = $this->db->get();

        return $result = $query->row_array();

    }


    function updatePassword($mobile, $newPassword){

        $newPass = array('password' => sha1($newPassword));
        $this->db->where('tbl_bookusers.mobile', $mobile);
        $this->db->update('tbl_bookusers', $newPass);

        return true;
    }


    function updateMobile($mobile, $newMobile){

        $this->db->where('tbl_bookusers.mobile', $mobile);
        $this->db->update('tbl_bookusers', $newMobile);

        return true;
    }


    function confirmUpdateMobile($oldMobile, $newMobile){


        $this->db->where('tbl_bookusers.mobile', $oldMobile);
        $this->db->update('tbl_bookusers', $newMobile);

        return $newMobile;
    }


//    get the face and identy status according to phone number
    function getIdentyStatus($mobile){

        $this->db->select('BaseTbl.identyStatus, BaseTbl.faceStateInfo');
        $this->db->from('tbl_bookusers as BaseTbl');
        $this->db->where('BaseTbl.mobile', $mobile);
        $query = $this->db->get();

        $result = $query->row_array();
        return $result;
    }



}

  