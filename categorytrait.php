<?php
trait CategoryTrait {
    protected function categories(){
        if($this->registry->template->login_check){
            $className = strtolower(get_class($this));
            switch($className){
                case 'store' :
                    $page_id = '3|0';
                    $menu_title = 'Store';
                    $isLinkParentBC = true;
                    break;
                case 'hotel' :
                    $page_id = '4|0';
                    $menu_title = 'Hotel';
                    $isLinkParentBC = true;
                    break;
                case 'dining' :
                    $page_id = '5|0';
                    $menu_title = 'Dining';
                    $isLinkParentBC = true;
                    break;
                case 'beauty' :
                    $page_id = '6|0';
                    $menu_title = 'Beauty &amp; Wellness';
                    $isLinkParentBC = true;
                    break;
                case 'trade' :
                    $page_id = '7|0';
                    $menu_title = 'Trade';
                    $isLinkParentBC = true;
                    break;
                case 'voucher' :
                    $page_id = '8|0';
                    $menu_title = 'Voucher';
                    $isLinkParentBC = true;
                    break;
                case 'newsfeed' :
                    $page_id = '9|0';
                    $menu_title = 'Newsfeed';
                    $isLinkParentBC = true;
                    break;
                case 'magazine' :
                    $page_id = '10|1';
                    $menu_title = 'Magazine';
                    $isLinkParentBC = true;
                    break;
                case 'product' :
                    $page_id = '12|0';
                    $menu_title = 'Product Categories';
                    $isLinkParentBC = false;
                    break;
                case 'specialoffers' :
                    $page_id = '16|0';
                    $menu_title = 'Special Offers';
                    $isLinkParentBC = true;
                    break;
                default :
                    $page_id = NULL;
                    break;
            }
            if(!empty($page_id) && UserHelper::checkUserAccess($page_id)) {
                $main_url = $className . '/categories';
                $get = filter_input_array(INPUT_GET, FILTER_VALIDATE_INT);

                if (empty($get['url_id'])) $get['url_id'] = 1;
                $get['orderby'] = 1;
                $get['order'] = 'ASC';
                if (isset($_GET['order']) && $_GET['order'] === 'DESC') $get['order'] = 'DESC';

                $viewmodel = new $this->registry->classModelName;
                $modelFunctionName = "get" . ucfirst(MainHelper::getDbStr($className)) . "Categories";
                $data_count = $viewmodel->{$modelFunctionName}(NULL, "", true);
                $totalrow = count($data_count);
                if($totalrow > 0) $totalhlm = intval(ceil ($totalrow / LIST_ITEM_LIMIT));
                else $totalhlm = 1;
                if($get['url_id'] > $totalhlm) header('Location: ' . ROOT_PATH . $main_url . '/');

                $param = array();
                $param['order_by'] = array("kategori"=>$get['order']);
                $limitervalue = array();
                if ($totalrow > LIST_ITEM_LIMIT){
                    $offset = ($get['url_id'] - 1) * LIST_ITEM_LIMIT;
                    $limitervalue["count"] = LIST_ITEM_LIMIT;
                    if (!empty($offset)) $limitervalue["offset"] = $offset;
                }
                if(!empty($limitervalue)) $param['limit'] = $limitervalue;

                $this->registry->template->data_list = $viewmodel->{$modelFunctionName}($param, "", true);
                $this->registry->template->main_url = $main_url;
                $this->registry->template->hlm = $get['url_id'];
                $this->registry->template->totalrow = $totalrow;
                $this->registry->template->totalhlm = $totalhlm;

                if(!($get['orderby'] == 1 && $get['order'] == 'ASC')) {
                    $this->registry->template->orderby = $get['orderby'];
                    $this->registry->template->order = strtolower($get['order']);
                }

                $this->registry->template->page_title = "Categories - " . $menu_title;
                $this->registry->template->header_title = "Categories";
                $this->registry->template->page_id = $page_id;
                $this->registry->template->menu_base_url = $className;

                $breadcrumb = array();
                $breadcrumb[0]['str'] = $menu_title;
                if($isLinkParentBC) $breadcrumb[0]['href'] = $className . "/";
                $breadcrumb[1]['str'] = "Categories";
                $breadcrumb[1]['active'] = true;
                $this->registry->template->breadcrumb = $breadcrumb;

                if ($totalrow > 0) {
                    $jsSrc = array();
                    $jsSrc[0]['type'] = "js";
                    $jsSrc[0]['src'] = "assets/js/bundles/list-data.js";
                    $jsSrc[1]['type'] = "js";
                    $jsSrc[1]['src'] = "assets/js/bundles/list-general-remove-button-function.js";
                    $jsSrc[2]['type'] = "js";
                    $jsSrc[2]['src'] = $this->registry->default_js_src;
                    $this->registry->template->jsSrc = $jsSrc;
                }

                $this->returnView(true, 'includes/list-categories.php');
            }
            else Redirect::home();
        }
        else Redirect::signin();
    }
    private function formcategory($type){
        if($this->registry->template->login_check){
            $className = strtolower(get_class($this));
            switch($className){
                case 'store' :
                    $page_id = '3|0';
                    $menu_title = 'Store';
                    $isLinkParentBC = true;
                    break;
                case 'hotel' :
                    $page_id = '4|0';
                    $menu_title = 'Hotel';
                    $isLinkParentBC = true;
                    break;
                case 'dining' :
                    $page_id = '5|0';
                    $menu_title = 'Dining';
                    $isLinkParentBC = true;
                    break;
                case 'beauty' :
                    $page_id = '6|0';
                    $menu_title = 'Beauty &amp; Wellness';
                    $isLinkParentBC = true;
                    break;
                case 'trade' :
                    $page_id = '7|0';
                    $menu_title = 'Trade';
                    $isLinkParentBC = true;
                    break;
                case 'voucher' :
                    $page_id = '8|0';
                    $menu_title = 'Voucher';
                    $isLinkParentBC = true;
                    break;
                case 'newsfeed' :
                    $page_id = '9|0';
                    $menu_title = 'Newsfeed';
                    $isLinkParentBC = true;
                    break;
                case 'magazine' :
                    $page_id = '10|1';
                    $menu_title = 'Magazine';
                    $isLinkParentBC = true;
                    break;
                case 'product' :
                    $page_id = '12|0';
                    $menu_title = 'Product Categories';
                    $isLinkParentBC = false;
                    break;
                case 'specialoffers' :
                    $page_id = '16|0';
                    $menu_title = 'Special Offers';
                    $isLinkParentBC = true;
                    break;
                default :
                    $page_id = NULL;
                    break;
            }
            if(!empty($page_id) && UserHelper::checkUserAccess($page_id)) {
                $viewmodel = new $this->registry->classModelName;
                $strDb = ucfirst(MainHelper::getDbStr($className));
                $strFunction = "get".$strDb."Categories";
                $parent_url = $className . '/categories/';
                $checkUrlId = false;
                if($type==='Add New') $checkUrlId = true;
                elseif($type==='Edit'){
                    $url_id = NULL;
                    if(isset($_GET['url_id'])) $url_id = intval(filter_var($_GET['url_id'], FILTER_VALIDATE_INT));
                    if(!empty($url_id)) {
                        $data_edit = $viewmodel->{$strFunction}(array('id' => $url_id));
                        if ($data_edit && is_array($data_edit) && count($data_edit) == 1) $checkUrlId = true;
                        else header('Location: ' . ROOT_PATH . $parent_url);
                    }
                    else header('Location: ' . ROOT_PATH . $parent_url);
                }

                if($checkUrlId){
                    if (isset($_POST) && !empty($_POST)) {
                        $field_kat = "nama_kategori";
                        $field_url = "url_kategori";
                        if($className=='newsfeed' || $className=='magazine' || $className=='product' || $className=='specialoffers'){
                            $field_kat = "kategori";
                            $field_url = "url_kat";
                        } 

                        if($type==='Add New') {
                            $category_name = '';
                            if(isset($_POST['category_name'])) $category_name = filter_var(MainHelper::removeQuote($_POST['category_name']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
                            if(!empty($category_name)) {
                                $check = $viewmodel->{$strFunction}(array($field_kat=>$category_name));
                                if(is_array($check) && count($check)==0) {
                                    $viewmodel = new $this->registry->classModelName(NULL, 'i');
                                    $strFunction = "insert".$strDb."Categories";
                                    if ($viewmodel->{$strFunction}(array($field_kat => $category_name, $field_url => MainHelper::getUrlString($category_name)))) Messages::setMsg('Successfully add new '.$className.' category.', 'success', 'Success!');
                                    else Messages::setMsg('Failed to add new '.$className.' category.', 'danger', 'Error!');
                                }
                                else Messages::setMsg('Category is already exist.', 'danger', 'Error!');
                            }
                            else Messages::setMsg('Incomplete input data.', 'danger', 'Error!');
                        }
                        elseif($type==='Edit') {
                            $args = array(
                                'hid_id' => FILTER_VALIDATE_INT
                            );
                            $post = filter_input_array(INPUT_POST, $args);
                            $post['category_name'] = NULL;
                            if(isset($_POST['category_name'])) $post['category_name'] = filter_var(MainHelper::removeQuote($_POST['category_name']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
                            if (!empty($post['hid_id']) && !empty($post['category_name'])) {
                                if ($post['hid_id'] == $url_id) {
                                    if($post['category_name'] == $data_edit[0]['kategori']) Messages::setMsg('No change.', 'success');
                                    else {
                                        $trueCheck = false;
                                        if (strtolower($post['category_name']) == strtolower($data_edit[0]['kategori'])) $trueCheck = true;
                                        else {
                                            $check = $viewmodel->{$strFunction}(array($field_kat => $post['category_name']));
                                            if (is_array($check) && count($check) == 0) $trueCheck = true;
                                        }
                                        if ($trueCheck) {
                                            $viewmodel = new $this->registry->classModelName(NULL, 'u');
                                            $strFunction = "update" . $strDb . "Categories";
                                            if ($viewmodel->{$strFunction}(array($field_kat => $post['category_name'], $field_url => MainHelper::getUrlString($post['category_name'])), array('id' => $post['hid_id']))) {
                                                $viewmodel = new $this->registry->classModelName;
                                                $strFunction = "get" . $strDb . "Categories";
                                                $data_edit = $viewmodel->{$strFunction}(array('id' => $url_id));
                                                Messages::setMsg('Successfully edit category.', 'success', 'Success!');
                                            }
                                            else Messages::setMsg('Failed to edit category.', 'danger', 'Error!');
                                        }
                                        else Messages::setMsg('Category is already exist.', 'danger', 'Error!');
                                    }
                                }
                                else Messages::setMsg('Invalid ID.', 'danger', 'Error!');
                            }
                            else Messages::setMsg('Incomplete input data.', 'danger', 'Error!');
                        }
                    }

                    if($type==='Edit') $this->registry->template->data_edit = $data_edit[0];
                    $this->registry->template->page_title = $type . " | Categories - " . $menu_title;
                    $this->registry->template->header_title = $type . " Category";
                    $this->registry->template->page_id = $page_id;

                    $breadcrumb = array();
                    $breadcrumb[0]['str'] = $menu_title;
                    if($isLinkParentBC) $breadcrumb[0]['href'] = $className . "/";
                    $breadcrumb[1]['str'] = "Categories";
                    $breadcrumb[1]['href'] = $parent_url;
                    $breadcrumb[2]['str'] = $type;
                    $breadcrumb[2]['active'] = true;
                    $this->registry->template->breadcrumb = $breadcrumb;

                    $jsSrc = array();
                    $jsSrc[0]['type'] = "js";
                    $jsSrc[0]['src'] = "assets/js/bundles/form-category.js";
                    $this->registry->template->jsSrc = $jsSrc;

                    $this->returnView(true, 'includes/form-category.php');
                }
                else header('Location: ' . ROOT_PATH . $parent_url);
            }
            else Redirect::home();
        }
        else Redirect::signin();
    }
    protected function addcategory(){
        $this->formcategory('Add New');
    }
    protected function editcategory(){
        $this->formcategory('Edit');
    }
    protected function ajax_remove_category(){
        if($this->registry->template->login_check) {
            $className = strtolower(get_class($this));
            switch($className){
                case 'store' :
                    $page_id = '3|0';
                    break;
                case 'hotel' :
                    $page_id = '4|0';
                    break;
                case 'dining' :
                    $page_id = '5|0';
                    break;
                case 'beauty' :
                    $page_id = '6|0';
                    break;
                case 'trade' :
                    $page_id = '7|0';
                    break;
                case 'voucher' :
                    $page_id = '8|0';
                    break;
                case 'newsfeed' :
                    $page_id = '9|0';
                    break;
                case 'magazine' :
                    $page_id = '10|1';
                    break;
                case 'product' :
                    $page_id = '12|0';
                    break;
                case 'specialoffers' :
                    $page_id = '16|0';
                    break;
                default :
                    $page_id = NULL;
                    break;
            }
            if (!empty($page_id) && UserHelper::checkUserAccess($page_id)) {
                $data_id = NULL;
                if(isset($_POST['data_id'])) $data_id = intval(filter_var($_POST['data_id'], FILTER_VALIDATE_INT));
                if(!empty($data_id)){
                    $viewmodel = new $this->registry->classModelName(NULL, 'd');
                    $strDb = ucfirst(MainHelper::getDbStr($className));
                    $strFunction = "delete".$strDb."Categories";
                    if ($viewmodel->{$strFunction}(array("id" => $data_id))){
                        if($className!='product') {
                            $field_name = 'id_kategori';
                            if($className=='newsfeed' || $className=='specialoffers') $field_name = 'kategori';
                            if($className=='magazine') $field_name = 'id_cat';

                            $strFunction = "update".$strDb;
                            $viewmodel = new $this->registry->classModelName(NULL, 'u');
                            $viewmodel->{$strFunction}(array($field_name => 0), array($field_name => $data_id));
                            if($className=='magazine') $viewmodel->updateMagazineSubCategories(array('id_kategori'=>0), array('id_kategori'=>$data_id));
                        }
                        $flag = 1;
                    }
                    else $flag = 2;
                }
                else $flag = 3;
            }
            else $flag = 4;
        }
        else $flag = 5;

        if($flag == 1) Messages::setMsg('Remove Success.', 'success', 'Succes!');
        echo $flag;
    }
}
?>