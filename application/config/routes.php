<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = "login";
$route['404_override'] = 'error_404';
$route['translate_uri_dashes'] = FALSE;


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'Backend/user';
$route['logout'] = 'Backend/user/logout';
$route['userListing'] = 'Backend/user/userListing';
$route['userListing/(:num)'] = "Backend/user/userListing/$1";
$route['addNewAdminScreen'] = "Backend/user/addNewAdminScreen";
$route['addNewAdmin'] = "Backend/user/addNewAdmin";
$route['editAdminScreen'] = "Backend/user/editAdminScreen";
$route['editAdminScreen/(:num)'] = "Backend/user/editAdminScreen/$1";
$route['editAdmin'] = "Backend/user/editAdmin";
$route['deleteUser'] = "Backend/user/deleteUser";
$route['profile'] = "Backend/user/profile";
$route['profile/(:any)'] = "Backend/user/profile/$1";
$route['profileUpdate'] = "Backend/user/profileUpdate";
$route['profileUpdate/(:any)'] = "Backend/user/profileUpdate/$1";

$route['loadChangePass'] = "Backend/user/loadChangePass";
$route['changePassword'] = "Backend/user/changePassword";
$route['changePassword/(:any)'] = "Backend/user/changePassword/$1";
$route['pageNotFound'] = "Backend/user/pageNotFound";
$route['checkEmailExists'] = "Backend/user/checkEmailExists";
$route['login-history'] = "Backend/user/loginHistoy";
$route['login-history/(:num)'] = "Backend/user/loginHistoy/$1";
$route['login-history/(:num)/(:num)'] = "Backend/user/loginHistoy/$1/$2";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";


/**  bookUserList for backend*/
$route['bookuserListing'] = 'Backend/bookuser/bookuserListing';
$route['bookuserListing/(:num)'] = "Backend/bookuser/bookuserListing/$1";
$route['bookuserListing/(:num)/(:num)'] = "Backend/bookuser/bookuserListing/$1/$2";
$route['addBookUserScreen'] = "Backend/bookuser/addBookUserScreen";
//$route['bookAddNewUser'] = "bookuser/bookAddNewUser";
$route['editBookUserScreen'] = "Backend/bookuser/editBookUserScreen";
$route['editBookUserScreen/(:num)'] = "Backend/bookuser/editBookUserScreen/$1";
$route['updateBookUser'] = "Backend/bookuser/updateBookUser";
$route['updateBookUser/(:num)'] = "Backend/bookuser/updateBookUser/$1";
$route['deleteBookUser'] = "Backend/bookuser/deleteBookUser";
$route['upload-identify_front/post']['post'] = "Backend/bookuser/uploadIdentifyFrontImage";
$route['upload-identify_back/post']['post'] = "Backend/bookuser/uploadIdentifyBackImage";
$route['upload-identify_face/post']['post'] = "Backend/bookuser/uploadFaceImage";


/** bookList for backend*/
$route['bookListing'] = 'Backend/booklist/bookListing';
$route['bookListing/(:num)'] = "Backend/booklist/bookListing/$1";
$route['bookListAddScreen'] = "Backend/booklist/bookListAddScreen";
$route['bookListAddScreen/(:num)'] = "Backend/booklist/bookListAddScreen/$1";
$route['bookListAddSub'] = "Backend/booklist/bookListAddSub";
$route['editBookListScreen'] = "Backend/booklist/editBookListScreen";
$route['editBookListScreen/(:num)'] = "Backend/booklist/editBookListScreen/$1";
$route['deleteBookList'] = "Backend/bookList/deleteBookList";
$route['do_upload/(:num)'] = "Backend/booklist/do_upload/$1";
$route['do_upload'] = "Backend/booklist/do_upload";

$route['getThumbnail'] = "Backend/booklist/getThumbnail";


/** feedback for backend*/
$route['feedbacking'] = "Backend/information/feedbackListing";
$route['feedbacking/(:num)'] = "Backend/information/feedbackListing/$1";
$route['delete_feedback'] = "Backend/information/deleteFeedback";
$route['information'] = "Backend/information/informationListing";
$route['information/(:num)'] = "Backend/information/informationListing/$1";
$route['delete_information'] = "Backend/information/deleteInformation";
$route['send_information'] = "Backend/information/sendInformation";

