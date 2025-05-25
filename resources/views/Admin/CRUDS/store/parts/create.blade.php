<!--begin::Form-->
<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('stores.store') }}">
    @csrf
    <div class="row g-4">

        <!-- Store Name -->
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{ __('admin.name') }}</span>
                <span class="red-star">*</span>
            </label>
            <input required type="text" class="form-control form-control-solid" name="name" value=""/>
        </div>

        <!-- Store Status -->
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label for="is_active" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{ __('admin.status') }}</span>
                <span class="red-star">*</span>
            </label>
            <select class="form-control" id="is_active" name="is_active">
                <option value="1">{{ __('admin.Active') }}</option>
                <option value="0">{{ __('admin.Not Active') }}</option>
            </select>
        </div>

        <!-- Store Type -->
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label for="type" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{ __('admin.type') }}</span>
                <span class="red-star">*</span>
            </label>
            <select class="form-control" id="type" name="type" required>
                <option value="" disabled selected>{{ __('admin.select_type') }}</option>
                <option value="main">{{ __('admin.main') }}</option>
                <option value="user">{{ __('admin.user') }}</option>
            </select>
        </div>

        <!-- Admin Select (hidden by default) -->
        <div class="d-flex flex-column mb-7 fv-row col-sm-6" id="adminSelectContainer" style="display: none;">
            <label for="admin_id" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">{{ __('admin.Admin') }}</span>
                <span class="red-star">*</span>
            </label>
            <select class="form-control js-example-basic-multiple" id="admin_id" name="admin_id">
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>

<!-- Scripts -->
<script>
    $('.dropify').dropify();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();

        // Function to handle type change
        function handleTypeChange() {
            if ($('#type').val() === 'user') {
                $('#adminSelectContainer').show(); // Show admin list
                $('#admin_id').prop('required', true); // Make admin_id required
            } else {
                $('#adminSelectContainer').hide(); // Hide admin list
                $('#admin_id').prop('required', false); // Remove required attribute
            }
        }

        // Handle type change event
        $('#type').on('change', handleTypeChange);

        // Trigger on page load to set initial state
        handleTypeChange();

        // Initialize DataTable with proper column definitions
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('stores.index') }}",
                type: 'GET'
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'admin_name', name: 'admin_name'}, // Changed from admin.name to admin_name
                {data: 'type', name: 'type'},
                {data: 'is_active', name: 'is_active'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
