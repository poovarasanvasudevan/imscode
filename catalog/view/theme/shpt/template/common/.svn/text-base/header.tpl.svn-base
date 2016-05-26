<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/shpt/stylesheet/stylesheet.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/external/jquery.cookie.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />
<script type="text/javascript" src="catalog/view/javascript/jquery/tabs.js"></script>
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>

<!-- srcm slider -->

<script type="text/javascript" src="catalog/view/javascript/srcm-slider/jquery-1.js"></script>
<script type="text/javascript" src="catalog/view/javascript/srcm-slider/jsFlashQueue.aspx"></script>
<script type="text/javascript" src="catalog/view/javascript/srcm-slider/jquery.js"></script>
<script type="text/javascript" src="catalog/view/javascript/srcm-slider/modernizr.js"></script>
<script type="text/javascript" src="catalog/view/javascript/srcm-slider/slider.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/shpt/stylesheet/slider.css" />

<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>


<?php } ?>
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<?php echo $google_analytics; ?>
</head>
<body>
<div id="container">
<div id="header">
<div class="header">
  <?php if ($logo) { ?>
  <div id="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></div>
  <?php } ?>
  <?php echo $language; ?>
 <!-- <?php echo $currency; ?> -->
  <?php echo $cart; ?>
  <!-- <div class="links"><a href="<?php echo $home; ?>"><?php echo $text_home; ?></a><a href="<?php echo $wishlist; ?>" id="wishlist-total"><?php echo $text_wishlist; ?></a><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a><a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></div> -->
   <div class="links"><a href="<?php echo $home; ?>"><?php echo $text_home; ?></a><!--<a href="<?php echo $wishlist; ?>" id="wishlist-total"><?php echo $text_wishlist; ?></a>--><a href="login">Login</a><a href="language">Language</a><a href="genre">Genre</a></div>
	   <div class="top_menu">
            <ul id="nav">
                <li><a class="dropdownctrl">Account</a>
                    <div class="subs">
                        <div>
                            <ul>
                                 <li>
                                    <ul>
										<li >
										  <?php if (!$logged) { ?>
											<a href="?route=account/login" >Login</a>
										  <?php } else { ?>
											<a href="?route=account/account" >My Account</a>
										<?php }  ?>
										</li>
										<li >
										  <?php if (!$logged) { ?>
											<a href="?route=account/register" >Create Account</a>
										  <?php } else { ?>
											<a href="?route=account/logout" >Logout</a>
										  <?php }  ?>										  
										</li>
                                    </ul>
                                  </li>
                                
                            </ul>
                        </div>
                    </div>
                </li>
			<li><a href="http://www.shriramchandramission.org/digitalstore/" target="_blank">Abhyasi Digital Store</a></li>
			<li><a href="https://www.shpt.in/shptsubscriptions/shptSubscription.do?action=reset" target="_blank">Subscriptions</a></li>
			<li><a href="/index.php?route=information/contact">Contact us</a></li>
            </ul>
    </div>

<?php if ($categories) { ?>
<div id="menu">
  <ul>
    <?php foreach ($categories as $category) { ?>
    <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
      <?php if ($category['children']) { ?>
      <div>
        <?php for ($i = 0; $i < count($category['children']);) { ?>
        <ul>
          <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
          <?php for (; $i < $j; $i++) { ?>
          <?php if (isset($category['children'][$i])) { ?>					
				<!-- Begin Part 1 of the extension Header menu add level 3 sub categories extension (line to be replaced: number 84 of the header.tpl file) -->		
				<li>
				<?php
				if(count($category['children'][$i]['children_level2'])>0){
				?>
						<a href="<?php echo $category['children'][$i]['href']; ?>" onmouseover='JavaScript:openSubMenu("<?php echo $category['children'][$i]['id']; ?>")'><?php echo $category['children'][$i]['name']; ?>
				<?php

						echo "<img src='catalog/view/theme/shpt/image/arrow-right.png' style='right:10px;margin-top:3px;position:absolute;'/></a>";
						//echo "<span style='right:5px;margin-top:-6px;position:absolute;color:white;font-weight:bold;font-size:18px;'>&#187;</span></a>";

				}
				else
				{
				?>
				<a href="<?php echo $category['children'][$i]['href']; ?>" onmouseover='JavaScript:closeSubMenu()' ><?php echo $category['children'][$i]['name']; ?></a>
				<?php
				}
				?>

				<?php if ($category['children'][$i]['children_level2']) { ?>
					  <div class="submenu" id="id_menu_<?php echo $category['children'][$i]['id']; ?>">
					   <ul>
						<?php for ($wi = 0; $wi < count($category['children'][$i]['children_level2']); $wi++) { ?>
						  <li>
								<a href="<?php echo $category['children'][$i]['children_level2'][$wi]['href']; ?>"  ><?php echo $category['children'][$i]['children_level2'][$wi]['name']; ?>
								</a>
						  </li>
				  <?php } ?>
				</ul>
			  </div>
			  <?php } ?>		  
			</li>
			<!-- END Part 1 of the extension Header menu add level 3 sub categories extension -->
          <?php } ?>
          <?php } ?>
        </ul>
        <?php } ?>
      </div>
      <?php } ?>
    </li>
    <?php } ?>
  </ul>
</div>
<?php } ?>

<div id="search">
    <div class="button-search"></div>
    <input type="text" name="search" value="<?php echo $search; ?>" onclick="this.value = '';" onkeydown="this.style.color = '#000000';" />
  </div>
  
  </div> <!-- .header ends -->
</div><!-- #header ends -->

<div id="notification"></div>
<!-- Begin Part 2 of the extension Header menu add level 3 sub categories extension-->
<script type="text/javascript">
function openSubMenu(id){
        //
        $('.submenu').hide();
        document.getElementById("id_menu_"+id).style.display="block";
}
function closeSubMenu(){
		$('.submenu').hide();
}
</script>
<style>
.submenu{
    background: url('catalog/view/theme/default/image/menu.png') repeat scroll 0 0 transparent;
        border: 1px solid #000000;
    border-radius: 0px 5px 5px 0px;
    margin-top:-23px;
    left:140px;
    position:absolute;
    min-width:140px;
    display:none;
}
@media screen and (-webkit-min-device-pixel-ratio:0) {
 .submenu {left: 139px;}

    }
</style>
<!--[if IE 7]>
<style>
#menu > ul > li > div {
width:140px!important;
}
.submenu{
   left:145px;
}
</style>
<![endif]-->
<!--[if IE 8]>
<style>
#menu > ul > li > div {
width:140px!important;
}
.submenu{
   left:150px;
}
</style>
 <![endif]-->
  <!-- END Part 2 of the extension Header menu add level 3 sub categories extension -->
