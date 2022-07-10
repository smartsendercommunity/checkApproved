var checkApprove = function (variable, urlCheck, urlFail = "https://google.com") {
    const getUrlParam = function( param ) {
        if ( ! param ) return;
        const queryString = window.location.search;
        const urlParams = new URLSearchParams( queryString );
        const paramValue = urlParams.get(param);
        return paramValue;
    };
    function getCookie(name) {
        let matches = document.cookie.match(
            new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") + "=([^;]*)")
        );
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
    var ssId = getUrlParam('ssId');
    if (!ssId) {
        ssId = getCookie('ssId');
    }
    var send = {
        userId: ssId,
        variable: variable,
    }
    let xhr = new XMLHttpRequest();
    xhr.open('POST', urlCheck);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let store = JSON.parse(this.responseText);
            if (!store.approve) {
                location.href = urlFail;
            }
        }
    };
    xhr.send(JSON.stringify(send));
}