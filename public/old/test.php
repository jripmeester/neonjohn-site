<body>
  {CONTENT}
  <?php	
	// show new bar
		$bStimulateCreateProfile = FALSE;
	if (config::isRegistered('stimulateCreateProfile')) {
		$bStimulateCreateProfile = config::get('stimulateCreateProfile');
	}
	if ($bStimulateCreateProfile === TRUE) {
		// show trigger to create profile	
		if ( ! $wmUser->can('competition.personalize') ) {
			$iNumberOfActiveUsers = user::getAllCountByGroupId(6);
			?>
			<div id="scrolltotop">
				<div>					
					<img src="/application/assets/images/footer_logo.jpg" alt="Logo Nevobo" class="floatLeft" style="margin-right: 20px" />
					<p><span class="highlight"><?php echo number_format($iNumberOfActiveUsers,0,'.',','); ?> volleyballiefhebbers</span> hebben al een account op volleybal.nl. </p> <a style="margin-left: 15px;" href="/competitie/aanmelden" onclick="_gaq.push(['_trackPageview', '/registeren/balk'],['b._trackPageview', '/registeren/balk']);"><img src="/application/assets/images/registreergratis.png" /></a>
		      <a href="#" class="backToTop"><img src="/application/assets/images/terugnaarboven2.png" alt="Terug naar boven" /></a>
				</div>
		</div>	
		<?php
			/*$session = registry::get('session');
			if ( $session instanceof session && $session->get('popupOpened') != 'true') {
		?>
		<script type="text/javascript">
			function cookieExists(cookieName) {
				return document.cookie.indexOf(cookieName)!=-1? true : false;
			}

				// open a welcome message as soon as the window loads
		    window.addEvent('domready', function() {
		    		(function(){Shadowbox.open({
			        content:    '/application/handlers/stimulateCreateProfile.php',
			        title:      "Registreer nu GRATIS",
			        height:     600,
			        width:      560,
			        player:			"iframe"
			   	 })}).delay(400);
		    });
			
		</script>
			<?php				
			}
			 */
		}
		// show user profile with competition buttons
		else {
			$sImage = NULL;
			
			if (isset($wmUser->wmUserInfo) && $wmUser->wmUserInfo->iFileId != NULL){
	      $wmFile = file::getById($wmUser->wmUserInfo->iFileId);
	      
	      if ($wmFile instanceof image) {
	        $wmFile->resizeAndCrop(35, 35);   
	        $sImage = '<img src="'.$wmFile->getProcessedPath().'" alt="'.$wmUser->sFirstName.'" class="floatLeft" style="margin-right: 10px" />';
	      } 
	    }
	    if ($sImage === NULL) {
	      $sImage = '';//'<img src="/application/assets/images/icons/medewerker.png" width="25" height="30" class="floatLeft" style="margin-right: 10px;" alt="" />';
	    }		?>
      
	
		<div id="scrolltotop">
			<div>
				<?php echo $sImage; ?>
				<p style="float: left; position: relative; display: block; margin-right: 15px;"><strong><?php echo $wmUser->sFirstName; ?></strong></p>
				<a class="footerButton first" href="/competitie/mijn-competitie" title="Dashboard">Mijn competitie</a>
				<?php
				 $wmMyOrganisation = NULL;
		      // mijn vereniging ophalen
		      if (isset($wmUser->wmUserInfo->iOrganisationId)) {
		        $wmMyModule = module::getGenericModuleByClassName('modISSOrganisations');
		        $wmMyOrganisation = clone $wmMyModule->wmModule; // Clone this instance to make sure we wont change the master version.
		        $wmMyOrganisation->getById($wmUser->wmUserInfo->iOrganisationId);
		      }
          if ($wmMyOrganisation != NULL && $wmMyOrganisation instanceof genericModule) {
        ?>
        <a class="footerButton" href="/competitie/vereniging/<?php echo $wmMyOrganisation->iOrganisationId; ?>" title="<?php echo $wmMyOrganisation->sName; ?>">Vereniging: <?php echo $wmMyOrganisation->sName; ?></a>
        <?php            	
					}
        ?>
				<a class="footerButton" href="/competitie/mijn-competitie/instellingen" title="Mijn instellingen">Mijn instellingen</a>
				<a class="footerButton" href="/competitie" title="Competitie portal">Zoek competitie</a>	     
	      <a class="footerButton last" href="/logout" title="Uitloggen">Uitloggen</a>
	      <a href="#" class="backToTop"><img src="/application/assets/images/terugnaarboven2.png" alt="Terug naar boven" /></a>
			</div>
		</div>	
		
<?php
		}		
	}
	// show default "terug naar boven"
	else {
?>
<div id="scrolltotop">
	<div><a href="#" class="backToTop"><img src="/application/assets/images/terugnaarboven.png" alt="Terug naar boven" /></a></div>
</div>
<?php
	}
?>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/nl_NL/all.js"></script>
<script src="/application/assets/javascript/facebook.js" type="text/javascript"></script>
<?php



if(isset($_GET['forgot']) && $_GET['forgot'] == 'password' && !$user->getUserId() > 0) {?>
<a href="/competitie/wachtwoord-vergeten" id="forgotpass" style="display: none;" rel="shadowbox;width=740;height=500;">wachtwoord vergeten</a>
<script type="text/javascript">
  window.addEvent('domready', function() {

    (function(){$('forgotpass').fireEvent('click');}).delay(500);

  });
</script>
<?php }?>
<?php
if(isset($_GET['login']) && $_GET['login'] == 'popup' && !$user->getUserId() > 0) {?>
<a href="/competitie/inloggen?ajax<?php echo isset( $_GET['target'] ) ? '=&target='.$_GET['target'] : NULL ?>" id="loginpopup" style="display: none;" rel="shadowbox;width=740;height=500;">Login</a>
<script type="text/javascript">
  window.addEvent('domready', function() {

    (function(){$('loginpopup').fireEvent('click');}).delay(500);

  });
</script>
<?php }?>
      <script type="text/javascript">
        function browserSupportsCookies() {
          var cookieEnabled=(navigator.cookieEnabled)? true : false;
          
          //ifÂ·notÂ·IE4+Â·norÂ·NS6+
          if (typeof navigator.cookieEnabled=="undefined" && !cookieEnabled){
            document.cookie="testcookie";
            cookieEnabled=(document.cookie.indexOf("testcookie")!=-1)? true : false;
          }
          return cookieEnabled;
        }
      
        if (browserSupportsCookies()) {
          window.addEvent('domready', function() {
            var myCookie = Cookie.read('firstVisitPopUpClosed');
            if(myCookie == null) {
              (function(){
                Shadowbox.open({
                  content:    '/application/handlers/nosVideo.php?sVideoId=YSYA5cY2r3c',
                  player:     "iframe",
                  title:      "Nummer Ã©Ã©n van de wereld! Alexander Brouwer en Robert Meeuwsen: GEFELICITEERD!",
                  height:     430,
                  width:      800,
                  options: {
                    onClose: function() {
                      var myCookie = Cookie.write('firstVisitPopUpClosed', 'true', {duration: 7});
                    }
                  }
                });
              }).delay(500);
            }
          });
        }
      </script>
</body>