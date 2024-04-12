var BrowserDetect = function() {
  var nav = window.navigator,
    ua = window.navigator.userAgent.toLowerCase();
  // detect browsers (only the ones that have some kind of quirk we need to work around)
  if (ua.match(/ipad/i) !== null)
    return "iPad";
  if (ua.match(/iphone/i) !== null)
    return "iPhone";
  if (ua.match(/android/i) !== null)
    return "Android";
  if (ua.match(/blackberry/gi) !== null)
    return "blackberry";
  if (ua.match(/opr/gi) !== null)
    return "opera";
  if (ua.match(/chrome/gi) !== null)
    return "Chrome";
  if (ua.match(/firefox/gi) !== null)
    return "Firefox";
  if (ua.match(/webkit/gi) !== null)
    return "Webkit";
  if (ua.match(/gecko/gi) !== null)
    return "Gecko";
  if (ua.match(/opera/gi) !== null)
    return "Opera";
  //If any case miss we will return null
  return null
}