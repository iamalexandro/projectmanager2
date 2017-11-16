$( document ).ready(function() {
    
    $('select').on('change', function(){
      //alert(this.value);
      var value = this.value;
      $.post('../../../index.php', { selectValue: value } );
    });

});