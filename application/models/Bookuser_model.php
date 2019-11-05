<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : User_model (User Model)
 * User model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Bookuser_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function bookUserListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.userId');
        $this->db->from('tbl_bookusers as BaseTbl');

        if(!empty($searchText)) {
            $likeCriteria = "(  BaseTbl.name  LIKE '%".$searchText."%'
                                OR BaseTbl.mobile  LIKE '%".$searchText."%'
                                OR BaseTbl.class  LIKE '%".$searchText."%'
                                OR BaseTbl.school  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);

        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function bookuserListing($searchText = '',  $schoolSearch = '', $classSearch = '', $page, $segment)
    {
        $this->db->select( 'BaseTbl.userId,BaseTbl.userSerial, BaseTbl.name, BaseTbl.studId, BaseTbl.class,BaseTbl.school,BaseTbl.mobile,BaseTbl.identyStatus,BaseTbl.faceStatus,
                            BaseTbl.faceInfoUrl,BaseTbl.faceImageUrl, BaseTbl.idCardFront, BaseTbl.idCardBack, 
                            SecTbl.progress,SecTbl.time,ThirdTbl.bookName,ThirdTbl.demandTime,ThirdTbl.coverUrl,
                            FourthTbl.averageProgress,FourthTbl.averageTime,FourthTbl.allAverageTime,FourthTbl.downloadedCount');
        $this->db->from('tbl_bookusers as BaseTbl');
        $this->db->join('tbl_book_information as SecTbl', 'BaseTbl.userId = SecTbl.userId AND BaseTbl.lastReadBookId = SecTbl.bookId','left');
        $this->db->join('tbl_booklist as ThirdTbl', 'SecTbl.bookId = ThirdTbl.bookId','left');
        $this->db->join('tbl_book_statistics as FourthTbl', 'ThirdTbl.bookId = FourthTbl.bookId','left');

        //  for search part
        if(!empty($searchText)) {
            $likeCriteria = "(  BaseTbl.name  LIKE '%".$searchText."%'
                                OR BaseTbl.mobile  LIKE '%".$searchText."%'
                                OR BaseTbl.class  LIKE '%".$searchText."%'
                                OR BaseTbl.school  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($schoolSearch)) {
            $likeCriteria = "(  BaseTbl.school  LIKE '%".$schoolSearch."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($classSearch)) {
            $likeCriteria = "(  BaseTbl.class  LIKE '%".$classSearch."%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('BaseTbl.isDeleted', 0);
        //  $this->db->where('SecTbl.bookId', 'BaseTbl.bookId');
        $this->db->order_by('BaseTbl.userSerial', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }


    function bookuserListingArray($searchText = '', $page, $segment){
        $this->db->select('*');
        $this->db->from('tbl_bookusers as BaseTbl');

        if(!empty($searchText)) {
            $likeCriteria = "(  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.userId', 'ASC');
        $query = $this->db->get();

        $result = $query->result_array();
        return $result;
    }


    public function getbookInfodWithisCurrent($mobile){

        $this->db->select('BaseTbl.process, BaseTbl.time, BaseTbl.mobile, SecTbl.bookName');
        $this->db->from('tbl_book_information as BaseTbl');
        $this->db->join('tbl_booklist as SecTbl', 'SecTbl.bookId = BaseTbl.bookId');

        $this->db->where('BaseTbl.mobile', $mobile);
        $this->db->where_in('BaseTbl.isCurrent', 1);
        $this->db->order_by('BaseTbl.bookId', 'ASC');
        $query = $this->db->get();

        $result = $query->result();

        return $result;
    }


    function getisReadCountWithMobile($userId){

        $this->db->select('BaseTb.isRead');
        $this->db->from('tbl_book_information as BaseTb');
        $this->db->where('BaseTb.userId', $userId);
        $this->db->where('BaseTb.isRead', 1);

        $query = $this->db->get();
        return $query->num_rows();
    }


    function getDownloadedCountWithMobile($userId){

        $this->db->select();
        $this->db->from('tbl_book_information as BaseTb');
//        $recommend = array('已下载');
        $this->db->where('BaseTb.userId', $userId);
//        $this->db->where_in('BaseTb.downloaded', $recommend);

        $query = $this->db->get();
        return $query->num_rows();
    }


    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('roleId !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }


    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_bookusers', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    

    function getUserInfoWithMobile($userId)
    {
        $this->db->select();
        $this->db->from('tbl_bookusers');
        $this->db->where('isDeleted', 0);
        $this->db->where('tbl_bookusers.userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }


    function getFavouriteCountWithMobile($userId){

        $this->db->select('BaseTb.isFavorite');
        $this->db->from('tbl_book_information as BaseTb');
        $this->db->where('BaseTb.userId', $userId);
        $this->db->where_in('BaseTb.isFavorite', 1);

        $query = $this->db->get();
        return $query->num_rows();
    }


    function getAttentionCountWithMobile($userId){

        $this->db->select('BaseTb.isAttention');
        $this->db->from('tbl_book_information as BaseTb');
        $this->db->where('BaseTb.userId', $userId);
        $this->db->where_in('BaseTb.isAttention', 1);

        $query = $this->db->get();
        return $query->num_rows();
    }


    function getAllTimeWithMobile($userId){

        $this->db->select('BaseTb.time');
        $this->db->from('tbl_book_information as BaseTb');
        $this->db->where('BaseTb.userId',$userId);
        $query = $this->db->get();
        $time =  $query->result_array();

        return $time;
    }


    function getImageUrlWithMobile($userId){

        $this->db->select('BaseTb.frontIdentifyUrl, BaseTb.backIdentifyUrl, BaseTb.faceImageUrl');
        $this->db->from('tbl_bookusers as BaseTb');
        $this->db->where('BaseTb.userId',$userId);
        $query = $this->db->get();
        $time =  $query->result_array();

        return $time;
    }



    /** update book in db*/
    public function updateBookUser($data){

        $this->db->trans_start();
        $this->db->where('tbl_bookusers.userId', $data['userId']);
        $this->db->update('tbl_bookusers',$data);

        return true;
    }



    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteBookUser($userid,$bookUserInfo)
    {
        $this->db->where('userId', $userid);
        $this->db->update('tbl_bookusers', $bookUserInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_bookusers');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }


    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_bookusers', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to get user login history
     * @param number $userId : This is user id
     */
    function loginHistoryCount($userId, $searchText, $fromDate, $toDate)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.userAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($userId >= 1){
            $this->db->where('BaseTbl.userId', $userId);
        }
        $this->db->from('tbl_last_login as BaseTbl');
        $query = $this->db->get();
        
        return $query->num_rows();
    }





    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_bookusers');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }

    /**
     * This function used to get user information by id with role
     * @param number $userId : This is user id
     * @return aray $result : This is user information
     */
    function getUserInfoWithRole($userId)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.roleId, Roles.role');
        $this->db->from('tbl_bookusers as BaseTbl');
        $this->db->join('tbl_bookusers as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

}

  