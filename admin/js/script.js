$(function() {
    // EDITOR CKE EDITOR
    ClassicEditor
        .create( document.querySelector( '#post_content' ) )
        .catch( error => {
            console.error( error );
        } );
});