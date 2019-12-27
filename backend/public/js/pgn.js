var classname = document.getElementsByClassName("n_result");

var myFunction = function() {

    function removeParam(key, url) {
        var rtn = url.split("?")[0],
            param,
            params_arr = [],
            queryString = (url.indexOf("?") !== -1) ? url.split("?")[1] : "";
        if (queryString !== "") {
            params_arr = queryString.split("&");
            for (var i = params_arr.length - 1; i >= 0; i -= 1) {
                param = params_arr[i].split("=")[0];
                if (param === key) {
                    params_arr.splice(i, 1);
                }
            }
            rtn = rtn + "?" + params_arr.join("&");
        }
        rtn = rtn.replace("??", "?");
        rtn = rtn.replace("?&", "?");
        return rtn;
    }

    var url = window.location.href;
    var sep = '?';
    var params = url.split('?')[1];
    try {
        count = params.length;
        sep = '&';
    }
    catch(err) {
        var count = 0;
        sep = '?';
    }
    var key = this.getAttribute("data-pgn");
    var url = removeParam(key, url) ;
    url = url+sep+'page=1'+'&'+key+'='+this.value;

    window.location.href = url;
    
};

Array.from(classname).forEach(function(element) {
    element.addEventListener('change', myFunction);
});