<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : User_model (User Model)
 * User model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Info_model extends CI_Model
{

    function feedbackListingCount()
    {
        $this->db->select('tbl_feedback.id');
        $this->db->from('tbl_feedback');

        $query = $this->db->get();
        
        return $query->num_rows();
    }
    

    function feedbackListing( $page, $segment)
    {
        $this->db->select( );
        $this->db->from('tbl_feedback');

        $this->db->order_by('tbl_feedback.date', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }


    function deleteFeedback($id){

        $this->db->delete('tbl_feedback', array('id' => $id));
    }


    function informationListingCount()
    {
        $this->db->select('tbl_information.id');
        $this->db->from('tbl_information');

        $query = $this->db->get();

        return $query->num_rows();
    }


    function informationListing( $page, $segment)
    {
        $this->db->select( );
        $this->db->from('tbl_information');

        $this->db->order_by('tbl_information.id', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }


    function getCountAllbookUser(){

        $this->db->select('tbl_bookusers.userId');
        $this->db->from('tbl_bookusers');
        $query = $this->db->get();

        return $query->num_rows();
    }


    function deleteInformation($id){

        $this->db->delete('tbl_information', array('id' => $id));
    }


    function insert($information)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_information', $information);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }


    function getAllBookUser(){

        $this->db->select('*');
        $this->db->from('tbl_bookusers');
        $query = $this->db->get();

        return $query->result();
    }
}

  