require([
  // Libs
  "use!underscore"
],

function(){
    window.JST = window.JST || {}; 
            
    window.JST['tml/instrument_list'] = _.template(
            "<select id='instrument_list'> " +
            "<option value='' ref=''>Select Instrument To complete</option>"+
            "</select>"
    );
    
    window.JST['tml/start_survey'] = _.template(
    		" <button id='submit' class='start_survey btn btn-success btn-large'>  Start </button>"
    		);
    
    window.JST['tml/instrument_list_item'] = _.template(
            "<option value='<%= item_key%>' ref='<%= item_name%>'><%= item_name%></option>"
        );
});