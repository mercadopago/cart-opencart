/**
* Polyfills
* @public
*/
(function (){

  // IE8, IE9
  if (!String.prototype.trim) {
    (function() {
      // Make sure we trim BOM and NBSP
      var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
      String.prototype.trim = function() {
        return this.replace(rtrim, '');
      };
    })();
  }

  var JSON = JSON || {};

  if (!JSON.parse) {
    (function() {
      JSON.parse = function (obj) {
        'use strict';
        return eval("(" + obj + ")");
      };
    })();
  }

  if (!JSON.stringify) {
    (function() {
      JSON.stringify = function (obj) {
        var t = typeof (obj);
        if (t != "object" || obj === null) {
          // simple data type
          if (t == "string"){
            obj = '"'+obj+'"';
          }
          return String(obj);
        } else {
          // recurse array or object
          var n, v, json = [], arr = (obj && obj.constructor == Array);
          for (n in obj) {
            v = obj[n]; t = typeof(v);
            if (t == "string"){
              v = '"'+v+'"';
            }else if (t == "object" && v !== null){
              v = JSON.stringify(v);
            }
            if(t !== "function"){
              json.push((arr ? "" : '"' + n + '":') + String(v));
            }
          }
          return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
        }
      };
    })();
  }

  if (!Array.prototype.filter) {
    (function(){
      Array.prototype.filter = function (fun) {
        'use strict';
        if (this === void 0 || this === null) {
          throw new TypeError();
        }
        var t = Object(this);
        var len = t.length >>> 0;
        if (typeof fun !== 'function') {
          throw new TypeError();
        }

        var res = [];
        var thisArg = arguments.length >= 2 ? arguments[1] : void 0;
        for (var i = 0; i < len; i++) {
          if (i in t) {
            var val = t[i];
            if (fun.call(thisArg, val, i, t)) {
              res.push(val);
            }
          }
        }
        return res;
      };
    })();
  }

  // Production steps of ECMA-262, Edition 5, 15.4.4.18
  if (!Array.prototype.forEach) {

    Array.prototype.forEach = function forEach(callback, thisArg) {
      'use strict';
      var T, k;

      if (this == null) {
        throw new TypeError("this is null or not defined");
      }

      var kValue,
      // 1. Let O be the result of calling ToObject passing the |this| value as the argument.
      O = Object(this),

      // 2. Let lenValue be the result of calling the Get internal method of O with the argument "length".
      // 3. Let len be ToUint32(lenValue).
      len = O.length >>> 0; // Hack to convert O.length to a UInt32

      // 4. If IsCallable(callback) is false, throw a TypeError exception.
      // See: http://es5.github.com/#x9.11
      if ({}.toString.call(callback) !== "[object Function]") {
        throw new TypeError(callback + " is not a function");
      }

      // 5. If thisArg was supplied, let T be thisArg; else let T be undefined.
      if (arguments.length >= 2) {
        T = thisArg;
      }

      // 6. Let k be 0
      k = 0;

      // 7. Repeat, while k < len
      while (k < len) {

        // a. Let Pk be ToString(k).
        //   This is implicit for LHS operands of the in operator
        // b. Let kPresent be the result of calling the HasProperty internal method of O with argument Pk.
        //   This step can be combined with c
        // c. If kPresent is true, then
        if (k in O) {

          // i. Let kValue be the result of calling the Get internal method of O with argument Pk.
          kValue = O[k];

          // ii. Call the Call internal method of callback with T as the this value and
          // argument list containing kValue, k, and O.
          callback.call(T, kValue, k, O);
        }
        // d. Increase k by 1.
        k++;
      }
      // 8. return undefined
    };
  }

  if (!document.querySelectorAll) {
    (function(){
      document.querySelectorAll = function (selectors) {
        var style = document.createElement('style'), elements = [], element;
        document.documentElement.firstChild.appendChild(style);
        document._qsa = [];

        style.styleSheet.cssText = selectors + '{x-qsa:expression(document._qsa && document._qsa.push(this))}';
        window.scrollBy(0, 0);
        style.parentNode.removeChild(style);

        while (document._qsa.length) {
          element = document._qsa.shift();
          element.style.removeAttribute('x-qsa');
          elements.push(element);
        }
        document._qsa = null;
        return elements;
      };
    })();
  }

  if (!document.querySelector) {
    (function(){
      document.querySelector = function (selectors) {
        var elements = document.querySelectorAll(selectors);
        return (elements.length) ? elements[0] : null;
      };
    })();
  }

})();


