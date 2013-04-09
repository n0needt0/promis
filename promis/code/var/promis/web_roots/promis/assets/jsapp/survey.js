require([
  // Libs
  "jquery",
  "use!backbone"
],
        
function( jQuery, Backbone) {

    var App = {
            Views: {},
            Models: {},
            Collections: {},
            Routers: {},
            init: function() {
                debug('initializing');
                debug(Conf);
                debug(App);
                App.Views.appview = new App.Views.AppView();
            }
        };

    
    
      // Our overall **AppView** is the top-level piece of UI.
      App.Views.AppView = Backbone.View.extend({

        // Instead of generating a new element, bind to the existing
          
        el: '#content' ,
        data:{},
        // Delegated events for creating new items, and clearing completed ones.
        events: {
          "click .start_survey" : "startSurvey",
          "click .action_continue" : "continueSurvey",
          "click .action_result" : "viewResult",
          "click .action_delete" : "deleteSurvey"
        	  
        },
        
        initialize: function () { 
            _.bindAll(this, "render");
            //render
            this.render();
        },

        render: function () {
            debug('binding to application element: ');
            this.listInstruments();
            
        },
        
        continueSurvey: function(e)
        {
        	try{
        		var token = $(e.currentTarget).attr('ref');
        		//get all the data for ths token and resubmit to asking again
				debug(token);
				
				var api_url = Conf.api.home + '/api/token_data/' + token;
              	
            	debug('api url:' + api_url);
            	
                $.ajax({
                    url: api_url,
                    dataType: "jsonp",
                    jsonp : "callback",
                    success: function(data) {
                    	debug(data);
                    	if(!_.isEmpty(data._id))
                    	{
                    		//submit to new form
                    		var fields = {
                    				pin:data.pin,
                    				pkey:data.pkey,
                    				instrument_name:data.instrument_name,
                    				instrument_id:data.instrument_id,
                    				token:data.token,
                    				id:data.id,
                    				expire:data.expire
                    		};
                    		
                    		var inputs = '';
                	        jQuery.each(fields, function(k,v){
                	            inputs+='<input type="hidden" name="'+ k +'" value=\''+ v +'\' />';
                	        });
                	        //send request
                	        jQuery('<form action="/ask" method="POST">'+inputs+'</form>')
                 	        .appendTo('body').submit();
                    	}
                    	
                      },
                    error: function(data) {
                          alert('can not finish api request to ' + api_url);
                          debug(data);
                        }
                     });
                
                debug('finished schedule api url:' + api_url);
            }
              catch (err)
            {
                debug(err);
            }
        	
        },
        viewResult: function(e)
        {
        	try{
        		var token = $(e.currentTarget).attr('ref');
        		//get all the data for ths token and resubmit to asking again
				debug(token);
				
				var api_url = Conf.api.home + '/api/token_data/' + token;
              	
            	debug('api url:' + api_url);
            	
                $.ajax({
                    url: api_url,
                    dataType: "jsonp",
                    jsonp : "callback",
                    success: function(data) {
                    	
                    	$('#info').html("<img src='/result/"+token+"'/>");
                    	
                    	$('#info').dialog({
	                  	      title:'Result',
	                  	      autoOpen: true,
	                  	      resizable: true,
	                  	      width:800,
	                  	      height:540,
	                  	      modal: false
                  	    });
                    	debug(data);
                      },
                    error: function(data) {
                          alert('can not finish api request to ' + api_url);
                          debug(data);
                        }
                     });
                
                debug('finished schedule api url:' + api_url);
            }
              catch (err)
            {
                debug(err);
            }
        },
        deleteSurvey: function(e)
        {
        	try{
        		var token = $(e.currentTarget).attr('ref');
        		//get all the data for ths token and resubmit to asking again
				debug(token);
				
				var api_url = Conf.api.home + '/api/token_delete/' + token;
              	
            	debug('api url:' + api_url);
            	
                $.ajax({
                    url: api_url,
                    dataType: "jsonp",
                    jsonp : "callback",
                    success: function(data) {
                    	debug(data);
                    	    //send request
                	        jQuery('<form action="/survey/' + pin + '/' + pkey +'" method="GET"></form>')
                 	        .appendTo('body').submit();
                      },
                    error: function(data) {
                          alert('can not finish api request to ' + api_url);
                          debug(data);
                        }
                     });
                
                debug('finished schedule api url:' + api_url);
            }
              catch (err)
            {
                debug(err);
            }
        },
        
        listInstruments: function(e){
            //this will list available instruments from all APIs

        	try{
        		
        		var p = waiting();
        		
            	var api_url = Conf.api.home + '/api/promis_forms';
                      	
            	debug('list instruments api url:' + api_url);
            	
                $.ajax({
                    url: api_url,
                    dataType: "jsonp",
                    jsonp : "callback",
                    success: function(data) {
                    	
                    	debug(data);
                    	
                    	debug('appendig to #instruments');
                    	
                    	$('#instruments').append(window.JST['tml/instrument_list']({}));
           
                        _.each(data,function(v,k){
                        	$('#instruments select').append(window.JST['tml/instrument_list_item']({item_name:v,item_key:k}));
                        });
                        
                        $('#instruments').append(window.JST['tml/start_survey']({}));
                        var p = done();
                      },
                    error: function(data) {
                          alert('can not finish api request to ' + api_url);
                          debug(data);
                          var p = done();
                        }
                     });
                
                debug('finished schedule api url:' + api_url);
            
            }
              catch (err)
            {
                alert(err);
            }
        },
        startSurvey: function(e){
        	try{
        		var odi = $('#instrument_list :selected').val()
        		var ref = $('#instrument_list :selected').attr('ref')
        		
        		if('' == odi)
        	    {
        			return;
        	    }
        		
            	var api_url = Conf.api.home + '/api/promis_token/' + odi + '/' + pin;
                      	
            	debug('token api url:' + api_url);
            	
                $.ajax({
                    url: api_url,
                    dataType: "jsonp",
                    jsonp : "callback",
                    success: function(data) {
                    	debug(data);
                    	if(!_.isEmpty(data.OID))
                    	{
                    		//submit to new form
                    		var fields = {
                    				pin:pin,
                    				pkey:pkey,
                    				instrument_name:ref,
                    				instrument_id:odi,
                    				token:data.OID,
                    				id:data.ID,
                    				expire:data.Expiration
                    		};
                    		
                    		var inputs = '';
                	        jQuery.each(fields, function(k,v){
                	            inputs+='<input type="hidden" name="'+ k +'" value=\''+ v +'\' />';
                	        });
                	        //send request
                	        jQuery('<form action="/ask" method="POST">'+inputs+'</form>')
                 	        .appendTo('body').submit();
                    	}
                    	
                      },
                    error: function(data) {
                          alert('can not finish api request to ' + api_url);
                          debug(data);
                        }
                     });
                
                debug('finished api url:' + api_url);
                
            }
              catch (err)
            {
                debug(err);
            }
        },


      });

    App.init();
});
