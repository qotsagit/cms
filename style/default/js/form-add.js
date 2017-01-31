$(document).ready(function() {
    var max_fields      = 100; //maximum input boxes allowed
    var wrapper         = $(".input_fields_multi"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).prepend('<div class="entry"><div class="col-xs-4"><label class="control-label">Wybierz zdjęcie </label><input type="file" name="image[]"  class="form-control"></div><div class="col-xs-6"><label class="control-label">Nazwa zdjęcia</label><input type="text" name="image_name[]"  class="form-control" placeholder=""></div><div class="col-xs-1"><label class="control-label">Usuń</label><span class="input-group-btn"><button class="remove_field btn btn-success btn-add" type="button"><span class="glyphicon glyphicon-minus"></span></button></span></div></div>'); //add input box
        }
    });
    
    //<div class="entry input-group col-md-6"><input type="file" name="image[]"  class="form-control"> <input type="text" name="image_name[]"  class="form-control" placeholder="Nazwa Zdjęcia"><button class="remove_field btn btn-success btn-add " type="button"><span class="glyphicon glyphicon-minus"></span></button></div>
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parents('div.entry').remove(); x--;
    })
});


$(document).ready(function() {
    var max_fields_pliki      = 100; //maximum input boxes allowed
    var wrapper_pliki         = $(".input_fields_multi_pliki"); //Fields wrapper
    var add_button_pliki      = $(".add_field_button_pliki"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button_pliki).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields_pliki){ //max input box allowed
            x++; //text box increment
            $(wrapper_pliki).prepend('<div class="entry"><div class="col-xs-4"><label class="control-label">Wybierz plik </label><input type="file" name="plik[]"  class="form-control"></div><div class="col-xs-6"><label class="control-label">Nazwa pliku</label><input type="text" name="plik_name[]"  class="form-control" placeholder=""></div><div class="col-xs-1"><label class="control-label">Usuń</label><span class="input-group-btn"><button class="remove_field_pliki btn btn-success btn-add" type="button"><span class="glyphicon glyphicon-minus"></span></button></span></div></div>'); //add input box
        }
    });
    
    //<div class="entry input-group col-md-6"><input type="file" name="image[]"  class="form-control"> <input type="text" name="image_name[]"  class="form-control" placeholder="Nazwa Zdjęcia"><button class="remove_field btn btn-success btn-add " type="button"><span class="glyphicon glyphicon-minus"></span></button></div>
    
    $(wrapper_pliki).on("click",".remove_field_pliki", function(e){ //user click on remove text
        e.preventDefault(); $(this).parents('div.entry').remove(); x--;
    })
});
