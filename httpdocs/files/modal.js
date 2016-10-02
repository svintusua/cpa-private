//Модальное окно
$(document).ready(function(){
    $(window).resize(function () {
        KMA.modalRefresh();
    });
    KMA.modalRefresh();

    $(document).on('click', 'a[modal], button[modal]', function () {
        var modalWindow = $('div#' + $(this).attr('modal'));
        if (modalWindow.length) {
            KMA.modalShow(modalWindow);
            Ready.initChosen();
            return false;
        }
    }).on('click', '.icon-close, .modal, .button-close', function (event) {
        if (event.target != this) {
            return false;
        } else {
            KMA.modalHide($(this).closest('.modal'))
        }
    }).on('keydown', function (key) {
        if (key.keyCode == 27)
            KMA.modalHide($('.modal:visible:last'))
    }).on('click', '.modal > *', function (event) {
        event.stopPropagation();
        return true;
    });
});