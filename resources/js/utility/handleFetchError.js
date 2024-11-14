export const handleFetchError = (xhr, status, error) => {
    debug.error("Ajax", {
        xhr,
        status,
        error,
    });
    Swal.fire({
        position: "center",
        icon: "error",
        title: error || "Terjadi kesalahan pada server",
        showConfirmButton: false,
        timer: 1500,
    });
};
