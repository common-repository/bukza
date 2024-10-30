(function($) {
    function bukzaUpdate (dataObject, reload) {
            $.ajax({
                url: wpData.rest_url + '/bukza/v1/update',
                method: 'POST',
                beforeSend: function(xhr){
                  xhr.setRequestHeader( 'X-WP-Nonce', wpData.nonce );
                },
                data: {
                    id: dataObject.id,
                    secret: dataObject.secret
                }
              }).done(function(response){
                  if(reload){
                    document.location.reload();
                  }
              }).fail(function(response){
				  if(response.responseJSON){
					alert( response.responseJSON.message );
				  }
              });
    }

    function processMessage (e) {
		if (e && e.data && (typeof e.data) == 'string' && e.data.indexOf('BUKZA_CROSS_FRAME_WORDPRESS') != -1) {
			var dataObject = JSON.parse(e.data);
			if (dataObject.command === 'BUKZA_WORDPRESS_UPDATE_RELOAD') {
				bukzaUpdate(dataObject, true);
			} else if (dataObject.command === 'BUKZA_WORDPRESS_UPDATE') {
				bukzaUpdate(dataObject, false);
			} else if (dataObject.command === 'BUKZA_WORDPRESS_RELOAD') {
				document.location.reload();
			}
		}
    }

    $(function() {
        if (window.addEventListener) {
            window.addEventListener("message", processMessage, false);
        }
        else {
            window.attachEvent("onmessage", processMessage);
        }
    });
})(jQuery)