<!DOCTYPE html>


<?php
    include "operation.php";
    session_start();
 error_reporting(0);   
   if($_GET['req_to'])
    $user_email=$_GET['req_to'];

   
    $user= new user();
    $date = date_create();
    $personal=$user->search(NULL,$_SESSION['email']);
    $req_list=$user->req_list($_SESSION['email']);
    $fri_list=$user->fri_list($_SESSION['email']);
    $create_group=$user->group_info($_SESSION['email'],'create');
    $join_group=$user->group_info($_SESSION['email'],'join');
    $new_message=$user->New_message($_SESSION['email'],date_format($date,'Y-m-d H:i:s'));
    $Notification=$user->notification($_SESSION['email'],date_format($date,'Y-m-d H:i:s'));
    $user_info=$user->user_info($user_email);
    $my_post=$user->my_post($user_email);
    


    
if(is_array($user_info)){

    if(isset($user_info['success'])){
        $user_info1=$user_info['success'];
    }


}

if(is_array($new_message))
    {
        if(isset($new_message)){
            $new_message1=$new_message['success'];
            
        }
    }
    
    if(is_array($fri_list)){
        if(isset($fri_list['success'])){
            $fri_list1=$fri_list['success'];
        }

    }

    if(is_array($req_list)){
        if(isset($req_list['success'])){
            $req_list1=$req_list['success'];

        }  
          }
       
    if(isset($_POST['approved'])){
        

        $user->action('approve',$_POST['email'],$_SESSION['email']);
    }
    else if(isset($_POST['reject'])){

        $user->action('reject',$_POST['email'],$_SESSION['email']);
    }
    elseif(isset($_POST['text'])){
        $user->share($_SESSION['email'],$_POST['post'],'text');
    }
    elseif(isset($_POST['pic'])){
        
        $user->share($_SESSION['email'],$_FILES,'image');
    }

    $_SESSION['user_name']=$personal['success']['0']['First_Name'];
    $_SESSION['pic']=$personal['success']['0']['pic'];

    ?>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Gebo Admin Panel</title>
    
        <!-- Bootstrap framework -->
            <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
            <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css" />
        <!-- gebo blue theme-->
            <link rel="stylesheet" href="css/blue.css" />
        <!-- tooltips-->
            <link rel="stylesheet" href="lib/qtip2/jquery.qtip.min.css" />
        <!-- main styles -->
            <link rel="stylesheet" href="css/style.css" />
			
            

             <link rel="stylesheet" href="img/splashy/splashy.css" />
	
        <!-- Favicon -->
            <link rel="shortcut icon" href="favicon.ico" />

            <script src="js/jquery.min.js">
</script>

<!--<script>

          var limit="0:10"

if (document.images){
var parselimit=limit.split(":")
parselimit=parselimit[0]*60+parselimit[1]*1
}
function beginrefresh(){
if (!document.images)
return
if (parselimit==1)
window.location.reload()
else{ 
parselimit-=1
curmin=Math.floor(parselimit/60)
cursec=parselimit%60
if (curmin!=0)
curtime=curmin+" minutes and "+cursec+" seconds left until page refresh!"
else
curtime=cursec+" seconds left until page refresh!"
window.status=curtime
setTimeout("beginrefresh()",1000)
}
}

