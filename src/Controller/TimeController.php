<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

class TimeController extends AbstractController
{
    /**
     * @Route("/time", name="time", methods={"POST"})
     */
    public function index(Request $request): Response
    {
        $data =$request->getContent();
        $arr = json_decode($data);
        $aux = array();
        foreach ($arr as $key => $value) {

                if($key == "data1"){
                    
                    $hora = substr($value, 0,2);
                }
                if ($key == "data2") {
                    if(strlen($value)>1){

                        $simbolo = '-';
                        $cantidad = substr($value, 1,1);
                    }else{
                        $simbolo = '+';
                        $cantidad = substr($value, 0,1);
                    }

                }

                $aux[$key] = $value;           
            
            
            
                
        }

         $invalidHora=array(

            'code'=>406,
            'message'=>'Not Acceptable',
            'errors'=>true,
            'result'=>json_decode($data)

        );


        if(intval($hora)>24){
            return new JsonResponse($invalidHora,406);
        }
        if($simbolo == '+'){
            $nuevaHora = intval($hora) + intval($cantidad);    
        }
        if($simbolo == '-'){
            $nuevaHora = intval($hora) - intval($cantidad);    
        }
        if($nuevaHora > 24){
            $nuevaHora=$nuevaHora - 24;
        }
         $result['time'] = substr_replace($aux["data1"], str_pad($nuevaHora,2, '0', STR_PAD_LEFT) , 0, 2);
         $result['timezone'] = 'utc';


        
         $response=array(

            'code'=>200,
            'message'=>'success',
            'errors'=>null,
            'result'=>$result

        );

        return new JsonResponse($response,200);
    }
}
