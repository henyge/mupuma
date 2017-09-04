<?php
/*******************************************************************************
* Mupuma Management Solutions Limited Website  -- General API for pages --     *
*                                                                              *
* Version: 3.0 Web App                                                         *
* Date:    2017-08-19                                                          *
* Author:  AYERAKWA Henry Gyan, 0269605544                                     *
*******************************************************************************/

session_start(['cache_limiter' => 'private']);
require_once('library.php');
ini_set('display_errors',1);

class PRICOM extends PMS_LIBRARY{
  var $loginError;
	
  //API Constructor
  public function __construct(){
		parent::__construct();
	}
	
	function _head(){
  ?>
  <!DOCTYPE html>
	<html class="no-js" lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="description" content="software app site template" />
	<meta name="keywords" content="corporate, software, app, business, marketing, site template, web marketing, internate marketing"/>
	<meta name="author" content="Tansh" />
	<link rel="icon" type="image/png" href="assets/images/logo_new.png"/>
	<title>Mupuma Management Solutions Ltd.</title>

	<!--google web font-->
	<link href="http://fonts.googleapis.com/css?family=Arimo:400,400italic" rel="stylesheet" type="text/css">

	<!--style sheets-->
	<link rel="stylesheet" media="screen" href="assets/css/style.css"/>
	<link rel="stylesheet" media="screen" href="assets/css/navigation.css"/>
	<link rel="stylesheet" media="screen" href="assets/css/jquery-ui-1.10.3.custom.css"/>
	<!--[if IE 7]>
					<link rel="stylesheet" type="text/css" href="css/ie7.css">
	<![endif]-->
	<!--[if IE 8]>
					<link rel="stylesheet" type="text/css" href="css/ie8.css">
	<![endif]-->

	<!--jquery libraries / others are at the bottom-->
	<script src="assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="assets/js/modernizr.js" type="text/javascript"></script>

	<!--flexslider scripts starts-->
	<link rel="stylesheet" media="screen" href="assets/css/flexslider.css"/>
	<script src="assets/js/jquery.flexslider-min.js" type="text/javascript" ></script>
	<script type="text/javascript">
	$(window).load(function () {
			//Image Slider
			$('.image-slider').flexslider({
					animation: "slide",
					slideshowSpeed: 4000,
					animationDuration: 600,
					controlNav: true,
					keyboardNav: true,
					directionNav: true,
					pauseOnHover: true,
					pauseOnAction: true,
			});
	});
	</script>
	<!--flexslider scripts end-->

	<!--jcarousel scripts starts-->
	<link rel="stylesheet" media="screen" href="assets/css/jcarousel.css"/>
	<script src="assets/js/jquery.jcarousel.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	//Image slider for gallery	
	$(document).ready(function() {	
		$('#mycarousel').jcarousel({
			 easing: 'easeInOutQuint',
			 animation: 600
		});

	});
	</script>
	<!--jcarousel scripts ends-->

	<!--prettyphoto scripts starts-->
	<link rel="stylesheet" media="screen" href="assets/css/prettyPhoto.css"/>
	<script src="assets/js/jquery.prettyPhoto.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function() {	
	$('a[data-rel]').each(function() {
			$(this).attr('rel', $(this).data('rel'));
	});
	$("a[rel^='prettyPhoto[mixed]']").prettyPhoto({
			animation_speed: 'fast',
			slideshow: 5000,
			autoplay_slideshow: false,
			opacity: 0.80,
			show_title: false,
			theme: 'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
			overlay_gallery: false,
			social_tools: false
	});
	});
	</script>
	<!--prettyphoto scripts ends-->

	<!--subscribe scripts starts-->
	<script src="assets/js/jquery.validate.js"  type="text/javascript"></script>
	<script src="assets/js/jquery.form.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function() {	
	$(function() {
			var v = $("#subform").validate({
			submitHandler: function(form) {
			$(form).ajaxSubmit({
			target: "#result_sub",
			clearForm: true
			});
			}
			});
	});	
	//To clear form field on page refresh
	$('#subform #email').val('');
	});
	</script>
	<!--subscribe scripts ends-->

	</head>
	<body>
  <?php
  }
	function _foot(){
  ?>
			<script src="assets/js/jquery.supersubs.js" type="text/javascript"></script> 
			<script src="assets/js/jquery.superfish.js" type="text/javascript"></script> 
			<script src="assets/js/jquery.cycle.all.js" type="text/javascript"></script> 
			<script src="assets/js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script> 
			<script src="assets/js/jquery.easing.1.3.js" type="text/javascript"></script> 
			<script src="assets/js/jquery.quicksand.js" type="text/javascript"></script> 
			<script src="assets/js/twitter.js" type="text/javascript"></script> 
			<script src="assets/js/custom.js" type="text/javascript"></script>
		</body>
	</html>
  <?php
  }
	function _footItem(){
  ?>
  <div id="footer">
		<div class="container footer_inner clearfix"> 

			<!--about starts-->
			<div class="grid_4">
				<h4>About Mupuma</h4>
				<p>We are an African company defining service and excellence in technology-driven business solutions. Mupuma Management Solutions Limited was established in Zambia in 2010 with two local directors. </p>
				<a href="#"><img src="assets/images/logo.png" width="125" height="35" alt="logo" class="logo"></a> </div>
			<!--about ends--> 

			<!--list starts-->
			<div class="grid_4">
				<h4>Quick Links</h4>
				<ul class="list1">
					<li><a href="#">About Mupuma</a></li>
					<li><a href="#">Our Team</a></li>
					<li><a href="#">Services</a></li>
					<li><a href="#">Help</a></li>
					<li><a href="#">Contacts</a></li>
				</ul>
			</div>
			<!--list ends--> 

			<!--testimonial starts-->
			<div class="grid_4">
				<h4>What our clients say...</h4>
				<div class="testimonial_style1"> 

					<!--first testimonial starts-->
					<div>
						<p>" Praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim "</p>
						<span>John Doe <br/>
						company name</span> </div>
					<!--first testimonial ends--> 

					<!--second testimonial starts-->
					<div>
						<p>" Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram decima. "</p>
						<span>Jenny<br/>
						company name</span> </div>
					<!--second testimonial ends--> 

				</div>
			</div>
			<!--testimonial ends--> 

			<div class="clear"></div>
		</div>
	</div>
	<div id="copyright">
		<div class="container clearfix"> 

			<!--copyright text and general links-->
			<div class="grid_6">
				<p>&copy; MMXVII &middot; All the respective rights reserved &middot; Mupuma Management Solutions</p>
				<ul class="copyright">
					<li><a href="<?= $this->path; ?>terms/">Terms</a></li>
					<li><a href="<?= $this->path; ?>privacy/">Privacy policy</a></li>
					<li>Powered by: <a href="http://www.pricomghana.com" target="_blank">Pricom</a></li>
				</ul>
			</div>

			<!--social links-->
			<div class="grid_6">
				<ul class="social">
					<li><a href="#"><img src="assets/images/icons/social/twitter.png" width="16" height="16" alt="icon"></a></li>
					<li><a href="#"><img src="assets/images/icons/social/facebook.png" width="16" height="16" alt="icon"></a></li>
					<li><a href="#"><img src="assets/images/icons/social/google-plus.png" width="16" height="16" alt="icon"></a></li>
					<li><a href="#"><img src="assets/images/icons/social/flickr.png" width="16" height="16" alt="icon"></a></li>
					<li><a href="#"><img src="assets/images/icons/social/delicious.png" width="16" height="16" alt="icon"></a></li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
	</div>
  <?php
  }
	
	//Includes - Page segments
	function _topBar(){
		
  ?>
	<div id="top">
		<div class="container clearfix">
			<div class="grid_12">
				<p>Welcome to Mupuma Management Solutions</p>
				<p class="call">Call for support: <span class="color">+260 966 795 334</span></p>
			</div>
		</div>
	</div>
  <?php
  }
	function _topArea(){
		$data = $this->getData('SELECT * FROM portal WHERE page=6 AND category>0 AND category_sub=0 AND active=1');
		$icon = array('fa fa-home', 'icon-technology-1', 'icon-letter-1');
  ?>
	<header class="header-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12">
					<div class="logo">
						<a href="<?= $this->path; ?>"><img src="assets/images/logo/logo.png" alt="Troysteel Logo"></a>
					</div>
				</div>
				<div class="col-lg-8 col-md-9 col-sm-12 col-xs-12">
					<div class="header-contact-info">
						<ul>
							<?php foreach($data as $k=>$dt){?>
							<li>
								<div class="iocn-holder"><span class="<?= $icon[$k]; ?>"></span></div>
								<div class="text-holder"><?= $dt['content']; ?></div>
							</li>
							<?php };?>
						</ul>
					</div>
				</div>


			</div>
		</div>
	</header>
  <?php
  }
	function _nav($p){
  ?>
	<div id="header">
		<div class="container  header_inner clearfix">
			<div class="grid_12"> 

				<!--logo here--> 
				<a href="#"> <img src="assets/images/logo.png" width="125" height="35" alt="logo" class="logo"> </a> 

				<!--menu / navigation starts-->
				<ul class="sf-menu">
					<li><a href="<?= $this->path; ?>" class="<?= ( $p[0] == 'home' || $p[0] == '' ) ? 'current' : ''; ?>">Home</a></li>
					<li><a href="#" class="<?= ( in_array( $p[0], array( 'about_us', 'our_team' ) ) ) ? 'current' : ''; ?>">About Us</a>
						<ul>
							<li><a href="<?= $this->path; ?>about_us/">About Us</a></li>
							<li><a href="<?= $this->path; ?>our_team/">Our Team</a></li>
						</ul>
					</li>
					<li><a href="<?= $this->path; ?>products/" class="<?= ( $p[0] == 'products' ) ? 'current' : ''; ?>">Products</a> </li>
					<li><a href="<?= $this->path; ?>services/" class="<?= ( $p[0] == 'services' ) ? 'current' : ''; ?>">Services</a> </li>
					<li><a href="<?= $this->path; ?>contacts/" class="<?= ( $p[0] == 'contacts' ) ? 'current' : ''; ?>">Contacts</a></li>
					<li class="login_link"> 

						<!--login_wrapper starts-->
						<div class="login_wrapper"> <a href="#" class="login"><span>login</span></a>
							<form method="post" id="login_form" action="#">
								<fieldset>
									<p>
										<label>Username or email</label>
										<input id="username" name="username" type="text"/>
									</p>
									<p>
										<label>Password</label>
										<input id="password" name="password" type="password"/>
									</p>
									<p>
										<input class="login_submit" value="Login" type="submit"/>
									</p>
									<div class="clear"></div>
									<p class="remember">
										<input id="remember" name="remember" type="checkbox"/>
										<label  class="remember">Remember me</label>
									</p>
									<p class="forgot"> Forgot <a href="#">Password</a> or <a href="#">Username</a>...?</p>
								</fieldset>
							</form>
						</div>
						<!--login_wrapper ends--> 

					</li>
				</ul>
				<!--menu ends-->

				<div class="clear"></div>
			</div>
		</div>
	</div>
  <?php
  }
	function _flash(){
  ?>
	<div id="header_bottom">
		<div class="container clearfix">
			<div class="grid_12"> 

			 <!--flexslider starts-->
				<div class="flexslider image-slider">
					<ul class="slides">

						<!--first slide starts-->
						<li>
							<div class="image_slide_frame1">
								<img src="assets/flash/f1.png" height="302" style="margin-left: 117px;" />
							</div>
							<div class="slide-2">
								<p>Do More With Sage...</p>
								<h1>Software, Consultancy &amp; Training</h1>
								<h3>An <span class="color">End-to-End Business Solutions</span> for your Company.</h3>
								<!--<a href="#" class="button_appstore"></a>--> </div>
						</li>
						<!--first slide starts--> 

						<!--second slide starts-->
						<li>
							<div class="slide-1">
								<div class="circle1">
									<p class="big_letter">1</p>
									<h1>Sage One</h1>
									<span>Tackle accounting with your own two hands</span>
									<p>Small business solutions that help you take care of admin, lock down your numbers, and run your business like a pro.</p>
								</div>
								<div class="circle2">
									<p class="big_letter">50</p>
									<h1>Sage 50</h1>
									<span>Get more with Sage 50 Accounting</span>
									<p>Run your business efficiently with in-depth solution to manage your accounting, invoicing, cash flow, inventory, taxes, and more.</p>
								</div>
								<div class="circle3">
									<p class="big_letter">100</p>
									<h1>Sage 100</h1>
									<span>What Sage 100 can do for you</span>
									<p>Sage 100 helps your growing company with accounting, manufacturing, distribution, inventory management and more.</p>
								</div>
							</div>
						</li>
						<!--second slide ends--> 

						<!--third slide starts-->
						<li>
							<div class="slide-3">
								<h3>Service Line Offers</h3>
								<ul class="list3 clearfix">
									<li>Business Consultancy</li>
									<li>Information Planning</li>
									<li>Project Management </li>
									<li>Human Performance/Training </li>
								</ul>
								<a href="<?= $this->path; ?>services/" class="top_padding">Learn more &raquo;</a></div>
							<div class="image_slide_frame2" style="overflow: hidden;"><img src="assets/images/preview/any-slide-img.jpg" width="422" height="302" alt="image"></div>
							<div class="slide-3">
								<h3>Technical Services</h3>
								<ul class="list3 clearfix">
									<li>Application software</li>
									<li>System Integration</li>
									<li>Business Process Out source </li>
								</ul>
							</div>
						</li>
						<!--third slide ends--> 

						<!--forth slide starts-->
						<li>
							<div class="slide-1">
								<div class="circle1">
									<p class="big_letter">S</p>
									<h1>Service</h1>
									<!--<span>signup with softone</span>-->
									<p>We continuously anticipate our clients’ needs and identify dynamic solutions to meet their needs.</p>
								</div>
								<div class="circle2">
									<p class="big_letter">E</p>
									<h1>Excellent</h1>
									<!--<span>download lorem ipsum</span>-->
									<p>Excellence defines what we do and how we do it.</p>
								</div>
								<div class="circle3">
									<p class="big_letter">D</p>
									<h1>Delivered</h1>
									<!--<span>install and ready to go</span>-->
									<p>We deliver on time, what you expected and what you want.</p>
								</div>
							</div>
						</li>
						<!--forth slide ends-->

					</ul>
				</div>
				<!--flexslider ends-->

				<div class="clear"></div>
			</div>
		</div>
	</div>
  <?php
  }
	
	function home(){$this->page();}
	function page($c = '', $s = '', $l = ''){
		$c = $this->gvar($c,'c');
		$s = $this->gvar($s,'s');
		$l = $this->gvar($l,'l');

		if($l != ''){ $this->path = '../../../'; }
		elseif($s != ''){ $this->path = '../../'; }
		elseif($c != '' && $c != 'home'){ $this->path = '../'; }

		$area = ($c == '' || $c == 'home') ? 'home' : $c ;
		$params = array($c,$s,$l) ;
		
		$this->_head();
		$this->_topBar();
		$this->_nav($params);
		if($area == 'home'){
			$this->_flash();
			$this->_homeContent();
		} 
		else{
			$this->_content($params);
		}

		$this->_footItem();
		$this->_foot();
  }
	
	//Homepage & includes
	function _homeContent(){
		$this->_homeAbout();
		$this->_homeSubscribe();
		$this->_clients();
  }
	function _homeAbout(){
  ?>
	<div class="section colored">
		<div class="container clearfix">
			<div class="grid_12"> 

				<!--action2 starts-->
				<div class="action2">
					<h1>Welcome to Mupuma Management Solutions Limited </h1>
					<p>The world today revolves around information. In addition to accounting and ERP solutions, we provide expertise in designing secure networks to suit the client’s needs and budget. Mupuma Management Solutions is also an authorized reseller for a range of HP hardware products.</p><br />
					<p>We are an African company defining service and excellence in technology-driven business solutions. Mupuma is structured to ensure that services are delivered in the shortest possible time to allow our customers to focus on their needs with up to date financial and analytical information.</p>
				</div>
				<!--action2 ends--> 

				<!--button here--> 
				<a href="<?= $this->path; ?>contacts/" class="button button-orange right"> <span><img src="assets/images/icons/button/button-icon1-orange.png" width="17" height="16" alt="icon">Quick Enquiry</span> </a>
				<div class="clear"></div>
			</div>
		</div>
	</div>
  <?php
  }
	function _homeSubscribe(){
  ?>
	<div class="section colored">
		<div class="container clearfix">
			<div class="grid_12">
				<div class="box">
					<div class="box_inner clearfix"> 

						<!--subscribe text here-->
						<div class="subscribe_text">
							<h3>Subscribe for product updates and promotions!</h3>
							<p>We don't do spam and your email is held confidential.</p>
						</div>

						<!--subscribe form here-->
						<form id="subform" method="post" action="subscribe-form.php">
							<fieldset>
								<p>
									<input name="email" id="email" placeholder="Enter Email id here" class="required email" />
								</p>
								<input type="submit" class="sub_submit" name="submit" value="subscribe" />
								<div id="result_sub"></div>
							</fieldset>
						</form>
						<!--subscribe form ends-->

						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
  <?php
  }
	function _clients(){
  ?>
	<div class="section">
		<div class="container clearfix"> 

			<!--requirements starts-->
			<div class="grid_3">
				<h2>Slogan</h2>
				<ul class="list3">
					<li>Service</li>
					<li>Excellence</li>
					<li>Delivered </li>
				</ul>
			</div>
			<!--requirements ends--> 

			<!--gallery starts-->
			<div class="grid_9">
				<h2>Take a look at our clientele</h2>
				<ul id="mycarousel" class="jcarousel-skin-tango">
					<li>
						<div class="thumb"><img src="assets/images/preview/p1.jpg" width="200" height="125" alt="Image"/><a href="assets/images/preview/p1.jpg" data-rel="prettyPhoto[mixed]" title="Cactus Financial Services, Zambia" class="zoom first_icon"></a> <a href="#" target="_blank" class="link second_icon"></a></div>
					</li>
					<li>
						<div class="thumb"><img src="assets/images/preview/p2.jpg" width="200" height="125" alt="Image"/><a href="assets/images/preview/p2.jpg" data-rel="prettyPhoto[mixed]" title="This is title of image" class="zoom first_icon"></a> <a href="#" target="_blank" class="link second_icon"></a></div>
					</li>
					<li>
						<div class="thumb"><img src="assets/images/preview/p3.jpg" width="200" height="125" alt="Image"/><a href="assets/images/preview/p3.jpg" data-rel="prettyPhoto[mixed]" title="This is title of image" class="zoom first_icon"></a> <a href="http://tanshcreative.com" target="_blank" class="link second_icon"></a></div>
					</li>
					<li>
						<div class="thumb"><img src="assets/images/preview/p4.jpg" width="200" height="125" alt="Image"/><a href="assets/images/preview/p4.jpg" data-rel="prettyPhoto[mixed]" title="This is title of youtube video" class="zoom first_icon"></a> <a href="http://tanshcreative.com" target="_blank" class="link second_icon"></a></div>
					</li>
				</ul>
			</div>
			<!--gallery ends--> 

		</div>
	</div>
  <?php
  }
	
	//Other pages & includes
	function _content($p){
		
  	if($p[0] == 'about_us') 
				$this->_aboutUs();
			
		else if($p[0] == 'our_team')
				$this->_team();
		
		else if($p[0] == 'contacts')
				$this->_contact();
		
		else if($p[0] == 'services')
				$this->_services();
		
		else if($p[0] == 'products')
				$this->_products();
		
		else if($p[0] == 'help')
				$this->_help();
		
		else if($p[0] == 'terms')
				$this->_terms();
		
		else if($p[0] == 'privacy')
				$this->_privacy();
  }
	
	function _aboutUs(){
  ?>
  <div class="top_gradient">
		<div class="container clearfix">
			<div class="grid_12"> 

				<!--page header starts-->
				<div class="page_header clearfix">
					<h1>Profile</h1>
					<p>We are an African company defining service and excellence in technology-driven business solutions.</p>
<p>&nbsp;</p>
<p>Mupuma Management Solutions Limited was established in Zambia in 2010 with two local directors. The company caters to all forms of business intelligence requirements by implementing accounting solutions for customers through the Oracle and Sage Group lines of Enterprise Resource Planning (ERP) systems.</p>
<p>&nbsp;</p>
<p>Mupuma is structured to ensure that services are delivered in the shortest possible time to allow our customers to focus on their needs with up to date financial and analytical information.</p>
				</div>
				<!--page header ends--> 

			</div>
		</div>

		<!--container for content and sidebar starts-->
		<div class="container clearfix"> 

			<!--sidebar starts-->
			<div class="sidebar">
				<h4>Our Mission</h4>
				<p>To help our customers get the most from their investment in technology by deriving optimal performance during its entire life cycle.</p><br />
				<p><img src="assets/images/logo_new.png" width="250" /></p>
				<div class="spacer_30px"></div>

				<!--tabs starts-->
				<div class="tabs_wrapper">
					<!--<ul>
						<li class="first_tab"><a href="#tabs-1" class="first_tab">Nunc</a></li>
						<li><a href="#tabs-2">Proin dolor</a></li>
						<li><a href="#tabs-3">Aenean</a></li>
					</ul>
					<div id="tabs-1">
						<p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. </p>
					</div>
					<div id="tabs-2">
						<ul class="list3">
							<li>Dolore eu feugiat nulla facilisis</li>
							<li>Olestie consequat</li>
							<li>Imperdiet doming id assum</li>
							<li>Nam liber tempor cum soluta nobis</li>
						</ul>
					</div>
					<div id="tabs-3">
						<p>Mauris eleifend est et turpis. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat. Vestibulum non ante. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
					</div>-->
				</div>
				<!--tabs ends-->

				<div class="spacer_30px"></div>
				<!--<p>Molestie consequat, vel illum dolore eu feugiat nulla facilisis accumsan et iusto <a href="contact.html">contact us</a> odio dignissim qui blandit praesent luptatum zzril delenit nihil imperdiet mazim placerat facer possim assum.</p>-->
			</div>
			<!--sidebar ends--> 

			<!--content starts-->
			<div class="grid_8 content"> 

				<!--features starts-->
				<div class="grid_8 first last features_style3">
					<h2>Core Values </h2>
					<div class="grid_4 first"> 
						<h4>Service Excellence</h4>
						<p>We believe in defining the standards of service excellence in everything we do. We believe in going the extra mile to ensure our customers expectations are consistently met and exceeded. Excellence defines what we do and how we do it.</p>
					</div>
					<div class="grid_4 last"> 
						<h4>Passion for success</h4>
						<p>We care deeply about winning in the marketplace for our clients and for ourselves.</p>
					</div>

					<!--spacer here-->
					<div class="spacer_30px"></div>
					<!--spacer ends-->

					<div class="grid_4 first">
						<h4>Innovation leadership </h4>
						<p>We continuously anticipate our clients’ needs and identify dynamic solutions to meet their needs. We redefine the rules of competition in our market place.</p>
					</div>
					<div class="grid_4 last"> 
						<h4>Valued partnerships</h4>
						<p>We value each other and the partnerships that we have that ensure that we consistently deliver on our promise of excellence.</p>
					</div>

					<!--spacer here-->
					<div class="spacer_30px"></div>
					<!--spacer ends-->

				<h2>Culture </h2>
				<ul class="list2">
					<li>A passionate culture that cares deeply about winning in the market place.</li>
					<li>An organizational culture that continuously strives to achieve and provide excellent service</li>
					<li>Team culture of colleagues who communicate well, develop solutions together and respect each other</li>
					<li>An innovative culture that seeks to anticipate client demands and provide timely solutions.</li>
				</ul>
					<!--<div class="grid_4 first"> 
						<h4>Cost effective</h4>
						<p>Nam liber tempor cum soluta nobis eleifend option ullamcorper suscipit lobortis nisl commodo consequat facer possim assum.</p>
					</div>
					<div class="grid_4 last"> <img src="images/icons/features/feature-icon-11.png" width="64" height="64" alt="icon">
						<h4>24 X 7 support</h4>
						<p>Duis autem vel eum iriure dolor in vulputate velit molestie consequat, consuetudium lectorum. Mirum est notare quam littera gothica.</p>
					</div>
					<div class="clear"></div>
				</div>-->
				<!--features ends--> 

			</div>
			<!--content ends-->

			<div class="clear"></div>
		</div>
		<!--container for content and sidebar ends-->

		<div class="clear"></div>
	</div>
	<!--top_gradient ends-->

	<div class="spacer_30px"></div>

  <?php
  }
	function _team(){
  ?>
	<div class="top_gradient">
		<div class="container clearfix">
			<div class="grid_12">

				<!--page header starts-->
				<div class="page_header clearfix">
					<h1>Our Team</h1>
					<p></p>
				</div>
				<!--page header ends-->

			</div>
		</div>

		<!--features two columns starts-->
		<div class="container features_main clearfix">
			<div class="grid_3"> <a href="#"><img src="assets/images/preview/img-g3.jpg" width="200" height="125" alt="Image" class="image_frame"/></a> </div>
			<div class="grid_9">
				<h2><a href="#">Shemu Sinkala</a></h2>
				<h4>Senior Consultant </h4>
				<p>Mr. Sinkala is a Certified Consultant on SAGE ACCPAAC and other Sage Products. He is also a Full Part 2 ACCA Qualification. Shemu has extensive experience in Accounting/ Audit and Consultancy Software in the design and implementation of computerized Financial Management Systems in donor funded Organizations. </p>
			</div>
			
			<div class="spacer_30px"></div>
			
			<div class="grid_3"> <a href="#"><img src="assets/images/preview/img-g3.jpg" width="200" height="125" alt="Image" class="image_frame"/></a> </div>
			<div class="grid_9">
				<h2><a href="#">Senia Bianca Nyondo</a></h2>
				<h4>Managing Consultant </h4>
				<p>Ms Senia holds a Degree in Computing and Networking from Greenwich University and is also a Certified ACCPAC Consultant, certified by Softline ACCPAC. Having worked as an IT specialist with over 6 years of experience, ranging from System Administration and customer support in various key positions in organisations like DCDM, Zamtel, Railway Systems and Senia has Wide experience in I.T and Sage Accpac ERP. </p>
			</div>
			
			<div class="spacer_30px"></div>
			
			<div class="grid_3"> <a href="#"><img src="assets/images/preview/img-g3.jpg" width="200" height="125" alt="Image" class="image_frame"/></a> </div>
			<div class="grid_9">
				<h2><a href="#">Chisiki Nandazi</a></h2>
				<h4>Head Corporate Sales and Services </h4>
				<p>Chisiki manages the Corporate Sales operations for the company. She drives the Hardware and software. Over the past years she has spent a lot of time building and creating relationships with the top IT leaders in Zambia providing with solutions that enable them to meet the current technology needs and this is done within their budgetary limits. </p>
			</div>
			
			<div class="spacer_30px"></div>
			
			<div class="grid_3"> <a href="#"><img src="assets/images/preview/img-g3.jpg" width="200" height="125" alt="Image" class="image_frame"/></a> </div>
			<div class="grid_9">
				<h2><a href="#">Isaac Chilinda Sindazi</a></h2>
				<h4>ACCPAC Consultant </h4>
				<p>Chilinda is the Accpac consultant and he provides support to Accpac team. He holds a Honars Degree in Agriculture which he attained from the African University and is currently pursuing the CIMA programme. His passion for Information Technology and Accounting makes him a strategic partner and enables to contribute a great deal on many of our project tasks. </p>
			</div>
			
			<div class="spacer_30px"></div>
			
			<div class="grid_3"> <a href="#"><img src="assets/images/preview/img-g3.jpg" width="200" height="125" alt="Image" class="image_frame"/></a> </div>
			<div class="grid_9">
				<h2><a href="#">Ngoza Nandazi</a></h2>
				<h4>ACCPAC Consultant </h4>
				<p>Ngoza is responsible for managing the admin side of our business. She is an accountant by profession but her determination has allowed her to stretch her limits and expand her field. </p>
			</div>
			
			<div class="spacer_30px"></div>
			
			
		</div>
		<!--features two columns ends-->

		
	</div>
  <?php
  }
	function _services(){
	?>
	<div class="top_gradient">
		<div class="container clearfix">
			<div class="grid_12">

				<!--page header starts-->
				<div class="page_header clearfix">
					<h1>Services</h1>
					<p>The world today revolves around information. In addition to accounting and ERP solutions, we provide expertise in designing secure networks to suit the client’s needs and budget. Mupuma Management Solutions is also an authorized reseller for a range of HP hardware products. </p>
				</div>
				<!--page header ends-->

			</div>
    

    <div class="grid_4">
      <h4>Our service line offers:</h4>
      <ul class="list2">
        <li>Business Consultancy</li>
        <li>Information Planning</li>
        <li>Project Management</li>
        <li>Human Performance/Training</li>
        <li>Process Re-engineering</li>
      </ul>
    </div>
    <div class="grid_4">
      <h4>We offer the following technical services:</h4>
      <ul class="list2">
        <li>Application software</li>
        <li>System Integration</li>
        <li>Business Process Out source</li>
      </ul>
    </div>
    <div class="grid_4">
      <h4>Our Industrial Scope is able to cater for:</h4>
      <ul class="list2">
        <li>Processing Industries</li>
        <li>Telecommunications</li>
        <li>Agriculture</li>
        <li>Financial services</li>
        <li>Governments</li>
        <li>Services</li>
      </ul>
    </div>
    <!--list styles ends-->
    <div class="spacer_30px"></div>

		</div>
	</div>
	<?php
	}
	function _contact(){
	?>
	<div class="top_gradient">
		<div class="container clearfix">
			<div class="grid_12"> 

				<!--page header starts-->
				<div class="page_header clearfix">
					<h1>Contact Support</h1>
					<p>We would like to hear from you. Contact us directly or through the details below, or fill out the form and we'll get back to you soon.</p>
				</div>
				<!--page header ends--> 

			</div>
		</div>

		<!--container for content and sidebar starts-->
		<div class="container clearfix"> 

			<!--content starts-->
			<div class="grid_8 content">
				<p>Please checkout our <a href="<?= $this->path; ?>help/">Help page</a> for immediate solutions before contacting support.</p>
				<form  id="contactform" method="post" action="submit-form.php">
					<fieldset>
						<p>
							<label>We help you with?</label>
							<select name="subject">
								<option value="General support">General support</option>
								<option value="Bug support">Bug support</option>
								<option value="Other">Other</option>
							</select>
						</p>
						<p>
							<label>Please type your message in brief! * </label>
							<textarea name="message" id="message" class="required"></textarea>
						</p>
						<p>
							<label>Name*</label>
							<input name="name" class="required" />
						</p>
						<p>
							<label>E-Mail* </label>
							<input name="email" class="required email"/>
						</p>
						<div class="spacer_20px"></div>
						<p>
							<input type="submit" class="submit" name="submit" value="Click to submit" />
						</p>
						<div id="result"></div>
					</fieldset>
				</form>
				<div class="spacer_20px"></div>
				<p>Don't forget to <a href="#">subscribe our newsletter</a> for product updates and promotions.</p>
				<div class="clear"></div>
			</div>
			<!--content ends--> 

			<!--sidebar starts-->
			<div class="sidebar"> 

				<!--address-->
				<h4>Our address</h4>
				<p>Mupuma Management Solution Ltd.<br/>
					Plot 7535 Off Buluwe Road,<br/>
					Woodlands Lusaka, <br/>
					P.O. Box 33259, Zambia</p>

				<!--map-->
				<div class="image_frame">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15383.209223240705!2d28.345209185358648!3d-15.441217833747254!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19408cf2166e2ea9%3A0xfcce38b6ffee78c7!2sWoodlands%2C+Lusaka%2C+Zambia!5e0!3m2!1sen!2sgh!4v1503261724249" width="238" height="120" frameborder="0" style="border:0" allowfullscreen></iframe>
					<br />
					<small><a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15383.209223240705!2d28.345209185358648!3d-15.441217833747254!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19408cf2166e2ea9%3A0xfcce38b6ffee78c7!2sWoodlands%2C+Lusaka%2C+Zambia!5e0!3m2!1sen!2sgh!4v1503261724249" style="color:#ffb400;text-align:left" target="_blank">View Larger Map</a></small> </div>

				<!--spacer-->
				<div class="spacer_15px"></div>

				<!--email-->
				<h4>Email</h4>
				<p>Send a message to <a href="mailto:info@mupuma.co.zm">info@mupuma.co.zm</a> We'll get back to you within 24 hours. </p>

				<!--call-->
				<h4>Talk to us</h4>
				<p>+260 966 795 334 <br />
					+260 977 795 334 </p>

				<!--hours-->
				<h4>Working hours</h4>
				<p>Monday - Friday<br/>
					9am - 5pm GMT</p>
			</div>
			<!--sidebar ends-->

			<div class="clear"></div>
		</div>
		<!--container for content and sidebar ends-->

		<div class="clear"></div>
	</div>
	<!--top_gradient ends--> 

	<!--spacer here-->
	<div class="spacer_30px"></div>

	<?php
	}
	function _products(){
  ?>
  <div class="top_gradient">
  <div class="container clearfix">
    <div class="grid_12"> 
      
      <!--page header starts-->
      <div class="page_header clearfix">
        <h1>Products</h1>
        <p>Find your solution from the options below </p>
      </div>
      <!--page header ends--> 
      
    </div>
  </div>
  
  <!--Portfolio four columns starts-->
  <div class="container features_main clearfix">
    <div class="grid_12"> 
      <!--portfolio navigation starts-->
      <ul class="filter_nav">
        <li class="active"><a href="#" class="all"> All</a></li>
        <li><a href="#" class="soft">Sage</a></li>
        <li><a href="#" class="app">HP Products</a></li>
        <li><a href="#" class="vid">Networks</a></li>
      </ul>
      
      <!--portfolio navigation ends-->
      
      <ul class="portfolio_4column filter_content">
        <li class="item" data-id="id-1" data-type="vid">
          <div class="thumb"><a href="#"><img src="assets/images/preview/Peer-to-Peer.jpg" width="200" height="125" alt="Image"/></a><a href="assets/images/preview/Peer-to-Peer.jpg" data-rel="prettyPhoto[mixed]" title="Peer-to-Peer Network" class="zoom first_icon"></a> <a href="#" target="_blank" class="link second_icon"></a></div>
        </li>
        <li class="item" data-id="id-2" data-type="soft">
          <div class="thumb"><a href="#"><img src="assets/images/preview/sage_one_287x135.png" width="200" height="125" alt="Image"/></a><a href="assets/images/preview/sage_one_287x135.png" data-rel="prettyPhoto[mixed]" title="Sage One" class="zoom first_icon"></a> <a href="#" target="_blank" class="link second_icon"></a></div>
        </li>
        <li class="item" data-id="id-3" data-type="app">
          <div class="thumb"><a href="#"><img src="assets/images/preview/laptop.jpg" width="200" height="125" alt="Image"/></a><a href="assets/images/preview/laptop.jpg" data-rel="prettyPhoto[mixed]" title="Laptop" class="zoom first_icon"></a> <a href="#" target="_blank" class="link second_icon"></a></div>
        </li>
        <li class="item" data-id="id-4" data-type="vid">
          <div class="thumb"><a href="#"><img src="assets/images/preview/Client-Server.jpg" width="200" height="125" alt="Image"/></a><a href="assets/images/preview/Client-Server.jpg" data-rel="prettyPhoto[mixed]" title="Client Server Network" class="play first_icon"></a> <a href="#" target="_blank" class="link second_icon"></a></div>
        </li>
        <li class="item" data-id="id-5" data-type="soft">
          <div class="thumb"><a href="#"><img src="assets/images/preview/sage_live_287x135.png" width="200" height="125" alt="Image"/></a><a href="assets/images/preview/sage_live_287x135.png" data-rel="prettyPhoto[mixed]" title="Sage Live" class="zoom first_icon"></a> <a href="#" target="_blank" class="link second_icon"></a></div>
        </li>
        <li class="item" data-id="id-6" data-type="app">
          <div class="thumb"><a href="#"><img src="assets/images/preview/printers.jpg" width="200" height="125" alt="Image"/></a><a href="assets/images/preview/printers.jpg" data-rel="prettyPhoto[mixed]" title="Printers" class="zoom first_icon"></a> <a href="#" target="_blank" class="link second_icon"></a></div>
        </li>
        <li class="item" data-id="id-7" data-type="app">
          <div class="thumb"><a href="#"><img src="assets/images/preview/servers.jpg" width="200" height="125" alt="Image"/></a><a href="assets/images/preview/servers.jpg" data-rel="prettyPhoto[mixed]" title="High End Servers" class="zoom first_icon"></a> <a href="#" target="_blank" class="link second_icon"></a></div>
        </li>
        <li class="item" data-id="id-8" data-type="soft">
          <div class="thumb"><a href="#"><img src="assets/images/preview/sage_people_287x135.png" width="200" height="125" alt="Image"/></a><a href="assets/images/preview/sage_people_287x135.png" data-rel="prettyPhoto[mixed]" title="Sage People" class="zoom first_icon"></a> <a href="#" target="_blank" class="link second_icon"></a></div>
        </li>
      </ul>
    </div>
  </div>
  <!--Portfolio four columns ends-->
  
  <div class="clear"></div>
</div>
  <?php
  }
	
	function _help(){
  ?>
  <div class="top_gradient">
  <div class="container clearfix">
    <div class="grid_12"> 
      
      <!--page header starts-->
      <div class="page_header clearfix">
        <h1>Help</h1>
        <p>Everything you need to know about Mupuma Management Solutions</p>
      </div>
      <!--page header ends--> 
      
    </div>
  </div>
  
  <!--container for content and sidebar starts-->
  <div class="container clearfix"> 
    
    <!--content starts-->
    <div class="grid_8 content"> 
      
      <!--accordion starts-->
      <div class="accordion_wrapper">
        <div>
          <h3><a href="#">How to get started with Mupuma? </a></h3>
          <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Phasellus mattis tincidunt nibh. Cras orci urna, blandit id, pretium vel, aliquet ornare, felis. Maecenas scelerisque sem non nisl. Fusce sed lorem in enim dictum bibendum.
            Nam dui erat, auctor a, dignissim quis, sollicitudin eu, felis. Pellentesque nisi urna, interdum eget, sagittis et, consequat vestibulum, lacus. Mauris porttitor ullamcorper augue.</div>
        </div>
        <div>
          <h3><a href="#">What  quis nostrud exercitation ullamco Mupuma? </a></h3>
          <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Phasellus mattis tincidunt nibh. Cras orci urna, blandit id, pretium vel, aliquet ornare, felis. Maecenas scelerisque sem non nisl. Fusce sed lorem in enim dictum bibendum. </div>
        </div>
        <div>
          <h3><a href="#">When praesent luptatum zzril delenit? </a></h3>
          <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Phasellus mattis tincidunt nibh. Cras orci urna, blandit id, pretium vel, aliquet ornare, felis. Maecenas scelerisque sem non nisl. Fusce sed lorem in enim dictum bibendum.
            Nam dui erat, auctor a, dignissim quis, sollicitudin eu, felis. Pellentesque nisi urna, interdum eget, sagittis et, consequat vestibulum, lacus. Mauris porttitor ullamcorper augue.</div>
        </div>
        <div>
          <h3><a href="#">Why ullamco laboris nisi ut aliquip scelerisque sem non? </a></h3>
          <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            
            Nam dui erat, auctor a, dignissim quis, sollicitudin eu, felis. Pellentesque nisi urna, interdum eget, sagittis et, consequat vestibulum, lacus. Mauris porttitor ullamcorper augue.</div>
        </div>
      </div>
      <!--accordion ends-->
      
    </div>
    <!--content ends--> 
    
    <!--sidebar starts-->
    <div class="sidebar">
      <h4>Checklist</h4>
      <ul class="list3">
        <li>Dolore facilisis accumsan et iusto dignissim blandit praesent luptatum.</li>
        <li>Olestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan praesent </li>
        <li>Nam liber tempor cum soluta nobis eleifend option congue nihil facer.</li>
      </ul>
      
      <div class="spacer_30px"></div>
      <p>Molestie consequat, vel illum dolore eu feugiat nulla facilisis accumsan et iusto <a href="<?= $this->path; ?>contacts/">contact us</a> odio dignissim qui blandit praesent luptatum zzril delenit nihil imperdiet mazim placerat facer possim assum.</p>
    </div>
    <!--sidebar ends-->
    
    <div class="clear"></div>
  </div>
  <!--container for content and sidebar ends-->
  
  <div class="clear"></div>
</div>
<!--top_gradient ends-->

<div class="spacer_30px"></div>
  <?php
  }
	function _terms($itm = ''){
		$title = ($itm == 'terms_and_conditions') ? 'Terms &amp; Conditions' : 'Privacy Policy';
  ?>
	<div class="top_gradient">
		<div class="container clearfix">
			<div class="grid_12">

				<!--page header starts-->
				<div class="page_header clearfix">
					<h1>Terms &amp; Conditions</h1>
					<p>Coming soon... </p>
					<br /><br /><br /><br /><br /><br /><br />
				</div>
				<!--page header ends-->

			</div>
		</div>
	</div>
  <?php
  }
	function _privacy($itm = ''){
		$title = ($itm == 'terms_and_conditions') ? 'Terms &amp; Conditions' : 'Privacy Policy';
  ?>
	<div class="top_gradient">
		<div class="container clearfix">
			<div class="grid_12">

				<!--page header starts-->
				<div class="page_header clearfix">
					<h1>Privacy Policy</h1>
					<p>Coming soon... </p>
					<br /><br /><br /><br /><br /><br /><br />
				</div>
				<!--page header ends-->

			</div>
		</div>
	</div>
  <?php
  }
	
	function template(){
  ?>
  
  <?php
  }
}