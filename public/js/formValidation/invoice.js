$('#invoice')
    .form({
        fields: {},
        onSuccess: function() {
            var li = '';
            var checkInvoiceRow = 0;
            var checkDate = 0;
            var quantityAll = $("input[id*='_quantity']");
            var descriptionAll = $("input[id*='_description']");
            var unitPriceAll = $("input[id*='_unitPrice']");

            quantityAll.each(function() {
                if($(this).val().length === 0) {
                    checkInvoiceRow++;
                    $(this).parent().parent().addClass('error');
                } else {
                    $(this).parent().parent().removeClass('error');
                }
            });

            descriptionAll.each(function() {
                if($(this).val().length === 0) {
                    checkInvoiceRow++;
                    $(this).parent().parent().addClass('error');
                } else {
                    $(this).parent().parent().removeClass('error');
                }
            });

            unitPriceAll.each(function() {
                if($(this).val().length === 0) {
                    checkInvoiceRow++;
                    $(this).parent().parent().addClass('error');
                } else {
                    $(this).parent().parent().removeClass('error');
                }
            });

            if(checkInvoiceRow > 0) {
                li += '<li>Aucune ligne de facture ne peut être vide</li>';
            }

            function isValidDate(d) {
              return d instanceof Date && !isNaN(d);
            }

            var date = $("#invoice_date").val();
            var d = isValidDate(new Date(date));

            if(d) {
                $("#invoice_date").parent().removeClass('error');
            } else {
                checkDate++;
                li += '<li>Le format de la date est incorrect</li>';
                $("#invoice_date").parent().addClass('error');
            }

            var countAllError = checkDate + checkInvoiceRow;

            if(countAllError > 0) {
                $('div.error.message').show();
                $('div.error.message').html('');
                $('div.error.message').append("<ul class='list'>" + li + "</ul>");
                return false;
            } else {
                $('div.error.message').hide();
                return true;
            }
        }
    }
);

$('.dropdown')
    .dropdown({
        clearable: true,
    })
;
