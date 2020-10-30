        $(document).ready(function() {
                    
            $("#alert1").click(function() {
                jAlert('error', 'Message sent error.', 'Error');
            });

            $("#alert3").click(function() {
                jAlert('success', 'The message was successfully sent.', 'Success sent');
            });
			
        });