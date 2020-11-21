$(document).ready(function(){
    var uploader = new ss.SimpleUpload({
        button: 'change-p-image', // file upload button
        url: 'uploadHandler.php', // server side handler
        name: 'uploadfile', // upload parameter name        
        responseType: 'json',
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        maxSize: 1024, // kilobytes
        hoverClass: 'ui-state-hover',
        onSubmit: function(filename, extension) {
            this.setFileSizeBox(sizeBox); // designate this element as file size container
            this.setProgressBar(progress); // designate as progress bar
          },         
        onComplete: function(filename, response) {
            if (!response) {
                alert(filename + 'upload failed');
                return false;            
            }
            // do something with response...
          }
    });        
});