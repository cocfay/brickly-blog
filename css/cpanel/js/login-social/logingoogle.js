
var GoogleLogin = {

  CallBackLogin : async function(response){

    let data = GoogleLogin.decodeToken(response.credential);

    var DataSend;

    let CountryUs = await GoogleLogin.GetCountry();
        if(CountryUs){
           DataSend = {'RequestUserSocial' : 
                                          {
                                            'UserID':data.sub, 
                                            'AccessToken' : response.credential, 
                                            'Name' : data.name, 
                                            'Email' : data.email,
                                            'Country' : CountryUs,
                                            'Type' : 'Google'
                                          }
                        };
        }else{
            DataSend = {'RequestUserSocial' : 
                                          {
                                            'UserID':response.sub, 
                                            'AccessToken' : response.credential, 
                                            'Name' : data.name, 
                                            'Email' : data.email,
                                            'Country' : 0,
                                            'Type' : 'Google'
                                          }
                        };

        }
        GoogleLogin.Login(DataSend);


  },

  Login: function(DataSend){
          $.post('./socialregisterlogin',DataSend,function(r){

            if(r.error === true){
              alert(r.message);
            }else if(r.error === false){
              window.location.reload();
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

  decodeToken : function(token){
        let base64Url = token.split('.')[1]
        let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        let jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
        return JSON.parse(jsonPayload)

  },


}

window.onload = function () {
    google.accounts.id.initialize({
        client_id: "917390612785-1oa9360b789nc9a04mhaltrffgjd3ems.apps.googleusercontent.com",
        callback: GoogleLogin.CallBackLogin
    });
    google.accounts.id.renderButton(
        document.getElementById("googlesesion"),
        { theme: "outline", size: "large", width: "500" }  // customization attributes
    );

}
