/*globals $, jQuery, CSPhotoSelector */

$(document).ready(function() {
    var selector, logActivity, callbackAlbumSelected, callbackPhotoUnselected, callbackSubmit;
    var buttonOK = $('#CSPhotoSelector_buttonOK');
    var o = this;


    /* --------------------------------------------------------------------
     * Photo selector functions
     * ----------------------------------------------------------------- */

    fbphotoSelect = function(id) {
        // if no user/friend id is sent, default to current user
        if (!id)
            id = 'me';

        callbackAlbumSelected = function(albumId) {
            var album, name;
            album = CSPhotoSelector.getAlbumById(albumId);
            // show album photos
            selector.showPhotoSelector(null, album.id);
        };

        callbackAlbumUnselected = function(albumId) {
            var album, name;
            album = CSPhotoSelector.getAlbumById(albumId);
        };

        callbackPhotoSelected = function(photoId) {
            var photo;
            photo = CSPhotoSelector.getPhotoById(photoId);
            buttonOK.show();
            logActivity('Selected ID: ' + photo.id);
        };

        callbackPhotoUnselected = function(photoId) {
            var photo;
            album = CSPhotoSelector.getPhotoById(photoId);
            buttonOK.hide();
        };

        callbackSubmit = function(photoId) {
            var photo;
            photo = CSPhotoSelector.getPhotoById(photoId);
            logActivity('<input type="hidden" id="fbimgurl" value="' + photo.source + '"> ');
            /*var url = "http://ecoins.pnf-sites.info/developer/personlisedcoin/step2/";
            jQuery.ajax({
                type: 'POST',
                url: url,
                data: {data: photo.source}
            }).done(function(msg) {
               alert('yes');
                   
            });*/
            
            //setCookie("fbimg",photo.source,1);
             downloadimg(photo.source);
          
        };


        // Initialise the Photo Selector with options that will apply to all instances
        CSPhotoSelector.init({debug: true});

        // Create Photo Selector instances
        selector = CSPhotoSelector.newInstance({
            callbackAlbumSelected: callbackAlbumSelected,
            callbackAlbumUnselected: callbackAlbumUnselected,
            callbackPhotoSelected: callbackPhotoSelected,
            callbackPhotoUnselected: callbackPhotoUnselected,
            callbackSubmit: callbackSubmit,
            maxSelection: 1,
            albumsPerPage: 6,
            photosPerPage: 200,
            autoDeselection: true
        });

        // reset and show album selector
        selector.reset();
        selector.showAlbumSelector(id);
    }


    /* --------------------------------------------------------------------
     * Click events
     * ----------------------------------------------------------------- */

    $("#btnLogin").click(function(e) {
        e.preventDefault();
        FB.login(function(response) {
            if (response.authResponse) {
                $("#login-status").html("Logged in");
            } else {
                $("#login-status").html("Not logged in");
            }
            id = $(this).attr('data-id');
            fbphotoSelect(id);
        }, {scope: 'user_photos, friends_photos'});

    });

    $("#btnLogout").click(function(e) {
        e.preventDefault();
        FB.logout();
        $("#login-status").html("Not logged in");
    });

    $(".photoSelect").click(function(e) {
        e.preventDefault();
        id = null;
        if ($(this).attr('data-id'))
            id = $(this).attr('data-id');
        fbphotoSelect(id);
    });

    logActivity = function(message) {
        $("#results").append('<div>' + message + '</div>');
    };
});
function setCookie(cname,cvalue,exdays)
{ //alert(cname);
  //  alert(cvalue);
    //alert(exdays);
var d = new Date();
d.setTime(d.getTime()+(exdays*24*60*60*1000));
var expires = "expires="+d.toGMTString();
document.cookie = cname + "=" + cvalue + "; " + expires+';domain=ecoins.pnf-sites.info ;path=/';
window.location.href = 'https://personalizedcoins.com/personalizedcoin/step2/';
} 
function downloadimg(fbimg){
    //alert(1);
     $.ajax({
                    type: "POST",
                    url: 'https://personalizedcoins.com/select_template/createimage/',
                    data: {image: fbimg},
                    success: function(data) {
                    //    alert(data);
                      setCookie("fbimg",data,1);
                    }
                });
    
}