/** homepage for backend*/
$route['homepage'] = "Backend/homepage";


/** API for app*/
// register part
$route['verifyCode']['post'] = "Api/Reg/verifyCode";
$route['confirmVerify']['post'] = "Api/Reg/confirmVerify";
$route['uploadIdentify']['post'] = "Api/Reg/uploadIdentify";
$route['register']['post'] = "Api/Reg/register";
$route['uploadFaceInfo']['post'] = "Api/Reg/uploadFaceInfo";

// forgot password part
$route['verifyForgot']['post'] = "Api/Reg/verifyForgot";
$route['confirmForgot']['post'] = "Oauth2/PasswordCredentials/confirmForgot";
$route['identify']['post'] = "Oauth2/PasswordCredentials/identify";

// login part
$route['login']['post'] = "Oauth2/PasswordCredentials";
$route['sendAllFaceStateInfo']['post'] = "Oauth2/PasswordCredentials/sendAllFaceStateInfo";
$route['faceLogin']['post'] = "Oauth2/PasswordCredentials/faceLogin";
$route['getFaceSateInfo']['post'] = "Oauth2/PasswordCredentials/getFaceSateInfo";
$route['bookUserFaceInfo']['post'] = "Oauth2/PasswordCredentials/bookUserFaceInfo"; // old
$route['getFaceInfoUrl']['post'] = "Oauth2/PasswordCredentials/getFaceInfoUrl";
$route['update']['post'] = "Api/Api/update";

//  library part
$route['searchList']['post'] = "Api/Api/searchList";
$route['searchAllBook']['post'] = "Api/Api/searchAllBook";
$route['searchAllBookwithMobile']['post'] = "Api/Api/searchAllBookwithMobile";
$route['getFaceInfoUrl']['post'] = "Api/Api/getFaceInfoUrl";
$route['notifyServerBookDownLoaded']['post'] = "Api/Api/notifyServerBookDownLoaded";
$route['updateParamWithMobile']['post'] = "Api/Api/updateParamWithMobile";
$route['updatePageWithMobile']['post'] = "Api/Api/updatePageWithMobile";
$route['updateTimeWithMobile']['post'] = "Api/Api/updateTimeWithMobile";
$route['updateendPointWithMobile']['post'] = "Api/Api/updateendPointWithMobile";
$route['getDownloadedStateWithMobile']['post'] = "Api/Api/getDownloadedStateWithMobile";
$route['searchDownloadedBook']['post'] = "Api/Api/searchDownloadedBook";
$route['searchisReadBook']['post'] = "Api/Api/searchisReadBook";
$route['searchisNotReadBook']['post'] = "Api/Api/searchisNotReadBook";
$route['searchFavouriteBook']['post'] = "Api/Api/searchFavouriteBook";
$route['searchCategory']['post'] = "Api/Api/searchCategory";
$route['addfavouriteCount']['post'] = "Api/Api/addfavouriteCount";
$route['addreceiveInfoCount']['post'] = "Api/Api/addreceiveInfoCount";
$route['addAttentionCount']['post'] = "Api/Api/addAttentionCount";
$route['addReadingCount']['post'] = "Api/Api/addReadingCount";
$route['addReadedCount']['post'] = "Api/Api/addReadedCount";
$route['saveUserBookInfo']['post'] = "Api/Api/saveUserBookInfo";

//  个人中心  API
$route['Information']['post'] = "Api/Api/feedback";
$route['updatePassword']['post'] = "Api/Api/updatePassword";
$route['getupdateMobileOtp']['post'] = "Api/Api/getupdateMobileOtp";
$route['confirmUpdateMobile']['post'] = "Api/Api/confirmUpdateMobile";
$route['getIdentyStatus']['post'] = "Api/Api/getIdentyStatus";
$route['updatePersonalInfo']['post'] = "Api/Api/updatePersonalInfo";
$route['getbookuserinfo']['post'] = "Api/Api/getbookuserinfo";


