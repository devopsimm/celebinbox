String.prototype.toUpperCaseWords = function () {
    return this.replace(/\w+/g, function(a){
        return a.charAt(0).toUpperCase() + a.slice(1).toLowerCase()
    })
}
