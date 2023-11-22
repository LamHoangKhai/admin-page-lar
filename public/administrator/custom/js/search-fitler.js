$(document).ready(() => {
    let storage = {
        search: "",
        status: [],
        featured: [],
        category: "",
    };

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    //handle search
    $("#search").keypress(
        debounce((e) => {
            if (e.keyCode === 13) {
                return 0;
            }
            console.log("run");
            storage = { ...storage, search: e.target.value };

            loadSearchFilter(storage);
        }, 500)
    );

    $("#search").keyup(
        debounce((e) => {
            if (e.keyCode === 8) {
                storage = { ...storage, search: e.target.value };
                console.log(storage);
                loadSearchFilter(storage);
            }
            return 0;
        }, 500)
    );
    // end handle search

    // handle filter
    $(".filter").change((e) => {
        const selecter = e.target;
        const isChecked = selecter.checked;
        const name = selecter.name;
        const value = selecter.value;

        if (name === "status") {
            storage = isChecked
                ? { ...storage, status: [...storage.status, value] }
                : {
                      ...storage,
                      status: [...storage.status.filter((e) => e !== value)],
                  };
        }

        if (name === "featured") {
            storage = isChecked
                ? { ...storage, featured: [...storage.featured, value] }
                : {
                      ...storage,
                      featured: [
                          ...storage.featured.filter((e) => e !== value),
                      ],
                  };
        }

        $(selecter).attr("disabled", true);
        setTimeout(() => {
            $(selecter).removeAttr("disabled");
        }, 500);

        loadSearchFilter(storage);
    });
    // end handle filter

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

    //handle filter category
    $("#category").change((e) => {
        if (!e.target.value) {
            storage = { ...storage, category: "" };
            loadSearchFilter(storage);
            return 0;
        }
        storage = { ...storage, category: e.target.value };
        loadSearchFilter(storage);
    });
    //end handle filter category
});

// function debounce
const debounce = (callback, timeout = 500) => {
    let timer;
    return (...agrs) => {
        clearTimeout(timer);
        timer = setTimeout(() => {
            callback.apply(this, agrs);
        }, timeout);
    };
};
// end function debounce

//  call api Search
const loadSearchFilter = (storage) => {
    if (
        !storage.search &&
        storage.status.length === 0 &&
        storage.featured.length === 0
    ) {
        $("#renderData").html("");
        return 0;
    }

    let url = "http://localhost:8000/api/search?";
    if (storage.search) {
        url += "s=" + storage.search + "&";
    }
    if (storage.category) {
        url += "category_id=" + storage.category + "&";
    }
    if (storage.status) {
        storage.status.forEach((e) => {
            url += "status[]=" + e + "&";
        });
    }
    if (storage.featured) {
        storage.featured.forEach((e) => {
            url += "featured[]=" + e + "&";
        });
    }

    $("#renderData").html("");

    $.ajax({
        type: "GET",
        url: url,
        contentType: "json",
        success: (res) => {
            let xhtml = "";
            let data = res.data || [];
            data.forEach((element) => {
                let status =
                    element.status === 1
                        ? ["Show", "success"]
                        : ["Hidden", "secondary"];
                let featured =
                    element.featured === 1
                        ? ["Featured", "primary"]
                        : ["Unfeatured", "danger"];

                xhtml += `
            <tr>
            <td>${element.id}</td>
            <td>${element.name}</td>
            <td>${element.price}</td>
            <td>${element.category.name}</td>
            <td><span class="right badge badge-${status[1]}">${status[0]}</span>
            </td>
            <td><span class="right badge badge-${featured[1]}">${featured[0]}</span>
            </td>
            </tr>
            `;
            });
            $("#renderData").append(xhtml);
        },
        error: function (error) {
            console.log(error.message);
        },
    });
};
