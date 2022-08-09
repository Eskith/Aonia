function send(data, action, successCallback, errorCallback) {
	data.action = action; 
	//console.log(data);
    fetch(window.location.href , {
        method: 'POST', // or 'PUT'
        body: JSON.stringify(data) , // data can be `string` or {object}!
        headers:{
              'Content-Type': 'application/json'
          }
      }).then(res => {
          if(res.ok){
              res.text().then(text => {
                let data; 
                  try {
					  console.log(text);
                      data = JSON.parse(text); 
                  } catch (error) {
                      console.error("Error parsing the data.");
                      console.log(text);
                        if(showNotification) showNotification("Hubo algún problema con el formato de los datos recibidos del servidor", "Error en el formato de los datos", 'Error');
                      throw error;
                  }
                  if(successCallback)successCallback(data); 
              }).catch(err => {
                  console.log("Error",err);
                  if(errorCallback) errorCallback(err);
                  if(showNotification) showNotification("Hubo algún problema en la respuesta del servidor", "Error en la respuesta del servidor", 'Error');
                  //document.getElementById("posts").insertAdjacentHTML("afterbegin", `<p>Hubo algún problema con la búsqueda. Inténtalo de nuevo</p>`);
                  //addNotification("Error", "Error recibiendo los datos del servidor.", "error");
              }); 
          }
      }).catch(error => {
          console.log("Error",error);
          if(showNotification) showNotification("Hubo algún problema en la conexión con el servidor", "Error en la conexión con el servidor", 'Error');

          //document.getElementById("posts").insertAdjacentHTML("afterbegin", `<p>Hubo algún problema con la búsqueda. Inténtalo de nuevo</p>`);
          //addNotification("Error", "Error enviando los datos al servidor", "error");
      });
}