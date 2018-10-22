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
});