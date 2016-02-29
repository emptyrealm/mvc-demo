<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lance
 * Time: 下午3:40
 * To change this template use File | Settings | File Templates.
 */
class home extends Controller {

    public $server_url='http://www.twototwo.cn/bus/Service.aspx?';
    public $key='965fdc7b-2e11-4aa8-b013-05449acc865a';
    public $zone='珠海';
    public $format='json';
    public $type=array(
        '1'=>'去程',
        '2'=>'回程',
        '3'=>'环线',
        '4'=>'单向行驶'
    );


    public function index(){
        $this->response->setOutput($this->render('demo/index'));
    }

    public function route_list() {
        $url=$this->server_url.'format='.$this->format.'&action=QueryAllBusLine&key='.$this->key.'&zone='.$this->zone.'&more=1';
        $result=$this->_curl($url);
        $result=json_decode($result,true);
        $result=$result['Response']['Main']['Item'];
        foreach($result as $item){
            $url2=$this->server_url.'format='.$this->format.'&action=QueryBusByLine&key='.$this->key.'&zone='.$this->zone.'&line='.$item['XianLuBianMa'];
            $result2=$this->_curl($url2);
            $result2=json_decode($result2,true);
            $result2=$result2['Response']['Main']['Item']['FangXiang'];

            foreach($result2 as $item2){
                $this->load->model('test');
                $insert_data=array();
                $insert_data['stop']=in_array($item2['@Value'],$this->type);
                $insert_data['rows']=$item2['@Rows'];
                $this->test_model->test();
                print_r($result2);
                exit;
            }
        }

    }

    public function _curl($url){
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, $url);
        curl_setopt ($curl, CURLOPT_HEADER,0);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
        curl_setopt ($curl, CURLOPT_TIMEOUT,5);
        $get_content = curl_exec($curl);
        curl_close ($curl);
        return $get_content;
    }
}