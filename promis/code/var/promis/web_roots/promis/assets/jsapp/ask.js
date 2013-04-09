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
          
        el: '#survey' ,
        data:{},
        answer: {},
        // Delegated events for creating new items, and clearing completed ones.
        events: {
          "click .btn_answer" : "doAnswer",
          "click .see_result"  : "seeResult",
          "click .another_survey" : "anotherSurvey",
          "click .new_pin" : "newPin"
         }, 
        
        initialize: function () { 
            _.bindAll(this, "render");
            //render
            this.render();
        },

        render: function () {
            debug('binding to application element: ');
            this.getSurvey();
            
        },
        
        seeResult: function(e){
          	try{
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
        
        anotherSurvey: function(e){
            window.location.href = '/survey/' + pin + '/' + pkey;
        },
        
        newPin: function(e){
            window.location.href = '/';
        },
        
        getResult: function(e){

        	try{
                
        		var p = waiting();
        		
            	var api_url = Conf.api.home + '/api/promis_result/' + token;
            	
                $.ajax({
                    url: api_url,
                    dataType: "jsonp",
                    jsonp : "callback",
                    success: function(data) {

                         $('#survey').append(window.JST['tml/finish']({}));
                          progressbar.progressbar('option', 'value', 100 ) ;
                          var p = done();
                          return;
                    },
                    error: function(data) {
                          debug('can not finish api request to ' + api_url);
                          debug(data);
                          window.location.href = '/survey/' + pin + '/' + pkey;
                        }
                     });
                
                debug('finished api url:' + api_url);
                
            }
              catch (err)
            {
                debug(err);
            }
        },
        
        getSurvey: function(e){

        	try{
                
        		var p = waiting();
        		
            	var api_url = Conf.api.home + '/api/promis_ask/' + token;
            	
            	if( _.size(this.answer) > 0 )
                {
            		//this is next question so just keep going
            		api_url += '/' + this.answer.ItemResponseOID + '/' + this.answer.Value;
            		
            		this.answer = {};
                	$('#survey').html(""); //delete all
                	var bar = progressbar.progressbar( "value");
                	debug(bar);
                	progressbar.progressbar('option', 'value', bar + 5 ) ;
                	debug('survey api url:' + api_url);
                }
            	
           
            	var that = this;
            	
                $.ajax({
                    url: api_url,
                    dataType: "jsonp",
                    jsonp : "callback",
                    success: function(data) {
                    	debug('appendig to #survey');
                    	
                    	
                    	if(!_.isEmpty(data.DateFinished))
                    	{
                    		that.getResult();
                    		return;
                    	}
                    	
                        _.each(data.Items[0].Elements,function(v){
                        	debug(v);
                        	
                        	//see how many elements are there
                        	var qel = 2; //
                        	
                        	qel = _.size(data.Items[0].Elements)
                        	
                        	if(1 == v.ElementOrder)
                            {
                        		//main question
                        		$('#survey').append(window.JST['tml/question'](v));
                            }
                        	
                        	if((2 == v.ElementOrder) && (3==qel))
                            {
                        			//sub question
                        			$('#survey').append(window.JST['tml/question_sub'](v));
                            }
                        	 else
                        	{
                        			$('#survey').append('<h2>&nbsp;</h2>');
                        	}
                        	
                        	if(qel == v.ElementOrder) 
                            {
                        		//answers
                        		_.each(v.Map,function( va){
                        			debug(va);
                        			$('#survey').append(window.JST['tml/answer_item'](va));
                        		});
                            }
                        	
                        });

                        var p = done();
                        return;
                        
                      },
                    error: function(data) {
                          debug('can not finish api request to ' + api_url);
                          debug(data);
                          window.location.href = '/survey/' + pin + '/' + pkey;
                        }
                     });
                
                debug('finished api url:' + api_url);
                
            }
              catch (err)
            {
                debug(err);
            }
        },
        doAnswer: function(e){
        	try{
        		var this_answer = $(e.currentTarget);
        		this.answer.ElementOID = this_answer.attr('ElementOID');
        		this.answer.FormItemOID = this_answer.attr('FormItemOID');
        		this.answer.ItemResponseOID = this_answer.attr('ItemResponseOID');
        		this.answer.Value = this_answer.attr('Value');
        		this.answer.Description = this_answer.attr('Description');
                
				//submit answer locally and get response before proceeding
				debug(this.answer);
				this.getSurvey();
            }
              catch (err)
            {
                debug(err);
            }
        },

      });

    App.init();
});
