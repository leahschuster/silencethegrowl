<?php
/*
Template Name: Silence the Growl
*/
?>
<?php get_header(); ?>

<!--Gray corner block -->
<div id="corner" class="corner text-center scale-up">
     <div class="corner-inner">
          <!--Fade on scroll -->
          <div class="fade-content">
               <!--UWD icon-->
               <a class="icons-uwd-icon block"></a>
               <hr>
          </div>
          
          <!--Silence the Growl logo -->
          <a href="/" class="logo">
               <img src="/wp-content/themes/silencethegrowl/assets/img/silence-the-growl-logo.png" alt="Silence the Growl">
          </a>
          <!--Fade on scroll -->
          <div class="fade-content">
               <hr>
               <p class="caption">A $5 solution to end summer hunger. Give a kid their summer back <span class="blue-light">(pack)<span></p>
          
          
               <a href="#donate" class="btn btn-icon mb20"><span class="btn-label"><i class="icons-give"></i></span> <span>Give Now</span></a>
               
               <p class="caption mt40 mb10">Every 3 shares<br/> buys another backpack</p>
               
               <div class="btn-group">
                    <a data-url="http://twitter.com/intent/tweet?text=<?php echo the_title(); echo get_permalink(); ?>" class="btn btn-white share-pop"><i class="fa fa-twitter"></i> Tweet</a>
                    <a data-url="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" class="btn btn-white share-pop"><i class="fa fa-facebook"></i> Share</a>
               </div>
          </div>
     </div>
</div>

<div class="video">
     <div class="container-fluid">
          <a href="#"  data-id="#video_overlay" class="bold btn-watch modal-trigger"><span class="btn btn-white btn-circle"><i class="fa fa-play"></i></span>WATCH</a>
          <div class="bg-img">
               <img src="//s3-us-west-2.amazonaws.com/uwd-assets/video-screenshot.jpg" class="img-responsive" />
          </div>
     </div>
</div>


<!--Content-->
<section class="info">
     <div class="container text-center">
          <div class="row">
               <div class="col-sm-12">
                    <span class="icons-girl-with-lunch inline"></span>
                    <div class="bg-white">
                         <p class="mb0 large">More than</p>
                         <h2>1.2 Million Children </h2>
                         <p class="large">across North Texas qualify for free or reduced-price<br/> meals during the school year.</p>
                    </div>

                    <div class="blue-light calendar-block">
                         <span class="icons-calendar block mb10"></span>
                         <span class="uppercase light">When school lets out for the summer... </span>
                    </div>
               </div>
          </div>

          <div class="row">
               <div class="col-sm-6">
                    <span class="icons-groceries inline"></span>
                    <p>Meal sites pick up where schools left off and provide these kids with breakfast and lunch during weekdays. </p>
               </div>

               <div class="col-sm-6">
                    <span class="icons-girl-in-room inline"></span>
                    <p>But what happens when kids can’t get to those sites during the week? And what happens when kids are home over the weekend?</p>  
               </div>
          </div>
          
          <div class="row mt100">
               <div class="col-sm-12">
                    <p class="large"> 
                         <span class="icons-backpack block mb10"></span>
                         Help prevent summer hunger by providing kids with backpacks filled with healthy and easy-to-prepare food. Together, we can silence their growl with full backpacks, full tummies, and full <span class="blue-light">(of fun)</span> summers.
                    </p>
                    <p class="blue-light uppercase small mt40">Brought to you by<br/> <span class="bold">United Way</span></p>
               </div>
          </div>
        

          
     </div>
</section>

<!--DONATION FORM -->
<div id="donation" class="donate">
     <div class="container">
          <div class="row">
               <div class="col-sm-5">
                    <p class="hide-step-two text-center">A donation of $5 provides 1 backpack. Generous donors like you have already provided 386 children with backpacks!</p>
                    <!--donation form-->
                     <div class="donation-form">
                         <div class="input-price-options row">
                              <ul class="gfield_radio">
                                   <li id="priceInterval1" class="col-xs-4">
                                        <input type="radio" name="donate-amount" value="5" id="choice_6_0" tabindex="1">
                                        <label for="choice_6_0">$5</label>
                                   </li>
                                   <li id="priceInterval2" class="col-xs-4">
                                        <input type="radio" name="donate-amount" value="25" checked="true" id="choice_6_1" tabindex="2">
                                        <label for="choice_6_1">$25</label>
                                   </li>
                                   <li id="priceInterval3" class="col-xs-4">
                                        <input type="radio" name="donate-amount" value="100" id="choice_6_2" tabindex="3">
                                        <label for="choice_6_2">$100</label>
                                   </li>
                              </ul>                    
                         </div>  
                         <div class="col-sm-12">            
                              <script src="https://www.dntly.com/assets/js/v1/form.js" type="text/javascript" async="async" data-donately-ssl="true" data-donately-amount="25" data-donately-id="2835" data-donately-campaign-id="1834"></script>
                              <button id="donate_card_info" class="btn btn-icon"><span class="btn-label"><i class="fa fa-credit-card"></i></span> <span>Enter Payment Info</span></button>
                         </div>
                    </div>
               </div>
               <div class="col-sm-2"></div>
               <div class="col-sm-5 text-center">
                    <p>PepsiCo is donating $1 for every 3 shares across your networks. Same goes for every 3 follows of UWMD’s social channels!</p>
                    <p class="uppercase small bold mb10 mt30">Share</p>
                    <a class="btn btn-blue-light btn-square share-pop" data-url="http://twitter.com/intent/tweet?text=<?php echo the_title(); echo get_permalink(); ?>"><i class="fa fa-twitter"></i></a>
                    <a class="btn btn-blue-light btn-square share-pop" data-url="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" class="btn btn-white share-pop"><i class="fa fa-facebook"></i></a>


                    <p class="uppercase small bold mb10 mt30">Follow</p>
                    <a href="http://twitter.com/intent/follow?source=followbutton&variant=1.0&screen_name=UnitedWayDallas" class="btn btn-gray btn-square"><i class="fa fa-twitter"></i></a>
                    <a href="http://www.facebook.com/unitedwaydallas" class="btn btn-gray btn-square"><i class="fa fa-facebook"></i></a>
                    <a href="http://www.instagram.com/unitedwaydallas/" class="btn btn-gray btn-square"><i class="fa fa-instagram"></i></a>
               
               </div>
          </div>
     </div>
</div>

<div id="backpack_scroll">
     <div class="backpack-image"></div>
</div>

<footer class="bg-gray text-center email-signup-form">
     <a id="closeFooter" class="fa fa-close"></a>
     <div class="container">
          <div class="row">
               <div class="col-sm-12">
                    <h3>Welcome to <span class="bold">UNITE</span></h3>
                    <?php gravity_form('Email Sign Up', $display_title=false, $display_description=true, $display_inactive=false, $field_values=null, $ajax=true, $tabindex=100); ?>
               </div>
          </div>
     </div>
</footer>



</div><!-- .site-content -->

<div id="modal">
     <div class="modal" id="video_overlay">
          <button class="modal-close"></button>

          <div class='embed-container'>
               <!-- vimeo video -->         
               <div class="lazyload" data-video-id="119095457" data-video-service="vimeo"></div>
          </div> 
     </div>
</div>

<?php wp_footer(); ?>


</body>
</html>



