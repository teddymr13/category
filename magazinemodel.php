<?php
require_once 'traits/mainslidermodeltrait.php';

class MagazineModel extends Model{
    use MainSliderModelTrait;

    public function getMagazineCategories($param = NULL, $sql_str = "", $exception = false){
        if($exception){
            if(empty($sql_str)) $sql_str = "SELECT id, kategori FROM magazine_categories WHERE id > 0";
            if(!empty($param)){
                if(isset($param['order_by'])) $sql_str .= $this->concatOrder($param['order_by']);
                if(isset($param['limit'])) $sql_str .= $this->concatLimiter($param['limit']);
            }
            $this->query($sql_str);
            return $this->resultSet();
        }
        else {
            $sql_str = "SELECT id, kategori FROM magazine_categories";
            return $this->basicQuerySelect($param, $sql_str);
        }
    }
    public function insertMagazineCategories($param, $sql_str = "INSERT INTO magazine_categories"){
        return $this->basicQueryInsert($param, $sql_str);
    }
    public function updateMagazineCategories($set, $param = NULL, $sql_str = "UPDATE magazine_categories"){
        return $this->basicQueryUpdate($set, $param, $sql_str);
    }
    public function deleteMagazineCategories($param = NULL, $sql_str = "DELETE FROM magazine_categories"){
        return $this->basicQueryDelete($param, $sql_str);
    }

    public function getMagazineSubCategories($param = NULL, $sql_str = "", $join = false, $exception = false){
        if($exception){
            if(empty($sql_str)) {
                if($join) $sql_str = "SELECT magazine_sub_categories.id, magazine_sub_categories.nama, magazine_sub_categories.id_kategori, magazine_categories.kategori as parent FROM magazine_sub_categories LEFT JOIN magazine_categories ON magazine_sub_categories.id_kategori = magazine_categories.id WHERE magazine_sub_categories.id > 0";
                else $sql_str = "SELECT id, nama, id_kategori FROM magazine_sub_categories WHERE id > 0";
            }
            if(!empty($param)){
                if(isset($param['order_by'])) $sql_str .= $this->concatOrder($param['order_by']);
                if(isset($param['limit'])) $sql_str .= $this->concatLimiter($param['limit']);
            }
            $this->query($sql_str);
            return $this->resultSet();
        }
        else {
            if($join) $sql_str = "SELECT magazine_sub_categories.id, magazine_sub_categories.nama, magazine_sub_categories.id_kategori, magazine_categories.kategori as parent FROM magazine_sub_categories LEFT JOIN magazine_categories ON magazine_sub_categories.id_kategori = magazine_categories.id";
            else $sql_str = "SELECT id, nama, id_kategori FROM magazine_sub_categories";
            return $this->basicQuerySelect($param, $sql_str);
        }
    }
    public function insertMagazineSubCategories($param, $sql_str = "INSERT INTO magazine_sub_categories"){
        return $this->basicQueryInsert($param, $sql_str);
    }
    public function updateMagazineSubCategories($set, $param = NULL, $sql_str = "UPDATE magazine_sub_categories"){
        return $this->basicQueryUpdate($set, $param, $sql_str);
    }
    public function deleteMagazineSubCategories($param = NULL, $sql_str = "DELETE FROM magazine_sub_categories"){
        return $this->basicQueryDelete($param, $sql_str);
    }

    public function getMagazineBrands($param = NULL, $sql_str = "", $exception = false){
        if($exception){
            if(empty($sql_str)) $sql_str = "SELECT id, merek FROM magazine_brand WHERE id > 0";
            if(!empty($param)){
                if(isset($param['order_by'])) $sql_str .= $this->concatOrder($param['order_by']);
                if(isset($param['limit'])) $sql_str .= $this->concatLimiter($param['limit']);
            }
            $this->query($sql_str);
            return $this->resultSet();
        }
        else {
            $sql_str = "SELECT id, merek, url_merek, url_gambar, periode, deskp, kk,ovw FROM magazine_brand";
            return $this->basicQuerySelect($param, $sql_str);
        }
    }
    public function insertMagazineBrands($param, $sql_str = "INSERT INTO magazine_brand"){
        return $this->basicQueryInsert($param, $sql_str);
    }
    public function updateMagazineBrands($set, $param = NULL, $sql_str = "UPDATE magazine_brand"){
        return $this->basicQueryUpdate($set, $param, $sql_str);
    }
    public function deleteMagazineBrands($param = NULL, $sql_str = "DELETE FROM magazine_brand"){
        return $this->basicQueryDelete($param, $sql_str);
    }