(function (){

  var settings = {
    api_url: "https://api.mercadopago.com"
  }

  var ModuleAnalytics = {
    public_key: null,
    token: null,

    //post
    payer_email: null,
    user_logged: null,
    platform: null,
    platform_version: null,
    module_version: null,
    installed_modules: null,
    additional_info: null,

    //put
    payment_id: null,
    payment_type: null,
    checkout_type: null
  }

  ModuleAnalytics.setPublicKey = function(publicKey){
    ModuleAnalytics.public_key = publicKey;
  };
  ModuleAnalytics.setToken = function(token){
    ModuleAnalytics.token = token;
  };
  ModuleAnalytics.setPayerEmail = function(payerEmail){
    ModuleAnalytics.payer_email = payerEmail;
  };
  ModuleAnalytics.setUserLogged = function(userLogged){
    ModuleAnalytics.user_logged = userLogged;
  };
  ModuleAnalytics.setPlatform = function(platform){
    ModuleAnalytics.platform = platform;
  };
  ModuleAnalytics.setPlatformVersion = function(platformVersion){
    ModuleAnalytics.platform_version = platformVersion;
  };
  ModuleAnalytics.setModuleVersion = function(moduleVersion){
    ModuleAnalytics.module_version = moduleVersion;
  };
  ModuleAnalytics.setInstalledModules = function(installedModules){
    ModuleAnalytics.installed_modules = installedModules;
  };
  ModuleAnalytics.setAdditionalInfo = function(additionalInfo){
    ModuleAnalytics.additional_info = additionalInfo;
  };
  ModuleAnalytics.setPaymentId = function(paymentId){
    ModuleAnalytics.payment_id = paymentId;
  };
  ModuleAnalytics.setPaymentType = function(paymentType){
    ModuleAnalytics.payment_type = paymentType;
  };
  ModuleAnalytics.setCheckoutType = function(checkoutType){
    ModuleAnalytics.checkout_type = checkoutType;
  };

  ModuleAnalytics.referer = (function () {
    var referer = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');

    return referer;
  })();

  ModuleAnalytics.post = function () {


    var checkout = getCheckoutId()

    var url = settings.api_url + "/modules/tracking/checkout" + getParamsRequest()

    var data = ModuleAnalytics

    AJAX({
      url: url,
      method : "POST",
      data:data,
      timeout : 5000,
      success : function (status, response){

        if (status == 200 || status == 201){
          setCheckoutId(response.checkout_id)
        }
      }
    });
  }

  ModuleAnalytics.put = function () {

    var url = settings.api_url + "/modules/tracking/checkout/" + getCheckoutId() + getParamsRequest()

    var data = ModuleAnalytics

    AJAX({
      url: url,
      method : "PUT",
      data:data,
      timeout : 5000,
      success : function (status, response){

        if (status == 200 || status == 201){
          removeCheckoutId()
        }
      }
    });
  }

  function getParamsRequest(){
    var params = "?public_key=" + ModuleAnalytics.public_key

    if(ModuleAnalytics.public_key == null){
      params = "?token=" + ModuleAnalytics.token
    }

    return params
  }

  function setCheckoutId(checkoutId){
    if (typeof(Storage) !== "undefined") {
      localStorage.setItem("checkout_id", checkoutId);
    } else {
      setCookie("checkout_id", checkoutId, 10);
    }

    return checkoutId
  }

  function getCheckoutId(){
    if (typeof(Storage) !== "undefined") {
      return localStorage.getItem("checkout_id")
    } else {
      return getCookie("checkout_id")
    }
  }

  function removeCheckoutId() {

    if (typeof(Storage) !== "undefined") {
      return localStorage.removeItem("checkout_id")
    } else {
      removeCookie("checkout_id")
    }

  }


  function setCookie(name,value,days) {
    if (days) {
      var date = new Date();
      date.setTime(date.getTime()+(days*24*60*60*1000));
      var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
  }

  function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
  }

  function removeCookie(name) {
    createCookie(name,"",-1);
  }



  function AJAX(options){
    var useXDomain = !!window.XDomainRequest;

    var req = useXDomain ? new XDomainRequest() : new XMLHttpRequest()
    var data;

    options.url += (options.url.indexOf("?") >= 0 ? "&" : "?") + "referer="+escape(ModuleAnalytics.referer);

    options.requestedMethod = options.method;

    if (useXDomain && options.method == "PUT") {
      options.method = "POST";
      options.url += "&_method=PUT";
    }

    req.open(options.method, options.url, true);

    req.timeout = options.timeout || 1000;

    if (window.XDomainRequest) {
      req.onload = function(){
        data = JSON.parse(req.responseText);
        if (typeof options.success === "function") {
          options.success(options.requestedMethod === 'POST' ? 201 : 200, data);
        }
      };
      req.onerror = req.ontimeout = function(){
        if(typeof options.error === "function"){
          options.error(400,{user_agent:window.navigator.userAgent, error : "bad_request", cause:[]});
        }
      };
      req.onprogress = function() {};
    } else {
      req.setRequestHeader('Accept','application/json');

      if(options.contentType){
        req.setRequestHeader('Content-Type', options.contentType);
      }else{
        req.setRequestHeader('Content-Type', 'application/json');
      }

      req.onreadystatechange = function() {
        if (this.readyState === 4){
          if (this.status >= 200 && this.status < 400){
            // Success!
            data = JSON.parse(this.responseText);
            if (typeof options.success === "function") {
              options.success(this.status, data);
            }
          }else if(this.status >= 400){
            data = JSON.parse(this.responseText);
            if (typeof options.error === "function") {
              options.error(this.status, data);
            }
          }else if (typeof options.error === "function") {
            options.error(503, {});
          }
        }
      };
    }

    if(options.method === 'GET' || options.data == null || options.data == undefined){
      req.send();
    }else{
      req.send(JSON.stringify(options.data));
    }
  }

  this.ModuleAnalytics = ModuleAnalytics

}).call();