@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Open a Ticket</h3>

    <div id="success-message" class="alert alert-success d-none"></div>
    <div id="error-message" class="alert alert-danger d-none"></div>

    <form id="ticketForm">
        @csrf
        <div class="mb-3">
            <label>Customer Name</label>
            <input type="text" name="customer_name" class="form-control">
            <span class="text-danger" id="error-customer_name"></span>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
            <span class="text-danger" id="error-email"></span>
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
            <span class="text-danger" id="error-phone"></span>
        </div>
        <div class="mb-3">
            <label>Problem Description</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
            <span class="text-danger" id="error-description"></span>
        </div>
        <button class="btn btn-success" id="submitBtn" type="submit">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="submitSpinner"></span>
            <span id="submitText">Submit</span>
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('input[name="phone"]').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $('#ticketForm').on('submit', function(e) {
            e.preventDefault();
            $('#submitBtn').attr('disabled', true);
            $('#submitSpinner').removeClass('d-none');
            $('#submitText').text('Submitting...');
            $('.text-danger').html('');

            $.ajax({
                url: "{{ url('/ticket') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    window.location.href = "/ticket/thankyou?ref=" + response.reference;
                },
                error: function(xhr) {
                    $('#submitBtn').attr('disabled', false);
                    $('#submitSpinner').addClass('d-none');
                    $('#submitText').text('Submit');

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#error-' + key).text(value[0]);
                        });
                    } else {
                         toastr.error('Something went wrong!');
                    }
                }
            });
        });
    });
</script>
@endpush