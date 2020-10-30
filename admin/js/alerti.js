        $(document).ready(function() {
                    
            $("#alert1").click(function() {
                jAlert('error', 'This is the error dialog box with some extra text.', 'Error Dialog');
            });

            $("#alert3").click(function() {
                jAlert('success', 'This is the success dialog.', 'Success Dialog');
            });
			
        });