
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


var $ = require("jquery");

require("jquery-ui/ui/widgets/sortable");

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    }
});

$.fn.sortableRows = function (options) {
    this.each(function () {

        var table = $(this);
        table.addClass('-sortable');

        var sortableElem = $('tbody', table);

        sortableElem.sortable({
            helper: preserveWidthOnDrag,
            axis: 'y',
            cancel: '[data-sortable=disabled]',
            containment: "parent",
            update: function (e, ui) {
                var url = table.data('sortable');
                var method = 'patch';

                var data = {
                    '_method': method,
                    'ids': sortableElem.sortable('toArray', {
                        attribute: 'data-row-id'
                    }),
                };

                $.ajax({
                    type: 'POST',
                    data: data,
                    url: url,
                    success: function (response, textStatus, jqXhr) {
                        var event = jQuery.Event( "sorted" );
                        event.reponse = response;
                        event.status = textStatus;
                        event.source = 'ajax';
                        event.table = table;
                        jQuery(table).trigger(event);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("The following error occured: " + textStatus, errorThrown);
                        sortableElem.sortable('cancel');
                    }
                });
            }
        });

    });

    return this;

    function preserveWidthOnDrag(e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    }

};

$("table[data-sortable]").sortableRows();