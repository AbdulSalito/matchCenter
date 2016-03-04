function checkOldPwd(id,fontId,pwdDb){
   var inputId = document.getElementById(id);
   var fontChange = document.getElementById(fontId);
	if (inputId.value != pwdDb) {
   	 	alert( '«·»«”ÊÊ—œ «·ﬁœÌ„ Œ«ÿ∆' );
	}
}
function isEmail(string) {
  var regex1 = /^[\w\.\-]*[\w\.\-]+\@([a-z0-9]+[\.\-])*[a-z0-9]+\.[a-z]{2,}$/i
  var regex2 = /^[\w\.\-]*[\w\.\-]+\@\[\d{1,3}\.\d{1,3}\.\d{1.3}\.\d{1,3}\]$/i

  if (regex1.test(string)) { return true; }
  else { 
    if (regex2.test(string)) { return true; }
    else { 
      alert("Email address is not valid")
      return false; 
    }
  }
}

function chkvals(nm) {
  var df = document.forms[nm]
  if (!compFields(nm)) { return false; }
  if (df.email1.value == "") {
    alert("Must have an email address in 'Email' field");
    df.email1.focus();
    return false;
  }
  if (df.email2.value == "") {
    alert("Must have an email address in 'Retype Email' field");
    df.email2.focus();
    return false;
  }
  if (!isEmail(df.email1.value)) {
    df.email1.focus();
    return false;
  }
  return true
}

function compFields(nm) {
  var df = document.forms[nm]
  var aa,bb;
  aa = df.email1.value;
  bb = df.email2.value;
  if ((aa=="") || (bb=="")) { return true; }
  if (aa!=bb) {
    alert("Email and check fields should match");
    df.email1.focus();
    return false;
  }
  return true;
}
