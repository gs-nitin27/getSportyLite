<?php 
include('resources/config.php');
include('Controller/userdatabaseservice.php');

/****************Sign Up in Getsporty***********************/

if($_POST['act']=='gs_signup')
{
   $name       =  urldecode($_POST ['name']);
   $email      =  urldecode($_POST ['email']);
   $password1  =  md5(urldecode(@$_POST ['password']));
   $where      =  "WHERE `email` = '".$email."'";
   $req        =  new userdataservice();
   $res        =  $req->userExits($where);
   $data       =  array('name'=>$name,'email'=>$email,'password'=> $password1);
    if($res)
    {
     $status = array('status' => 0, 'message' => 'User is  already Registered');
     $data1=array('data' =>$status);
     echo json_encode($data1); 
    }
   else
   {
   $req1 = new userdataservice();

   $res1 = $req1->GsUserRegister($data);
   if($res1 == '1')
   {
   $req2 = new userdataservice();
   $res2 = $req2->userExits($where);
   if($res2 != 0)
   {
   $res3 = array('data' => $res2,'status' => 1);
   echo json_encode($res3);  
   }
   }
   else
   {
   $res3 = array('data' => 'Record not saved','status' => 0);
   echo json_encode($res3);  
   }
   }
} 

/****************************Sign In GetSporty*******************************/

else if($_REQUEST['act']=="gs_login")
  {
    //echo "ram";die();
    $email         = urldecode($_REQUEST['email']);
    $pass          = md5(urldecode($_REQUEST['password']));
    $username      = mysql_real_escape_string($email);
    $password1     = mysql_real_escape_string($pass);
    $req           =  new userdataservice();
    $res           =  $req->gsSignIn($email,$password1);
    if($res)
      {
        $data = array('data'=>$res,'status'=>'1');
        echo json_encode($data);
      }
      else
      {
        $data = array('data'=>'Invalid login credentials' , 'status'=>'0');
        echo json_encode($data);
      }
  }
/****************************Listing The Resources *******************************/

else if($_REQUEST['act']=="gs_list")
{ 
 // echo "ram";die();
    $req           =  new userdataservice();
    $res           =  $req->getList();
    if($res)
    {   
//print_r($res);die();
     // print_r($res[0]['description']);die;

      //echo $res['description'];die();

      // preg_replace("/[^a-zA-Z 0-9]+/", "", $res['description']);
        $data = array('data'=>$res,'status'=>'1');
        
       echo json_encode($data);
       //print_r($data);die();

       //print_r($data);
    }
    else
    {
       $data = array('data'=>'0' , 'status'=>'0');
        echo json_encode($data);
    }
}


/****************************Searching The Resources *******************************/

else if($_REQUEST['act']=="gs_sports")
{ 
    $req           =  new userdataservice();
    $res           =  $req->Get_Sports();
    if($res)
    {   
        $data = array('sports'=>$res);
        $data = array('data'=>$data,'status'=>'1');
        echo json_encode($data);
     }
    else
    {
       $data = array('data'=>'0' , 'status'=>'0');
        echo json_encode($data);
    }
}
else if($_REQUEST['act']=="gs_location")
{ 

    $req           =  new userdataservice();
    $res           =  $req->Get_Location();
    if($res)
    {   

      $data = array('location'=>$res);
        $data = array('data'=>$data,'status'=>'1');
        
       echo json_encode($data);
  
    }
    else
    {
       $data = array('data'=>'0' , 'status'=>'0');
        echo json_encode($data);
    }
}


/****************************Searching The Resources *******************************/



else if($_REQUEST['act']=="gs_search")
{
   $key          =  urldecode(@($_POST ['key']));
   $sports       =  urldecode((@$_POST ['sports']));
   $location     =  urldecode(@($_POST ['location']));
   $topic        =  urldecode(@($_POST ['topic']));
   //$para         =  urldecode(@($_POST ['para']));

     //echo "ram";die();
    $req           =  new userdataservice();
     //$where      =  "WHERE `email` = '".$email."'";
    //$fwhere="WHERE `sport`='$sports' OR `location`='$location' OR `title`='$topic'";

    $res           =  $req->GetSearch($key,$sports,$location,$topic,$key);
    if($res)
    {   

      //$data = array('location'=>$res);
        $data = array('data'=>$res,'status'=>'1');
        
       echo json_encode($data);
  
    }
    else
    {
       $data = array('data'=>'0' , 'status'=>'0');
        echo json_encode($data);
    }
}











?>