<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class OauthUser_model extends CI_Model
{
    public $username;
    public $password;
    protected $database;

    public function  __construct()
    {
        parent::__construct();
//      for connecting another db(oauth.db).
//        $this->database = $this->load->database('oauth', TRUE);
        $this->load->database();
    }


    /**  when user regiter , get otp from server by mobile*/
    function isExistOauthUser($mobile){

        $query = $this->db->get_where('oauth_users', array('username' => $mobile));
        if ($query->num_rows() > 0){
            return true;
        }

        return false;

    }


    public function insert($bookUser){

        $query = $this->db->get_where('oauth_users', array('username' => $bookUser['mobile']));
        if ($query->num_rows() > 0){
            return ;
        }

        $username = $bookUser['mobile'];
        $password = sha1($bookUser['password']);

        $oauthUser = array('username' => $username,
                            'password' => $password);

        $this->db->insert('oauth_users', $oauthUser);
    }


    public function update($bookUser)
    {
        $username = $bookUser['name'];
        $password = sha1($bookUser['password']);

        $oauthUser = array('username' => $username,
                            'password' => $password);

        return $this->database->update('oauth_users', $oauthUser, array('first_name'=>$bookUser['nickName']));
    }


    function updateMobile($mobile, $newMobileOauth){

        $this->db->where('oauth_users.username', $mobile);
        $this->db->update('oauth_users', $newMobileOauth);

        return true;
    }


    /** get the mobile number according to accesstoken*/
    public function getMobileFromToken($access_token){

//       *  in here unlike Api_model, should use $this->database
        $this->db->select('BaseTbl.user_id');
        $this->db->from('oauth_access_tokens as BaseTbl');
        $this->db->where('BaseTbl.access_token', $access_token);

        $query = $this->db->get();

        $result = $query->row_array();
        return $result;
    }


    public function delete($studId){
        $this->database->delete('oauth_users', array('password'=>$studId));
    }
}

  