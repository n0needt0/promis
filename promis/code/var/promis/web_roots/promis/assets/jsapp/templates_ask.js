require([
  // Libs
  "use!underscore"
],

function(){
    window.JST = window.JST || {}; 
            
    window.JST['tml/question'] = _.template(
            "<h2 class='question_main'><%= Description%></h2>"
    );
    
    window.JST['tml/question_sub'] = _.template(
            "<h2 class='question_sub'><%= Description%></h2>"
    );
    
    window.JST['tml/answer_item'] = _.template(
            "<div class='btn btn_answer btn-success btn-large answer-line' ElementOID='<%= ElementOID%>' " +
            "FormItemOID='<%=FormItemOID%>' "+
            "ItemResponseOID='<%=ItemResponseOID%>' " +
            "Value='<%=Value%>' " +
            ">" +
            "<%= Description%></div><br>"
        );
    
    window.JST['tml/finish'] = _.template(
    		"<div class='finish'>"+
            "<div class='btn see_result btn-success btn-large'><i class='icon-search'> </i> See Results</div> " +
            "<div class='btn another_survey btn-success btn-large'><i class='icon-repeat'> </i> Another Survey</div> " +
            "<div class='btn new_pin btn-success btn-large'><i class='icon-home'> </i> New PIN</div> " +
            "</div>"
    );
});