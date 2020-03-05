$("#tasks th.text-primary").click(function(event) {
    var postedData = {
        sort: $(this).attr("class")
    };

    $.ajax({
        type: 'POST',
        url: "/main/sort",
        data: postedData,
        success: function(result) {
            location.reload();
        }
    });
});

$(".page-link").click(function (event) {
    event.preventDefault();

    var postedData = {
        currentPage: parseInt($(this).attr("href"))
    };

    $.ajax({
        type: 'POST',
        url: "/main/set_current_page",
        data: postedData,
        success: function(result) {
            location.reload();
        }
    });
})

$(':checkbox').change(function() {
    $(this).parent().parent().parent().parent().submit();

});

$('.user_name').change(function() {
    $(this).parent().parent().parent().submit();

});

$(".text").change(function() {

    var postedData = {
        id: $(this).parent().parent().parent().find('input.id').val(),
        text: $(this).parent().parent().parent().find('input.text').val()
    };

    $.ajax({
        type: 'POST',
        url: "/admin/edit_task_text",
        data: postedData,
        success: function(result) {
            location.reload();
        }
    });
});