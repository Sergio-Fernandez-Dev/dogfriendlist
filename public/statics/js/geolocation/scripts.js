$(document).ready(function(){
    $.post( "", { "lat" : 3.345, "lng" : -123.390 }, null, "json" )
    .done(function( data) {
        console.log( data.city);
    }); 
});