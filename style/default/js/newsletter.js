$("#newsletter-form").submit
(
	function(event)
	{
		event.preventDefault();
		var result;
		$.ajax
		({
			type: "POST",
			data: $("#newsletter-form").serialize(),
			url: "newsletter",
			success: function(html)
			{
				//php  zwraca html z resulatem
                //$("#alert-area").html(html);
                msg = JSON.parse(html);             

                if(msg.code == 1)
				{
					$( "#newsletter-form" ).delay( 800 ).fadeIn( 400 );
					//$( "div.second" ).slideUp( 300 ).fadeIn( 400 );
                    //$("#newsletter-form").hide();
                }

				$("#alert-area").html(msg.text);
				$("#alert-area").fadeIn(500);
				$("#alert-area").delay( 400 ).fadeOut(1500);
                

			},

			error: function()
			{
				result = '<div class="alert alert-danger">There was an error sending the message!</div>';
				$("#alert-area").html(result);
			}

		});

	}

);