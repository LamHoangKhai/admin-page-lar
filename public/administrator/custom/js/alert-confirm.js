// modal confirm delete user
$(".confirm").click(async (e) => {
    e.preventDefault();
    const url = e.target.href;
    const name = e.target.getAttribute("value");
    // show modal
    await Swal.fire({
        title: "Are you sure?",
        html: `Bạn có muốn xóa <strong>${name}</strong> hay không`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            return (window.location.href = url);
        }
    });
});
