$(document).ready(function () {
    // lets give 'active' class to choosed link from nav
    $(".left-side ul li").each(function (index) {
        var currentUrl = window.location.href;
        var urlOfLink = $(this).find('a').attr('href');
        currentUrl = currentUrl.split('?')[0];//remove if contains GET
        if (currentUrl == urlOfLink) {
            $(this).addClass('active');
        }
    });
});

// Upload More Images on publish product
$('.finish-upload').click(function () {
    $('.finish-upload .finish-text').hide();
    $('.finish-upload .loadUploadOthers').show();
    var someFormElement = document.getElementById('uploadImagesForm');
    var formData = new FormData(someFormElement);
    $.ajax({
        url: urls.uploadOthersImages,
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data)
        {
            $('.finish-upload .finish-text').show();
            $('.finish-upload .loadUploadOthers').hide();
            reloadOthersImagesContainer();
            $('#modalMoreImages').modal('hide');
            document.getElementById("uploadImagesForm").reset();
        }
    });
});

$('.orders-page .show-more').click(function () {
    var tr_id = $(this).data('show-tr');
    $('table').find('[data-tr="' + tr_id + '"]').toggle(function () {
        if ($('[data-tr="' + tr_id + '"]').is(':visible')) {
            $('.orders-page .fa-chevron-up').show();
            $('.orders-page .fa-chevron-down').hide();
        } else {
            $('.orders-page .fa-chevron-up').hide();
            $('.orders-page .fa-chevron-down').show();
        }
    });

});

$('.change-ord-status').change(function () {
    var the_id = $(this).data('ord-id');
    var to_status = $(this).val();

    $.post(urls.changeVendorOrdersOrderStatus, {the_id: the_id, to_status: to_status}, function (data) {
        if (data == '0') {
            alert('Error with status change. Please check logs!');
        }
    });
});
$(".change-products-form").change(function () {
    $('#searchProductsForm').submit();
});

$(".changeOrder").change(function () {
   $('#searchOrderForm').submit();
});

$(document).ready(function () {
    $('.more-info').click(function () {
        $('#preview-info-body').empty();
        var order_id = $(this).data('more-info');
        var text = $('#order_id-id-' + order_id).text();
        $("#client-name").empty().append(text);
        var html = $('#order-id-' + order_id).html();
        $("#preview-info-body").append(html);
    });
    $('.edit-info').click(function () {
        $('#preview-edit-body').empty();
        var order_id = $(this).data('edit-info');
        $('#order_id').val(order_id);
        var text = $('#order_id-id-' + order_id).text();
        $("#client-name").empty().append(text);
        var html = $('#order-edit-id-' + order_id).html();
        $("#preview-edit-body").append(html);
    });
});
function changeOrdersOrderStatus(id, to_status, products, userEmail) {
    $.post(urls.changeVendorOrdersOrderStatus, {the_id: id, to_status: to_status, products: products, userEmail: userEmail}, function (data) {
        //console.log(data);
        location.reload();
        if (data == '1') {
            
            if (to_status == 0) {
                $('[data-action-id="' + id + '"] div.status b').text('Not processed');
                $('[data-action-id="' + id + '"]').removeClass().addClass('bg-danger text-center');
            }
            if (to_status == 1) {
                $('[data-action-id="' + id + '"] div.status b').text('Processed');
                $('[data-action-id="' + id + '"]').removeClass().addClass('bg-success  text-center');
            }
            if (to_status == 2) {
                $('[data-action-id="' + id + '"] div.status b').text('Shipped');
                $('[data-action-id="' + id + '"]').removeClass().addClass('bg-warning  text-center');
            }
            if (to_status == 3) {
                $('[data-action-id="' + id + '"] div.status b').text('Delivered');
                $('[data-action-id="' + id + '"]').removeClass().addClass('bg-success  text-center');
            }
            if (to_status == 4) {
                $('[data-action-id="' + id + '"] div.status b').text('Caceled');
                $('[data-action-id="' + id + '"]').removeClass().addClass('bg-warning  text-center');
            }
            $('#new-order-alert-' + id).remove();
        } else {
            //alert('Error with status change. Please check logs!');
        }
    });
}
$('.locale-change').click(function () {
    var toLocale = $(this).data('locale-change');
    $('.locale-container').hide();
    $('.locale-container-' + toLocale).show();
    $('.locale-change').removeClass('active');
    $(this).addClass('active');
});

function reloadOthersImagesContainer() {
    $('.others-images-container').empty();
    $('.others-images-container').load(urls.loadOthersImages, {"folder": $('[name="folder"]').val()});
}

//products publish
function removeSecondaryProductImage(image, folder, container) {
    $.ajax({
        type: "POST",
        url: urls.removeSecondaryImage,
        data: {image: image, folder: folder}
    }).done(function (data) {
        $('#image-container-' + container).remove();
    });
} 
function trackDetails(order_id) {
    $.ajax({
        type: "POST",
        url: urls.tracking_details,
        data: {order_id: order_id}
    }).done(function (data) {
        $('#tracking_details_info').html(data);
    });
}