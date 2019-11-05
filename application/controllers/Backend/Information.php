<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';




/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Information extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('info_model');
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
    function feedbackListing()
    {
        $this->load->library('pagination');

        $count = $this->info_model->feedbackListingCount();

        $returns = $this->paginationCompress ( "feedbacking/", $count, 10 );

        $data['feedbacks'] = $this->info_model->feedbackListing($returns["page"], $returns["segment"]);
        $this->global['pageTitle'] = 'CodeInsect : User Listing';

        $this->loadViews("information/feedback", $this->global, $data, NULL);
    }


    function deleteFeedback(){

        $id = $this->input->post('id');
        log_message('error', 'deleteFeedback(): id = '.$id);
        $result =  $this->info_model->deleteFeedback($id);

        if ($result > 0) { echo(json_encode(array('res'=>TRUE))); }
        else { echo(json_encode(array('res'=>FALSE))); }
    }


    function informationListing()
    {

        $this->load->library('pagination');

        $count = $this->info_model->informationListingCount();

        $returns = $this->paginationCompress ( "informationListing/", $count, 10 );

        $data['informations'] = $this->info_model->informationListing($returns["page"], $returns["segment"]);
        $this->global['pageTitle'] = 'CodeInsect : User Listing';

        $countAllBookUser = $this->info_model->getCountAllbookUser();
        $data['allCount'] = $countAllBookUser;
        log_message('error', 'informationListing(): allCount='.$countAllBookUser);

        $this->loadViews("information/information", $this->global, $data, NULL);
    }


    function deleteInformation(){

        $id = $this->input->post('id');
        log_message('error', 'deleteInformation(): id = '.$id);
        $result =  $this->info_model->deleteInformation($id);

        if ($result > 0) { echo(json_encode(array('res'=>TRUE))); }
        else { echo(json_encode(array('res'=>FALSE))); }
    }


    function sendInformation(){

            $title = $this->input->post('dlgTitle');
            $content = $this->input->post('dlgContent');
            $releaseTime  = date('Y-m-d H:i:s');
            $canceldTime = date('Y-m-d H:i:s', time() + 3600*24*10);

            $information = array('title' => $title,
                'content' => $content,
                'releaseTime' => $releaseTime,
                'cancelTime' => $canceldTime);
            $this->info_model->insert($information);

        redirect('information');
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

}
?>