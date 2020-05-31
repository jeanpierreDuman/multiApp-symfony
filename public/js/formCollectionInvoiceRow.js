$(document).ready(function() {

    $("#invoice_addOrChooseCustomer").change(function() {
         if($(this).is(':checked')) {
            $("#customer-content").hide();
            $("#add-customer-content").show();
         } else {
             $("#customer-content").show();
             $("#add-customer-content").hide();
         }
    });

    $collectionCriteriasHolder = $('div.rows');
    $collectionCriteriasHolder.data('index', $('#table-invoice').find('tbody').find('tr').length);

    if($('#table-invoice').find('tbody').find('tr').length === 0) {
        addInvoiceRow($collectionCriteriasHolder, $('#table-invoice').find('tbody'));
    }

    $(".addRow").on('click', function(e) {
        addInvoiceRow($collectionCriteriasHolder, $('#table-invoice').find('tbody'));
    });

    $(".removeRow").click(function() {
        if($('#table-invoice').find('tbody').find('tr').length > 1) {
            $(this).parent().parent().remove();
        }

        updateTotalAmountPrice();
    });

    $("input[id*='_unitPrice'], input[id*='_quantity']").change(function() {
        updateTotalAmountPrice();
    });

    updateTotalAmountPrice();

    function addInvoiceRow($collectionCriteriasHolder, place) {

        var prototype = $collectionCriteriasHolder.data('prototype');
        var index = $collectionCriteriasHolder.data('index');
        var newForm = prototype;

        newForm = newForm.replace(/__name__/g, index);
        $collectionCriteriasHolder.data('index', index + 1);
        $(place).append(newForm);

        $(".removeRow").on('click', function(e) {
            e.preventDefault();

            if($('#table-invoice').find('tbody').find('tr').length > 1) {
                $(this).parent().parent().remove();
            }

            updateTotalAmountPrice();
        });

        $("input[id*='_unitPrice'], input[id*='_quantity']").change(function() {
            updateTotalAmountPrice();
        });
    }

    function updateTotalAmountPrice()
    {
        var trAll = $("table#table-invoice").find('tbody').find('tr');
        var totalHT = 0;

        trAll.each(function() {
            var quantityInput = $(this).find("input[id*='_quantity']");
            var unitPriceInput = $(this).find("input[id*='_unitPrice']");
            var quantity = quantityInput.val();
            var unitPrice = unitPriceInput.val();
            var tryCalcul = true;

            /* check / add / update / quantity */
            parseIntQuantity = parseInt(quantity);

            if(isNaN(parseIntQuantity)) {
                var defaultQuantity = 1;
                quantity = defaultQuantity;
                quantityInput.val(1);
            } else {
                quantity = parseIntQuantity;
                quantityInput.val(quantity)
            }

            /* check / add / update / unitPrice */
            if(unitPrice.toString().indexOf(',') != -1) {
                unitPrice = unitPrice.replace(',', '.');
            }

            parseFloatUnitPrice = parseFloat(unitPrice);

            if(!isNaN(parseFloatUnitPrice)) {
                unitPriceInput.val(parseFloatUnitPrice);
            } else {
                unitPriceInput.val(0);
                tryCalcul = false;
            }

            if(tryCalcul) {
                var amountHT = quantity * unitPrice;
            } else {
                var amountHT = 0;
            }

            if(isNaN(amountHT)) {
                $(this).find("input[id*='_amountPrice']").val(0);
            } else {
                $(this).find("input[id*='_amountPrice']").val(amountHT.toFixed(2));
                totalHT += amountHT;
            }

        });

        $("#invoice_amountHt").val(totalHT.toFixed(2));
        updateTVA();
    }

    function updateTVA()
    {
        var tva = $("#invoice_tva").val();
        var totalAmountHT = $("#invoice_amountHt").val();
        var tvaSub = ((totalAmountHT * tva) / 100).toFixed(2);
        $("#invoice_subTva").val(parseFloat(tvaSub));
        var result = (parseFloat(tvaSub) + parseFloat(totalAmountHT)).toFixed(2);
        $("#invoice_amountTtc").val(result.toString());
    }

    $("#invoice_tva").change(function() {
        updateTVA();
    });
});
