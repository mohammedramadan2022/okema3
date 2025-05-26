<form action="{{ route('items.update', $item->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-12">
            <div class="mb-10">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control form-control-solid" placeholder="Enter name" value="{{ $item->name }}" required />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-10">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-select form-select-solid" required>
                    <option value="">Select Category</option>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-10">
                <label for="device_id" class="form-label">Device</label>
                <select name="device_id" id="device_id" class="form-select form-select-solid" required>
                    <option value="">Select Device</option>
                    @foreach(\App\Models\Device::all() as $device)
                        <option value="{{ $device->id }}" {{ $item->device_id == $device->id ? 'selected' : '' }}>{{ $device->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-10">
                <label for="barcode" class="form-label">Barcode</label>
                <input type="text" name="barcode" id="barcode" class="form-control form-control-solid" placeholder="Enter barcode" value="{{ $item->barcode }}" required />
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-10">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select form-select-solid" required>
                    <option value="">Select Status</option>
                    <option value="active" {{ $item->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $item->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
