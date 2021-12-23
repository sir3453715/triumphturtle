export const init = (selector, options = {}) => {
    return $(selector).select2(Object.assign({
        templateResult: item => {
            if (!item.id) {
                return item.text;
            }
            let text = item.text,
                search = $(selector).data('select2').dropdown.$search.val(),
                _text = text.split(''),
                startIndex = 0
            $.each(search.split(''), (index, ch) => {
                for (let i = startIndex; i < _text.length; i++) {
                    if(_text[i] == ch) {
                        _text[i] = '<span class="select2-rendered-highlight" style="color:red;">' + ch + '</span>'
                        startIndex = i;
                        break;
                    }
                }
            })

            return $('<span>' + _text.join('') + '</span>');
        }
    }, options))
}
