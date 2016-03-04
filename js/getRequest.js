var getRequest = function( url, callbackFunction, DivTarget) {
  var httpRequest;

  if (window.XMLHttpRequest) { 
    httpRequest = new XMLHttpRequest();
  }
  else if (window.ActiveXObject) { 
    try {
        httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e) {
        try {
            httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e) {}
    }
  }

  if (!httpRequest) { 
    alert('Giving up :( Cannot create an XMLHTTP instance');
    return false;
  }
  httpRequest.open('get', url, true);
  httpRequest.onreadystatechange = function() {
    var completed = 4, successful = 200;
    if (httpRequest.readyState == completed) {
      if (httpRequest.status == successful) {
         callbackFunction(httpRequest.responseText, DivTarget);
      } else {
         alert('There was a problem with the request.');
      }
    }
  }
  httpRequest.send(null);
}  