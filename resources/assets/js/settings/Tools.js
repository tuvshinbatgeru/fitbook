module.exports = (function () {

    function Tools() {

    }

    Tools.prototype.newId = function () {
        return '_' + Math.random().toString(36).substr(2, 9);    
    };

    Tools.prototype.arrayBy = function(items, filter) {
        var arrays = [];

        for (var d = 0, len = items.length; d < len; d += 1) {
            var ret = {};
            arrays.push(items[d][filter]);
        }    

        return arrays;
    };

    Tools.prototype.collectionBy = function (items, filter) {
        var arrays = [];
        var fields = filter.split('|');

        for (var d = 0, len = items.length; d < len; d += 1) {
            var ret = {};
            for(var i = 0; i < fields.length; i ++) {
                ret[fields[i]] = items[d][fields[i]];
            }

            arrays.push(ret);
        }

        return arrays;
    };

    Tools.prototype.transformParameters = function (plainArray) {
        /*var { 
            x: 5,
            y: 6 
        };*/

        return encodeURIComponent(JSON.stringify(plainArray));
    };

    return function install(Vue) {
        Vue.prototype.$tools = new Tools();
    }

})();