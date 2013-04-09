<script>
$(document).ready(function(){
    $('#submit').click(function(){
        var pin = $('#pin').val();

        if('ENTER PIN' != pin)
        {
            window.location.href = '/survey/' + pin;
        }

    });

    $(this).keypress(function (e){
        code = e.keyCode ? e.keyCode : e.which;
          if(code.toString() == 13)
          {
             $('#submit').click();
          }
    })

    $('#pin').click(function(){
    	var pin = $('#pin').val();

        if('ENTER PIN' == pin)
        {
        	$('#pin').val("");
        }

    });
});
</script>
<style>
#form {
    margin-left: auto;
    margin-right: auto;
    padding-bottom: 10px;
    padding-top: 10px;
    text-align: left;
    width: 100%;
}
</style>

<div id="content">
<div id='form'>
    <input id='pin' value='ENTER PIN'></input>
    <button id='submit' class='btn btn-success btn-large fullscreen'>  Start </button>
</div>
</div>
