<?php

namespace app\controllers;

use Yii;
use app\models\LineForm;
use yii\web\Controller;
use yii\web\Response;

class LineController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate(){
        $model = new LineForm();
        $access_token = 'Vc4+AyNpHxJCvzDsINZQpYx0j89Y26XWpAefFLHqIsekth8Be35Z5JtScJfXONx2SIHHBnq2g1xORJVW93vJqLyebuuwyLQ3Wo5zAT7kjEdq+3JQtuhKlDSijQBG7tKeK2YdcsLG0Z8BUedjyZrkmAdB04t89/1O/w1cDnyilFU=';
        $url = 'https://api.line.me/v2/bot/message/push';
        $to = 'U42bd564d1c5ed0adf7d5a43113a277d0';
        
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $data = [
                'messages'=> [$model->message]
            ];
            $post = json_encode($data);
            $result = $this->getCurl($url,$access_token,$post);
            return $this->render('create',['result'=>$result]);
        }
        return $this->render('create',['model'=>$model]);
    }

    protected function getCurl($url,$access_token,$data){
        $header = array('Content-Type: application/json','Authorization: Bearer '.$access_token);
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result ."\r\n";
    }

}
