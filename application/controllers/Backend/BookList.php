<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';



/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class BookList extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('bookList_model');
        $this->load->helper(array('form', 'url'));
        $this->isLoggedIn();

    }


    /**
     * This function used to load the first screen of the book
     */
    public function index()
    {
        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the book list
     */
    function bookListing()
    {
           $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $categorySearch = $this->security->xss_clean($this->input->post('categorySearch'));
            $data['searchText'] = $searchText;
            $data['categorySearch'] = $categorySearch;

            $this->load->library('pagination');

            $count = $this->bookList_model->bookListingCount($searchText);

            $returns = $this->paginationCompress ( "bookListing/", $count, 10 );

            $data['userRecords'] = $this->bookList_model->bookListing($searchText,$categorySearch, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = 'CodeInsect : User Listing';

            $this->loadViews("bookList/booklist", $this->global, $data, NULL);
    }


    function bookListAddScreen(){
//        $this->load->model('bookList_model');
        $this->global['pageTitle'] = 'CodeInsect : Add New User';
        $this->loadViews("bookList/bookListAddScreen", $this->global, NULL, NULL);
    }


/**  when add new book , upload book to server*/
    public function addNewBook() {

        $data['bookSerial'] = $this->input->post('bookSerial', TRUE);
        $data['category'] = $this->input->post('category', TRUE);
        $data['isbn'] = $this->input->post('isbn', TRUE);
        $data['bookName'] = $this->input->post('bookName', TRUE);
        $data['edition'] = $this->input->post('edition', TRUE);
        $data['author'] = $this->input->post('author', TRUE);
        $data['publishDate'] = $this->input->post('publishDate', TRUE);
        $data['publishingHouse'] = $this->input->post('publishingHouse', TRUE);
        $data['pageCount'] = $this->input->post('pageCount', TRUE);
        $data['summary'] = $this->input->post('summary', TRUE);
        $data['demandTime'] = $this->input->post('demandTime', TRUE);
        $data['deadline'] = $this->input->post('deadline', TRUE);
        $data['isDeleted'] = "0";

        $staticsData['averageProgress'] = 0;
        $staticsData['readingCount'] = 0;
        $staticsData['averageTime'] = 0;
        $staticsData['allAverageTime'] = 0;
        $staticsData['isReadCount'] = 0;
        $staticsData['favouriteCount'] = 0;
        $staticsData['downloadedCount'] = 0;
        $staticsData['attentionCount'] = 0;

//        upload part property
        $config['upload_path']   = $_SERVER['DOCUMENT_ROOT']."/Hour/assets/upload/book";
        $config['allowed_types']        = '*'; // 'gif|jpg|png|doc|txt|pdf|jpeg|xls|';
        $config['max_size']             = '1000000';
        $config['max_width']            = 1024;
        $now = time();
        $config['file_name']             = "book_$now";

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('bookfile')) {
            $error = array('error' => $this->upload->display_errors());
            $this->loadViews('bookList/bookListAddScreen', $error, NULL, NULL);
        } else {
            $upload_data = $this->upload->data();

            //get the uploaded file name
            $data['fileName'] = $_FILES['bookfile']['name'];
            $data['bookNameUrl'] = "assets/upload/book/".$upload_data['file_name'];

            $bookId = $this->bookList_model->addNewBook($data);
            $staticsData['bookId'] = $bookId;
            log_message('error',  'addNewBook(), bookId='.$bookId);
            $this->bookList_model->addNewStatistics($staticsData);

            redirect('bookListing');
        }
    }


    /**  capture and save image of book, but don't work*/
    public function save_img() {

        echo '<img src="'.$_POST['img_val'].'" />';

        $filteredData=substr($_POST['img_val'], strpos($_POST['img_val'], ",")+1);

        $unencodedData=base64_decode($filteredData);

        file_put_contents('img.png', $unencodedData);

//        $data = $this->input->post('hid_img');
//        $file = md5(uniqid()) . '.png';
//
//        // remove "data:image/png;base64,"
//        $uri =  substr($data,strpos($data,",")+1);
//
//        // save to file in uploads folder of codeigniter
//        file_put_contents($_SERVER['DOCUMENT_ROOT']."/Hour/assets/upload/".$file, base64_decode($uri));
//
//        $res=$this->db->insert('tbl_otp',array('otp'=>base_url('upload/').$file));
//        $detail = $this->db->select('*')->from('tbl_otp')->where('tempId', $this->db->insert_id())->get()->row();
//        echo '<img src="'.base_url('uploads/').$detail->message.'" style="width:500px;"/>';
    }


    function editBookListScreen($bookId = NULL)
    {

        if($bookId == null)
        {
            redirect('bookListing');
        }
        log_message('error', 'editBookListScreen(), bookId='.$bookId);

//        $data['roles'] = $this->bookList_model->getUserRoles();
        $data['bookInfo'] = $this->bookList_model->getBookInfowithBookId($bookId);

        $this->global['pageTitle'] = 'CodeInsect : Edit User';
        $this->loadViews("bookList/editBookListScreen", $this->global, $data, NULL);
//        var_dump($data['bookInfo']);
    }


    /**  when add new book , upload book to server*/
    public function updateBook() {

        $data['bookId'] = $this->input->post('bookId', TRUE);
        $data['bookSerial'] = $this->input->post('bookSerial', TRUE);
        $data['category'] = $this->input->post('category', TRUE);
        $data['isbn'] = $this->input->post('isbn', TRUE);
        $data['bookName'] = $this->input->post('bookName', TRUE);
        $data['edition'] = $this->input->post('edition', TRUE);
        $data['author'] = $this->input->post('author', TRUE);
        $data['publishDate'] = $this->input->post('publishDate', TRUE);
        $data['publishingHouse'] = $this->input->post('publishingHouse', TRUE);
        $data['pageCount'] = $this->input->post('pageCount', TRUE);
        $data['summary'] = $this->input->post('summary', TRUE);
        $data['demandTime'] = $this->input->post('demandTime', TRUE);
        $data['deadline'] = $this->input->post('deadline', TRUE);
        $data['isDeleted'] = "0";

        $staticsData['bookId'] = $data['bookId'];
        $staticsData['favouriteCount'] = $this->input->post('favouriteCount', TRUE);
        $staticsData['downloadedCount'] = $this->input->post('downloadedCount', TRUE);
        $staticsData['averageProgress'] = $this->input->post('averageProgress', TRUE);
        $staticsData['readingCount'] = $this->input->post('readingCount', TRUE);
        $staticsData['averageTime'] = $this->input->post('averageTime', TRUE);
        $staticsData['allAverageTime'] = $this->input->post('allAverageTime', TRUE);
        $staticsData['isReadCount'] = $this->input->post('isReadCount', TRUE);
        $staticsData['attentionCount'] = $this->input->post('attentionCount', TRUE);
        log_message('error', 'updateBook(): $bookId='.$staticsData['bookId']);
        log_message('error', 'updateBook(), downloadedCount='.$staticsData['downloadedCount']);

//        $config['upload_path']   = $_SERVER['DOCUMENT_ROOT']."/Hour/assets/upload/book/";
//        $config['allowed_types']        = 'gif|jpg|png|doc|txt|pdf|jpeg|xls|epub';
//        $config['max_size']             = '1000000';
//        $config['max_width']            = 1024;

//        $this->load->library('upload', $config);

//        if ( ! $this->upload->do_upload('bookfile')) {
//            $error = array('error' => $this->upload->display_errors());
//            $this->loadViews('bookList/bookListAddScreen', $error, NULL, NULL);
//        } else {
//            $upload_data = $this->upload->data();

            //get the uploaded file name
//            $data['fileName'] = $upload_data['file_name'];
//            $data['bookNameUrl'] = $_SERVER['DOCUMENT_ROOT']."/Hour/assets/upload/book/".$data['fileName'];

            $this->bookList_model->updateBook($data);
            $this->bookList_model->updateStaticsBook($staticsData);

            redirect('editBookListScreen');
//        }
    }


    function deleteBookList(){
        $bookId = $this->input->post('bookId');
        $bookInfo = array('isDeleted'=> '1');

        $result = $this->bookList_model->deleteBookList($bookId, $bookInfo);
        if ($result > 0) { echo(json_encode(array('res'=>TRUE))); }
        else { echo(json_encode(array('res'=>FALSE))); }
    }


    function bookListAddSub(){
            $name = $this->input->post('name');
            $publisher = $this->input->post('publisher');
            $coverUrl = $this->input->post('coverUrl');
            $contentUrl = $this->input->post('coverUrl');

            $listInfo = array('name'=>$name, 'publisher'=>$publisher, 'coverUrl'=>$coverUrl, 'contentUrl'=>$contentUrl, 'isDeleted'=>'0');

            $this->load->model('bookList_model');
            $this->bookList_model->addListBookSub($listInfo);

            redirect('bookListing');
//        }
    }


    function editBookList(){
        $listId = $this->input->post('userId');

        $name = $this->input->post('name');
        $publisher = $this->input->post('publisher');
        $coverUrl = $this->input->post('coverUrl');
        $contentUrl = $this->input->post('contentUrl');

        $bookListInfo = array('name'=>$name, 'publisher'=>$publisher, 'coverUrl'=>$coverUrl, 'contentUrl'=>$contentUrl, 'isDeleted'=>'0');
        $result = $this->bookList_model->editBookList($bookListInfo, $listId);

        if ($result == true){

        }else{

        }
        redirect('bookListing');
    }


    function getThumbnail(){
//        ConvertApi::setApiSecret('GMvn5qn5I5c0UKDW');
//        $dir = $_SERVER['DOCUMENT_ROOT']."/Hour/assets/upload";
//        $pdfResult = ConvertApi::convert(
//          'extract',
//          [
//              'File' => '/../convertapi/exmaples/files/test.pdf',
//              'PageRange' => 1,
//          ]
//        );
//        $jpgResult = ConvertApi::convert(
//            'jpg',
//            [
//                'File' => $pdfResult->getFile(),
//                'ScaleImage' => true,
//                'ScaleProportions' => true,
//                'ImageHeight' => 300,
//                'ImageWidth' => 300,
//
//            ]
//        );
//        $savedFiles = $jpgResult->saveFiles($dir);
//
//        echo "The thumbnail saved to\n";
//        print_r($savedFiles);

        ConvertApi::setApiSecret('GMvn5qn5I5c0UKDW');
        $result = ConvertApi::convert('thumbnail', [
            'File' => '/../convertapi/examples/files/test.pdf',
            'PageRange' => '1-2',
        ], 'pdf'
        );
        $result->saveFiles($_SERVER['DOCUMENT_ROOT']."/Hour/assets/upload");
    }

}
?>