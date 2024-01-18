$(document).ready(function () {
    $('.close-alert').click(function () {
        $('body .alert').remove()
    })
});

function formatCurrency(price = '', symbol = " VNĐ") {
    if (!price) {
        return ''
    }
    var price = parseFloat(price).toLocaleString();
    return price + symbol;
}
