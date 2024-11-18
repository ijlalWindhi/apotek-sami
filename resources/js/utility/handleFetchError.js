export const handleFetchError = (xhr, status, error) => {
    debug.error("Ajax", {
        xhr,
        status,
        error,
    });
    const errorMessage =
        xhr.responseJSON.message || error || "Terjadi kesalahan pada server";
    Swal.fire({
        position: "center",
        icon: "error",
        title: errorMessage,
        showConfirmButton: false,
        timer: 1500,
    });
};
