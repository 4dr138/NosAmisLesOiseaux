$('.unmask').on('click', function(){

    if($(this).prev('input').attr('type') == 'password')
        changeType($(this).prev('input'), 'text');

    else
        changeType($(this).prev('input'), 'password');

    return false;
});

function changeType(x, type) {
    if(x.prop('type') == type)
        return x; // ça serait facile.
    try {
        // Une sécurité d'IE empêche ceci
        return x.prop('type', type);
    }
    catch(e) {
        // On tente de recréer l'élément
        // En créant d'abord une div
        var html = $("<div>").append(x.clone()).html();
        var regex = /type=(\")?([^\"\s]+)(\")?/;
        // la regex trouve type=text ou type="text"
        // si on ne trouve rien, on ajoute le type à la fin, sinon on le remplace
        var tmp = $(html.match(regex) == null ?
            html.replace(">", ' type="' + type + '">') :
            html.replace(regex, 'type="' + type + '"') );

        // on rajoute les vieilles données de l'élément
        tmp.data('type', x.data('type') );
        var events = x.data('events');
        var cb = function(events) {
            return function() {
                //Bind all prior events
                for(i in events) {
                    var y = events[i];
                    for(j in y) tmp.bind(i, y[j].handler);
                }
            }
        }(events);
        x.replaceWith(tmp);
        setTimeout(cb, 10); // On attend un peu avant d'appeler la fonction
        return tmp;
    }
}