$(document).ready(function(){
   $(".registerBtn").click(function(){
       $(".login").fadeOut('normal', function(){
            $(".register").fadeIn('normal');
            $("#mid").addClass('tall');

            $('.logUserName').removeClass('error');
            $('.logUserPass').removeClass('error');
            $('small').remove();
       });
   });
        
   $(".loginBtn").click(function(){
       $(".register").fadeOut('normal', function(){
            $(".login").fadeIn('normal');
            $("#mid").removeClass('tall');

            $('.regUserName').removeClass('error');
            $('.regUserEmail').removeClass('error');
            $('.regUserPass').removeClass('error');
            $('.regUserConfirm').removeClass('error');
            $('small').remove();
        });
   });
})