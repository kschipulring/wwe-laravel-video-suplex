jQuery(document).ready(function($) {
    
    // Our script will go here
    $('.lightbox_trigger').click(function(e) {
        e.preventDefault();

        var vidContentId = "videocontent";

        var image_href = $(this).attr("href");
        
        // Code that makes the lightbox appear
        if ($('#lightbox').length > 0) { // #lightbox exists

            var tempContent = `<video id="videoplayer" width="50%" controls>
              <source id="vidsource" src="`+ image_href +`" type="video/mp4">
              Your browser does not support HTML5 video.
            </video>`;

            //populate the video content
            $('#'+vidContentId).html(tempContent);

            //show lightbox window - you can use a transition here if you want, i.e. .show('fast')
            $('#lightbox').show();
        }else { //#lightbox does not exist 
            
            //create HTML markup for lightbox window
            var lightbox = 
            `<div id="lightbox">
                <div id="`+vidContentId+`"></div>
                <h2>Click to close</h2> 
            </div>`;
                
            //insert lightbox HTML into page
            $('body').append(lightbox);
        }
    });

    //Click anywhere on the page to get rid of lightbox window
    $('#lightbox').on('click', function() {
        $('#lightbox').hide();

        $('#videocontent').html("");
    });


    //I like this part
    $('.like_trigger').click(function(e) {
        e.preventDefault();

        //user id and video id pair associated with this button
        var ids = $(this).attr("rel");

        //get the id attribute
        var domId = $(this).attr("id");

        var vid = $(this).attr("vid");

        $.ajax({
            url: window.videoLikeAjaxPath + '?ids=' + ids,
            context: document.body
        }).done(function(data) {
            $( "#" + domId ).addClass( "hide" ).removeClass("show");

            console.log( $( "#" + domId ).next().attr("id")  );

            $( "#" + domId ).next().addClass( "show" ).removeClass("hide");

            //increase the number of likes for this video
            var num_likes = parseInt( $("#num_likes_"+vid).text() );

            $("#num_likes_"+vid).text( num_likes+1 ); 
        });
    });

    //this is unlikable
    $('.unlike_trigger').click(function(e) {
        e.preventDefault();

        var ids = $(this).attr("rel");

        var domId = $(this).attr("id");

        var vid = $(this).attr("vid");

        $.ajax({
            url: window.videoUnlikeAjaxPath + '?ids=' + ids,
            context: document.body
        }).done(function(data) {
            $( "#" + domId ).addClass( "hide" ).removeClass("show");

            console.log( $( "#" + domId ).prev().attr("id")  );

            $( "#" + domId ).prev().addClass( "show" ).removeClass("hide");

            //lower the number of likes for this video
            var num_likes = parseInt( $("#num_likes_"+vid).text() );

            $("#num_likes_"+vid).text( num_likes-1 );         
        });
    });

});


function showPosition(latlon, eid) {  
    var img_url = "https://maps.googleapis.com/maps/api/staticmap?center="
    +latlon+"&zoom=14&size=400x300&key="+window.googleMapsKey;
    document.getElementById(eid).innerHTML = "<img src='"+img_url+"' />";
}

function mapGroup(){
    console.log("Google Maps loaded");
}