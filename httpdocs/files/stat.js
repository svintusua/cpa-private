var StatShow = Backbone.View.extend({
    prefix: 'StatShow',

    events: {
        "change #viewDateFrom": "datasUpdate",
        "change #viewDateTo": "datasUpdate",
        "submit #statFilter": "update",
        //"click #submitForm": "update",
        "click .exportFormat": "export",
        //"click .stat-refresh-button": "update",
        "click .search-day": "showDayStat",
        "click .search-offer": "showBannerStat",
        "click .search-channel": "showBannerStat",
        "click .groupBtn": "groupingChange",
        "click #searchResult th.js-sortable": "orderChange",
        "reset #statFilter": "resetFilter"
    },

    groupingChange: function (event) {
        var group = $(event.currentTarget).data('group');
        var defaultGroup = (group == 'day') ? 'desc' : 'asc';
        $('#order').val(defaultGroup);

        $('#grouping').val(group);
        $('#orderBy').val($(event.currentTarget).data('group'));
        $('#statFilter').submit();
    },

    afterAjax: function (data) {
        $('#searchResult th.js-sortable').off('click').on('click', function (event) {

            var orderBy = $(event.currentTarget).data('order-by');
            var oldOrderBy = $('#orderBy').val();

            var order = 'desc';
            if (orderBy == oldOrderBy) {
                order = (data.order == 'desc') ? 'asc' : 'desc';
            }

            $('#orderBy').val(orderBy);
            $('#order').val(order);
            $('#statFilter').submit();
        });
    },

    export: function(event){
        var format = $(event.currentTarget).data('format');
        $('#isExport').val(format);
        $('#statFilter').attr('action', '/stat');
        $('#statFilter').attr('target', '_blank');
        $('#statFilter').attr('method', 'post');
        $('#statFilter').submit();
        $('#isExport').val('');
    },

    update: function (event) {
        var self = this;
        var grouping = $('#grouping').val();

        if ($('#isExport').val() == '') {
            event.preventDefault();

            if (grouping == 'time') {
                KMA.makeRequest(
                    '/stat/stat/showday',
                    $('#statFilter').serialize(),
                    'json',
                    function (data) {
                        if (data.result == '1') {
                            $('#searchResult').html(data.html);
                        } else {
                            $('#searchResult').html('Скорее всего Ваша сессия просрочена. Пожалуйста обновите страницу или выполните вход в систему.');
                        }
                        self.afterAjax(data);
                    }
                );
            } else {
                KMA.makeRequest(
                    '/stat/stat/show',
                    $('#statFilter').serialize(),
                    'json',
                    function (data) {
                        if (data.result == '1') {
                            $('#searchResult').html(data.html);
                            $('#history').val((data.history > 0) ? 1 : 0);
                        } else {
                            $('#searchResult').html('Скорее всего Ваша сессия просрочена. Пожалуйста обновите страницу или выполните вход в систему.');
                        }
                        self.afterAjax(data);
                    }
                );
            }
        }
    },

    // reset filter form
    resetFilter: function (event) {
        event.preventDefault();

        // сбрасываем фильтр по дате
        var oDate = new Date();
        var iDay = oDate.getDate();
        var sDate = oDate.getFullYear() + '-' + (oDate.getMonth() + 1) + '-' + ((iDay < 10) ? '0' : '') + iDay;
        $('#dateFrom').val(sDate);
        $('#dateTo').val(sDate);
        var sDate = ((iDay < 10) ? '0' : '') + iDay + '/' + (oDate.getMonth() + 1) + '/' + oDate.getFullYear();
        $( "#viewDateFrom" ).val(sDate);
        $( "#viewDateTo" ).val(sDate);

        // сбрасываем выпадающие списки
        $(".resetFilter").val(0);
        $("#currencyFilter").val('RUB');
        $(".resetFilter").trigger('chosen:updated');
        $(".clearFilter").html('').trigger('chosen:updated');
    },

    //Обработка Нажатия на кнопку подтверждения email-a
    approve: function (event) {
        event.preventDefault();
        $('#confirmForm').dialog({autoOpen: true, width: 500, modal: true});
        $('#requestConfirm').off('click');
        $('#requestConfirm').on('click', function(event) {
            event.preventDefault();
            KMA.makeRequest(
                '/users/user/confirm',
                {},
                'json',
                function (data) {
                    if (KMA.isset(data.ok) && (data.ok == 1)){
                        $.showInfoBox('Код подтверждения успешно отправлен.');
                    }
                }
            )
        });

        $('#mailLastConfirm').off('click');
        $('#mailLastConfirm').on('click', function (event) {
            event.preventDefault();
            KMA.makeRequest(
                '/users/user/confirm',
                {
                    'key': $('#confirmKey').val()
                },
                'json',
                function (data) {
                    if (KMA.isset(data.ok) && (data.ok == 1)){
                        window.location.reload();
                    }
                }
            )
        });
    },

    autoPrepare: function()
    {
        Ready.initFakeSelect();

        $( "#viewDateFrom" ).datepicker({
            defaultDate: new Date(),
            changeMonth: true,
            numberOfMonths: 2,
            dateFormat: "dd/mm/yy",
            altField: "#dateFrom",
            altFormat: "yy-mm-dd",
            firstDay: 1,
            onClose: function( selectedDate ) {
                $( "#viewDateTo" ).datepicker( "option", "minDate", selectedDate );

                var date1 = new Date($('#dateFrom').val());
                var date2 = new Date($('#dateTo').val());
                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if (diffDays > 62) {
                    $("#landingFilter").val('').trigger('chosen:updated');
                    $("#prelandingFilter").val('').trigger('chosen:updated');
                    $("#data1Filter").val('').trigger('chosen:updated');
                    $("#data2Filter").val('').trigger('chosen:updated');
                    $("#data3Filter").val('').trigger('chosen:updated');
                    $("#data4Filter").val('').trigger('chosen:updated');
                    $("#data5Filter").val('').trigger('chosen:updated');
                    $(".hiddenFilters").hide();
                } else {
                    $(".hiddenFilters").show();
                }

                Ready.reInitFixedBtn();
            }
        });
        var oDate = new Date();
        $( "#viewDateFrom" ).datepicker('setDate', oDate);
        $( "#viewDateTo" ).datepicker({
            defaultDate: new Date(),
            changeMonth: true,
            numberOfMonths: 2,
            dateFormat: "dd/mm/yy",
            altField: "#dateTo",
            altFormat: "yy-mm-dd",
            firstDay: 1,
            onClose: function( selectedDate ) {
                $( "#viewDateFrom" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
        $( "#viewDateTo" ).datepicker('setDate', oDate);

        $("#currencyFilter").chosen().change(function (event) {
            
            var currencyId = $(event.currentTarget).val();
            if (currencyId != '') {
                // обновить список офферов
                KMA.makeRequest(
                    '/stat_getoffers',
                    {
                        "currency_id": currencyId
                    },
                    'json',
                    function (data) {
                        if (data != null) {
                            $('#offerFilter').html('<option></option>');
                            for (var i in data) {
                                $('#offerFilter').append('<option value="' + data[i].idOffer + '">' + data[i].offerName + '</option>');
                            }
                        }
                        $("#offerFilter").trigger("chosen:updated");
                    });
            }
        }).chosenIcon({
            disable_search_threshold: 10
        });

        $('#offerFilter').chosen().change(function (event) {

            var offerId = parseInt($(event.currentTarget).val());
            if (offerId > 0) {
                // обновить список лэндингов
                KMA.makeRequest(
                    '/stat_getlands',
                    {
                        "offer_id": offerId
                    },
                    'json',
                    function (data) {
                        if (data != null) {
                            $('#landingFilter').html('<option></option>');
                            for (var i in data) {
                                $('#landingFilter').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                            }
                        }
                        $("#landingFilter").trigger("chosen:updated");
                    });

                KMA.makeRequest(
                    '/stat_getprelands',
                    {
                        "offer_id": offerId
                    },
                    'json',
                    function (data) {
                        if (data != null) {
                            $('#prelandingFilter').html('<option></option>');
                            for (var i in data) {
                                $('#prelandingFilter').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                            }
                        }
                        $("#prelandingFilter").trigger("chosen:updated");
                    });
            }
        });
    },

    datasUpdate: function()
    {
        KMA.makeRequest(
            '/stat/stat/getdata',
            $('#statFilter').serialize(),
            'json',
            function (data) {
                if (KMA.isset(data.ok) && (data.ok == 1)) {
                    $('#data1Filter').empty();
                    $('#data1Filter').append($('<option value="">Все</option>'));
                    $.each(data.data1, function(key, value){
                        $('#data1Filter').append($('<option value="' + _.escape(value) + '">' + _.escape(value) + '</option>'));
                    });

                    $('#data2Filter').empty();
                    $('#data2Filter').append($('<option value="">Все</option>'));
                    $.each(data.data2, function(key, value){
                        $('#data2Filter').append($('<option value="' + _.escape(value) + '">' + _.escape(value) + '</option>'));
                    });

                    $('#data3Filter').empty();
                    $('#data3Filter').append($('<option value="">Все</option>'));
                    $.each(data.data3, function(key, value){
                        $('#data3Filter').append($('<option value="' + _.escape(value) + '">' + _.escape(value) + '</option>'));
                    });

                    $('#data4Filter').empty();
                    $('#data4Filter').append($('<option value="">Все</option>'));
                    $.each(data.data4, function(key, value){
                        $('#data4Filter').append($('<option value="' + _.escape(value) + '">' + _.escape(value) + '</option>'));
                    });

                    $('#data5Filter').empty();
                    $('#data5Filter').append($('<option value="">Все</option>'));
                    $.each(data.data5, function(key, value){
                        $('#data5Filter').append($('<option value="' + _.escape(value) + '">' + _.escape(value) + '</option>'));
                    });

                    $( "#data1Filter" ).trigger("chosen:updated");
                    $( "#data2Filter" ).trigger("chosen:updated");
                    $( "#data3Filter" ).trigger("chosen:updated");
                    $( "#data4Filter" ).trigger("chosen:updated");
                    $( "#data5Filter" ).trigger("chosen:updated");
                }
            }
        );
    },

    showDayStat: function(event) {
        event.preventDefault();
        var date = $(event.currentTarget).attr('data-date');

        if (!date) {
            return false;
        }
        var $expandDetails = $('#expand-' + date);
        if(!$expandDetails.is(":visible"))
        {
            var data = $('#statFilter').serializeObject();
            data.dateFrom = date;
            data.dateTo = date;
            data.grouping = 'time';
            data.expand = 1;
            data.order = 'ASC';

            KMA.makeRequest(
                '/stat_day',
                data,
                'json',
                function (data) {
                    if (KMA.isset(data.result) && (data.result == 1)) {
                        $expandDetails.html(data.html);
                        $expandDetails.show();
                    }
                },
                'stat.statHour'
            );
        }
        else
        {
            $expandDetails.hide();
        }
    },

    showBannerStat: function(event) {
        event.preventDefault();
        var id = $(event.currentTarget).attr('data-id');
        if (!id) {
            return false;
        }
        var $expandDetails = $('#expand-' + id);
        if(!$expandDetails.is(":visible"))
        {
            var data = {
                'dateFrom': $('#dateFrom').val(),
                'dateTo': $('#dateTo').val(),
                'filter': {}
            };

            $grouping = $('.statistics-category li.current .groupBtn').data('group');
            if ($grouping == 'idChannel') {

                data.filter.idChannel = id;
            } else {
                data.filter.idOffer = id;
            }

            KMA.makeRequest(
                '/stat_banner',
                data,
                'json',
                function (data) {
                    if (KMA.isset(data.result) && (data.result == 1)) {
                        $expandDetails.html(data.html);
                        $expandDetails.show();
                    }
                },
                'stat.statBanner'
            );
        }
        else
        {
            $expandDetails.hide();
        }
    },

    render: function () {
        this.setElement($('#content').get(0));
        this.autoPrepare();
        return this;
    }
});

$(document).ready(function(){
    var stat = new StatShow();
    stat.render();
});