    public function deleteMagazineMainPic($param = NULL, $sql_str = "DELETE FROM magazine_main_pic"){
        return $this->basicQueryDelete($param, $sql_str);
    }

    public function getMagazinePricing($param = NULL, $sql_str = "SELECT id_merek, periode, jml_issue, harga, harga_promo FROM magazine_pricing"){
        return $this->basicQuerySelect($param, $sql_str);
    }
    public function bulkInsertMagazinePricing($id, $period, $issue, $price, $discounted_price){
        if(!empty($id) && is_array($period) && is_array($issue) && is_array($price) && is_array($discounted_price)) {
            $str_values = '';
            $write_comma = false;
            for ($i = 0; $i < count($period); $i++) {
                if (!empty($period[$i]) && !empty($issue[$i]) && !empty($price[$i])) {
                    $checkPrice = true;
                    if(!empty($discounted_price[$i]) && round($discounted_price[$i], 2) >= round($price[$i], 2)) $checkPrice = false;
                    if($checkPrice) {
                        if ($write_comma) $str_values .= ", ";
                        else $write_comma = true;
                        $str_values .= "(:brandid, :period" . $i . ", :issue" . $i . ", :price" . $i . ", :discprice" . $i . ")";
                    }
                }
            }

            if (!empty($str_values)) {
                $this->query("INSERT INTO magazine_pricing (id_merek, periode, jml_issue, harga, harga_promo) VALUES " . $str_values);
                $this->bind(":brandid", $id);
                for ($i = 0; $i < count($period); $i++) {
                    if (!empty($period[$i]) && !empty($issue[$i]) && !empty($price[$i])) {
                        $checkPrice = true;
                        if(!empty($discounted_price[$i]) && round($discounted_price[$i], 2) >= round($price[$i], 2)) $checkPrice = false;
                        if($checkPrice) {
                            $this->bind(":period" . $i, $period[$i]);
                            $this->bind(":issue" . $i, $issue[$i]);
                            $this->bind(":price" . $i, round($price[$i], 2));
                            $this->bind(":discprice" . $i, round($discounted_price[$i], 2));
                        }
                    }
                }
                return $this->execute();
            }
            else return true;
        }
        return false;
    }
    public function deleteMagazinePricing($param = NULL, $sql_str = "DELETE FROM magazine_pricing"){
        return $this->basicQueryDelete($param, $sql_str);
    }

    public function getMaMagazPeriod($param = NULL, $sql_str = "SELECT id, periode FROM ma_magz_period"){
        return $this->basicQuerySelect($param, $sql_str);
    }

