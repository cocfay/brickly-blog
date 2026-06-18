window.fbAsyncInit = function() {
    FB.init({
        //appId      : '868276264606206',
        appId : '2051841411708883',
        cookie     : true,  // enable cookies to allow the server to access 
                            // the session
        xfbml      : true,  // parse social plugins on this page
        version    : 'v15.0' // Specify the Graph API version to use
    });

};

  // Load the SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/es_ES/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk')
);




var FacebookApi = {

  CheckLogin : async function(){

    FB.getLoginStatus(function(response) {
      if(response.status === 'connected'){
        FacebookApi.GetDataUser({'Login':true, 'AccessToken' : response.authResponse.accessToken })
      }else{
        consoe.log('Inicie session en la app.');
      }
    });

  },

  GetDataUser : async function(parms){
      FB.api('/me', 'GET', {"fields":"id,name,email,picture,location{location{country}}"}, async function(response) {

        if(parms.Login == true){
          var DataSend = {};
          if(response.location.location.country != undefined){
             DataSend = {'RequestUserSocial' : 
                                          {
                                            'UserID':response.id, 
                                            'AccessToken' : parms.AccessToken, 
                                            'Name' : response.name, 
                                            'Email' : response.email,
                                            'Country' : response.location.location.country,
                                            'Type' : 'Facebook'
                                          }
                        };
          }else{
              let CountryUs = await FacebookApi.GetCountry();
              if(CountryUs){
                 DataSend = {'RequestUserSocial' : 
                                          {
                                            'UserID':response.id, 
                                            'AccessToken' : parms.AccessToken, 
                                            'Name' : response.name, 
                                            'Email' : response.email,
                                            'Country' : CountryUs,
                                            'Type' : 'Facebook'
                                          }
                        };

              }else{

                  DataSend = {'RequestUserSocial' : 
                                          {
                                            'UserID':response.id, 
                                            'AccessToken' : parms.AccessToken, 
                                            'Name' : response.name, 
                                            'Email' : response.email,
                                            'Country' : 0,
                                            'Type' : 'Facebook'
                                          }
                        };

              }


          }
          
            FacebookApi.Login(DataSend);
        }else{
          return response;
        }

      });

  },
  GetCountry : async function(){

   let getres = await $.get("./getdataloc");

   let parseRT =  JSON.parse(getres);

   if(parseRT.country_name != undefined){
    return parseRT.country_name;
   }else{
    return false;
   }
  },

  Login: function(DataSend){
          $.post('./socialregisterlogin',DataSend,function(r){

            if(r.error === true){
              alert(r.message);
            }else if(r.error === false){
              window.location.reload();
            }
          });



  }


}
