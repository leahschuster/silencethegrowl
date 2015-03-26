/* DONATION FORMS 
 - This is needed on any page that has a donately form... 
 - /donate /pledge /unite-forever 
 - and possibly the society pages */

 
if(typeof jQuery == 'undefined') {
    console.log('%cERROR', 'color:red', ' - jQuery not found.')
} else {


!(function ($) {
     var priceInterval ='#intervalDonateForm .input-price-options label',
     inputAmountID ='#donately-amount';


     //Update Amount input when price is clicked
     //Click donate presets
     $(document).delegate(priceInterval, 'mouseup touchstart', function(event) {
          event.preventDefault();
          var newAmount = $(this).prev('input').val();
          $(inputAmountID).val(newAmount);
     }); 
     

     //Click Enter Payment Info button
     $(document).delegate('#donate_card_info', 'mouseup touchstart', function(event) {
          event.preventDefault();
          $('#donation').addClass('step-two');
     }); 



     //remove selected state of Price Interval box
     function removePriceSelection(){
          $('.input-price-options input').prop('checked', false);
     }

     //when Enter Amount is clicked
     $(inputAmountID).click( function(){
          removePriceSelection()
     });




     /** WINDOW LOAD  */
     $(window).load(function(){

        //donately return messages
        function receiveMessage(event){
            try {var data = JSON.parse(event.data);}
            catch (e) {var data = event.data;}
            if(data.event == 'donately.loaded'){  
              console.log('donately form loaded');
            }
            if(data.event == 'donately.success'){
               // ga('send', 'event', 'donation', 'success');
             }
          }
          if (window.addEventListener){
            window.addEventListener('message', receiveMessage, false);
          }
          else if (window.attachEvent){
            window.attachEvent('message', receiveMessage);
          }

    });

 

})(jQuery);





};


