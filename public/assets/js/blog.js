var nextArticle = $("#nextArticle");
var prevArticle = $("#prevArticle");
var articleId = $('#articleID').val();
function checkArticle(articleId)
{
    var url = Routing.generate('checkID', {id: articleId});
    $.ajax(
    {
        url: url,
        type: 'POST',
        data: articleId,
        success: function(data){
            console.log('hello');
        },
        error: function(data){
            alert('No Data');
        }
    });
}
checkArticle(articleId);