    public function getMagazine($param = NULL, $sql_str = "", $join = false){
        if(empty($sql_str))
            if($join) $sql_str = "SELECT magazine.id as id, magazine.judul as judul, magazine.url_judul as url_judul, magazine.sub_judul as sub_judul, magazine.id_merek as id_merek, magazine.tgl_terbit as tgl_terbit, magazine_brand.merek as merek, magazine_brand.url_merek as url_merek FROM magazine LEFT JOIN magazine_brand ON magazine.id_merek = magazine_brand.id";
            else $sql_str = "SELECT id, judul, sub_judul, id_cat, id_sub_cat, id_merek, data_config_id, ovw, kk, deskp, harga, harga_promo, url_thumb, url_cover, url_video, vol_edisi, no_edisi, tgl_terbit, jml_hlm, best_seller FROM magazine";
        return $this->basicQuerySelect($param, $sql_str);
    }
    public function getMagazineWithFilter($filter_title, $filter_category, $filter_sub_category, $filter_brand, $filter_issued_date_from, $filter_issued_date_to, $param = NULL, $join = false){
        $condition = "";
        if(!empty($filter_title)) $condition = " WHERE (magazine.judul LIKE :judul OR magazine.sub_judul LIKE :judul)";
        if($filter_category > 0 || $filter_category === 0){
            if(empty($condition)) $condition = " WHERE";
            else $condition .= " AND";
            if($filter_category === 0) $condition .= " (magazine.id_cat = 0 || magazine.id_sub_cat = 0)";
            else $condition .= " magazine.id_cat = :category";
        }
        if(!empty($filter_sub_category)){
            if(empty($condition)) $condition = " WHERE";
            else $condition .= " AND";
            $condition .= " magazine.id_sub_cat = :subcategory";
        }
        if($filter_brand > 0 || $filter_brand === 0){
            if(empty($condition)) $condition = " WHERE";
            else $condition .= " AND";
            $condition .= " magazine.id_merek = :brand";
        }
        if(!empty($filter_issued_date_from)){
            if(empty($condition)) $condition = " WHERE";
            else $condition .= " AND";
            $condition .= " magazine.tgl_terbit >= :dateissuedfrom";
        }
        if(!empty($filter_issued_date_to)){
            if(empty($condition)) $condition = " WHERE";
            else $condition .= " AND";
            $condition .= " magazine.tgl_terbit <= :dateissuedto";
        }

        if($join) {
            $sql_str = "SELECT magazine.id as id, magazine.judul as judul, magazine.sub_judul as sub_judul, magazine.tgl_terbit as tgl_terbit, magazine_brand.merek as merek FROM magazine LEFT JOIN magazine_brand ON magazine.id_merek = magazine_brand.id" . $condition;
        }
        else $sql_str = "SELECT magazine.id FROM magazine" . $condition;

        if(isset($param['order_by'])) $sql_str .= $this->concatOrder($param['order_by']);
        if(isset($param['limit'])) $sql_str .= $this->concatLimiter($param['limit']);

        $this->query($sql_str);
        if(!empty($filter_title)) $this->bind(':judul', "%" . $filter_title . "%");
        if(!empty($filter_category)) $this->bind(':category', $filter_category);
        if(!empty($filter_sub_category)) $this->bind(':subcategory', $filter_sub_category);
        if($filter_brand > 0 || $filter_brand === 0) $this->bind(':brand', $filter_brand);
        if(!empty($filter_issued_date_from)) $this->bind(':dateissuedfrom', $filter_issued_date_from);
        if(!empty($filter_issued_date_to)) $this->bind(':dateissuedto', $filter_issued_date_to);
        return $this->resultSet();
    }
    public function insertMagazine($param, $sql_str = "INSERT INTO magazine"){
        return $this->basicQueryInsert($param, $sql_str);
    }
    public function updateMagazine($set, $param = NULL, $sql_str = "UPDATE magazine"){
        return $this->basicQueryUpdate($set, $param, $sql_str);
    }
    public function deleteMagazine($param = NULL, $sql_str = "DELETE FROM magazine"){
        return $this->basicQueryDelete($param, $sql_str);
    }

