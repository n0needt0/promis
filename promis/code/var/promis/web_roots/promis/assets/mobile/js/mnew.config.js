


//Set the require.js configuration for your application.

require.config({
  
  paths: {
    // Libraries
    jquery: "/assets/vendor/jquery/jquery",
    jquerymobile: "/assets/vendor/mobile/jquery.mobile-1.3.0.min",
    iosorientation: "/assets/vendor/mobile/ios-orientationchange-fix.min",
    cordova: "/assets/vendor/mobile/cordova-2.5.0",
    underscore: "/assets/vendor/underscore",
    backbone: "/assets/vendor/backbone",
    json2: "/assets/vendor/json2",
    // Shim Plugin
    use: "/assets/vendor/require/plugins/use",
    async: "/assets/vendor/require/plugins/async"
  },

  use: {
    backbone: {
      deps: ["underscore", "jquery", "json2","jquerymobile","iosorientation"],
      attach: "Backbone"
    },

    underscore: {
      attach: "_"
    }
  },
  
//Initialize the application with the main application file
  deps: [
         "/assets/mobile/js/mhome.app.js",
         "/assets/mobile/js/mhome.templates.js"
         ]
   
});

