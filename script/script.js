window.onload = function (){
    mainBottomSet();
}

function mainBottomSet()
{
    var main = document.getElementsByTagName("main")[0];
    var footer = document.getElementsByTagName("footer")[0];
    main.style.marginBottom = footer.clientHeight + "px";
}

function toHomepageCheck()
{
    if(window.confirm("ホームページに移動しますか？")) window.location.href = "https://yama-kawa-mori.github.io/Homepage/";
}

function Search()
{
    var query = window.prompt("検索するタイトルを入力してください", "");
    if(query != "" && query != null) location.href = "./index.php?search=" + query;
}

function Check()
{
    if(window.confirm("本当に削除してもよろしいですか？")) return true;
    else return false;
}