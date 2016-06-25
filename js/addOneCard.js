/**
 * Created by wenkaiW10 on 6/25/2016.
 */


/**
 * 向id为postsContainer的元素中添加cardObject，也即一个动态
 * @param cardDataObject
 */
function addOneCard(cardDataObject) {
    var cardData1 = document.createElement("div");
    console.log("in addOneCard: " + JSON.stringify(cardDataObject));
//        console.log()
    switch (cardDataObject.type){
        case "text":
            cardData1.innerHTML ='<div class="mdl-card on-the-road-again mdl-cell mdl-cell--8-col" style="width: 584px">' +
                '<div class="mdl-color-text--grey-600 mdl-card__supporting-text">' +
                cardDataObject.text +  // 此处存放文字
                '</div>' +
                '<div class="mdl-card__supporting-text meta mdl-color-text--grey-600">'+
                '<div class="minilogo"><img src="' + processIconStr(cardDataObject.icon) + '" width="45px", height="45px"></div> '+
                '<div onclick="window.open(' + "'../view_user/?name=" + cardDataObject.name + "&userid_to_view=" + cardDataObject.userid + "'" +')"><div>'+
                '<strong>' + cardDataObject.name + '</strong><br>'+  // 发布者名称
                '<span>' + cardDataObject.create_time + '</span>'+ //发布时间
                '</div></div>'+
                '<div>'+
                '<ul><li class="on-card-button" onclick="window.open(' + "'../show_post/?postid=" + cardDataObject.postid + "'" + ')">评论</li></ul>'+
                '</div>'+
                '</div>'+
                '</div>';
            break;
        case "textAndImage":
            cardData1.innerHTML ='<div class="mdl-card on-the-road-again mdl-cell mdl-cell--8-col" style="width: 640px">' +  //TODO 解决宽度不能自适应的问题
                '<div class="mdl-card__title mdl-color-text--grey-50" style="background: url('+
                '' + //最好是绝对路径，否则可能找不到
                ')">'+
                '</div>'+
                '<div class="mdl-color-text--grey-600 mdl-card__supporting-text">' +
                cardDataObject.textContent +  // 此处存放文字
                '</div>' +
                '<div class="mdl-card__supporting-text meta mdl-color-text--grey-600">'+
                '<div class="minilogo"></div> '+
                '<div>'+
                '<strong>' + cardDataObject.poster.posterName + '</strong>'+  // 发布者名称
                '<span>2 days ago</span>'+
                '</div>'+
                '<div>'+
                '<ul>  <li class="on-card-button">评论</li></ul>'+
                '</div>'+
                '</div>'+
                '</div>';

            break;
        default:
            throw "Invalid cardDataObject type";
    }
    var postContainer = document.getElementById("postsContainer");
    postContainer.appendChild(cardData1);
}

/**
 * 将用户头像的路径处理为可以显示在src里面的路径
 * @param iconStr
 */
function processIconStr(iconStr){
    if(iconStr){
        if(iconStr.length <= 0){
            return "../images/icon/default.jpg";
        }else{
            return "../images/icon/" + iconStr + ".jpg";
        }
    }
    return "../images/icon/default.jpg";
}