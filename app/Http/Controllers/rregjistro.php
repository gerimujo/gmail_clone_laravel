<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dhena;
use App\Models\hyrje;
use App\Models\mesazhe;
use App\Models\hapmesazhe;

use Illuminate\Support\Facades\Session;

class rregjistro extends Controller
{
   public $id;

   public $emri;
   public $mbiemri;
   private $email;
   public $password;

   public function store(Request $request)
   {
      $emri = $request->input('emri');
      $mbiemri = $request->input('mbiemri');
      $email = $request->input('email');
      $password = $request->input('pass');


      $numer = rand(1000, 9999);
      $numer = (string) $numer;
      $reg = new dhena();
      $reg->id = $numer;
      $reg->emri = $emri;
      $reg->mbiemri = $mbiemri;
      $reg->email = $email;
      $reg->password = $password;
      $reg->save();





      return response(["proces" => "done"]);
   }
   public function hyremail(Request $request)
   {
      $email = $request->input('email');
      $data = dhena::where("email", $email)->get();
      $res = $data->all();

      if ($data[0]['email'] === $email) {
         hyrje::truncate();
         $model = new hyrje();
         $model->id = $data[0]['id'];
         $model->emri = $data[0]['emri'];
         $model->mbiemri = $data[0]['mbiemri'];
         $model->email = $data[0]['email'];
         $model->password = $data[0]['password'];
         $model->save();


      }


      return response($res);




   }
   function emailadr()
   {
      $mode = hyrje::first();

      return ($mode);


   }
   function passadr()
   {
      $model = hyrje::first();
      return ($model);

   }
   function emrishronjaepar()
   {
      $model = hyrje::first();
      $fjala = $model['emri'];
      $shkronja = substr($fjala, 0, 1);
      return (["shkronja" => $shkronja]);

   }
   function sendemail(Request $request)
   {

      $email = $request->input('email1');
      $subject = $request->input('subject1');
      $content = $request->input('content1');

     $email1 = hyrje::first();

      $emailim = $email1['email'];
      $numer = rand(1000, 9999);
      $numer = (string) $numer;
      $mes = new mesazhe();
      $mes->derguesi = $emailim;
      $mes->subject = $subject;
      $mes->text = $content;
      $mes->marresi = $email;
      $mes->id = $numer;
      $mes->save();
      return (["process" => "done"]);

   }
   function marrsend()
   {
      $emialhap = hyrje::first();
      $em = $emialhap['email'];
      $mesazh = mesazhe::where("derguesi", $em)->get();
      foreach ($mesazh as $mes) {
         $mes['ck'] = false;
         $ind = 0;
         $der = $mes['marresi'];

         while ($ind < strlen($der) && $der[$ind] !== "@") {
            $ind++;
         }
         $mes['name'] = "To : " . substr($der, 0, $ind);


      }
      return ($mesazh);
   }
   function marrinboxz(){
      $emialhap = hyrje::first();
      $em = $emialhap['email'];
      $mesazh = mesazhe::where("marresi", $em)->get();
      foreach ($mesazh as $mes) {
         $mes['ck'] = false;
         $ind = 0;
         $der = $mes['derguesi'];

         while ($ind < strlen($der) && $der[$ind] !== "@") {
            $ind++;
         }
         $mes['name'] = substr($der, 0, $ind);
      }
      return ($mesazh);
   }
   function deletemessagess(Request $request){
      $number = $request->input('number');
      
     foreach($number as $nu){
       mesazhe::where("id",$nu)->delete();
      }
      return(['number' => $number]);
    }
    function insertmesazhhapsend(Request $request){
      $numer = $request->input('number');
      hapmesazhe::truncate();
      $mesazhi = mesazhe::where("id", $numer)->get();
      $ne = new hapmesazhe();
      $ne->derguesi = $mesazhi[0]['derguesi'];
     $ne->subject = $mesazhi[0]['subject'];
     $ne->text = $mesazhi[0]['text'];
     $ne->marresi = $mesazhi[0]['marresi'];
     $ne->id = $mesazhi[0]['id'];
     $ne->save(); 
     return(["number"=>$numer]);


    }
    function sendmesazhehap(){
      $emialhap = hapmesazhe::first();
      $em = $emialhap['id'];
      $mesazh = mesazhe::where("id", $em)->get();

      foreach ($mesazh as $mes) {
         $mes['ck'] = false;
         $ind = 0;
         $der = $mes['marresi'];

         while ($ind < strlen($der) && $der[$ind] !== "@") {
            $ind++;
         }
         $mes['name'] = "To : " . substr($der, 0, $ind);


      }
      return ($mesazh);

    }function marrmesazhehap(){
      $emialhap = hapmesazhe::first();
      $em = $emialhap['id'];
      $mesazh = mesazhe::where("id", $em)->get();
      foreach ($mesazh as $mes) {
         $mes['ck'] = false;
         $ind = 0;
         $der = $mes['derguesi'];

         while ($ind < strlen($der) && $der[$ind] !== "@") {
            $ind++;
         }
         $mes['name'] = substr($der, 0, $ind);
      }
      return ($mesazh);
    }
    function nxjerrkeysearch(){
      $email = hyrje::first();
      $emai = $email['email'];

      $listaemail = mesazhe::where("derguesi",$emai)->orWhere("marresi", $emai)->get();
return($listaemail);



    }function logout(){
      $email = hyrje::first();
      $em = $email['email'];
      $embi = dhena::where("email", $em)->get();
    $emri = $embi[0]['emri'];
      $mbiemri = $embi[0]['mbiemri'];
      $bashk = $emri." ".$mbiemri;

      return(["email"=>$em, "bashk"=>$bashk]);

    }

}