window.onload=beginrefresh
//-->
</script>

		
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/ie.css" />
            <script src="js/ie/html5.js"></script>
			<script src="js/ie/respond.min.js"></script>
        <![endif]-->
		
		<script>
			//* hide all elements & show preloader
			document.getElementsByTagName('html')[0].className = 'js';
		</script>
    <!-- Shared on MafiaShare.net  --><!-- Shared on MafiaShare.net  --></head>
    <body class="gebo-fixed">
		<div id="maincontainer" class="clearfix">
			<!-- header -->
            <header>
                <div class="navbar navbar-fixed-top">
                    <div class="navbar-inner">
                        <div class="container-fluid">
                            <a class="brand" href="dashboard.php"><i class="icon-home icon-white"></i> Home</a>
                            <ul class="nav user_menu pull-right">

                            	<li class="hidden-phone hidden-tablet">
                                    <div class="nb_boxes clearfix">
                                        <a data-toggle="modal" href="message_box.php?msg_type=recived"  class="label ttip_b" title="New messages"><?php echo count($new_message1);?> <i class="splashy-mail_light"></i></a>
                                        <a data-toggle="modal" data-backdrop="static" href="" class="label ttip_b" title="New tasks">10 <i class="splashy-calendar_week"></i></a>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['user_name'];?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
										<li><a href="user_profile.php">My profile</a></li>
										<li class="divider"></li>
										<li><a href=<?php echo "logout.php?action=logout";?>>Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
							<a data-target=".nav-collapse" data-toggle="collapse" class="btn_menu">
								<span class="icon-align-justify icon-white"></span>
							</a>
                            <nav>
                                <div class="nav-collapse">
                                    <ul class="nav">
                                        <li class="dropdown">
                                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php if(count($req_list)>0) echo count($req_list);?> Friends request <b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <?php
                                                        if(isset($req_list['success'])){
                                                        foreach ($req_list['success'] as $value) {

                                                            $_SESSION['Friend']=$value['Email'];
                                                            echo "<li><a href=''>$value[First_Name]. $value[Last_Name]  <form action='dashboard.php' method=POST ><input type=hidden value=$value[Email] name=email><input type ='submit' name='approved' value='confirm'>&nbsp;&nbsp;<input type ='submit' name='reject' value='reject'></form></a><li>";
                                                        }
                                                    }
                                                    elseif(isset($req_list['error'])){
                                                        echo "$req_list[error]";
                                                    }
                                                ?>         
                                            </ul>
                                        </li>
										<li class="dropdown">
                                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"> Notification<b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                 <?php                                               
                                                            
                                                if(isset($Notification['success'])){
                                                    
                                                foreach($Notification as $value){

                                                    echo "<li>$value[share_by]</li>";
                                                }
                                            }
                                            else  {
                                                
                                            
                                            
                                                echo "<li>No nofcation</li>";
                                            }


                                                ?>
                                               
                                            </ul>
                                        </li>
										<li class="dropdown">
                                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"> Setting <b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="setting.php">Account setting </a></li>
                                               
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- main content -->
           <div class="row-fluid"  style="margin-left:260px;margin-top:59px;">
                        <div class="span12">
                            <div class="chat_box">
                                <div class="row-fluid">
                                    <div class="span8 chat_content">
                                        <div class="vcard">

                                            <?php $s=(isset($user_info['success']['0']['pic']))? $user_info['success']['0']['pic'] : "img/User-icon.png";?>
                                        <img class="thumbnail" src=<?php echo $s;?> alt=""  width="90" height="90"/>
                                        <ul>
                                            <li class="v-heading">
                                                User info
                                            </li>
                                            <li>
                                                <span class="item-key">Full name</span>
                                                <div class="vcard-item"><?php echo $user_info['success']['0']['First_Name'] ," ", $user_info['success']['0']['Last_Name']; ?></div>
                                            </li>
                                           
                                            <li>
                                                <span class="item-key">Email</span>
                                                <div class="vcard-item"><?php echo $user_info['success']['0']['Email'];?></div>
                                            </li>
                                            <li>
                                                <span class="item-key">Gender</span>
                                                <div class="vcard-item"><?php echo $user_info['success']['0']['Gender'];?></div>
                                            </li>
                                            <li>
                                                <span class="item-key">City</span>
                                                <div class="vcard-item"><?php echo $user_info['success']['0']['Current_city'];?></div>
                                                
                                            </li>
                                             <li>
                                                <span class="item-key">HomeTown</span>
                                                <div class="vcard-item"><?php echo $user_info['success']['0']['Hometown'];?></div>
                                            </li>
                                           
                                            
                                            <li class="v-heading">
                                                User Post
                                            </li>
                                            </ul>
                                            <?php
                                            
                                            if(is_array($my_post))
                                                if(isset($my_post['success'])){


                                foreach($my_post['success'] as $value){

                                    if(isset($value['share_text'])){
                                       
                                        echo "<pre><div><img src='$value[pic]' width=60 height=60><h3>$value[First_Name]&nbsp;$value[Last_Name]</b></h3></div>
                                        <div><h3>$value[share_text]</h3></div>
                                        </pre>";                                                

                                        $comment1=$user->comment_access($value['share_id']);   

                                        if(isset($comment1))                                     
                                        foreach($comment1['success'] as $value3)
                                            echo "<pre><div><img src='$value3[pic]'  width=50 height=50>&nbsp;<b>&nbsp;&nbsp;$value3[First_Name]</b> $value3[comment]<div>Comment at &nbsp;$value3[timestamp]</div></div></pre>";
                                        
                                }
                                else if(isset($value['share_pic'])){

                                   echo "<pre><div><div><img src='$value[pic]' width=60 height=60><h3> $value[First_Name]&nbsp;$value[Last_Name]</h3></div>
                                       <div>$value[label]</div>
                                        <div><h2><img src=image/$value[share_pic] width=300 height=300 ></img></h2></div>
                                       </pre>";
                                   $comment1=$user->comment_access($value['share_id']);
                                   if(isset($comment1)) 
                                        foreach($comment1['success'] as $value3)
                                            echo "<pre><div><img src='$value3[pic]'  width=50 height=50>&nbsp;<b>$value3[First_Name]&nbsp;&nbsp;</b>$value3[comment]</div><div>Comment at &nbsp;$value3[timestamp]</div></pre>";
                                        
                                    } 

                                    else if(isset($value['share_video'])){

                                   echo "<pre><div><div><img src='$value[pic]' width=60 height=60><h3> $value[First_Name]&nbsp;$value[Last_Name]</h3></div>
                                   <div>$value[label]</div>
                                        <div><h2><video width=300 height=300 controls>
                                        <source src=image/$value[share_video] type=video/mp4>
                                        </video></h2></div>
                                      </pre>";
                                   $comment1=$user->comment_access($value['share_id']);
                                   if(isset($comment1)) 
                                        foreach($comment1['success'] as $value3)
                                            echo "<pre><div><img src='$value3[pic]'  width=50 height=50>&nbsp;<b>$value3[First_Name]&nbsp;&nbsp;</b>$value3[comment]</div><div>Comment at &nbsp;$value3[timestamp]</div></pre>";
                                        
                                    } 



                                }

                                                }
                                                else if(isset($my_post['error'])){

                                                   echo "<div class='alert alert-error'>                                
                               <strong><li>$my_post[error]</li></strong></div>"; 

                                                }

                                                

                                            ?>
                                   </div>                                     
                                                                       
                        </div>
                                    <div class="span3 chat_sidebar" style="margin-left:60px;">
                                        <div class="chat_heading clearfix">
                                            <div class="btn-group pull-right">
                                                <a href="#" class="btn btn-mini ttip_t" title="Refresh list"><i class="icon-refresh"></i></a>
                                                <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-mini ttip_t" title="Options"><i class="icon-cog"></i></a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#">Ban selected users</a></li>
                                                    <li><a href="#">Another action</a></li>
                                                </ul>   
                                            </div>
                                            Friends
                                        </div>
                                        <ul class="chat_user_list">
                                            <?php                             
                                   
                                    if(isset($fri_list['success']))
                                        foreach($fri_list['success'] as $value){

                                            $arr[]=$value['Email'];

                                           
                                    echo " <li class=online active chat_you>  

                                    <a href=message.php?friend_id=$value[Email] target=_blank>
                                      
                                    $value[First_Name] <span></span>   </a>

                                        
                                    </li>";
                                }

                                $_SESSION['friend']=$arr;
                               
                                    ?>                                          
                                           
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        

            
			<!-- sidebar -->
            <a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>
            <div class="sidebar">
				<div class="antiScroll">
					<div class="antiscroll-inner">
						<div class="antiscroll-content">
							<div class="sidebar_inner">
								<form action="search_page1.php" class="input-append" method="POST" >
                                    <input autocomplete="off"  class="search_query input-medium" size="16" type="text"  name="find"/><button type="submit" class="btn" name="search"><i class="icon-search"></i></button>
                                </form>
								<div id="side_accordion" class="accordion">

									 <div><img src=<?php echo $_SESSION['pic'];?> width=200 height=200><br><br>
									
									<div class="accordion-group">
										<div class="accordion-heading">
											<a href="#collapseOne" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
												Time line
											</a>
										</div>
										<div class="accordion-body collapse" id="collapseOne">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li><a href=<?php echo "timeline.php?req_to=$_SESSION[email]";?>> TimeLine</a></li>
													
												</ul>
											</div>
										</div>
									</div>
									<div class="accordion-group">
										<div class="accordion-heading">
											<a href="#collapseTwo" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
												Message
											</a>
										</div>
										<div class="accordion-body collapse" id="collapseTwo">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li><a href="message_box.php?msg_type=all" target=_blank>All message</a></li>
                                                    <li><a href="message_box.php?msg_type=send" target=_blank>Send Message</a></li>
                                                    <li><a href="message_box.php?msg_type=recived" target=_blank>Recived Message</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="accordion-group">
										<div class="accordion-heading">
											<a href="#collapseThree" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
												Group
											</a>
										</div>
										<div class="accordion-body collapse" id="collapseThree">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													 <?php
                                                    if(isset($join_group['success'])){
                                                    foreach($join_group['success'] as $value){
                                                        echo "<li><a href=group_user.php?group_id=$value[admin]&group_name=$value[group_name] target=_blank >$value[group_name]</a><li>";
                                                      $group[]=$value['group_name'];
                                                    }
                                                }
                                                else{
                                                    echo "No group found";
                                                }
                                                $_SESSION['group_name']=$group;                                                

                                                    ?>
												</ul>
											</div>
										</div>
									</div>
									<div class="accordion-group">
										<div class="accordion-heading">
											<a href="#collapseFour" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
												Group created
											</a>
										</div>
										<div class="accordion-body collapse in" id="collapseFour">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													 <?php             
                            if(isset($create_group['success']))
                              foreach($create_group['success'] as $value ){
                               echo "<li><a href=group_admin.php?id=$value[id]&group_id=$value[Email]&group_name=$value[First_Name] target=_blank>$value[First_Name]</a></li>";
                                                 
                                }

                                 ?>
                                 <li><a href ="group_reg.php"><b>Create New Group</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			
            
            <script src="js/jquery.min.js"></script>
			<!-- smart resize event -->
			<script src="js/jquery.debouncedresize.min.js"></script>
			<!-- hidden elements width/height -->
			<script src="js/jquery.actual.min.js"></script>
			<!-- js cookie plugin -->
			<script src="js/jquery.cookie.min.js"></script>
			<!-- main bootstrap js -->
			<script src="bootstrap/js/bootstrap.min.js"></script>
			<!-- tooltips -->
			<script src="lib/qtip2/jquery.qtip.min.js"></script>
			<!-- fix for ios orientation change -->
			<script src="js/ios-orientationchange-fix.js"></script>
			<!-- scrollbar -->
			<script src="lib/antiscroll/antiscroll.js"></script>
			<script src="lib/antiscroll/jquery-mousewheel.js"></script>
			<!-- common functions -->
			<script src="js/gebo_common.js"></script>
	
			<script>
				$(document).ready(function() {
					//* show all elements & remove preloader
					setTimeout('$("html").removeClass("js")',1000);
				});
			</script>
		
		</div>
	</body>
</html>