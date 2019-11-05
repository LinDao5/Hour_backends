<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : User_model (User Model)
 * User model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class BookList_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function bookListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.bookId');
        $this->db->from('tbl_booklist as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.bookSerial  LIKE '%".$searchText."%'
                            OR BaseTbl.bookName  LIKE '%".$searchText."%'
                            OR  BaseTbl.publisher  LIKE '%".$searchText."%'
                            OR  BaseTbl.category  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

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
    function bookListing($searchText = '', $categorySearch = '', $page, $segment)
    {
        $this->db->select('BaseTbl.bookId, BaseTbl.bookSerial, BaseTbl.coverUrl, BaseTbl.bookName, BaseTbl.bookNameUrl,BaseTbl.category, 
                          BaseTbl.publishDate, BaseTbl.author, BaseTbl.deadline, BaseTbl.demandTime, BaseTbl.summary, BaseTbl.publishingHouse,
                          SceTbl.averageProgress, SceTbl.averageTime, SceTbl.allAverageTime, SceTbl.favouriteCount, SceTbl.downloadedCount, SceTbl.attentionCount, SceTbl.readingCount, SceTbl.isReadCount');
        $this->db->from('tbl_booklist as BaseTbl');
        $this->db->join('tbl_book_statistics as SceTbl', 'BaseTbl.bookId = SceTbl.bookId', 'left');

        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.bookSerial  LIKE '%".$searchText."%'
                            OR BaseTbl.bookName  LIKE '%".$searchText."%'
                            OR  BaseTbl.author  LIKE '%".$searchText."%'
                            OR  BaseTbl.category  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        if(!empty($categorySearch)) {
            $likeCriteria = "(BaseTbl.category  LIKE '%".$categorySearch."%' )";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.bookId', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();
        return $result;
    }


    /** add new book in db*/
    public function addNewBook($data){

        $this->db->trans_start();
        $this->db->insert('tbl_booklist',$data);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    /** add new book in db*/
    public function addNewStatistics($data){

        $this->db->trans_start();
        $this->db->insert('tbl_book_statistics',$data);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    /**   get the bookInformation from tbl_booklist according to bookId*/
    function getBookInfowithBookId($bookId)
    {
        $this->db->select('tbl_booklist.bookId, tbl_booklist.bookSerial, tbl_booklist.coverUrl, tbl_booklist.bookName, tbl_booklist.bookNameUrl, 
                          tbl_booklist.publishDate, tbl_booklist.author, tbl_booklist.deadline, tbl_booklist.demandTime, tbl_booklist.summary, 
                          tbl_booklist.category, tbl_booklist.publishingHouse, tbl_booklist.pageCount, tbl_booklist.isbn, tbl_booklist.edition,
                           tbl_book_statistics.averageProgress, tbl_book_statistics.averageTime, tbl_book_statistics.allAverageTime, tbl_book_statistics.favouriteCount,
                           tbl_book_statistics.downloadedCount, tbl_book_statistics.attentionCount, tbl_book_statistics.readingCount, tbl_book_statistics.isReadCount' );
        $this->db->from('tbl_booklist');
        $this->db->join('tbl_book_statistics', 'tbl_booklist.bookID = tbl_book_statistics.bookId', 'left');
        $this->db->where('isDeleted', 0);
        $this->db->where('tbl_booklist.bookId', $bookId);
        $query = $this->db->get();

        return $query->row();
    }


    /** update book in db*/
    public function updateBook($data){

        $this->db->trans_start();
        $this->db->where('tbl_booklist.bookId', $data['bookId']);
        $this->db->update('tbl_booklist',$data);

        return true;
    }


    /** update book in db*/
    public function updateStaticsBook($staticsData){

        $this->db->where('tbl_book_statistics.bookId', $staticsData['bookId']);
        $this->db->update('tbl_book_statistics', $staticsData);
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
        log_message('error', 'updateStaticsBook() downloadedCount='.$staticsData['downloadedCount']);

        return $result;

    }


/**  delete book item  from db */
    function deleteBookList($bookId, $bookInfo){

        $this->db->where('tbl_booklist.bookId', $bookId);
        $this->db->update('tbl_booklist', $bookInfo);

        return true;
    }


    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('roleId !=', 1);
        $query = $this->db->get();

        return $query->result();
    }


    function addListBookSub($listInfo){
//      trans_start for another type's db; example innoDB, BDB ...
        $this->db->trans_start();
        $this->db->insert('tbl_booklist',$listInfo);

        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    function editBookList($bookListInfo, $id){
        $this->db->where('id', $id);
        $this->db->update('tbl_booklist', $bookListInfo);

        return TRUE;
    }
}

  