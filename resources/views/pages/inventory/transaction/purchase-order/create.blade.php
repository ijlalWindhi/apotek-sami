<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <select class="js-example-basic-single" name="state">
        <option value="AL">Alabama</option>
        <option value="WY">Wyoming</option>
    </select>
</x-layout>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%' // opsional untuk tampilan yang lebih baik
        });
    });
</script>