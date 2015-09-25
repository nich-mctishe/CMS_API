portfolio.service('formatService', [function() {

    return {
        'singularise': function(word) {
            if (word.slice(-1) === 's') {
                if(word.slice(-3) == 'ies') {
                    word = word.substring(0, word.length - 3) + 'y';
                } else {
                    word = word.substring(0, word.length - 1);
                }
            }

            return word;
        },
        formatAjaxDataObject: function(category, data) {
            category = this.singularise(category);

            return {
                'url': category,
                'data': data
            }
        }
    }

}]);