    public function getMagazineTransactions($param = NULL, $sql_str = "", $join = false){
        if(empty($sql_str))
            if($join) $sql_str = "SELECT magazine_transaction.id as id, magazine_transaction.price as price, magazine_transaction.date_created as date_created, magazine_transaction.status as status, magazine_transaction.status_by_admin as status_by_admin, user_data_front_end.nama as nama FROM magazine_transaction LEFT JOIN user_data_front_end ON magazine_transaction.id_user = user_data_front_end.id";
            else $sql_str = "SELECT id, email_ppac, id_trans_paypal, id_receipt_paypal, receipt_ref_num_paypal, id_user, id_admin, price, tipe_transaksi, id_majalah, detail_majalah, date_created, date_verified, date_confirmed, status, status_by_admin, cancel_desc FROM magazine_transaction";
        return $this->basicQuerySelect($param, $sql_str);
    }
    public function getMagazineTransactionsWithFilter($filter_id, $filter_name, $filter_status, $filter_date_added_from, $filter_date_added_to, $param = NULL, $join = false){
        $condition = "";
        if(!empty($filter_id)) $condition = " WHERE magazine_transaction.id LIKE :id";
        if(!empty($filter_name)){
            if(empty($condition)) $condition = " WHERE";
            else $condition .= " AND";
            $condition .= " magazine_transaction.id_user IN (SELECT user_data_front_end.id FROM user_data_front_end WHERE user_data_front_end.nama LIKE :name)";
        }
        if(!empty($filter_status)){
            if(empty($condition)) $condition = " WHERE";
            else $condition .= " AND";
            switch ($filter_status){
                case 1 : $condition .= " magazine_transaction.status = 1 AND magazine_transaction.status_by_admin = 1"; break;
                case 2 : $condition .= " (magazine_transaction.status = 1 OR magazine_transaction.status = 2) AND magazine_transaction.status_by_admin = 0"; break;
                case 3 : $condition .= " magazine_transaction.status = 0"; break;
                default: break;
            }
        }
        if(!empty($filter_date_added_from)){
            if(empty($condition)) $condition = " WHERE";
            else $condition .= " AND";
            $condition .= " magazine_transaction.date_created >= :datefrom";
        }
        if(!empty($filter_date_added_to)){
            if(empty($condition)) $condition = " WHERE";
            else $condition .= " AND";
            $condition .= " magazine_transaction.date_created <= :dateto";
        }

        if($join) {
            $sql_str = "SELECT magazine_transaction.id as id, magazine_transaction.price as price, magazine_transaction.date_created as date_created, magazine_transaction.status as status, magazine_transaction.status_by_admin as status_by_admin, user_data_front_end.nama as nama FROM magazine_transaction LEFT JOIN user_data_front_end ON magazine_transaction.id_user = user_data_front_end.id" . $condition;
        }
        else $sql_str = "SELECT magazine_transaction.id FROM magazine_transaction" . $condition;

        if(isset($param['order_by'])) $sql_str .= $this->concatOrder($param['order_by']);
        if(isset($param['limit'])) $sql_str .= $this->concatLimiter($param['limit']);

        $this->query($sql_str);
        if(!empty($filter_id)) $this->bind(':id', "%" . $filter_id . "%");
        if(!empty($filter_name)) $this->bind(':name', "%" . $filter_name . "%");
        if(!empty($filter_date_added_from)) $this->bind(':datefrom', $filter_date_added_from . " 00:00:00");
        if(!empty($filter_date_added_to)) $this->bind(':dateto', $filter_date_added_to . " 23:59:59");
        return $this->resultSet();
    }
    public function updateMagazineTransactions($set, $param = NULL, $sql_str = "UPDATE magazine_transaction"){
        return $this->basicQueryUpdate($set, $param, $sql_str);
    }

    public function getEmailUserMagazineSubscriber($idbrand, $validuntil){
        $this->query("SELECT user_login_front_end.email as email FROM user_magazine_subscription LEFT JOIN user_login_front_end ON user_magazine_subscription.id_user = user_login_front_end.id WHERE user_magazine_subscription.id_merek = :idbrand AND user_magazine_subscription.valid_until >= :validuntil");
        $this->bind(':idbrand', $idbrand);
        $this->bind(':validuntil', $validuntil);
        return $this->resultSet();
    }
    public function getUserMagazineSubscription($param = NULL, $sql_str = "SELECT valid_until FROM user_magazine_subscription"){
        return $this->basicQuerySelect($param, $sql_str);
    }
    public function insertUserMagazineSubscription($param, $sql_str = "INSERT INTO user_magazine_subscription"){
        return $this->basicQueryInsert($param, $sql_str);
    }
    public function updateUserMagazineSubscription($set, $param = NULL, $sql_str = "UPDATE user_magazine_subscription"){
        return $this->basicQueryUpdate($set, $param, $sql_str);
    }
}