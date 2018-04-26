var nextArticle = $("#nextArticle");
var prevArticle = $("#prevArticle");
var articleId = $('#articleID').val();
var nextArticleID = Number(articleId) + 1;
var prevArticleID = Number(articleId) - 1;
var type = '';
function checkArticle(articleId, type)
{
    var url = Routing.generate('checkID', {id: articleId});
    $.ajax(
    {
        url: url,
        type: 'POST',
        data: articleId,
        success: function(data){
            console.log(type);
            if(type == 'next')
            {
                if(data !== '-99')
                {
                    nextArticle.show()
                }
                else
                {
                    nextArticle.hide();
                }
            }
            else
            {
                if(data !== '-99')
                {
                    prevArticle.show()
                }
                else
                {
                    prevArticle.hide();
                }
            }
        },
        error: function(data){
            alert('no data');
        }
    });
}
checkArticle(nextArticleID, 'next');
checkArticle(prevArticleID, 'prev');

tinymce.init({
    forced_root_block : "",
    force_p_newlines : false,
    force_br_newlines : true,


    selector: "textarea",
    width: 600,
    height:300,
    plugins: [
        "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking"
        //     "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
    ],
    //
    toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
    toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
    toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft",
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tinymce.com/css/codepen.min.css'],

    menubar: false,
    toolbar_items_size: 'small',

    style_formats: [{
        title: 'Bold text',
        inline: 'b'
    }, {
        title: 'Red text',
        inline: 'span',
        styles: {
            color: '#ff0000'
        }
    }, {
        title: 'Red header',
        block: 'h1',
        styles: {
            color: '#ff0000'
        }
    }, {
        title: 'Example 1',
        inline: 'span',
        classes: 'example1'
    }, {
        title: 'Example 2',
        inline: 'span',
        classes: 'example2'
    }, {
        title: 'Table styles'
    }, {
        title: 'Table row 1',
        selector: 'tr',
        classes: 'tablerow1'
    }],

    templates: [{
        title: 'Test template 1',
        content: 'Test 1'
    }, {
        title: 'Test template 2',
        content: 'Test 2'
    }],

    init_instance_callback: function () {
        window.setTimeout(function() {
            $("#div").show();
        }, 1000);
    }
});