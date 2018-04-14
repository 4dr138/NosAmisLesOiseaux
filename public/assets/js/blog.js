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
