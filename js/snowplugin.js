jQuery(document).ready(function($){
    var fullPath = window.location.protocol+'//'+window.location.hostname+(window.location.port ? ':'+window.location.port: '');
	  var audio_state='Play';
	  var d = new Date();
	   if (localStorage.getItem("audioState") === null) {
              localStorage.setItem('audioState','Play');
			   var firstVisit = d.getTime();
			  localStorage.setItem('visit_F',firstVisit);
			  audio_state=localStorage.getItem("audioState");
            }
		 else{		        
				// not first visit check time difference
				var lastVisit=localStorage.getItem('visit_F');
				var current= new Date();
				var currentVisit=current.getTime();
				if(currentVisit > lastVisit)
				{
				     var visitDifference=currentVisit-lastVisit;
					     var msec = visitDifference;
                         var hh = Math.floor(msec / 1000 / 60 / 60);
                            if(hh>=1){
							     // reset preference
								  localStorage.setItem('audioState','Play');
								  localStorage.setItem('visit_F',currentVisit);
							}
							else{
							     audio_state=localStorage.getItem("audioState");								 
							}
				}
		 }
	     // set the default state prefered by user
		   if( audio_state=='Play')
		   {
			  document.getElementById('audio').play();
              document.getElementById('player').src='/wp-content/plugins/Snowy_Bells/images/play.png';   
           }
		   else if(audio_state=='Pause')
		   {
			  document.getElementById('audio').pause();
             document.getElementById('player').src='/wp-content/plugins/Snowy_Bells/images/pause.jpg';
		   }
	      jQuery(function(){
	      jQuery('#player').click(function() {
		      var audioElement=document.getElementById('audio');
		          if(audioElement.paused)
				  {
					  document.getElementById('audio').play();
					  localStorage.setItem('audioState','Play');
                      document.getElementById('player').src='/wp-content/plugins/Snowy_Bells/images/play.png';
                      console.log('play');
				  }
				  else
				  {
					document.getElementById('audio').pause();
					localStorage.setItem('audioState','Pause');
                    document.getElementById('player').src='/wp-content/plugins/Snowy_Bells/images/pause.jpg';
                      console.log('pause');
				  }
			   });
	  });
});
    