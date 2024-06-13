
    $(document).ready(function(){
        $('#staffview').hide();
        $('#timtecview').hide();
        $('#hodview').hide();
        $('#siteupdate').fadeOut(5000);
         

        $('#staff').hover(
           function (){
            $('#staffview').fadeIn(2000)
            .addClass('ch_vw');
            $(this).addClass('ch_view');
           },
           function (){
            $('#staffview').fadeOut(1000)
            $(this).removeClass('ch_view');
           }
        );

        $('#timtec').hover(
            function (){
             $('#timtecview').fadeIn(2000)
             .addClass('ch_vw');
             $(this).addClass('ch_view');
            },
            function (){
             $('#timtecview').fadeOut(1000);
             $(this).removeClass('ch_view');
            }
         );

         $('#hod').hover(
            function (){
             $('#hodview').fadeIn(2000)
             .addClass('ch_vw');
             $(this).addClass('ch_view');
            },
            function (){
             $('#hodview').fadeOut(1000);
             $(this).removeClass('ch_view');
            }
         );

         $('.title').addClass('ch_vwt');
        
         $('fieldset').hover(function(){
            $('fieldset').toggleClass('formback');
         });
        
         //tooltips for the whatsapp on index page
         $('.btn-close').click(function() {
    $('.message').fadeOut();
  });
        
         
    });
