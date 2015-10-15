(function() {

  var FacebookCommerce = {
    setCookie: function(name, value, path) {
      var d = new Date();
      d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));

      var cValue      = [name, "=", value, ";"].join('');
      var cExpires    = ["expires=", d.toUTCString(), ';'].join('');
      var cPath       = ["path=", path, ';'].join('');
      document.cookie = [cValue, cExpires, cPath].join('');
    },
    getCookie: function(name) {
        var cName = name + "=";
        var cArray = document.cookie.split(';');
        for (var i = 0; i < cArray.length; i++) {
          var val = cArray[i];
          while (val.charAt(0) === ' ') {
            val = val.substring(1);
          }
          if (val.indexOf(cName) === 0) {
            return val.substring(cName.length, val.length);
          }
        }
        return "";
    },
    checkCookie: function(name) {
      var val = this.getCookie(name);
      if (val !== "") {
        return true;
      } else {
        return false;
      }
    }
  };

  var checkoutNextThankYouPage = window.location.pathname.match(/^\/\d{7,}\/checkouts\/[a-z0-9]{32}\/thank_you$/i);

  var notifyFacebookOfConversion = function(checkoutTotal) {
    var _fbq = window._fbq || (window._fbq = []);

    // This JavaScript was obtained from Facebook via their Offsite Conversion Pixel API.
    // https://developers.facebook.com/docs/reference/ads-api/offsite-pixels
    if (!_fbq.loaded) {
      var fbds = document.createElement('script');
      fbds.async = true;
      fbds.src = '//connect.facebook.net/en_US/fbds.js';
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(fbds, s);
      _fbq.loaded = true;
    }

    _fbq.push(['track', 6026163987670, { 'value': checkoutTotal, 'currency': 'USD' }]);
  };

  if (checkoutNextThankYouPage) {
    if ((typeof(Shopify) === "object") && (typeof(Shopify.checkout) === "object")) {
      path = location.pathname;
      if (!FacebookCommerce.checkCookie('facebook_commerce_conversion')) {
        notifyFacebookOfConversion(Shopify.checkout.total_price);
        FacebookCommerce.setCookie('facebook_commerce_conversion', true, path);
      }
    }
  }

})();
