<!--begin::Form-->
<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('admin.expenses.post-add-expense-transaction') }}">
    @csrf
    <div class="row">



        <div class="col-lg-4 col-sm-12 mb-5">
            {{ Form::label('safe_id', __('Admin.Safe') . ':', ['class' => 'form-label required mb-3']) }}
            {{ Form::select('safe_id', $safes->mapWithKeys(fn($safe) => [$safe->id => $safe->name])->toArray(), null, [
                'class'        => 'form-select io-select2',
                'id'           => 'safe_id',
                'placeholder'  => __('admin.Safe'),
                'data-control' => 'select2',
            ]) }}
        </div>
   <div class="col-lg-4 col-sm-12 mb-5">
            {{ Form::label('expense_id', __('Admin.Expense') . ':', ['class' => 'form-label required mb-3']) }}
            {{ Form::select('expense_id', $expenses->mapWithKeys(fn($expense) => [$expense->id => $expense->name])->toArray(), null, [
                'class'        => 'form-select io-select2',
                'id'           => 'expense_id',
                'placeholder'  => __('admin.Expense'),
                'data-control' => 'select2',
            ]) }}
        </div>

        <div class="col-lg-4 col-sm-12 mb-5">
            {{ Form::label('amount', __('admin.Amount') . ':', ['class' => 'form-label required mb-3']) }}
            {{ Form::number('amount', null, [
                'class' => 'form-control',
                'id' => 'amount',
                'step' => '0.01',
                'min' => '0',
                'required' => true,
            ]) }}
            <div class="invalid-feedback" id="amount_error"></div>
        </div>
        <div class="col-lg-4 col-sm-12 mb-5">
            {{ Form::label('notes', __('admin.Notes') . ':', ['class' => 'form-label required mb-3']) }}
            {{ Form::text('notes', null, [
                'class' => 'form-control',
                'id' => 'notes',
                'step' => '0.01',
                'min' => '0',
                'required' => true,
            ]) }}
            <div class="invalid-feedback" id="notes_error"></div>
        </div>

        <div    class = "col-12 mt-5">
            <button type  = "submit" class = "btn btn-primary">
                <i      class = "fas fa-save me-2"></i>{{ __('admin.Save') }}
            </button>
        </div>
    </div>


</form>
<script>
    $('.dropify').dropify();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
</script>
