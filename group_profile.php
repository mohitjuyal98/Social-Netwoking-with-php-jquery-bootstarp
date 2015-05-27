<!DOCTYPE html>


<?php
    include "operation.php";
    session_start();
  // error_reporting(0);   


   
  
    $user= new user();
    $date = date_create();
    $personal=$user->search(NULL,$_SESSION['email']);
    $req_list=$user->req_list($_SESSION['email']);
     $fri_list=$user->group_member($_SESSION['group_id']);
    $create_group=$user->group_info($_SESSION['email'],'create');
    $join_group=$user->group_info($_SESSION['email'],'join');
    $new_message=$user->New_message($_SESSION['email'],date_format($date,'Y-m-d H:i:s'));
     $info=$user->user_info($_SESSION['group_id']);

    if(isset($_POST['update'])){
    $update=$user->group_update($_POST['First_Name'],$_POST['sign'],$_SESSION['group_id']);
    $user->upload($_FILES,$_SESSION['group_id']);

    if(is_array($update))

        if(isset($update['success'])){

            echo $update['success'];
        }
        elseif(isset($update['error'])){
            echo $update['error'];
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
        

        $user->group_action('approve',$_POST['email'],$_SESSION['group_id']);
    }
    else if(isset($_POST['reject'])){

        $user->group_action('reject',$_POST['email'],$_SESSION['group_id']);
    }
    elseif(isset($_POST['text'])){
        $user->group_share($_SESSION['email'],$_POST['post'],'text',$_SESSION['group_id']);
    }
    elseif(isset($_POST['pic'])){
        
        $user->group_share($_SESSION['email'],$_FILES,'image',$_SESSION['group_id']);
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
                            <a class="brand" href="#"><i class="icon-home icon-white"></i> Name</a>
                            <ul class="nav user_menu pull-right">

                            	<li class="hidden-phone hidden-tablet">
                                    <div class="nb_boxes clearfix">
                                        <a data-toggle="modal" href="message_box.php?msg_type=recived"  class="label ttip_b" title="New messages"><?php echo count($new_message1);?> <i class="splashy-mail_light"></i></a>
                                        <a data-toggle="modal" data-backdrop="static" href="" class="label ttip_b" title="New tasks">10 <i class="splashy-calendar_week"></i></a>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['group_name'];?>(Admin)<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
										<li><a href="group_profile.php">My profile</a></li>
										<li class="divider"></li>
										<li><a href=<?php echo "logout.php?action=logout"?>>Logout</a></li>
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
                                                    else if(isset($req_list['error'])){
                                                        echo "$req_list[error]";
                                                    }
                                                ?>         
                                            </ul>
                                        </li>
										<li class="dropdown">
                                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"> Notification<b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">menu section</a></li>
                                                <li><a href="#">menu section</a></li>
                                                <li><a href="#">menu section</a></li>
                                            </ul>
                                        </li>
										<li class="dropdown">
                                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"> Setting <b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Account setting </a></li>
                                               
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

                                        <form class="form-horizontal"  action="group_profile.php" method="POST"  enctype="multipart/form-data">
                                        <fieldset>
                                            <div class="control-group formSep">
                                                <label class="control-label">Username</label>
                                                <div class="controls text_line">
                                                    <strong><?php echo $_SESSION['group_id'];?></strong>
                                                </div>
                                            </div>
                                            <div class="control-group formSep">
                                                <label for="file" class="control-label">User avatar</label>
                                                <div class="controls">
                                                    <div data-fileupload="image" class="fileupload fileupload-new">
                                                        <input type="hidden" />
                                                        <div style="width: 80px; height: 80px;" class="fileupload-new thumbnail"><img src=<?php echo $info['success']['0']['pic'];?> alt="" /></div>
                                                        <div style="width: 80px; height: 80px; line-height: 80px;" class="fileupload-preview fileupload-exists thumbnail"></div>
                                                        <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" id="file" name="file" ></span>
                                                        <a data-dismiss="fileupload" class="btn fileupload-exists" href="#">Remove</a>
                                                    </div>  
                                                </div>
                                            </div>
                                            <div class="control-group formSep">
                                                <label for="u_fname" class="control-label">Group Name</label>
                                                <div class="controls">
                                                    <input type="text" id="u_fname" class="input-xlarge" name="First_Name" value=<?php echo $info['success']['0']['First_Name'];?> />
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="control-group formSep">
                                                <label class="control-label">I want to receive:</label>
                                                <div class="controls">
                                                    <label class="checkbox inline">
                                                        <input type="checkbox" value="newsletter" id="email_newsletter" name="email_receive" />
                                                        Newsletters
                                                    </label>
                                                    <label class="checkbox inline">
                                                        <input type="checkbox" value="sys_messages" id="email_sysmessages" name="email_receive" checked="checked" />
                                                        System messages
                                                    </label>
                                                    <label class="checkbox inline">
                                                        <input type="checkbox" value="other_messages" id="email_othermessages" name="email_receive" />
                                                        Other messages
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="control-group formSep">
                                                <label class="control-label">Language(s)</label>
                                                <div class="controls">
                                                    <select name="user_languages" id="user_languages" multiple data-placeholder="Choose a language(s)..." class="span8">
                                                        <option selected="selected">English</option>
                                                        <option>French</option>
                                                        <option>German</option>
                                                        <option>Italian</option>
                                                        <option>Chinese</option>
                                                        <option>Spanish</option>
                                                    </select>
                                                </div>
                                            </div>
                                            

                                            <div class="control-group formSep">
                                                <label for="u_signature" class="control-label">Signature</label>
                                                <div class="controls">
                                                    <textarea rows="4" id="u_signature" class="input-xlarge" name="sign"><?php echo $info['success']['0']['sign'];?></textarea>
                                                    <span class="help-block">Automatic resize</span>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <button class="btn btn-gebo" type="submit" name="update">Save changes</button>
                                                <button class="btn">Cancel</button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
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
                                            Group member
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

									 <div><img src=<?php echo $_SESSION['pic']?> width=200 height=200><br><br>
									
									<div class="accordion-group">
										<div class="accordion-heading">
											<a href="#collapseOne" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
												Section
											</a>
										</div>
										<div class="accordion-body collapse" id="collapseOne">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
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

			<!-- <div  class="sidebar_right">
			 	<div class="antiScroll">
					<div class="antiscroll-inner">
						<div class="antiscroll-content">
							<div class="sidebar_inner">
								<form action="index.php?uid=1&amp;page=search_page" class="input-append" method="post" >
									<input autocomplete="off" name="query" class="search_query input-medium" size="16" type="text" placeholder="Search..." /><button type="submit" class="btn"><i class="icon-search"></i></button>
								</form>
								<div id="side_accordion" class="accordion">
									
									<div class="accordion-group">
										<div class="accordion-heading">
											<a href="#collapseOne" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
												Section
											</a>
										</div>
										<div class="accordion-body collapse" id="collapseOne">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="accordion-group">
										<div class="accordion-heading">
											<a href="#collapseTwo" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
												Section
											</a>
										</div>
										<div class="accordion-body collapse" id="collapseTwo">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="accordion-group">
										<div class="accordion-heading">
											<a href="#collapseThree" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
												Section
											</a>
										</div>
										<div class="accordion-body collapse" id="collapseThree">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="accordion-group">
										<div class="accordion-heading">
											<a href="#collapseFour" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
												Section
											</a>
										</div>
										<div class="accordion-body collapse in" id="collapseFour">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
													<li><a href="javascript:void(0)">Side menu</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>-->

            
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