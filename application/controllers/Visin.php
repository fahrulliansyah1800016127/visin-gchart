<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Visin extends CI_Controller {
	public function index()
	{
        $dataUrl=base_url('assets/sales.json');
        $dataStringJson=file_get_contents($dataUrl);
        $dataJson=json_decode($dataStringJson);
        $data=$dataJson[2]->data;      
        $output['region']=$this->region($data);
        $this->load->view('visin',$output);   
    }

    function region($data)
    {
        $result=array();
        foreach($data as $row)
        {
            if(isset($result[$row->Region]) == false)
            {
                $result[$row->Region]=$row->Units;
            }else{
                $units=$result[$row->Region];
                $result[$row->Region]=$units + $row->Units;
            }
        };
        //konversi dalam format tabulasi
        $keys=array_keys($result);
        $tabs=[['Region','Units']];
        foreach($keys as $row)
        {
            $dt=[$row,$result[$row]];
            array_push($tabs,$dt);
        }
        return json_encode($tabs);
    }
}
