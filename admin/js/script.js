$(function() {
    // EDITOR CKE EDITOR
    ClassicEditor
        .create( document.querySelector( '#post_content' ) )
        .catch( error => {
            console.error( error );
        } );

    $('#selectAllBoxes').on('click', function() {
       if (this.checked) {
           $('.checkboxes').each(function() {
              this.checked = true;
           });
       } else {
           $('.checkboxes').each(function() {
               this.checked = false;
           });
       }
    });

    var div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $("body").prepend(div_box);
    $('#load-screen').delay(700).fadeOut(600, function() {
       $(this).remove();
    });


});

//
// function loadUsersOnline() {
//     $.get("functions.php?online_users=result", function(data) {
//         $('.users_online').text(data);
//     });
// }
// setInterval(function() {
//     loadUsersOnline();
// }, 1000);
