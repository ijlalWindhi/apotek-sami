<div id="drawer-profile"
    class="fixed top-0 left-0 z-50 w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800"
    tabindex="-1" aria-labelledby="drawer-profile-label">
    <h5 id="drawer-profile-label" class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">Ubah Profil
    </h5>
    <button type="button" data-drawer-hide="drawer-profile" aria-controls="drawer-profile"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Close menu</span>
    </button>
    <div>
        <form class="py-4 overflow-y-auto" method="POST">
            @csrf
            <ul class="space-y-2 font-medium">
                <li>
                    <div class="space-y-2">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                        <input type="text" name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Nama" required>
                    </div>
                </li>
                <li>
                    <div class="space-y-2">
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 disabled:bg-gray-200 disabled:cursor-not-allowed"
                            placeholder="Email" required disabled>
                    </div>
                </li>
                <li>
                    <div class="space-y-2">
                        <label for="password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Password">
                    </div>
                </li>
                <li>
                    <div class="space-y-2">
                        <label for="password_confirmation"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi
                            Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Konfirmasi Password">
                    </div>
                </li>
                <li>
                    <x-button class="w-full mt-4" type="submit">Simpan</x-button>
                </li>
            </ul>
        </form>
    </div>
</div>

@php
    $userId = Auth::user()->id;
@endphp

<script>
    $('#drawer-profile form').on('submit', function(e) {
        e.preventDefault();

        let employee_id = $('#employee_id').val();
        let formData = $(this).serializeArray();
        let data = {};

        $.each(formData, function() {
            data[this.name] = this.value;
        });

        // Show loading icon
        $('#drawer-profile form').prepend(templates.loadingModal);
        $.ajax({
            url: `/inventory/pharmacy/employee/${employee_id}`,
            type: "POST",
            data: JSON.stringify(data),
            contentType: "application/json",
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-HTTP-Method-Override': 'PUT'
            },
            success: function(response) {
                // Close modal
                $('#drawer-profile').removeClass('flex').addClass('hidden');
                Swal.fire({
                    icon: "success",
                    title: "Berhasil memperbarui data",
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(() => {
                    // Refresh page
                    window.location.reload();
                }, 250);
            },
            error: (xhr, status, error) => {
                handleFetchError(xhr, status, error);
            },
            complete: function() {
                // Hide loading icon
                $('#drawer-profile form .absolute').remove();
            }
        });
    });

    /**
     * Data Fetching and Processing
     */
    const dataServiceProfile = {
        getDetail: (id) => {
            $.ajax({
                url: `/inventory/pharmacy/employee/${id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    // Fill the modal with data
                    $('#drawer-profile #name').val(response.data.name);
                    $('#drawer-profile #email').val(response.data.email);

                    // Add hidden input for form submission
                    if (!$('#drawer-profile form #employee_id').length) {
                        $('#drawer-profile form').append(
                            `<input type="hidden" id="employee_id" name="employee_id" value="${id}">`
                        );
                    } else {
                        $('#drawer-profile form #employee_id').val(id);
                    }
                },
                error: (xhr, status, error) => {
                    handleFetchError(xhr, status, error);
                },
                complete: function() {
                    // Hide loading icon
                    $('#drawer-profile form .absolute').remove();
                }
            });
        },
    };

    /**
     * Event Handlers
     */
    const eventHandlersProfile = {
        /**
         * Initializes all event handlers
         */
        init: () => {
            // Edit tax handler
            $('body').on('click', '#btn-edit-profile', function() {
                let user_id = {{ $userId }};

                // Reset form
                $('#drawer-profile form').trigger('reset');

                // Show loading icon
                $('#drawer-profile form').prepend(templates.loadingModal);

                // Fetch data
                dataServiceProfile.getDetail(user_id);
            });
        },
    };

    // Initialize when document is ready
    $(document).ready(() => {
        debug.log('Ready', 'Document ready, initializing...');
        eventHandlersProfile.init();
    });
</script>
