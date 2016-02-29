<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lance
 * Time: 下午2:09
 * To change this template use File | Settings | File Templates.
 */
class test_model extends Model {
    public function insert_route($data) {
       $data= $this->db->query('NSERT INTO  '.DB_PREFIX.'zhuhai  (stop,route,position,type,rows) VALUES ('.$data["stop"].','.$data["route"].','.$data["position"].','.$data["type"].','.$data["rows"].'))');
    }
}