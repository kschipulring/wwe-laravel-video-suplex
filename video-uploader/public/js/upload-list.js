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

        $('#'+vidContentId).html("");
    });


    //I like this part
    $('.like_trigger').click(function(e) {
        e.preventDefault();

        //var tempArr = $(this).attr("rel").split(",");

        var ids = $(this).attr("rel");

        $.ajax({
            url: window.videoLikeAjaxPath + '?ids=' + ids,
            context: document.body
        }).done(function(data) {
            console.log("diet joke = ", $(this) );
            
        });
    });
});
