$(document).ready(() => {
    // get category
    $.ajax({
        type: "GET",
        url: "http://localhost:8000/api/category",
        contentType: "json",
        success: (res) => {
            let xhtml = `<option value="">--Chọn--Category--</option>`;
            let data = res.data;
            data.forEach((element) => {
                xhtml += `<option value="${element.id}">${element.name}</option>`;
            });
            $("#category").append(xhtml);
        },
        error: function (error) {
            console.log(error.message);
        },
    });
    // end get category
});
